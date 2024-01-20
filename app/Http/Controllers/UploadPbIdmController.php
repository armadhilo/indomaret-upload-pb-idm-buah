<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
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

        //! CHECK MASTER_SUPPLY_IDM
        // sb.AppendLine(" SELECT COUNT(DISTINCT msi_kodedc)  ")
        // sb.AppendLine(" FROM master_supply_idm  ")
        // sb.AppendLine(" WHERE msi_kodeigr = '" & KDIGR & "' ")

       //? if jum > 0 lanjut CHECK TBMASTER_PLUIDM jika kosong $flag_pluidm = false

            //! CHECK TBMASTER_PLUIDM
            // sb.AppendLine(" SELECT idm_kodeidm, COUNT(DISTINCT idm_pluidm) jml_pluidm ")
            // sb.AppendLine("  FROM tbmaster_pluidm  ")
            // sb.AppendLine("  WHERE idm_kodeigr = '" & KDIGR & "' ")
            // sb.AppendLine("  AND EXISTS ( ")
            // sb.AppendLine("        SELECT msi_kodedc  ")
            // sb.AppendLine("        FROM master_supply_idm  ")
            // sb.AppendLine("        WHERE msi_kodedc = idm_kodeidm ")
            // sb.AppendLine("        AND msi_kodeigr = idm_kodeigr ")
            // sb.AppendLine("      ) ")
            // sb.AppendLine("  GROUP BY idm_kodeidm ")
            // sb.AppendLine("  HAVING COUNT(DISTINCT idm_pluidm) > 0 ")

            //? if jum > 0 $flag_pluidm = true jika kosong $flag_pluidm = false

        //! ISI GRID HEADER
        // sb.AppendLine("Select COALESCE(Count(1),0) ")
        // sb.AppendLine("  From CSV_PB_BUAH ")
        // sb.AppendLine(" Where DATE_TRUNC('DAY', CPB_TGLPROSES) >= CURRENT_DATE - 7  ")
        // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
        // sb.AppendLine("   AND CPB_IP = '" & IP & "'  ")

        //? if jum > 0 panggil function RefreshGridHeader
    }

    private function RefreshGridHeader(){
        //! DELETE TEMP_CSV_PB_BUAH
        // sb.AppendLine("DELETE FROM TEMP_CSV_PB_BUAH ")
        // sb.AppendLine(" WHERE REQ_ID = '" & getIP() & "' ")

        //! INSERT INTO TEMP_CSV_PB_BUAH
        // sb.AppendLine("INSERT INTO TEMP_CSV_PB_BUAH ")
        // sb.AppendLine("( ")
        // sb.AppendLine("       JENIS, ")
        // sb.AppendLine("       NoPB, ")
        // sb.AppendLine("       TglPB, ")
        // sb.AppendLine("       TOKO, ")
        // sb.AppendLine("       PLUIDM, ")
        // sb.AppendLine("       PLUIGR, ")
        // sb.AppendLine("       QTY, ")
        // sb.AppendLine("       RUPIAH, ")
        // sb.AppendLine("       STOCK, ")
        // sb.AppendLine("       NAMA_FILE, ")
        // sb.AppendLine("       REQ_ID ")
        // sb.AppendLine(") ")

        // sb.AppendLine(" SELECT CASE prd_kodedepartement ")
        // sb.AppendLine("         WHEN '31' THEN 'IMPORT' ")
        // sb.AppendLine(" 		WHEN '32' THEN 'LOKAL' ")
        // sb.AppendLine(" 		ELSE 'CHILLED FOOD' ")
        // sb.AppendLine(" 	   END as JENIS, ")
        // sb.AppendLine("        noPB, ")
        // sb.AppendLine("        TGLPB, ")
        // sb.AppendLine("        TOKO as TOKO, ")
        // sb.AppendLine("        PLUIDM as PLUIDM, ")
        // sb.AppendLine("        PLUIGR as PLUIGR, ")
        // sb.AppendLine("        QTY, ")
        // sb.AppendLine("        COALESCE(ST_AVGCOST,0) ")
        // sb.AppendLine(" 	    / CASE WHEN PRD_UNIT = 'KG' THEN 1000 ELSE 1 END ")
        // sb.AppendLine(" 	    * QTY / CASE WHEN IDM_MINORDER::numeric = 1000 THEN 1000 ELSE 1 END as RUPIAH, ")
        // sb.AppendLine("        COALESCE(ST_SaldoAkhir,0) STOCK, ")
        // sb.AppendLine("        NAMA_FILE, ")
        // sb.AppendLine("        REQ_ID ")
        // sb.AppendLine("   FROM ( ")
        // If flagPLUIDM Then
        //     sb.AppendLine("     SELECT CPB_NoPB as NOPB, ")
        //     sb.AppendLine("            TO_CHAR(CPB_TGLPB,'DD-MM-YYYY') as TGLPB, ")
        //     sb.AppendLine("            CPB_KodeTOKO as TOKO, ")
        //     sb.AppendLine("            CPB_PLUIDM as PLUIDM, ")
        //     sb.AppendLine("            IDM_PLUIGR as PLUIGR, ")
        //     sb.AppendLine("            CPB_QTY as QTY, ")
        //     sb.AppendLine(" 	       SUBSTR(CPB_FILENAME,POSITION('PB' IN CPB_FILENAME)) AS NAMA_FILE, ")
        //     sb.AppendLine("            '" & IP & "' as REQ_ID, ")
        //     sb.AppendLine("            IDM_MINORDER, ")
        //     sb.AppendLine("            PRD_KodeDepartement, ")
        //     sb.AppendLine("            PRD_Unit ")
        //     sb.AppendLine("       FROM CSV_PB_BUAH ")
        //     sb.AppendLine("       JOIN master_supply_idm ")
        //     sb.AppendLine("     	ON CPB_KodeTOKO = MSI_KodeTOKO ")
        //     sb.AppendLine("       JOIN tbMaster_PLUIDM ")
        //     sb.AppendLine(" 	    ON CPB_PLUIDM = IDM_PLUIDM ")
        //     sb.AppendLine("        AND MSI_KodeDC = IDM_KodeIDM ")
        //     sb.AppendLine("       JOIN tbMaster_PRODMAST ")
        //     sb.AppendLine(" 	    ON PRD_PRDCD = IDM_PLUIGR ")
        //     sb.AppendLine("      WHERE DATE_TRUNC('DAY', CPB_TGLPROSES) >= DATE_TRUNC('DAY', CURRENT_DATE - 7) ")
        //     sb.AppendLine("        AND (CPB_FLAG IS NULL OR CPB_FLAG = '') ")
        //     sb.AppendLine("        AND CPB_IP = '" & IP & "' ")
        // Else
        //     sb.AppendLine("     SELECT CPB_NoPB as NOPB,   ")
        //     sb.AppendLine("            TO_CHAR(CPB_TGLPB,'DD-MM-YYYY') as TGLPB,   ")
        //     sb.AppendLine("            CPB_KodeTOKO as TOKO, ")
        //     sb.AppendLine("            CPB_PLUIDM as PLUIDM, ")
        //     sb.AppendLine("            PRC_PLUIGR as PLUIGR, ")
        //     sb.AppendLine("            CPB_QTY as QTY, ")
        //     sb.AppendLine(" 	       SUBSTR(CPB_FILENAME,POSITION('PB' IN CPB_FILENAME)) AS NAMA_FILE, ")
        //     sb.AppendLine("            '" & IP & "' as REQ_ID, ")
        //     sb.AppendLine("            PRC_MINORDER, ")
        //     sb.AppendLine("            PRD_KodeDepartement, ")
        //     sb.AppendLine("            PRD_Unit ")
        //     sb.AppendLine("       FROM CSV_PB_BUAH ")
        //     sb.AppendLine("       JOIN tbmaster_prodcrm ")
        //     sb.AppendLine("         ON CPB_PLUIDM = PRC_PLUIDM ")
        //     sb.AppendLine("       JOIN tbMaster_PRODMAST ")
        //     sb.AppendLine("         ON PRD_PRDCD = PRC_PLUIGR ")
        //     sb.AppendLine("      WHERE DATE_TRUNC('DAY', CPB_TGLPROSES) >= DATE_TRUNC('DAY', CURRENT_DATE - 7) ")
        //     sb.AppendLine("        AND (CPB_FLAG IS NULL OR CPB_FLAG = '') ")
        //     sb.AppendLine("        AND CPB_IP = '" & IP & "' ")
        // End If
        // sb.AppendLine("   ) A ")
        // sb.AppendLine("   LEFT JOIN tbMaster_STOCK ")
        // sb.AppendLine("     ON A.PLUIGR = ST_PRDCD ")
        // sb.AppendLine("    AND ST_LOKASI = '01' ")

        //! ISI DATAGRID HEADER PB IDM
        // sb.AppendLine("Select JENIS, ")
        // sb.AppendLine("       NOPB, ")
        // sb.AppendLine("       TGLPB, ")
        // sb.AppendLine("       TOKO, ")
        // sb.AppendLine("       COUNT(DISTINCT PLUIDM) as PLU, ")
        // sb.AppendLine("       SUM(RUPIAH) as RUPIAH, ")
        // sb.AppendLine("       NAMA_FILE ")
        // sb.AppendLine("  FROM TEMP_CSV_PB_BUAH ")
        // sb.AppendLine(" WHERE REQ_ID = '" & IP & "'")
        // sb.AppendLine(" GROUP By JENIS, NOPB, TGLPB, TOKO, NAMA_FILE")
    }

    //! PROSES F3
    public function actionF3(){

        //! VARIABLE
        $SalahSatuPBGaLolos = FALSE;
        $jum = 0; //dummy

        //? ada proses decrypt file
        //? Decryption dengan metode AES alias RijndaelManaged
        //? 128 bit
        //? pass -> idm123

        //? jika data kosong goto SkipRecordKosongPBM

        //! DELETE CSV_PB_BUAH2 WHERE DATE_TRUNC('DAY', CPB_TGLPROSES) = CURRENT_DATE
        // sb.AppendLine("DELETE FROM CSV_PB_BUAH2 ")
        // sb.AppendLine(" Where CPB_IP = '" & IP & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TGLPROSES) = CURRENT_DATE ")

        //! START LOOP

        //? 03-01-2014 KALAU ADA REVISI PB UNTUK HARI INI
        //! DELETE CSV_PB_BUAH2 WHERE DATE_TRUNC('DAY', CPB_TglProses) = CURRENT_DATE AND CPB_NoPB
        // sb.AppendLine("DELETE FROM CSV_PB_BUAH2 ")
        // sb.AppendLine(" Where CPB_IP = '" & IP & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TglProses) = CURRENT_DATE ")
        // sb.AppendLine("   AND CPB_NoPB = '" & noPB & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("   AND CPB_KodeToko = '" & KodeToko & "' ")

        //! DELETE CSV_PB_BUAH WHERE DATE_TRUNC('DAY', CPB_TglProses) = CURRENT_DATE AND CPB_NoPB
        // sb.AppendLine("DELETE FROM CSV_PB_BUAH ")
        // sb.AppendLine(" Where CPB_IP = '" & IP & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TglProses) = CURRENT_DATE ")
        // sb.AppendLine("   AND CPB_NoPB = '" & noPB & "' ")
        // sb.AppendLine("   AND To_Char(CPB_TglPB,'DD-MM-YYYY') = '" & tglPB & "' ")
        // sb.AppendLine("   AND CPB_KodeToko = '" & KodeToko & "' ")

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

        // sb.AppendLine("SELECT COALESCE(Count(DISTINCT CPB_NoPB),0)  ")
        // sb.AppendLine("  FROM CSV_PB_BUAH2 ")
        // sb.AppendLine(" WHERE EXISTS ")
        // sb.AppendLine(" ( ")
        // sb.AppendLine("    SELECT pbo_nopb ")
        // sb.AppendLine("      FROM TBMASTER_PBOMI ")
        // sb.AppendLine("     WHERE PBO_NOPB = CPB_NoPB ")
        // sb.AppendLine("       AND PBO_KODEOMI = CPB_KodeToko ")
        // sb.AppendLine("       AND DATE_TRUNC('DAY', PBO_TGLPB) = DATE_TRUNC('DAY', CPB_TglPB) ")
        // sb.AppendLine("       AND CPB_NoPB ='" & noPB & "' ")
        // sb.AppendLine("       AND To_Char(CPB_TglPB,'DD-MM-YYYY')='" & tglPB & "'  ")
        // sb.AppendLine("       AND CPB_KodeToko = '" & KodeToko & "' ")
        // sb.AppendLine(" ) ")
        // sb.AppendLine("   AND CPB_KodeToko = '" & KodeToko & "' ")
        // sb.AppendLine("   AND CPB_NoPB ='" & noPB & "' ")
        // sb.AppendLine("   AND To_Char(CPB_TglPB,'DD-MM-YYYY')='" & tglPB & "' ")

        if($jum > 0){
            $SalahSatuPBGaLolos = true;
            //? continue;

            //* No Dokumen:" & noPB & vbNewLine & "Tanggal:" & tglPB & vbNewLine & "File:" & fi.Name & vbNewLine & vbNewLine & "SUDAH PERNAH DIPROSES!!!

        }

        //! GET PLU DOBEL BUAH
        // sb.AppendLine("Select CPB_PluIDM,COALESCE(count(CPB_KodeToko),0) ")
        // sb.AppendLine("  From CSV_PB_BUAH2 ")
        // sb.AppendLine(" Where CPB_IP = '" & IP & "'")
        // sb.AppendLine("   AND CPB_NoPB = '" & noPB & "'")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("   AND CPB_KodeToko = '" & KodeToko & "' ")
        // sb.AppendLine(" Group By CPB_PluIDM ")
        // sb.AppendLine("Having count(CPB_KodeToko) > 1 ")

        if($jum > 0){
            $SalahSatuPBGaLolos = true;
            //? continue;

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

        if($jum > 0){
            $SalahSatuPBGaLolos = true;
            //? continue;

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

        // $kodeDCIDM = $this->kodeDCIDM($kode_toko);

        //! MERGE INTO CSV_PB_BUAH - UPDATE JENISPB
        // sb.AppendLine("MERGE INTO ")
        // sb.AppendLine("     CSV_PB_BUAH A ")
        // sb.AppendLine("USING ")
        // sb.AppendLine("( ")
        // If kodeDCIDM <> "" Then
        // sb.AppendLine("  SELECT IDM_PLUIDM, ")
        // Else
        // sb.AppendLine("  SELECT PRC_PLUIDM, ")
        // End If
        // sb.AppendLine("         CASE PRD_KodeDepartement ")
        // sb.AppendLine("           WHEN '31' THEN 'IMPORT' ")
        // sb.AppendLine("           WHEN '32' THEN 'LOKAL' ")
        // sb.AppendLine("           ELSE 'CHILLED FOOD' ")
        // sb.AppendLine("         END AS JenisPB ")
        // If kodeDCIDM <> "" Then
        // sb.AppendLine("    FROM TBMASTER_PLUIDM,TBMASTER_PRODMAST ")
        // sb.AppendLine("   WHERE IDM_PLUIGR = PRD_PRDCD ")
        // sb.AppendLine("     AND PRD_KodeDivisi IN ('4','6') ")
        // sb.AppendLine("     AND IDM_KODEIDM = '" & kodeDCIDM & "' ")
        // sb.AppendLine(") b ")
        // sb.AppendLine("ON ")
        // sb.AppendLine("( a.CPB_PLUIDM = b.IDM_PLUIDM ")
        // sb.AppendLine("   AND CPB_IP = '" & IP & "' ")
        // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
        // sb.AppendLine("     AND CPB_NoPB = '" & noPB & "'")
        // sb.AppendLine("     AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("     AND CPB_KodeToko = '" & KodeToko & "') ")
        // Else
        // sb.AppendLine("    FROM TBMASTER_PRODCRM,TBMASTER_PRODMAST ")
        // sb.AppendLine("   WHERE PRC_PLUIGR = PRD_PRDCD ")
        // sb.AppendLine("     AND PRD_KodeDivisi IN ('4','6') ")
        // sb.AppendLine("     AND PRC_GROUP = 'I' ")
        // sb.AppendLine(") b ")
        // sb.AppendLine("ON ")
        // sb.AppendLine("( a.CPB_PLUIDM = b.PRC_PLUIDM ")
        // sb.AppendLine("   AND CPB_IP = '" & IP & "' ")
        // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
        // sb.AppendLine("     AND CPB_NoPB = '" & noPB & "'")
        // sb.AppendLine("     AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("     AND CPB_KodeToko = '" & KodeToko & "') ")
        // End If
        // sb.AppendLine("WHEN MATCHED THEN ")
        // sb.AppendLine("  UPDATE SET CPB_JenisPB = b.JenisPB ")

        //! END LOOP
    }

    public function actionF6(){
        // If dgvHeader.RowCount = 0 Then MsgBox("Belum Ada PB Reguler!!", MsgBoxStyle.Information, ProgName) : Return False
        // If MsgBox("Yakin Akan Proses Alokasi (Sudah Tarik Semua Data PBBH) ?? ", MsgBoxStyle.YesNo, ProgName) = MsgBoxResult.No Then Return False

        //! CEK DATA ALOKASI BUAH
        // sb.AppendLine("SELECT COALESCE(Count(0),0)  ")
        // sb.AppendLine("  FROM alokasi_buah ")
        // sb.AppendLine(" WHERE Flag_proses IS NULL ")

        //? if jum = 0
        //* Tidak Ada Data Alokasi Buah Yang Dapat Diproses !!

        //! CEK DATA ALOKASI BUAH
        // sb.AppendLine("WITH A AS ")
        // sb.AppendLine("( ")
        // sb.AppendLine("SELECT PLUIDM,KD_TOKO,Count(DOCNO)  ")
        // sb.AppendLine("  FROM alokasi_buah ")
        // sb.AppendLine(" GROUP BY PLUIDM,KD_TOKO ")
        // sb.AppendLine("HAVING Count(DOCNO) > 1 ")
        // sb.AppendLine(") SELECT COALESCE(COUNT(0),0) FROM A ")

        //? if jum > 0
        //* Terdapat Double Record Untuk ALOKASI_BUAH!!" & vbNewLine & "Harap Menghubungi MD Untuk Penyelesaiannya

        // ExecQRY("DELETE FROM TEMP_ALOKASI_BUAH WHERE IP = '" & IP & "' ", "DELETE FROM TEMP_ALOKASI_BUAH")

        //! INSERT INTO TEMP_ALOKASI_BUAH
        // sb.AppendLine("INSERT INTO TEMP_ALOKASI_BUAH ")
        // sb.AppendLine("(   ")
        // sb.AppendLine("  JENIS, ")
        // sb.AppendLine("  TOKO, ")
        // sb.AppendLine("  PLUIDM, ")
        // sb.AppendLine("  QTY, ")
        // sb.AppendLine("  IP ")
        // sb.AppendLine(") ")
        // sb.AppendLine("SELECT CASE DEPT ")
        // sb.AppendLine("         WHEN '31' THEN 'IMPORT' ")
        // sb.AppendLine("         WHEN '32' THEN 'LOKAL' ")
        // sb.AppendLine("         ELSE 'CHILLED FOOD' END AS JENIS, ")
        // sb.AppendLine("       KD_TOKO, ")
        // sb.AppendLine("       PLUIDM, ")
        // sb.AppendLine("       QTY, ")
        // sb.AppendLine("       '" & IP & "'  ")
        // sb.AppendLine("  FROM alokasi_buah ")
        // sb.AppendLine(" WHERE Flag_proses IS NULL ")

        //! MERGE INTO CSV_PB_BUAH
        // sb.AppendLine("MERGE INTO   ")
        // sb.AppendLine("               CSV_PB_BUAH a ")
        // sb.AppendLine("USING ")
        // sb.AppendLine("( ")
        // sb.AppendLine("  SELECT TOKO, ")
        // sb.AppendLine("         PLUIDM, ")
        // sb.AppendLine("         QTY ")
        // sb.AppendLine("    FROM TEMP_ALOKASI_BUAH ")
        // sb.AppendLine("   WHERE IP = '" & IP & "' ")
        // sb.AppendLine(") B ")
        // sb.AppendLine("ON ")
        // sb.AppendLine("( ")
        // sb.AppendLine("    a.CPB_KodeToko = b.TOKO ")
        // sb.AppendLine("AND a.CPB_PLUIDM = b.PLUIDM ")
        // sb.AppendLine("			   and DATE_TRUNC('DAY', CPB_TGLPROSES) >= CURRENT_DATE - 7 ")
        // sb.AppendLine(" AND (CPB_Flag IS NULL OR CPB_Flag = '') ")
        // sb.AppendLine("               AND CPB_IP = '" & IP & "' ")
        // sb.AppendLine(") ")
        // sb.AppendLine("WHEN MATCHED THEN ")
        // sb.AppendLine("  UPDATE SET CPB_QTY = b.QTY, ")
        // sb.AppendLine("			    CPB_ALOKASIBUAH = 'ALOKASI_BUAH' ")

        //! UPDATE alokasi_buah
        // sb.AppendLine("UPDATE alokasi_buah ")
        // sb.AppendLine("   SET FLAG_PROSES = '1', ")
        // sb.AppendLine("       USERID_Proses = '" & UserID & "', ")
        // sb.AppendLine("       TGL_Proses = CURRENT_TIMESTAMP ")
        // sb.AppendLine(" WHERE Flag_Proses IS NULL   ")

        //! INSERT INTO HISTORY_Alokasi_Buah
        // sb.AppendLine("INSERT INTO HISTORY_Alokasi_Buah ")
        // sb.AppendLine("( ")
        // sb.AppendLine("  KD_TOKO, ")
        // sb.AppendLine("  DOCNO, ")
        // sb.AppendLine("  TGL_DATA_AL, ")
        // sb.AppendLine("  PLUIDM, ")
        // sb.AppendLine("  PLUIGR, ")
        // sb.AppendLine("  QTY, ")
        // sb.AppendLine("  DEPT, ")
        // sb.AppendLine("  KATG, ")
        // sb.AppendLine("  CREATE_BY, ")
        // sb.AppendLine("  CREATE_DT, ")
        // sb.AppendLine("  FLAG_PROSES, ")
        // sb.AppendLine("  USERID_PROSES, ")
        // sb.AppendLine("  TGL_PROSES ")
        // sb.AppendLine(")   ")
        // sb.AppendLine("SELECT KD_TOKO, ")
        // sb.AppendLine("       DOCNO, ")
        // sb.AppendLine("       TGL_DATA_AL, ")
        // sb.AppendLine("       PLUIDM, ")
        // sb.AppendLine("       PLUIGR, ")
        // sb.AppendLine("       QTY, ")
        // sb.AppendLine("       DEPT, ")
        // sb.AppendLine("       KATG, ")
        // sb.AppendLine("       CREATE_BY, ")
        // sb.AppendLine("       CREATE_DT, ")
        // sb.AppendLine("       FLAG_PROSES, ")
        // sb.AppendLine("       USERID_PROSES, ")
        // sb.AppendLine("       TGL_PROSES ")
        // sb.AppendLine("  FROM alokasi_buah ")
        // sb.AppendLine(" WHERE Flag_proses IS NOT NULL ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', TGL_DATA_AL) < CURRENT_DATE - 30 ")

        //! DELETE FROM Alokasi_Buah
        // sb.AppendLine("DELETE FROM Alokasi_Buah ")
        // sb.AppendLine(" WHERE Flag_proses IS NOT NULL ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', TGL_DATA_AL) < CURRENT_DATE - 30  ")

        //* Proses Alokasi Buah Selesai

        //? kasih catch jika gagal maka return false
    }




}
