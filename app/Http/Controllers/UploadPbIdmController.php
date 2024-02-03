<?php

namespace App\Http\Controllers;

set_time_limit(0);

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class UploadPbIdmController extends Controller
{

    private $flag_pluidm;
    public function __construct(Request $request)
    {
        $this->flag_pluidm = false;
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }
    function index(){

        $this->CreateTabelBuah();
        $this->formLoad();

        return view("menu.upload-pb-idm");
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
                $this->flag_pluidm = true;
            }
       }
    }

    private function datatablesHeader(){

        $ip = $this->getIP();
        $flagPLUIDM = $this->flag_pluidm;

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
        $query .= "        COALESCE(ST_AVGCOST,0) / CASE WHEN PRD_UNIT = 'KG' THEN 1000 ELSE 1 END * QTY / CASE WHEN IDM_MINORDER::integer = 1000 THEN 1000 ELSE 1 END as RUPIAH,";
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
            $query .= "            PRC_MINORDER AS IDM_MINORDER,  ";
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
        DB::insert($query);
    }

    public function showDatatablesHeader(){

        $ip = $this->getIP();

        $count = DB::table('csv_pb_buah')
            ->where('cpb_ip', $ip)
            ->where(function($query){
                $query->whereNull('cpb_flag')
                    ->orWhere('cpb_flag','');
            })
            ->whereRaw("DATE_TRUNC('DAY', cpb_tglproses) >= CURRENT_DATE - 7")
            ->count();

        //? if jum > 0 panggil function RefreshGridHeader
        if($count > 0){
            $this->datatablesHeader();
        }

        //! ISI DATAGRID HEADER PB IDM
        $data = DB::select("
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

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //! PROSES F3
    public function actionF3(Request $request){
        $validator = validator($request->all(), [
            'files.*' => 'file|mimes:csv,txt', // Adjust max file size if needed
        ], [
            'files.*.mimes' => 'Invalid file type. Please upload .csv File.',
        ]);

        if ($validator->fails()) {
            return [
                'code' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $folderPath = $request->file('files');

        if (!$folderPath || empty($folderPath)) {
            return [
                'code' => 300,
                'message' => "Files Tidak Ditemukan!"
            ];
        }

        $dataCSV = [];

        foreach ($folderPath as $csvFile) {
            $csvData = Excel::toArray([], $csvFile);
            $header = $csvData[0][0];
            $rowData = array_slice($csvData[0], 1);
            $fileName = $csvFile->getClientOriginalName();;
            $groupedData = [];
            foreach ($rowData as $row) {
                $groupedRow = [
                    'NAMA_FILE' => $fileName,
                ];
                foreach ($header as $index => $columnName) {
                    $groupedRow[$columnName] = $row[$index];
                }
                $groupedData[] = $groupedRow;
            }

            $dataCSV = array_merge($dataCSV, $groupedData);
        }

        DB::beginTransaction();
        try{

            //! VARIABLE
            $SalahSatuPBGaLolos = FALSE;
            $ip = $this->getIP();

            //? ada proses decrypt file
            //? Decryption dengan metode AES alias RijndaelManaged
            //? 128 bit
            //? pass -> idm123

            //? jika data kosong goto SkipRecordKosongPBM

            //! DELETE CSV_PB_BUAH2 WHERE DATE_TRUNC('DAY', CPB_TGLPROSES) = CURRENT_DATE
            // sb.AppendLine("DELETE FROM CSV_PB_BUAH2 ")
            // sb.AppendLine(" Where CPB_IP = '" & IP & "' ")
            // sb.AppendLine("   AND DATE_TRUNC('DAY', CPB_TGLPROSES) = CURRENT_DATE ")

            DB::table('csv_pb_buah2')
                ->where('cpb_ip', $ip)
                ->whereRaw("DATE_TRUNC('DAY', cpb_tglproses) = CURRENT_DATE")
                ->delete();

            foreach($dataCSV as $csv){ //! START LOOP

                //! HANDLING
                //? ada case data yang dikirim double header
                if($csv['DOCNO'] == 'DOCNO'){
                    continue;
                }

                $noPB = $csv['DOCNO'];
                $KodeToko = $csv['TOKO'];
                $tglPB = $csv['TGL_PB'];
                $filename = $csv['NAMA_FILE'];

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

                //! INSERT INTO CSV_PB_BUAH2
                DB::table('csv_pb_buah2')->insert([
                    'cpb_recordid' => $csv['RECID'],
                    'cpb_kodetoko' => $csv['TOKO'],
                    'cpb_nopb' => $csv['DOCNO'],
                    'cpb_tglpb' => DB::raw("TO_DATE('" . $csv['TGL_PB'] . "','DD/MM/YYYY HH24:MI:SS')"),
                    'cpb_pluidm' => $csv['PRDCD'],
                    'cpb_qty' => $csv['QTY'],
                    'cpb_gross' => $csv['GROSS'],
                    'cpb_ip' => $ip,
                    'cpb_filename' => $csv['NAMA_FILE'],
                    'cpb_tglproses' => DB::raw("TO_DATE('" . Carbon::now()->format('d-m-Y') . "','DD/MM/YYYY HH24:MI:SS')"),
                    'cpb_flag' => '',
                    'cpb_create_by' => session('userid'),
                    'cpb_nourut' => null,
                ]);

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
                foreach($data as $item){
                    DB::table('csv_pb_buah')->insert([
                        'cpb_recordid' => $item->cpb_recordid,
                        'cpb_kodetoko' => $item->cpb_kodetoko,
                        'cpb_nopb' => $item->cpb_nopb,
                        'cpb_tglpb' => $item->cpb_tglpb,
                        'cpb_pluidm' => $item->cpb_pluidm,
                        'cpb_qty' => $item->cpb_qty,
                        'cpb_gross' => $item->cpb_gross,
                        'cpb_ip' => $item->cpb_ip,
                        'cpb_filename' => $item->cpb_filename,
                        'cpb_tglproses' => $item->cpb_tglproses,
                        'cpb_flag' => $item->cpb_flag,
                        'cpb_create_by' => session('userid'),
                        'cpb_nourut' => $item->cpb_nourut,
                    ]);
                }
            } //! END LOOP

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

            //! dummy
            DB::commit();

            $message = 'Proses TARIK DATA selesai';
            return ApiFormatter::success(200, $message);

        } catch (HttpResponseException $e) {
            // Handle the custom response exception
            throw new HttpResponseException($e->getResponse());

        }catch(\Exception $e){

            dd($e, $csv);

            DB::rollBack();

            $message = "Oops terjadi kesalahan ( $e )";
            throw new HttpResponseException(ApiFormatter::error(400, $message));
        }
    }

    //! PROSES F6 - ProsesAlokasi3()
    public function actionF6(){

        DB::beginTransaction();
        try{

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

            //! dummy
            // DB::commit();
            return ApiFormatter::success(200, 'Proses Alokasi Buah Selesai');

        } catch (HttpResponseException $e) {
            // Handle the custom response exception
            throw new HttpResponseException($e->getResponse());

        }catch(\Exception $e){

            DB::rollBack();

            $message = "Oops terjadi kesalahan ( $e )";
            throw ApiFormatter::error(500, $message);
        }


        //* Proses Alokasi Buah Selesai

        //? kasih catch jika gagal maka return false
    }

    //! Keys.F8, Keys.F9, Keys.F10
    public function actionF8F9F10(){

        DB::beginTransaction();
        try{

            //! VARIABLE
            //? default
            $buttonPress = '';
            $NoUrJenisPB = 0;
            $JumlahPB = 0;

            //? custom
            $ip = $this->getIP();
            $noPB = '';
            $tglPB = '';
            $KodeToko = '';

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
            $JenisPB = 'CHILLED FOOD';
            if($buttonPress == 'F8'){
                $JenisPB = 'IMPORT';
            }elseif($buttonPress == 'F9'){
                $JenisPB = 'LOKAL';
            }

            //* YAKIN INGIN MEMPROSES" & vbNewLine & PADC(JenisPB & " ??

            //? check apakah datatables header ada isinya?
            //? jika tidak

            //*  Tidak Ada Data " & JenisPB & " Yang Dapat Diproses !

            //? open form frmNoUrutBuah

            //! DELETE FROM TEMP_PB_VALID
            // sb.AppendLine("DELETE FROM TEMP_PB_VALID ")
            // sb.AppendLine(" Where IP = '" & IP & "' ")

            DB::table('TEMP_PB_VALID')
                ->where('ip', $ip)
                ->delete();

            //? check jika datatables header dan detail harus ada

            //! GET URUTAN JENISPB
            // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
            // sb.AppendLine("  FROM URUTAN_JENISPB_BUAH ")
            // sb.AppendLine(" WHERE DATE_TRUNC('DAY', UJB_CREATE_DT) = CURRENT_DATE ")
            // sb.AppendLine("   AND UJB_JenisPB = '" & JenisPB & "' ")

            $count = DB::table('URUTAN_JENISPB_BUAH')
                ->whereRaw("DATE_TRUNC('DAY', UJB_CREATE_DT) = CURRENT_DATE")
                ->where('UJB_JenisPB', $JenisPB)
                ->count();

            if($count == 0){
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

                DB::table('URUTAN_JENISPB_BUAH')
                    ->insert([
                        'UJB_JenisPB' => $JenisPB,
                        'UJB_NoUrut' => $NoUrJenisPB,
                        'UJB_Create_By' => session('userid'),
                        'UJB_Create_Dt' => Carbon::now(),
                    ]);
            }else{
                //! GET URUTAN JENISPB -> NoUrJenisPB
                // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
                // sb.AppendLine("  FROM URUTAN_JENISPB_BUAH ")
                // sb.AppendLine(" WHERE DATE_TRUNC('DAY', UJB_CREATE_DT) = CURRENT_DATE ")
                // sb.AppendLine("   AND UJB_JenisPB = '" & JenisPB & "' ")

                $count = DB::table('URUTAN_JENISPB_BUAH')
                    ->where('UJB_JenisPB', $JenisPB)
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
                $data = DB::select("
                    Select DISTINCT CPB_KodeToko
                    From CSV_PB_Buah
                    Where CPB_NoPB = '" . $noPB . "'
                        and DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" . $tglPB . "','DD-MM-YYYY')
                        And CPB_IP = '" . $ip . "'
                        AND (CPB_Flag IS NULL OR CPB_Flag = '')
                        and NOT EXISTS
                        (
                            Select CLB_Toko
                                From CLUSTER_BUAH
                                Where CLB_Toko = CPB_KodeToko
                        )
                ");

                if(count($data)){
                    $list = '';
                    foreach($data as $item){
                        $list .= $item->CPB_KodeToko . ',';
                    }

                    //* TOKO " & TokoTidakTerdaftar & " BELUM TERDAFTAR DI CLUSTER_BUAH!!
                    $message = "TOKO " . rtrim($list, ",") . " BELUM TERDAFTAR DI CLUSTER_BUAH!!";
                    return ApiFormatter::error(400, $message);
                }

                //! CEK SUDAH TERDAFTAR DI tbMaster_TokoIGR-2
                $data = DB::select("
                    Select DISTINCT CPB_KodeToko
                    From CSV_PB_BUAH
                    Where CPB_NoPB = '" . $noPB . "'
                        and DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" . $tglPB . "','DD-MM-YYYY')
                        and CPB_IP = '" . $ip . "'
                        AND (CPB_Flag IS NULL OR CPB_Flag = '')
                        and NOT EXISTS
                        (
                            Select Tko_KodeOMI
                                From tbMaster_TokoIGR
                                Where Tko_KodeOMI = CPB_KodeToko
                                And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE
                        )
                ");

                if(count($data)){
                    $list = '';
                    foreach($data as $item){
                        $list .= $item->CPB_KodeToko . ',';
                    }

                    //* TOKO " & TokoTidakTerdaftar2 & " Tidak Terdaftar Di TbMaster_TokoIGR !!
                    $message = "TOKO " . rtrim($list, ",") . " Tidak Terdaftar Di TbMaster_TokoIGR !!";
                    return ApiFormatter::error(400, $message);
                }

                //! CEK SUDAH TERDAFTAR DI tbMaster_TokoIGR-2
                $data = DB::select("
                    Select DISTINCT CPB_KodeToko
                    From CSV_PB_BUAH
                    Where CPB_NoPB = '" . $noPB . "'
                        and DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" . $tglPB . "','DD-MM-YYYY')
                        and CPB_IP = '" . $ip . "'
                        AND (CPB_Flag IS NULL OR CPB_Flag = '')
                        and EXISTS
                        (
                            Select Tko_KodeSBU
                                From tbMaster_TokoIGR
                                Where Tko_KodeOMI = CPB_KodeToko
                                And Tko_KodeSBU <> 'I'
                                And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE
                        )
                ");

                if(count($data)){
                    $list = '';
                    foreach($data as $item){
                        $list .= $item->CPB_KodeToko . ',';
                    }
                    //* TOKO " & SBUNotI & " KODE SBU nya Bukan I !!
                    $message = "TOKO " . rtrim($list, ",") . " KODE SBU nya Bukan I !!";
                    return ApiFormatter::error(400, $message);
                }

                //! CEK JADWAL KIRIM BUAH
                $data = DB::select("
                    Select DISTINCT CPB_KodeToko
                    From CSV_PB_BUAH
                    Where CPB_NoPB = '" . $noPB . "'
                        and DATE_TRUNC('DAY', CPB_TglPB) = TO_DATE('" . $tglPB . "','DD-MM-YYYY')
                        and CPB_IP = '" . $ip . "'
                        AND (CPB_Flag IS NULL OR CPB_Flag = '')
                        and NOT EXISTS
                        (
                            SELECT JKB_HARI
                            FROM JADWAL_KIRIM_BUAH
                            WHERE JKB_KodeToko = CPB_KodeToko
                            AND JKB_Hari = CASE Trim(To_Char(CURRENT_DATE,'DAY'))
                                                WHEN 'SATURDAY' THEN 'SENIN'
                                                WHEN 'SUNDAY' THEN 'SENIN'
                                                WHEN 'MONDAY' THEN 'SELASA'
                                                WHEN 'TUESDAY' THEN 'RABU'
                                                WHEN 'WEDNESDAY' THEN 'KAMIS'
                                                WHEN 'THURSDAY' THEN 'JUMAT'
                                                WHEN 'FRIDAY' THEN 'SABTU'
                                                WHEN 'SABTU' THEN 'SENIN'
                                                WHEN 'MINGGU' THEN 'SENIN'
                                                WHEN 'SENIN' THEN 'SELASA'
                                                WHEN 'SELASA' THEN 'RABU'
                                                WHEN 'RABU' THEN 'KAMIS'
                                                WHEN 'KAMIS' THEN 'JUMAT'
                                                WHEN 'JUMAT' THEN 'SABTU'
                                                ELSE 'SAPI'
                                            END
                        )
                ");

                if(count($data)){
                    $list = '';
                    foreach($data as $item){
                        $list .= $item->CPB_KodeToko . ',';
                    }

                    //* Hari Ini Bukan Jadwal Picking Untuk TOKO " & KirimHariIni
                    $message = "Hari Ini Bukan Jadwal Picking Untuk TOKO " . rtrim($list, ",");
                    return ApiFormatter::error(400, $message);
                }

                // ProsesPBIDM(dgvHeader.Rows(i).Cells(3).Value, txtPathFilePBBH.Text & "\" & dgvHeader.Rows(i).Cells(6).Value, JenisPB, NoUrJenisPB)

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

                DB::table('TEMP_PB_VALID')
                    ->insert([
                        'KodeToko' => $KodeToko,
                        'NoPB' => $noPB,
                        'TglPB' => DB::raw("TO_DATE('" . $tglPB . "','DD-MM-YYYY')"),
                        'IP' => $ip
                    ]);

                $JumlahPB += 1;

                skipPBBH:


            //! END LOOP DATATABLES HEADER

            if($JumlahPB == 0){
                //* Tidak Ada PB " & JenisPB & " !!
            }

            //! HITUNG JUMLAH ITEM DI PBOMI
            $count = DB::select("
                SELECT COALESCE(Count(0),0) as count
                FROM tbMaster_pbomi
                WHERE EXISTS
                (
                    SELECT cpb_kodetoko
                    FROM csv_pb_buah,
                        cluster_buah
                    WHERE CPB_JenisPB = '" . $JenisPB . "'
                    AND CPB_RecordID IS NULL
                    AND CPB_IP = '" . $ip . "'
                    AND CLB_Toko = CPB_KodeToko
                    AND (CPB_Flag IS NULL OR CPB_Flag = '')
                    AND cpb_kodetoko = pbo_kodeomi
                    AND cpb_nopb = pbo_nopb
                    AND cpb_tglpb = pbo_tglpb
                    AND EXISTS
                    (
                    SELECT KodeToko
                        FROM TEMP_PB_VALID
                        WHERE KodeToko = CPB_KodeToko
                            AND NoPB = CPB_NoPB
                            AND TglPB = CPB_TglPB
                            AND IP = '" . $ip . "'
                    )
                )
            ");

            if($count[0]->count > 0){
                //! INSERT INTO PICKING_ANTRIAN_BUAH
                DB::insert("
                    INSERT INTO PICKING_ANTRIAN_BUAH
                    (
                        PAB_KodeCluster,
                        PAB_JenisPB,
                        PAB_Create_By,
                        PAB_Create_Dt
                    )
                    SELECT DISTINCT CLB_Kode AS KodeCluster,
                        '" . $JenisPB . "' AS JenisPB,
                        '" . session('userid') . "',
                        CURRENT_DATE
                    FROM csv_pb_buah,
                        cluster_buah
                    WHERE CPB_JenisPB = '" . $JenisPB . "'
                        AND CPB_RecordID IS NULL
                        AND CPB_IP = '" . $ip . "'
                        AND CLB_Toko = CPB_KodeToko
                        AND (CPB_Flag IS NULL OR CPB_Flag = '')
                        AND EXISTS
                        (
                            SELECT KodeToko
                            FROM TEMP_PB_VALID
                            WHERE KodeToko = CPB_KodeToko
                                AND NoPB = CPB_NoPB
                                AND TglPB = CPB_TglPB
                                AND IP = '" . $ip . "'
                        )
                ");
            }

            //! SET FLAG CSV_PB_BUAH
            DB::update("
                UPDATE CSV_PB_BUAH
                SET CPB_Flag = '1'
                WHERE CPB_IP = '" . $ip . "'
                    AND (CPB_Flag IS NULL OR CPB_Flag = '')
                    AND EXISTS
                    (
                        SELECT KodeToko
                        FROM TEMP_PB_VALID
                        WHERE KodeToko = CPB_KodeToko
                            AND NoPB = CPB_NoPB
                            AND TglPB = CPB_TglPB
                            AND IP = '" . $ip . "'
                    )
            ");

            //! dummy
            DB::commit();

            //* PROSES UPLOAD " & JenisPB & " SELESAI DILAKUKAN
            $message = "PROSES UPLOAD " . $JenisPB . " SELESAI DILAKUKAN";
            return ApiFormatter::success(200, $message);

        } catch (HttpResponseException $e) {
            // Handle the custom response exception
            throw new HttpResponseException($e->getResponse());

        }catch(\Exception $e){

            DB::rollBack();

            $message = "Oops terjadi kesalahan ( $e )";
            throw new HttpResponseException(ApiFormatter::error(400, $message));
        }
    }
}
