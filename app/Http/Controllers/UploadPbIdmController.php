<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadPbIdmController extends Controller
{

    public function __construct(Request $request)
    {
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }

    function index(){

        $this->CreateTabelBuah();

        return view("home");
    }

    //? pertama kali halaman di load
    private function formLoad(){

        $ip = $this->getIP();

        //! CHECK MASTER_SUPPLY_IDM
        // sb.AppendLine(" SELECT COUNT(DISTINCT msi_kodedc)  ")
        // sb.AppendLine(" FROM master_supply_idm  ")
        // sb.AppendLine(" WHERE msi_kodeigr = '" & KDIGR & "' ")
        $count = DB::table('master_supply_idm')
            ->where('msi_kodeigr', session('KODECABANG'))
            ->count();

       //? if jum > 0 lanjut CHECK TBMASTER_PLUIDM jika kosong $flag_pluidm = false
       $flag_pluidm = false;
       if($count > 0){
            //! CHECK TBMASTER_PLUIDM
            $count = DB::select("
                SELECT idm_kodeidm, COUNT(DISTINCT idm_pluidm) jml_pluidm
                FROM tbmaster_pluidm
                WHERE idm_kodeigr = '" . session('KODECABANG') . "'
                AND EXISTS (
                    SELECT msi_kodedc
                    FROM master_supply_idm
                    WHERE msi_kodedc = idm_kodeidm
                        AND msi_kodeigr = idm_kodeigr
                    )
                GROUP BY idm_kodeidm
                HAVING COUNT(DISTINCT idm_pluidm) > 0
            ");

            //? if jum > 0 $flag_pluidm = true jika kosong $flag_pluidm = false
            if($count[0]->jml_pluidm > 0){
                $flag_pluidm = true;
            }
       }

        //! ISI GRID HEADER
        // sb.AppendLine("Select COALESCE(Count(1),0) ")
        // sb.AppendLine("  From CSV_PB_BUAH ")
        // sb.AppendLine(" Where DATE_TRUNC('DAY', CPB_TGLPROSES) >= CURRENT_DATE - 7  ")
        // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
        // sb.AppendLine("   AND CPB_IP = '" & IP & "'  ")

        $count = DB::table('csv_pb_buah')
            ->where('cpb_ip', $ip)
            ->where(function($query){
                $query->whereNull('cpb_flag')
                    ->orWhere('cpb_flag','');
            })
            ->whereRaw("DATE_TRUNC('DAY', cpb_tglproses) >= CURRENT_DATE - 7")
            ->count();

        //? if jum > 0 panggil function RefreshGridHeader
        //panggil query datatable_header
    }

    private function datatablesHeader(){

        $ip = $this->getIP();
        $flagPLUIDM = true;

        //! DELETE TEMP_CSV_PB_BUAH
        // sb.AppendLine("DELETE FROM TEMP_CSV_PB_BUAH ")
        // sb.AppendLine(" WHERE REQ_ID = '" & getIP() & "' ")

        DB::table('temp_csv_pb_buah')
            ->where('req_id', $ip)
            ->delete();

        //! INSERT INTO TEMP_CSV_PB_BUAH
        $query = "";
        $query .= "INSERT INTO TEMP_CSV_PB_BUAH ";
        $query .= "( ";
        $query .= "       JENIS, ";
        $query .= "       NoPB, ";
        $query .= "       TglPB, ";
        $query .= "       TOKO, ";
        $query .= "       PLUIDM, ";
        $query .= "       PLUIGR, ";
        $query .= "       QTY, ";
        $query .= "       RUPIAH, ";
        $query .= "       STOCK, ";
        $query .= "       NAMA_FILE, ";
        $query .= "       REQ_ID ";
        $query .= ") ";
        $query .= " SELECT CASE prd_kodedepartement ";
        $query .= "         WHEN '31' THEN 'IMPORT' ";
        $query .= " 		WHEN '32' THEN 'LOKAL' ";
        $query .= " 		ELSE 'CHILLED FOOD' ";
        $query .= " 	   END as JENIS, ";
        $query .= "        noPB, ";
        $query .= "        TGLPB, ";
        $query .= "        TOKO as TOKO, ";
        $query .= "        PLUIDM as PLUIDM, ";
        $query .= "        PLUIGR as PLUIGR, ";
        $query .= "        QTY, ";
        $query .= "        COALESCE(ST_AVGCOST,0) ";
        $query .= " 	    / CASE WHEN PRD_UNIT = 'KG' THEN 1000 ELSE 1 END ";
        $query .= " 	    * QTY / CASE WHEN IDM_MINORDER::numeric = 1000 THEN 1000 ELSE 1 END as RUPIAH, ";
        $query .= "        COALESCE(ST_SaldoAkhir,0) STOCK, ";
        $query .= "        NAMA_FILE, ";
        $query .= "        REQ_ID ";
        $query .= "   FROM ( ";
        if($flagPLUIDM){
            $query .= "     SELECT CPB_NoPB as NOPB, ";
            $query .= "            TO_CHAR(CPB_TGLPB,'DD-MM-YYYY') as TGLPB, ";
            $query .= "            CPB_KodeTOKO as TOKO, ";
            $query .= "            CPB_PLUIDM as PLUIDM, ";
            $query .= "            IDM_PLUIGR as PLUIGR, ";
            $query .= "            CPB_QTY as QTY, ";
            $query .= " 	       SUBSTR(CPB_FILENAME,POSITION('PB' IN CPB_FILENAME)) AS NAMA_FILE, ";
            $query .= "            '" . $ip . "' as REQ_ID, ";
            $query .= "            IDM_MINORDER, ";
            $query .= "            PRD_KodeDepartement, ";
            $query .= "            PRD_Unit ";
            $query .= "       FROM CSV_PB_BUAH ";
            $query .= "       JOIN master_supply_idm ";
            $query .= "     	ON CPB_KodeTOKO = MSI_KodeTOKO ";
            $query .= "       JOIN tbMaster_PLUIDM ";
            $query .= " 	    ON CPB_PLUIDM = IDM_PLUIDM ";
            $query .= "        AND MSI_KodeDC = IDM_KodeIDM ";
            $query .= "       JOIN tbMaster_PRODMAST ";
            $query .= " 	    ON PRD_PRDCD = IDM_PLUIGR ";
            $query .= "      WHERE DATE_TRUNC('DAY', CPB_TGLPROSES) >= DATE_TRUNC('DAY', CURRENT_DATE - 7) ";
            $query .= "        AND (CPB_FLAG IS NULL OR CPB_FLAG = '') ";
            $query .= "        AND CPB_IP = '" . $ip . "' ";
        }else{
            $query .= "     SELECT CPB_NoPB as NOPB,   ";
            $query .= "            TO_CHAR(CPB_TGLPB,'DD-MM-YYYY') as TGLPB,   ";
            $query .= "            CPB_KodeTOKO as TOKO, ";
            $query .= "            CPB_PLUIDM as PLUIDM, ";
            $query .= "            PRC_PLUIGR as PLUIGR, ";
            $query .= "            CPB_QTY as QTY, ";
            $query .= " 	       SUBSTR(CPB_FILENAME,POSITION('PB' IN CPB_FILENAME)) AS NAMA_FILE, ";
            $query .= "            '" . $ip . "' as REQ_ID, ";
            $query .= "            PRC_MINORDER, ";
            $query .= "            PRD_KodeDepartement, ";
            $query .= "            PRD_Unit ";
            $query .= "       FROM CSV_PB_BUAH ";
            $query .= "       JOIN tbmaster_prodcrm ";
            $query .= "         ON CPB_PLUIDM = PRC_PLUIDM ";
            $query .= "       JOIN tbMaster_PRODMAST ";
            $query .= "         ON PRD_PRDCD = PRC_PLUIGR ";
            $query .= "      WHERE DATE_TRUNC('DAY', CPB_TGLPROSES) >= DATE_TRUNC('DAY', CURRENT_DATE - 7) ";
            $query .= "        AND (CPB_FLAG IS NULL OR CPB_FLAG = '') ";
            $query .= "        AND CPB_IP = '" . $ip . "' ";
        }
        $query .= "   ) A ";
        $query .= "   LEFT JOIN tbMaster_STOCK ";
        $query .= "     ON A.PLUIGR = ST_PRDCD ";
        $query .= "    AND ST_LOKASI = '01' ";

        //! ISI DATAGRID HEADER PB IDM
        DB::select("
            Select JENIS,
                NOPB,
                TGLPB,
                TOKO,
                COUNT(DISTINCT PLUIDM) as PLU,
                SUM(RUPIAH) as RUPIAH,
                NAMA_FILE
            FROM TEMP_CSV_PB_BUAH
            WHERE REQ_ID = '" . $ip . "'
            GROUP By JENIS, NOPB, TGLPB, TOKO, NAMA_FILE
        ");
    }

    //! PROSES F3
    public function actionF3(){

        //! VARIABLE
        $SalahSatuPBGaLolos = FALSE;
        $ip = $this->getIP();
        $noPB = "";
        $KodeToko = "";
        $tglPB = "";
        $filename = "";

        //? ada proses decrypt file
        //? Decryption dengan metode AES alias RijndaelManaged
        //? 128 bit
        //? pass -> idm123

        //? jika data kosong goto SkipRecordKosongPBM

        //! DELETE CSV_PB_BUAH2 WHERE DATE_TRUNC('DAY', CPB_TGLPROSES) = CURRENT_DATE
        // sb.AppendLine("DELETE FROM CSV_PB_BUAH2 ")
        // sb.AppendLine(" Where CPB_IP = '" & IP & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TGLPROSES) = CURRENT_DATE ")

        DB::table('CSV_PB_bUAH2')
            ->where('cpb_ip', $ip)
            ->whereRaw("DATE_TRUNC('DAY', cpb_tglproses) = CURRENT_DATE")
            ->delete();

        //! START LOOP

        //? 03-01-2014 KALAU ADA REVISI PB UNTUK HARI INI
        //! DELETE CSV_PB_BUAH2 WHERE DATE_TRUNC('DAY', CPB_TglProses) = CURRENT_DATE AND CPB_NoPB
        // sb.AppendLine("DELETE FROM CSV_PB_BUAH2 ")
        // sb.AppendLine(" Where CPB_IP = '" & IP & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TglProses) = CURRENT_DATE ")
        // sb.AppendLine("   AND CPB_NoPB = '" & noPB & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("   AND CPB_KodeToko = '" & KodeToko & "' ")

        DB::table('csv_pb_buah2')
            ->where([
                'cpb_ip' => $ip,
                'cpb_nopb' => $noPB,
                'cpb_kodetoko' => $KodeToko,
            ])
            ->whereRaw("DATE_TRUNC('DAY', cpb_tglproses) = CURRENT_DATE")
            ->whereRaw("DATE_TRUNC('DAY', cpb_tglpb) = TO_DATE('" . $tglPB . "','DD-MM-YYYY')")
            ->delete();

        //! DELETE CSV_PB_BUAH WHERE DATE_TRUNC('DAY', CPB_TglProses) = CURRENT_DATE AND CPB_NoPB
        // sb.AppendLine("DELETE FROM CSV_PB_BUAH ")
        // sb.AppendLine(" Where CPB_IP = '" & IP & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TglProses) = CURRENT_DATE ")
        // sb.AppendLine("   AND CPB_NoPB = '" & noPB & "' ")
        // sb.AppendLine("   AND To_Char(CPB_TglPB,'DD-MM-YYYY') = '" & tglPB & "' ")
        // sb.AppendLine("   AND CPB_KodeToko = '" & KodeToko & "' ")

        DB::table('csv_pb_buah2')
            ->where([
                'cpb_ip' => $ip,
                'cpb_nopb' => $noPB,
                'cpb_kodetoko' => $KodeToko,
            ])
            ->whereRaw("DATE_TRUNC('DAY', cpb_tglproses) = CURRENT_DATE")
            ->where(DB::raw("To_Char(cpb_tglpb,'DD-MM-YYYY')"), $tglPB)
            ->delete();

        //? ini sek anomali karena ada if counter 100 (NOTE KEVIN)
        //! INSERT INTO CSV_PB_BUAH2
        // sb.AppendLine(" INSERT INTO CSV_PB_BUAH2 ( ")
        // sb.AppendLine("   cpb_recordid, ")
        // sb.AppendLine("   cpb_kodetoko, ")
        // sb.AppendLine("   cpb_nopb, ")
        // sb.AppendLine("   cpb_tglpb, ")
        // sb.AppendLine("   cpb_pluidm, ")
        // sb.AppendLine("   cpb_qty, ")
        // sb.AppendLine("   cpb_gross, ")
        // sb.AppendLine("   cpb_ip, ")
        // sb.AppendLine("   cpb_filename, ")
        // sb.AppendLine("   cpb_tglproses, ")
        // sb.AppendLine("   cpb_flag, ")
        // sb.AppendLine("   cpb_create_by, ")
        // sb.AppendLine("   cpb_nourut ")
        // sb.AppendLine(" ) VALUES ")
        // sb.AppendLine(" ( ")
        // sb.AppendLine("   '" & row(0).ToString & "', ")
        // sb.AppendLine("   '" & row(1).ToString & "', ")
        // sb.AppendLine("   '" & row(2).ToString & "', ")
        // sb.AppendLine(" TO_DATE('" & row(3).ToString & "','DD/MM/YYYY HH24:MI:SS'),")
        // sb.AppendLine("   '" & row(4).ToString & "', ")
        // sb.AppendLine("   " & row(5).ToString & ", ")
        // sb.AppendLine("   " & row(6).ToString & ", ")
        // sb.AppendLine("   '" & row(7).ToString & "', ")
        // sb.AppendLine("   '" & row(8).ToString & "', ")
        // sb.AppendLine(" TO_DATE('" & row(9).ToString & "','DD/MM/YYYY HH24:MI:SS'),")
        // sb.AppendLine("   '" & row(10).ToString & "', ")
        // sb.AppendLine("   '" & row(11).ToString & "', ")
        // sb.AppendLine("   " & IIf(row(12).ToString = "", "null", row(12).ToString) & " ")
        // sb.AppendLine(" ) ")

        $count = DB::select("
            SELECT COALESCE(Count(DISTINCT CPB_NoPB),0) as count
            FROM CSV_PB_BUAH2
            WHERE EXISTS
            (
                SELECT pbo_nopb
                FROM TBMASTER_PBOMI
                WHERE PBO_NOPB = CPB_NoPB
                AND PBO_KODEOMI = CPB_KodeToko
                AND DATE_TRUNC('DAY', PBO_TGLPB) = DATE_TRUNC('DAY', CPB_TglPB)
                AND CPB_NoPB ='" . $noPB . "'
                AND To_Char(CPB_TglPB,'DD-MM-YYYY')='" . $tglPB . "'
                AND CPB_KodeToko = '" . $KodeToko . "'
            )
            AND CPB_KodeToko = '" . $KodeToko . "'
            AND CPB_NoPB ='" . $noPB . "'
            AND To_Char(CPB_TglPB,'DD-MM-YYYY')='" . $tglPB . "'
        ");

        if($count[0]->count > 0){
            $SalahSatuPBGaLolos = true;
            //? continue;

            //* No Dokumen:" & noPB & vbNewLine & "Tanggal:" & tglPB & vbNewLine & "File:" & fi.Name & vbNewLine & vbNewLine & "SUDAH PERNAH DIPROSES!!!

            $message = "No Dokumen:" . $noPB . "Tanggal:" . $tglPB . "File:" . $filename . "SUDAH PERNAH DIPROSES!!!";
            return ApiFormatter::error(400, $message);

        }

        //! GET PLU DOBEL BUAH
        $data = DB::select("
            Select CPB_PluIDM, COALESCE(count(CPB_KodeToko),0) as count
            From CSV_PB_BUAH2
            Where CPB_IP = '" . $ip . "'
                AND CPB_NoPB = '" . $noPB . "'
                AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB . "','DD-MM-YYYY')
                AND CPB_KodeToko = '" . $KodeToko . "'
            Group By CPB_PluIDM
            Having count(CPB_KodeToko) > 1
        ");

        if(count($data)){
            $SalahSatuPBGaLolos = true;
            //? continue;

            $listPlu = '';
            foreach($data as $item){
                $listPlu .= $item->count . ',';
            }

            $message = "PLU " . rtrim($listPlu, ",") . " Dobel Di File " . $filename . " Yang Sedang Diproses, Harap Minta Revisi File PBBH Ke IDM - PLU DOBEL DI PBBH";
            return ApiFormatter::error(400, $message);
            //* PLU " & listPLU & " Dobel Di File " & fi.Name & " Yang Sedang Diproses," & vbNewLine & "Harap Minta Revisi File PBBH Ke IDM !", MsgBoxStyle.Information, ProgName & " - PLU DOBEL DI PBBH
        }

        //! ISI dtTempPBIDM2
        //? data ini di loop kemudian
        // sb.AppendLine("Select * ")
        // sb.AppendLine("  From CSV_PB_BUAH2 ")
        // sb.AppendLine(" Where CPB_IP = '" & IP & "'")
        // sb.AppendLine("   AND CPB_NoPB = '" & noPB & "'")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("   AND CPB_KodeToko = '" & KodeToko & "' ")

        $data = DB::table('csv_pb_buah2')
            ->where([
                'cpb_ip' => $ip,
                'cpb_nopb' => $noPB,
                'cpb_kodetoko' => $KodeToko,
            ])
            ->whereRaw("DATE_TRUNC('DAY', cpb_tglpb) = to_date('" . $tglPB . "','DD-MM-YYYY')")
            ->get();

        if(count($data) == 0){
            $SalahSatuPBGaLolos = true;
            //? continue;

            $message = "TIDAK ADA DATA YANG BISA JADI PB DI IGR!! - KARENA DATANYA KOSONG";
            return ApiFormatter::error(400, $message);
            //* TIDAK ADA DATA YANG BISA JADI PB DI IGR!!" & vbNewLine & "(KARENA DATANYA KOSONG
        }

        //? dari query diatas
        //!INSERT INTO CSV_PB_BUAH
        // sb.AppendLine(" INSERT INTO CSV_PB_BUAH ( ")
        // sb.AppendLine("   cpb_recordid, ")
        // sb.AppendLine("   cpb_kodetoko, ")
        // sb.AppendLine("   cpb_nopb, ")
        // sb.AppendLine("   cpb_tglpb, ")
        // sb.AppendLine("   cpb_pluidm, ")
        // sb.AppendLine("   cpb_qty, ")
        // sb.AppendLine("   cpb_gross, ")
        // sb.AppendLine("   cpb_ip, ")
        // sb.AppendLine("   cpb_filename, ")
        // sb.AppendLine("   cpb_tglproses, ")
        // sb.AppendLine("   cpb_flag, ")
        // sb.AppendLine("   cpb_create_by, ")
        // sb.AppendLine("   cpb_nourut ")
        //! END LOOP

        $kodeDCIDM = $this->kodeDCIDM($KodeToko);

        //! MERGE INTO CSV_PB_BUAH - UPDATE JENISPB
        $query = "";
        $query .= "MERGE INTO ";
        $query .= "     CSV_PB_BUAH A ";
        $query .= "USING ";
        $query .= "( ";
        if($kodeDCIDM <> ""){
            $query .= "  SELECT IDM_PLUIDM, ";
        }else{
            $query .= "  SELECT PRC_PLUIDM, ";
        }
        $query .= "         CASE PRD_KodeDepartement ";
        $query .= "           WHEN '31' THEN 'IMPORT' ";
        $query .= "           WHEN '32' THEN 'LOKAL' ";
        $query .= "           ELSE 'CHILLED FOOD' ";
        $query .= "         END AS JenisPB ";
        if($kodeDCIDM <> ""){
            $query .= "    FROM TBMASTER_PLUIDM,TBMASTER_PRODMAST ";
            $query .= "   WHERE IDM_PLUIGR = PRD_PRDCD ";
            $query .= "     AND PRD_KodeDivisi IN ('4','6') ";
            $query .= "     AND IDM_KODEIDM = '" . $kodeDCIDM  . "' ";
            $query .= ") b ";
            $query .= "ON ";
            $query .= "( a.CPB_PLUIDM = b.IDM_PLUIDM ";
            $query .= "   AND CPB_IP = '" . $ip . "' ";
            $query .= " AND (CPB_Flag IS NULL OR CPB_Flag = '') ";
            $query .= "     AND CPB_NoPB = '" . $noPB . "'";
            $query .= "     AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB . "','DD-MM-YYYY') ";
            $query .= "     AND CPB_KodeToko = '" . $KodeToko . "') ";
        }else{
            $query .= "    FROM TBMASTER_PRODCRM,TBMASTER_PRODMAST ";
            $query .= "   WHERE PRC_PLUIGR = PRD_PRDCD ";
            $query .= "     AND PRD_KodeDivisi IN ('4','6') ";
            $query .= "     AND PRC_GROUP = 'I' ";
            $query .= ") b ";
            $query .= "ON ";
            $query .= "( a.CPB_PLUIDM = b.PRC_PLUIDM ";
            $query .= "   AND CPB_IP = '" . $ip . "' ";
            $query .= " AND (CPB_Flag IS NULL OR CPB_Flag = '') ";
            $query .= "     AND CPB_NoPB = '" . $noPB . "'";
            $query .= "     AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB . "','DD-MM-YYYY') ";
            $query .= "     AND CPB_KodeToko = '" . $KodeToko . "') ";
        }
        $query .= "WHEN MATCHED THEN ";
        $query .= "  UPDATE SET CPB_JenisPB = b.JenisPB ";
    }

    //! PROSES F6 - ProsesAlokasi3()
    public function actionF6(){

        //! VARIABLE
        $ip = $this->GetIP();

        // If dgvHeader.RowCount = 0 Then MsgBox("Belum Ada PB Reguler!!", MsgBoxStyle.Information, ProgName) : Return False
        // If MsgBox("Yakin Akan Proses Alokasi (Sudah Tarik Semua Data PBBH) ?? ", MsgBoxStyle.YesNo, ProgName) = MsgBoxResult.No Then Return False

        //! CEK DATA ALOKASI BUAH
        // sb.AppendLine("SELECT COALESCE(Count(0),0)  ")
        // sb.AppendLine("  FROM alokasi_buah ")
        // sb.AppendLine(" WHERE Flag_proses IS NULL ")

        $count = DB::table('alokasi_buah')
            ->whereNull('Flag_proses')
            ->count();

        //? if jum = 0
        if($count ==  0){
            //* Tidak Ada Data Alokasi Buah Yang Dapat Diproses !!
            return ApiFormatter::error(400, 'Tidak Ada Data Alokasi Buah Yang Dapat Diproses !!');
        }

        //! CEK DATA ALOKASI BUAH
        $count = DB::select("
            WITH A AS
            (
                SELECT PLUIDM,KD_TOKO,Count(DOCNO)
                FROM alokasi_buah
                GROUP BY PLUIDM,KD_TOKO
                HAVING Count(DOCNO) > 1
            ) SELECT COALESCE(COUNT(0),0) FROM A
        ");

        //? if jum > 0
        if($count[0]->coalesce > 0){
            //* Terdapat Double Record Untuk ALOKASI_BUAH!!" & vbNewLine & "Harap Menghubungi MD Untuk Penyelesaiannya
            return ApiFormatter::error(400, 'Terdapat Double Record Untuk ALOKASI_BUAH!! Harap Menghubungi MD Untuk Penyelesaiannya');

        }

        //! DELETE FROM TEMP_ALOKASI_BUAH
        DB::table('temp_alokasi_buah')
            ->where('ip', $ip)
            ->delete();

        //! INSERT INTO TEMP_ALOKASI_BUAH
        DB::insert("
            INSERT INTO TEMP_ALOKASI_BUAH
            (
                JENIS,
                TOKO,
                PLUIDM,
                QTY,
                IP
            )
            SELECT CASE DEPT
                    WHEN '31' THEN 'IMPORT'
                    WHEN '32' THEN 'LOKAL'
                    ELSE 'CHILLED FOOD' END AS JENIS,
                KD_TOKO,
                PLUIDM,
                QTY,
                '" . $ip . "'
            FROM alokasi_buah
            WHERE Flag_proses IS NULL
        ");

        //! MERGE INTO CSV_PB_BUAH
        DB::insert("
            MERGE INTO
                CSV_PB_BUAH a
            USING (
                SELECT TOKO,
                    PLUIDM,
                    QTY
                FROM TEMP_ALOKASI_BUAH
                WHERE IP = '" . $ip . "'
            ) B
            ON
            (
                a.CPB_KodeToko = b.TOKO
                AND a.CPB_PLUIDM = b.PLUIDM
                    and DATE_TRUNC('DAY', CPB_TGLPROSES) >= CURRENT_DATE - 7
                AND (CPB_Flag IS NULL OR CPB_Flag = '')
                    AND CPB_IP = '" . $ip . "'
            )
            WHEN MATCHED THEN
            UPDATE SET CPB_QTY = b.QTY,
                CPB_ALOKASIBUAH = 'ALOKASI_BUAH'
        ");

        //! UPDATE alokasi_buah
        // sb.AppendLine("UPDATE alokasi_buah ")
        // sb.AppendLine("   SET FLAG_PROSES = '1', ")
        // sb.AppendLine("       USERID_Proses = '" & UserID & "', ")
        // sb.AppendLine("       TGL_Proses = CURRENT_TIMESTAMP ")
        // sb.AppendLine(" WHERE Flag_Proses IS NULL   ")

        DB::table('alokasi_buah')
            ->whereNull('Flag_Proses')
            ->update([
                'FLAG_PROSES' => '1',
                'USERID_Proses' => session('userid'),
                'TGL_Proses' => Carbon::now(),
            ]);

        //! INSERT INTO HISTORY_Alokasi_Buah
        DB::insert("
            INSERT INTO HISTORY_Alokasi_Buah
            (
                KD_TOKO,
                DOCNO,
                TGL_DATA_AL,
                PLUIDM,
                PLUIGR,
                QTY,
                DEPT,
                KATG,
                CREATE_BY,
                CREATE_DT,
                FLAG_PROSES,
                USERID_PROSES,
                TGL_PROSES
            )
            SELECT KD_TOKO,
                DOCNO,
                TGL_DATA_AL,
                PLUIDM,
                PLUIGR,
                QTY,
                DEPT,
                KATG,
                CREATE_BY,
                CREATE_DT,
                FLAG_PROSES,
                USERID_PROSES,
                TGL_PROSES
            FROM alokasi_buah
            WHERE Flag_proses IS NOT NULL
                AND DATE_TRUNC('DAY', TGL_DATA_AL) < CURRENT_DATE - 30
        ");

        //! DELETE FROM Alokasi_Buah
        // sb.AppendLine("DELETE FROM Alokasi_Buah ")
        // sb.AppendLine(" WHERE Flag_proses IS NOT NULL ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', TGL_DATA_AL) < CURRENT_DATE - 30  ")
        DB::table('Alokasi_Buah')
            ->whereNotNull('Flag_proses')
            ->whereRaw("DATE_TRUNC('DAY', TGL_DATA_AL) < CURRENT_DATE - 30")
            ->delete();

        return ApiFormatter::success(200, 'Proses Alokasi Buah Selesai');

        //* Proses Alokasi Buah Selesai

        //? kasih catch jika gagal maka return false
    }

    //! Keys.F8, Keys.F9, Keys.F10
    public function actionF8F9F10(){

        //! VARIABLE
        $jum = '';
        $buttonPress = '';
        $NoUrJenisPB = 0;
        // If Strings.Format(Now, "HHmmss") >= "234000" Then
        //     MsgBox("Mohon Tunggu Sampai JAM 12 MALAM" & vbNewLine & "Untuk Melakukan UPLOAD PB!!", MsgBoxStyle.Information, ProgName)
        //     Exit Sub
        // End If

        // Dim JenisPB As String = ""
        // If e.KeyCode = Keys.F8 Then
        //     JenisPB = "IMPORT"
        // ElseIf e.KeyCode = Keys.F9 Then
        //     JenisPB = "LOKAL"
        // ElseIf e.KeyCode = Keys.F10 Then
        //     JenisPB = "CHILLED FOOD"
        // End If

        //! CHECK TOMBOL YANG DITEKAN
        if($buttonPress == 'F8'){
            $jenisPB = 'IMPORT';
        }elseif($buttonPress == 'F9'){
            $jenisPB = 'LOKAL';
        }elseif($buttonPress == 'F10'){
            $jenisPB = 'CHILLED FOOD';
        }

        //* YAKIN INGIN MEMPROSES" & vbNewLine & PADC(JenisPB & " ??

        //? check apakah datatables header ada isinya?
        //? jika tidak

        //*  Tidak Ada Data " & JenisPB & " Yang Dapat Diproses !

        //? open form frmNoUrutBuah

        //! DELETE FROM TEMP_PB_VALID
        // sb.AppendLine("DELETE FROM TEMP_PB_VALID ")
        // sb.AppendLine(" Where IP = '" & IP & "' ")

        //? check jika datatables header dan detail harus ada

        //! GET URUTAN JENISPB
        // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
        // sb.AppendLine("  FROM URUTAN_JENISPB_BUAH ")
        // sb.AppendLine(" WHERE DATE_TRUNC('DAY', UJB_CREATE_DT) = CURRENT_DATE ")
        // sb.AppendLine("   AND UJB_JenisPB = '" & JenisPB & "' ")

        if($jum == 0){
            //! GET URUTAN NoUrJenisPB
            //? result nanti NoUrJenisPB+1 untuk jadi variable NoUrJenisPB
            // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
            // sb.AppendLine("  FROM URUTAN_JENISPB_BUAH ")
            // sb.AppendLine(" WHERE DATE_TRUNC('DAY', UJB_CREATE_DT) = CURRENT_DATE ")

            $count = DB::table('URUTAN_JENISPB_BUAH')
                ->whereRaw("DATE_TRUNC('DAY', UJB_CREATE_DT) = CURRENT_DATE")
                ->count();

            $NoUrJenisPB = $count + 1;

            //! INSERT INTO URUTAN_JENISPB_BUAH
            // sb.AppendLine("INSERT INTO URUTAN_JENISPB_BUAH ")
            // sb.AppendLine("( ")
            // sb.AppendLine("  UJB_JenisPB, ")
            // sb.AppendLine("  UJB_NoUrut, ")
            // sb.AppendLine("  UJB_Create_By, ")
            // sb.AppendLine("  UJB_Create_Dt ")
            // sb.AppendLine(") ")
            // sb.AppendLine("VALUES ")
            // sb.AppendLine("( ")
            // sb.AppendLine("  '" & JenisPB & "', ")
            // sb.AppendLine("  " & NoUrJenisPB & ", ")
            // sb.AppendLine("  '" & UserID & "', ")
            // sb.AppendLine("  CURRENT_TIMESTAMP ")
            // sb.AppendLine(") ")
        }else{
            //! GET URUTAN JENISPB -> NoUrJenisPB
            // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
            // sb.AppendLine("  FROM URUTAN_JENISPB_BUAH ")
            // sb.AppendLine(" WHERE DATE_TRUNC('DAY', UJB_CREATE_DT) = CURRENT_DATE ")
            // sb.AppendLine("   AND UJB_JenisPB = '" & JenisPB & "' ")

            $count = DB::table('URUTAN_JENISPB_BUAH')
                ->where('UJB_JenisPB', $jenisPB)
                ->whereRaw("DATE_TRUNC('DAY', UJB_CREATE_DT) = CURRENT_DATE")
                ->count();

            $NoUrJenisPB = $count;
        }

        //!LOOP DATATABLES HEADER

            // If dgvHeader.Rows(i).Cells(0).Value <> JenisPB Then GoTo skipPBBH
            // KodeToko = dgvHeader.Rows(i).Cells(3).Value.ToString
            // noPB = dgvHeader.Rows(i).Cells(1).Value.ToString
            // tglPB = dgvHeader.Rows(i).Cells(2).Value.ToString

            //! GET KODETOKO TIDAK TERDAFTAR
            // sb.AppendLine("Select DISTINCT CPB_KodeToko ")
            // sb.AppendLine("  From CSV_PB_Buah ")
            // sb.AppendLine(" Where CPB_NoPB = '" & noPB & "' ")
            // sb.AppendLine("   and DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" & tglPB & "','DD-MM-YYYY') ")
            // sb.AppendLine("   And CPB_IP = '" & IP & "' ")
            // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
            // sb.AppendLine("   and NOT EXISTS ")
            // sb.AppendLine("   ( ")
            // sb.AppendLine("     Select CLB_Toko ")
            // sb.AppendLine("	      From CLUSTER_BUAH ")
            // sb.AppendLine("	     Where CLB_Toko = CPB_KodeToko ")
            // sb.AppendLine("   ) ")

            if(count($TokoTidakTerdaftar)){
                $listToko = '';
                foreach($TokoTidakTerdaftar as $item){
                    //? list toko disini
                }
                //* TOKO " & TokoTidakTerdaftar & " BELUM TERDAFTAR DI CLUSTER_BUAH!!
            }

            //! CEK SUDAH TERDAFTAR DI tbMaster_TokoIGR-2
            // sb.AppendLine("Select DISTINCT CPB_KodeToko ")
            // sb.AppendLine("  From CSV_PB_BUAH ")
            // sb.AppendLine(" Where CPB_NoPB = '" & noPB & "' ")
            // sb.AppendLine("   and DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" & tglPB & "','DD-MM-YYYY') ")
            // sb.AppendLine("   and CPB_IP = '" & IP & "' ")
            // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
            // sb.AppendLine("   and NOT EXISTS ")
            // sb.AppendLine("   ( ")
            // sb.AppendLine("     Select Tko_KodeOMI ")
            // sb.AppendLine("	      From tbMaster_TokoIGR ")
            // sb.AppendLine("	     Where Tko_KodeOMI = CPB_KodeToko ")
            // sb.AppendLine("        And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE ")
            // sb.AppendLine("   ) ")

            if(count($TokoTidakTerdaftar2)){
                $listToko2 = '';
                foreach($TokoTidakTerdaftar2 as $item){
                    //? list toko disini
                }
                //* TOKO " & TokoTidakTerdaftar2 & " Tidak Terdaftar Di TbMaster_TokoIGR !!
            }

            //! CEK SUDAH TERDAFTAR DI tbMaster_TokoIGR-2
            // sb.AppendLine("Select DISTINCT CPB_KodeToko ")
            // sb.AppendLine("  From CSV_PB_BUAH ")
            // sb.AppendLine(" Where CPB_NoPB = '" & noPB & "' ")
            // sb.AppendLine("   and DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" & tglPB & "','DD-MM-YYYY') ")
            // sb.AppendLine("   and CPB_IP = '" & IP & "' ")
            // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
            // sb.AppendLine("   and EXISTS ")
            // sb.AppendLine("   ( ")
            // sb.AppendLine("     Select Tko_KodeSBU ")
            // sb.AppendLine("	      From tbMaster_TokoIGR ")
            // sb.AppendLine("	     Where Tko_KodeOMI = CPB_KodeToko ")
            // sb.AppendLine("	       And Tko_KodeSBU <> 'I' ")
            // sb.AppendLine("        And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE ")
            // sb.AppendLine("   ) ")

            if(count($SBUNotI)){
                $listSBUNotI = '';
                foreach($SBUNotI as $item){
                    //? list toko disini
                }
                //* TOKO " & SBUNotI & " KODE SBU nya Bukan I !!
            }

            //! CEK JADWAL KIRIM BUAH
            // sb.AppendLine("Select DISTINCT CPB_KodeToko ")
            // sb.AppendLine("  From CSV_PB_BUAH ")
            // sb.AppendLine(" Where CPB_NoPB = '" & noPB & "' ")
            // sb.AppendLine("   and DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" & tglPB & "','DD-MM-YYYY') ")
            // sb.AppendLine("   and CPB_IP = '" & IP & "' ")
            // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
            // sb.AppendLine("   and NOT EXISTS ")
            // sb.AppendLine("   ( ")
            // sb.AppendLine("SELECT JKB_HARI ")
            // sb.AppendLine("  FROM JADWAL_KIRIM_BUAH ")
            // sb.AppendLine(" WHERE JKB_KodeToko = CPB_KodeToko ")
            // sb.AppendLine("   AND JKB_Hari = CASE Trim(To_Char(CURRENT_DATE,'DAY'))  ")
            // sb.AppendLine("                   WHEN 'SATURDAY' THEN 'SENIN' ")
            // sb.AppendLine("                   WHEN 'SUNDAY' THEN 'SENIN' ")
            // sb.AppendLine("                   WHEN 'MONDAY' THEN 'SELASA' ")
            // sb.AppendLine("                   WHEN 'TUESDAY' THEN 'RABU' ")
            // sb.AppendLine("                   WHEN 'WEDNESDAY' THEN 'KAMIS' ")
            // sb.AppendLine("                   WHEN 'THURSDAY' THEN 'JUMAT' ")
            // sb.AppendLine("                   WHEN 'FRIDAY' THEN 'SABTU' ")
            // sb.AppendLine("                   WHEN 'SABTU' THEN 'SENIN' ")
            // sb.AppendLine("                   WHEN 'MINGGU' THEN 'SENIN' ")
            // sb.AppendLine("                   WHEN 'SENIN' THEN 'SELASA' ")
            // sb.AppendLine("                   WHEN 'SELASA' THEN 'RABU' ")
            // sb.AppendLine("                   WHEN 'RABU' THEN 'KAMIS' ")
            // sb.AppendLine("                   WHEN 'KAMIS' THEN 'JUMAT' ")
            // sb.AppendLine("                   WHEN 'JUMAT' THEN 'SABTU' ")
            // sb.AppendLine("                   ELSE 'SAPI' ")
            // sb.AppendLine("                  END     ")
            // sb.AppendLine("   ) ")

            if(count($KirimHariIni)){
                $listSBUNotI = '';
                foreach($KirimHariIni as $item){
                    //? list toko disini
                }
                //* Hari Ini Bukan Jadwal Picking Untuk TOKO " & KirimHariIni
            }

            // ProsesPBIDM(dgvHeader.Rows(i).Cells(3).Value, txtPathFilePBBH.Text & "\" & dgvHeader.Rows(i).Cells(6).Value, JenisPB, NoUrJenisPB)

            if(AdaProses){
                //! INSERT INTO TEMP_PB_VALID
                // sb.AppendLine("INSERT INTO TEMP_PB_VALID ")
                // sb.AppendLine("( ")
                // sb.AppendLine("  KodeToko, ")
                // sb.AppendLine("  NoPB, ")
                // sb.AppendLine("  TglPB, ")
                // sb.AppendLine("  IP ")
                // sb.AppendLine(") ")
                // sb.AppendLine("VALUES ")
                // sb.AppendLine("( ")
                // sb.AppendLine(" '" & KodeToko & "', ")
                // sb.AppendLine(" '" & noPB & "', ")
                // sb.AppendLine(" TO_DATE('" & tglPB & "','DD-MM-YYYY'), ")
                // sb.AppendLine(" '" & IP & "'  ")
                // sb.AppendLine(") ")

                $JumlahPB += 1;
            }

            skipPBBH:


        //! END LOOP DATATABLES HEADER

        if($JumlahPB == 0){
            //* Tidak Ada PB " & JenisPB & " !!
        }

        //! HITUNG JUMLAH ITEM DI PBOMI
        // sb.AppendLine("SELECT COALESCE(Count(0),0)  ")
        // sb.AppendLine("  FROM tbMaster_pbomi  ")
        // sb.AppendLine(" WHERE EXISTS ")
        // sb.AppendLine(" ( ")
        // sb.AppendLine("   SELECT cpb_kodetoko  ")
        // sb.AppendLine("     FROM csv_pb_buah,  ")
        // sb.AppendLine("          cluster_buah  ")
        // sb.AppendLine("    WHERE CPB_JenisPB = '" & JenisPB & "'  ")
        // sb.AppendLine("      AND CPB_RecordID IS NULL  ")
        // sb.AppendLine("      AND CPB_IP = '" & IP & "'  ")
        // sb.AppendLine("      AND CLB_Toko = CPB_KodeToko  ")
        // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
        // sb.AppendLine("      AND cpb_kodetoko = pbo_kodeomi ")
        // sb.AppendLine("      AND cpb_nopb = pbo_nopb ")
        // sb.AppendLine("      AND cpb_tglpb = pbo_tglpb  ")
        // sb.AppendLine("      AND EXISTS  ")
        // sb.AppendLine("   (  ")
        // sb.AppendLine("   SELECT KodeToko  ")
        // sb.AppendLine("     FROM TEMP_PB_VALID  ")
        // sb.AppendLine("    WHERE KodeToko = CPB_KodeToko  ")
        // sb.AppendLine("      AND NoPB = CPB_NoPB  ")
        // sb.AppendLine("      AND TglPB = CPB_TglPB  ")
        // sb.AppendLine("      AND IP = '" & IP & "'   ")
        // sb.AppendLine("   )  ")
        // sb.AppendLine(" ) ")

        if($jum > 0){
            //! INSERT INTO PICKING_ANTRIAN_BUAH
            // sb.AppendLine("INSERT INTO PICKING_ANTRIAN_BUAH ")
            // sb.AppendLine("( ")
            // sb.AppendLine("  PAB_KodeCluster, ")
            // sb.AppendLine("  PAB_JenisPB,   ")
            // sb.AppendLine("  PAB_Create_By, ")
            // sb.AppendLine("  PAB_Create_Dt ")
            // sb.AppendLine(") ")
            // sb.AppendLine("SELECT DISTINCT CLB_Kode AS KodeCluster, ")
            // sb.AppendLine("       '" & JenisPB & "' AS JenisPB, ")
            // sb.AppendLine("       '" & UserID & "', ")
            // sb.AppendLine("       CURRENT_DATE  ")
            // sb.AppendLine("  FROM csv_pb_buah, ")
            // sb.AppendLine("       cluster_buah ")
            // sb.AppendLine(" WHERE CPB_JenisPB = '" & JenisPB & "' ")
            // sb.AppendLine("   AND CPB_RecordID IS NULL ")
            // sb.AppendLine("   AND CPB_IP = '" & IP & "' ")
            // sb.AppendLine("   AND CLB_Toko = CPB_KodeToko ")
            // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
            // sb.AppendLine("   AND EXISTS ")
            // sb.AppendLine("( ")
            // sb.AppendLine("SELECT KodeToko ")
            // sb.AppendLine("  FROM TEMP_PB_VALID ")
            // sb.AppendLine(" WHERE KodeToko = CPB_KodeToko ")
            // sb.AppendLine("   AND NoPB = CPB_NoPB ")
            // sb.AppendLine("   AND TglPB = CPB_TglPB ")
            // sb.AppendLine("   AND IP = '" & IP & "' ")
            // sb.AppendLine(") ")
        }

        //! SET FLAG CSV_PB_BUAH
        // sb.AppendLine("UPDATE CSV_PB_BUAH ")
        // sb.AppendLine("   SET CPB_Flag = '1' ")
        // sb.AppendLine(" WHERE CPB_IP = '" & IP & "' ")
        // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
        // sb.AppendLine("   AND EXISTS ")
        // sb.AppendLine("   ( ")
        // sb.AppendLine("     SELECT KodeToko ")
        // sb.AppendLine("       FROM TEMP_PB_VALID ")
        // sb.AppendLine("      WHERE KodeToko = CPB_KodeToko ")
        // sb.AppendLine("        AND NoPB = CPB_NoPB ")
        // sb.AppendLine("        AND TglPB = CPB_TglPB ")
        // sb.AppendLine("        AND IP = '" & IP & "' ")
        // sb.AppendLine("   ) ")

        //* PROSES UPLOAD " & JenisPB & " SELESAI DILAKUKAN
    }
}
