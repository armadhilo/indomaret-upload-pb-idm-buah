<?php

namespace App\Http\Controllers;

use App\Helper\ApiFormatter;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function CreateTabelTimbangan(){
        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'MASTER_TIMBANGANBUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE Master_TimbanganBuah
            DB::insert("
                CREATE TABLE Master_TimbanganBuah
                (
                    MTB_RecordID VARCHAR(2),
                    MTB_PLUIDM VARCHAR(10),
                    MTB_PLUIGR VARCHAR(10),
                    MTB_PLUBH VARCHAR(10),
                    MTB_Deskripsi VARCHAR(20),
                    MTB_AvgCost NUMERIC(14,4),
                    MTB_BestBefore NUMERIC(3),
                    MTB_ShopName VARCHAR(50),
                    MTB_WeightType NUMERIC(1),
                    MTB_KodeDepartement VARCHAR(3),
                    MTB_Create_By VARCHAR(3),
                    MTB_Create_Dt DATE,
                    MTB_Modify_By VARCHAR(3),
                    MTB_Modify_Dt DATE
                )
            ");
        }
    }

    public function CreateTabelBuah(){
        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TEMP_CSV_PB_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE TEMP_CSV_PB_BUAH
            DB::insert("
                CREATE TABLE TEMP_CSV_PB_BUAH
                (
                    JENIS     VARCHAR(15),
                    NOPB      VARCHAR(15),
                    TGLPB     VARCHAR(10),
                    TOKO      VARCHAR(5),
                    PLUIDM    VARCHAR(8),
                    PLUIGR    VARCHAR(8),
                    QTY       VARCHAR(10),
                    RUPIAH    NUMERIC(14,4),
                    STOCK     NUMERIC(10),
                    NAMA_FILE VARCHAR(300),
                    REQ_ID    VARCHAR(25)
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'CSV_PB_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE CSV_PB_BUAH
            DB::insert("
                Create Table CSV_PB_BUAH
                (
                    CPB_RecordID VARCHAR(1),
                    CPB_KodeToko VARCHAR(5),
                    CPB_NoPB VARCHAR(15),
                    CPB_TglPB DATE,
                    CPB_PluIDM VARCHAR(10),
                    CPB_QTY NUMERIC(18,2),
                    CPB_GROSS NUMERIC(14,4),
                    CPB_IP  VARCHAR(30),
                    CPB_FileName VARCHAR(300),
                    CPB_TglProses DATE,
                    CPB_Flag VARCHAR(1),
                    CPB_CREATE_BY VARCHAR(3),
                    CPB_NoUrut NUMERIC(5),
                    CPB_AlokasiBuah VARCHAR(300),
                    CPB_JenisPB VARCHAR(20)
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'CSV_PB_BUAH2'")
            ->count();

        if($data == 0){
            //! CREATE TABLE CSV_PB_BUAH2
            DB::insert("
                Create Table CSV_PB_BUAH2
                (
                    CPB_RecordID VARCHAR(1),
                    CPB_KodeToko VARCHAR(5),
                    CPB_NoPB VARCHAR(15),
                    CPB_TglPB DATE,
                    CPB_PluIDM VARCHAR(10),
                    CPB_QTY NUMERIC(18,2),
                    CPB_GROSS NUMERIC(14,4),
                    CPB_IP  VARCHAR(30),
                    CPB_FileName VARCHAR(300),
                    CPB_TglProses DATE,
                    CPB_Flag VARCHAR(1),
                    CPB_CREATE_BY VARCHAR(3),
                    CPB_NoUrut NUMERIC(5)
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TBTR_HEADER_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE TBTR_HEADER_BUAH
            DB::insert("
                CREATE TABLE TBTR_HEADER_BUAH (
                    HDB_kodeigr          VARCHAR(2)   DEFAULT NULL,
                    HDB_flag             VARCHAR(1)   DEFAULT NULL,
                    HDB_tgltransaksi     DATE          DEFAULT NULL,
                    HDB_kodetoko         VARCHAR(4)   DEFAULT NULL,
                    HDB_nopb             VARCHAR(15)  DEFAULT NULL,
                    HDB_tglpb            DATE          DEFAULT NULL,
                    HDB_itempb           NUMERIC(5,0)   DEFAULT NULL,
                    HDB_itemvalid        NUMERIC(5,0)   DEFAULT NULL,
                    HDB_rphvalid         NUMERIC(15,4)  DEFAULT NULL,
                    HDB_itemsales        NUMERIC(5,0)   DEFAULT NULL,
                    HDB_rphsales         NUMERIC(15,4)  DEFAULT NULL,
                    HDB_tglscanning      DATE          DEFAULT NULL,
                    HDB_itemscanning     NUMERIC(5,0)   DEFAULT NULL,
                    HDB_rphscanning      NUMERIC(15,4)  DEFAULT NULL,
                    HDB_filepb           VARCHAR(200) DEFAULT NULL,
                    HDB_keterangan       VARCHAR(50)  DEFAULT NULL,
                    HDB_KodeCluster      VARCHAR(10)   DEFAULT NULL,
                    HDB_NoUrut           VARCHAR(5)   DEFAULT NULL,
                    HDB_create_by        VARCHAR(3)   DEFAULT NULL,
                    HDB_create_dt        DATE          DEFAULT NULL,
                    HDB_modify_by        VARCHAR(3)   DEFAULT NULL,
                    HDB_modify_dt        DATE         DEFAULT NULL
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'CLUSTER_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE CLUSTER_BUAH
            DB::insert("
                CREATE TABLE CLUSTER_BUAH
                (
                    CLB_Kode      VARCHAR(10),
                    CLB_Toko      VARCHAR(5),
                    CLB_NoUrut    NUMERIC(5),
                    CLB_Create_By VARCHAR(5),
                    CLB_Create_Dt DATE,
                    CLB_Modify_By VARCHAR(5),
                    CLB_Modify_Dt DATE
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'JADWAL_KIRIM_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE JADWAL_KIRIM_BUAH
            DB::insert("
                CREATE TABLE JADWAL_KIRIM_BUAH
                (
                    JKB_HARI      VARCHAR(10),
                    JKB_KodeToko  VARCHAR(5),
                    JKB_NamaToko  VARCHAR(50),
                    JKB_Create_By VARCHAR(5),
                    JKB_Create_Dt DATE
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TEMP_ALOKASI_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE TEMP_ALOKASI_BUAH
            DB::insert("
                CREATE TABLE TEMP_ALOKASI_BUAH
                (
                    JENIS VARCHAR(20),
                    TOKO VARCHAR(5),
                    PLUIDM VARCHAR(10),
                    QTY NUMERIC(10),
                    IP VARCHAR(30)
                )
            ");

        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TEMP_URUTAN_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE TEMP_URUTAN_BUAH
            DB::insert("
                CREATE TABLE TEMP_URUTAN_BUAH
                (
                    JENIS VARCHAR(20),
                    PLU VARCHAR(10),
                    NoUrut NUMERIC(5),
                    IP VARCHAR(30)
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'URUTAN_JENISPB_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE URUTAN_JENISPB_BUAH
            DB::insert("
                CREATE TABLE URUTAN_JENISPB_BUAH
                (
                    UJB_JenisPB VARCHAR(15),
                    UJB_NoUrut NUMERIC(1),
                    UJB_Create_By VARCHAR(3),
                    UJB_Create_Dt DATE
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'PICKING_ANTRIAN_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE PICKING_ANTRIAN_BUAH
            DB::insert("
                CREATE TABLE PICKING_ANTRIAN_BUAH
                (
                    PAB_RecordID VARCHAR(2),
                    PAB_KodeCluster VARCHAR(10),
                    PAB_JenisPB VARCHAR(20),
                    PAB_DCP VARCHAR(3),
                    PAB_Create_By VARCHAR(5),
                    PAB_Create_Dt DATE,
                    PAB_Modify_By VARCHAR(5),
                    PAB_Modify_Dt DATE
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'DCP_MASTER_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE DCP_MASTER_BUAH
            DB::insert("
                CREATE TABLE DCP_MASTER_BUAH
                (
                    DMB_RecordID VARCHAR(2),
                    DMB_UserID VARCHAR(5),
                    DMB_UserName VARCHAR(40),
                    DMB_ID VARCHAR(3),
                    DMB_KodeCluster VARCHAR(10),
                    DMB_JenisPB VARCHAR(20),
                    DMB_Create_By VARCHAR(5),
                    DMB_Create_Dt Date,
                    DMB_Modify_By VARCHAR(5),
                    DMB_Modify_Dt Date
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'DCP_DATA_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE DCP_DATA_BUAH
            DB::insert("
                CREATE TABLE DCP_DATA_BUAH
                (
                    DDB_RecordID VARCHAR(2),
                    DDB_ID VARCHAR(3),
                    DDB_KodeSBU VARCHAR(2),
                    DDB_KodeToko VARCHAR(5),
                    DDB_NoPB VARCHAR(15),
                    DDB_TglPB DATE,
                    DDB_PRDCD VARCHAR(10),
                    DDB_PLUIDM VARCHAR(10),
                    DDB_Deskripsi VARCHAR(20),
                    DDB_Unit VARCHAR(10),
                    DDB_Frac NUMERIC(10),
                    DDB_FlagBKP1 VARCHAR(1),
                    DDB_FlagBKP2 VARCHAR(1),
                    DDB_QtyOrder NUMERIC(10),
                    DDB_QtyScan NUMERIC(10),
                    DDB_TglUpload DATE,
                    DDB_TglScan DATE,
                    DDB_UserScan VARCHAR(5),
                    DDB_IP VARCHAR(30),
                    DDB_KodeCluster VARCHAR(10),
                    DDB_JenisPB VARCHAR(20),
                    DDB_NoUrutJenisPB NUMERIC(1),
                    DDB_NoUrutPLU NUMERIC(5),
                    DDB_NoUrutToko NUMERIC(5),
                    DDB_NoKoli VARCHAR(20)
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'HISTORY_DCP_DATA_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE HISTORY_DCP_DATA_BUAH
            DB::insert("
                CREATE TABLE HISTORY_DCP_DATA_BUAH
                (
                    HDDB_RecordID VARCHAR(2),
                    HDDB_ID VARCHAR(3),
                    HDDB_KodeSBU VARCHAR(2),
                    HDDB_KodeToko VARCHAR(5),
                    HDDB_NoPB VARCHAR(15),
                    HDDB_TglPB DATE,
                    HDDB_PRDCD VARCHAR(10),
                    HDDB_PLUIDM VARCHAR(10),
                    HDDB_Deskripsi VARCHAR(20),
                    HDDB_Unit VARCHAR(10),
                    HDDB_Frac NUMERIC(10),
                    HDDB_FlagBKP1 VARCHAR(1),
                    HDDB_FlagBKP2 VARCHAR(1),
                    HDDB_QtyOrder NUMERIC(10),
                    HDDB_QtyScan NUMERIC(10),
                    HDDB_TglUpload DATE,
                    HDDB_TglScan DATE,
                    HDDB_UserScan VARCHAR(5),
                    HDDB_IP VARCHAR(30),
                    HDDB_KodeCluster VARCHAR(10),
                    HDDB_JenisPB VARCHAR(20),
                    HDDB_NoUrutJenisPB NUMERIC(1),
                    HDDB_NoUrutPLU NUMERIC(5),
                    HDDB_NoUrutToko NUMERIC(5),
                    HDDB_NoKoli VARCHAR(20)
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TEMP_PB_VALID'")
            ->count();

        if($data == 0){
            //! CREATE TABLE TEMP_PB_VALID
            DB::insert("
                CREATE TABLE TEMP_PB_VALID
                (
                    KodeToko VARCHAR(5),
                    NoPB VARCHAR(15),
                    TglPB DATE,
                    IP VARCHAR(20)
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'DCP_USER_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE DCP_USER_BUAH
            DB::insert("
                CREATE TABLE DCP_User_Buah
                (
                    DUB_kodeigr  VARCHAR(2)  DEFAULT NULL,
                    DUB_kodeuser VARCHAR(5)  DEFAULT NULL,
                    DUB_nik      VARCHAR(20) DEFAULT NULL
                )
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'SEQ_NOKOLI_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE SEQ_NOKOLI_BUAH
            DB::insert("
                CREATE SEQUENCE SEQ_NOKOLI_BUAH
                    MINVALUE 1
                    MAXVALUE 99999999
                    INCREMENT 1
                    CYCLE
                    START 1
            ");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'ALOKASI_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE ALOKASI_BUAH
            DB::insert("
                CREATE TABLE ALOKASI_BUAH
                (
                    kd_toko       VARCHAR(5)  DEFAULT NULL,
                    docno         VARCHAR(12) DEFAULT NULL,
                    tgl_data_al   DATE         DEFAULT NULL,
                    pluidm        VARCHAR(10) DEFAULT NULL,
                    pluigr        VARCHAR(10) DEFAULT NULL,
                    qty           NUMERIC(12,0) DEFAULT NULL,
                    dept          VARCHAR(3)  DEFAULT NULL,
                    katg          VARCHAR(3)  DEFAULT NULL,
                    create_by     VARCHAR(3)  DEFAULT NULL,
                    create_dt     DATE         DEFAULT NULL,
                    flag_proses   VARCHAR(1)  DEFAULT NULL,
                    userid_proses VARCHAR(5)  DEFAULT NULL,
                    tgl_proses    DATE     DEFAULT    NULL
                )
            ");

            // sb = New StringBuilder
            // sb.AppendLine("CREATE INDEX IDX1_ALOKASI_BUAH ON alokasi_buah (PLUIDM) ")
            // ExecQRY(sb.ToString, "CREATE INDEX IDX1_ALOKASI_BUAH")

            //! CREATE INDEX IDX1_ALOKASI_BUAH
            DB::insert("CREATE INDEX IDX1_ALOKASI_BUAH ON alokasi_buah (PLUIDM)");

            // sb = New StringBuilder
            // sb.AppendLine("CREATE INDEX IDX2_ALOKASI_BUAH ON alokasi_buah (PLUIGR) ")
            // ExecQRY(sb.ToString, "CREATE INDEX IDX2_ALOKASI_BUAH")

            //! CREATE INDEX IDX2_ALOKASI_BUAH
            DB::insert("CREATE INDEX IDX2_ALOKASI_BUAH ON alokasi_buah (PLUIGR)");

            // sb = New StringBuilder
            // sb.AppendLine("CREATE INDEX IDX3_ALOKASI_BUAH ON alokasi_buah (Trunc(CREATE_DT)) ")
            // ExecQRY(sb.ToString, "CREATE INDEX IDX3_ALOKASI_BUAH")

            //! CREATE INDEX IDX3_ALOKASI_BUAH
            DB::insert("CREATE INDEX IDX3_ALOKASI_BUAH ON alokasi_buah (Trunc(CREATE_DT))");
        }

        $data = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'HISTORY_ALOKASI_BUAH'")
            ->count();

        if($data == 0){
            //! CREATE TABLE HISTORY_ALOKASI_BUAH
            DB::insert("
                CREATE TABLE HISTORY_ALOKASI_BUAH
                (
                    kd_toko       VARCHAR(5)  DEFAULT NULL,
                    docno         VARCHAR(12) DEFAULT NULL,
                    tgl_data_al   DATE         DEFAULT NULL,
                    pluidm        VARCHAR(10) DEFAULT NULL,
                    pluigr        VARCHAR(10) DEFAULT NULL,
                    qty           NUMERIC(12,0) DEFAULT NULL,
                    dept          VARCHAR(3)  DEFAULT NULL,
                    katg          VARCHAR(3)  DEFAULT NULL,
                    create_by     VARCHAR(3)  DEFAULT NULL,
                    create_dt     DATE         DEFAULT NULL,
                    flag_proses   VARCHAR(1)  DEFAULT NULL,
                    userid_proses VARCHAR(5)  DEFAULT NULL,
                    tgl_proses    DATE     DEFAULT    NULL
                )
            ");

            // ExecQRY(sb.ToString, "CREATE TABLE HISTORY_ALOKASI_BUAH")

            // sb = New StringBuilder
            // sb.AppendLine("CREATE INDEX IDX1_HISTORY_ALOKASI_BUAH ON HISTORY_ALOKASI_BUAH (PLUIDM) ")
            // ExecQRY(sb.ToString, "CREATE INDEX IDX1_HISTORY_ALOKASI_BUAH")

            //! CREATE INDEX IDX1_HISTORY_ALOKASI_BUAH
            DB::insert("CREATE INDEX IDX1_HISTORY_ALOKASI_BUAH ON HISTORY_ALOKASI_BUAH (PLUIDM)");

            // sb = New StringBuilder
            // sb.AppendLine("CREATE INDEX IDX2_HISTORY_ALOKASI_BUAH ON HISTORY_ALOKASI_BUAH (PLUIGR) ")
            // ExecQRY(sb.ToString, "CREATE INDEX IDX2_HISTORY_ALOKASI_BUAH")

            //! CREATE CREATE INDEX IDX2_HISTORY_ALOKASI_BUAH
            DB::insert("CREATE INDEX IDX2_HISTORY_ALOKASI_BUAH ON HISTORY_ALOKASI_BUAH (PLUIGR)");

            // sb = New StringBuilder
            // sb.AppendLine("CREATE INDEX IDX3_HISTORY_ALOKASI_BUAH ON HISTORY_ALOKASI_BUAH (Trunc(CREATE_DT)) ")
            // ExecQRY(sb.ToString, "CREATE INDEX IDX3_HISTORY_ALOKASI_BUAH")

            //! CREATE CREATE INDEX IDX3_HISTORY_ALOKASI_BUAH
            DB::insert("CREATE INDEX IDX3_HISTORY_ALOKASI_BUAH ON HISTORY_ALOKASI_BUAH (Trunc(CREATE_DT))");
        }

        //! INSERT INTO history_alokasi_buah
        DB::insert("
            INSERT INTO history_alokasi_buah
            (
                kd_toko,
                docno,
                tgl_data_al,
                pluidm,
                pluigr,
                qty,
                dept,
                katg,
                create_by,
                create_dt,
                flag_proses,
                userid_proses,
                tgl_proses
            )
            SELECT kd_toko,
                docno,
                tgl_data_al,
                pluidm,
                pluigr,
                qty,
                dept,
                katg,
                create_by,
                create_dt,
                flag_proses,
                userid_proses,
                tgl_proses
            FROM history_alokasi_buah
            WHERE DATE_TRUNC('DAY', create_dt) <= CURRENT_DATE - 100
            AND flag_proses IS NOT NULL
        ");

        //! DELETE FROM alokasi_buah
        // sb.AppendLine("DELETE FROM alokasi_buah ")
        // sb.AppendLine(" WHERE DATE_TRUNC('DAY', create_dt) <= CURRENT_DATE - 100 ")
        // sb.AppendLine("   AND flag_proses IS NOT NULL ")

        DB::table('alokasi_buah')
            ->whereRaw("DATE_TRUNC('DAY', create_dt) <= CURRENT_DATE - 100")
            ->whereNotNull('flag_proses')
            ->delete();
    }

    public function getKodeDC($kode_toko){
        return DB::table('master_supply_idm')
            ->where('msi_kodetoko', $kode_toko)
            ->first()->msi_kodedc;
    }

    public function getIP(){
        return;
    }

    public function prosesPBIdm(){
        $jum = 0;
        $CounterKarton = 0;
        $CounterKecil = 0;
        $AdaKartonan = False;
        $AdaKecil = False;
        $KodeSBU = "";
        $jumItmCSV = 0;
        $jumTolakan = 0;
        $rphValid = 0;
        $PersenMargin = 0;
        $rphOrder = 0;
        $PBO_NoUrut = 0;
        $KubikPB = 0;
        $NoPick = 0;
        $Gate = "";
        $GateOrder = 0;
        $TipeMobil = "";
        $JumlahKontainer = 0;
        $JumlahBronjong = 0;
        $KodeCluster = "";
        $GroupCluster = "";
        $KubikasiMobil = 0;
        $KubikasiKontainer = 0;
        $KubikasiBronjong = 0;
        $NoSJ = "";
        $GR1 = "";
        $GR2 = "";
        $GR3 = "";
        $VolContainer = 0;
        $VolBronjong = 0;

        $ip = '';
        $KDIGR = '';
        $KodeToko = '';
        $noPB = '';
        $tglPB = '';
        $JenisPB = '';
        $NoUrJenisPB = '';

        //! DEL TEMP_CETAKPB_TOLAKAN_IDM
        // ExecQRY("DELETE FROM TEMP_CETAKPB_TOLAKAN_IDM WHERE REQ_ID = '" & IP & "' ", "DEL TEMP_CETAKPB_TOLAKAN_IDM")
        DB::table('temp_cetakpb_tolakan_idm')
            ->where('req_id', $ip)
            ->delete();

        //! CEK Di TBTR_HEADER_BUAH
        // sb.AppendLine("Select COALESCE(count(1),0) ")
        // sb.AppendLine("  From TBTR_HEADER_Buah ")
        // sb.AppendLine(" Where HDB_KodeIGR='" & KDIGR & "' ")
        // sb.AppendLine("   AND HDB_KodeToko = '" & KodeToko & "' ")
        // sb.AppendLine("   AND HDB_NoPB = '" & noPB & "' ")
        // sb.AppendLine("   AND DATE_TRUNC('DAY', HDB_TglPB) = TO_DATE('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine(" AND TO_CHAR(HDB_TglPB,'YYYY') = '" & Strings.Right(tglPB, 4) & "' ")

        $check = DB::table('tbtr_header_buah')
            ->where([
                'hdb_kodeigr' => $KDIGR,
                'hdb_kodetoko' => $KodeToko,
                'hdb_nopb' => $noPB,
            ])
            ->whereRaw("DATE_TRUNC('DAY', HDB_TglPB) = TO_DATE('" . $tglPB . "','DD-MM-YYYY')")
            ->where(DB::raw("TO_CHAR(hdb_tglpb,'YYYY')"),Carbon::parse($tglPB)->format('Y'))
            ->count();

        if($check > 0){
            //* MsgBox("PB Dengan No = " & noPB & ", KodeTOKO = " & KodeToko & ", Tgl PB = " & tglPB & vbNewLine & "Sudah Pernah Diproses !", MsgBoxStyle.Information, "UPLOAD PB IDM")
            $message = "PB Dengan No = $noPB, KodeTOKO = $KodeToko Sudah Pernah Diproses !";
            throw new HttpResponseException(ApiFormatter::error(400, $message));
        }

        $kodeDCIDM = $this->getKodeDC($KodeToko);

        //! ISI PLU TIDAK TERDAFTAR DI TBMASTER_PLUIDM
        $query = "";
        $query .= "INSERT Into TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "( ";
        $query .= "   KOMI, ";
        $query .= "   TGL, ";
        $query .= "   NODOK, ";
        $query .= "   TGLDOK, ";
        $query .= "   PLU, ";
        $query .= "   PLUIGR, ";
        $query .= "   KETA, ";
        $query .= "   TAG, ";
        $query .= "   DESCR, ";
        $query .= "   QTYO, ";
        $query .= "   GROSS, ";
        $query .= "   KCAB, ";
        $query .= "   KODEIGR, ";
        $query .= "   REQ_ID ";
        $query .= ") ";
        $query .= "Select '', ";
        $query .= "       CURRENT_DATE,  ";
        $query .= "	      CPB_NoPB, ";
        $query .= "	      CPB_TglPB, ";
        $query .= "	      CPB_PLUIDM, ";
        $query .= "	      null, ";
        $query .= "	      'PLU TIDAK TERDAFTAR DI TBMASTER_PRODCRM', ";
        $query .= "	      null, ";
        $query .= "	      null, ";
        $query .= "	      CPB_QTY, ";
        $query .= "	      null, ";
        $query .= "	      CPB_KodeToko, ";
        $query .= "	      '" . session('KODECABANG') . "', ";
        $query .= "	      '" . $ip . "' ";
        $query .= "  From CSV_PB_BUAH ";
        $query .= " Where not exists ";
        $query .= " ( ";
        if($kodeDCIDM <> ""){
            $query .= "    Select idm_pluigr ";
            $query .= "      From tbmaster_pluidm  ";
            $query .= "     Where idm_pluidm = CPB_PLUIDM  ";
            $query .= "       AND idm_kodeidm = '" . $kodeDCIDM . "' ";
            $query .= "	      AND idm_kodeigr = '" . session('KODECABANG') . "' ";
        }else{
            $query .= "    Select prc_pluigr ";
            $query .= "      From tbmaster_prodcrm  ";
            $query .= "     Where prc_pluidm = CPB_PLUIDM  ";
            $query .= "	      AND prc_group = 'I' ";
            $query .= "	      AND prc_kodeigr = '" . session('KODECABANG') . "' ";
        }
        $query .= " ) ";
        $query .= "   AND CPB_IP = '" . $ip . "'";
        $query .= "   AND CPB_NoPB = '" . $noPB . "'";
        $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";

        //! PLU IDM TIDAK MEMPUNYAI PLU INDOGROSIR
        $query = "";
        $query .= "INSERT Into TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "( ";
        $query .= "   KOMI, ";
        $query .= "   TGL, ";
        $query .= "   NODOK, ";
        $query .= "   TGLDOK, ";
        $query .= "   PLU, ";
        $query .= "   PLUIGR, ";
        $query .= "   KETA, ";
        $query .= "   TAG, ";
        $query .= "   DESCR, ";
        $query .= "   QTYO, ";
        $query .= "   GROSS, ";
        $query .= "   KCAB, ";
        $query .= "   KODEIGR, ";
        $query .= "   REQ_ID ";
        $query .= ") ";
        $query .= "Select '', ";
        $query .= "       CURRENT_DATE,  ";
        $query .= "	      CPB_NoPB, ";
        $query .= "	      CPB_TglPB, ";
        $query .= "	      CPB_PLUIDM, ";
        $query .= "	      null, ";
        $query .= "	      'PLU IDM TIDAK MEMPUNYAI PLU INDOGROSIR', ";
        $query .= "	      null, ";
        $query .= "	      null, ";
        $query .= "	      CPB_QTY, ";
        $query .= "	      null, ";
        $query .= "	      CPB_KodeToko, ";
        $query .= "	      '" . session('KODECABANG') . "', ";
        $query .= "	      '" . $ip . "' ";
        $query .= "  From CSV_PB_BUAH ";
        $query .= " Where exists ";
        $query .= " ( ";
        if($kodeDCIDM <> ""){
            $query .= "    Select idm_pluigr ";
            $query .= "      From tbmaster_pluidm  ";
            $query .= "     Where idm_pluidm = CPB_PLUIDM  ";
            $query .= "       AND idm_kodeidm = '" . $kodeDCIDM . "' ";
            $query .= "	      AND idm_kodeigr = '" . session('KODECABANG') . "' ";
            $query .= "       AND idm_pluigr IS NULL ";
        }else{
            $query .= "    Select prc_pluigr ";
            $query .= "      From tbmaster_prodcrm  ";
            $query .= "     Where prc_pluidm = CPB_PLUIDM  ";
            $query .= "	      AND prc_group = 'I' ";
            $query .= "	      AND prc_kodeigr = '" . session('KODECABANG') . "' ";
            $query .= "       AND PRC_PLUIGR IS NULL ";
        }
        $query .= " ) ";
        $query .= "   AND CPB_IP = '" . $ip . "'";
        $query .= "   AND CPB_NoPB = '" . $noPB . "'";
        $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";

        //! PLUIDM DISCONTINUE Tag:ARNGX
        $query = "";
        $query .= "INSERT Into TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "( ";
        $query .= "   KOMI, ";
        $query .= "   TGL, ";
        $query .= "   NODOK, ";
        $query .= "   TGLDOK, ";
        $query .= "   PLU, ";
        $query .= "   PLUIGR, ";
        $query .= "   KETA, ";
        $query .= "   TAG, ";
        $query .= "   DESCR, ";
        $query .= "   QTYO, ";
        $query .= "   GROSS, ";
        $query .= "   KCAB, ";
        $query .= "   KODEIGR, ";
        $query .= "   REQ_ID ";
        $query .= ") ";
        $query .= "Select '',  ";
        $query .= "       CURRENT_DATE,   ";
        $query .= "       CPB_NoPB,  ";
        $query .= "       CPB_TglPB,  ";
        $query .= "       CPB_PLUIDM,  ";
        if($kodeDCIDM <> ""){
            $query .= "       idm_pluigr,  ";
            $query .= "       'PRODCRM DISCONTINUE Tag:ARNGX',  ";
            $query .= "       IDM_KodeTag,  ";
            $query .= "       null,  ";
            $query .= "       CPB_QTY,  ";
            $query .= "       null,  ";
            $query .= "       CPB_KodeToko,  ";
            $query .= "       '" . session('KODECABANG') . "',  ";
            $query .= "       '" . $ip . "'  ";
            $query .= "  From CSV_PB_BUAH, tbmaster_pluidm  ";
            $query .= " Where CPB_IP = '" . $ip . "' ";
            $query .= "   AND CPB_NoPB = '" . $noPB . "' ";
            $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
            $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
            $query .= "   And idm_pluidm = CPB_PLUIDM   ";
            $query .= "   AND idm_kodeidm = '" . $kodeDCIDM . "' ";
            $query .= "   AND idm_kodeigr = '" . session('KODECABANG') . "' ";
            $query .= "   AND COALESCE(idm_kodetag,'0') IN ('A','R','N','G','X') ";
        }else{
            $query .= "       prc_pluigr,  ";
            $query .= "       'PRODCRM DISCONTINUE Tag:ARNGX',  ";
            $query .= "       PRC_KodeTag,  ";
            $query .= "       null,  ";
            $query .= "       CPB_QTY,  ";
            $query .= "       null,  ";
            $query .= "       CPB_KodeToko,  ";
            $query .= "       '" . session('KODECABANG') . "',  ";
            $query .= "       '" . $ip . "'  ";
            $query .= "  From CSV_PB_BUAH, tbmaster_prodcrm  ";
            $query .= " Where CPB_IP = '" . $ip . "' ";
            $query .= "   AND CPB_NoPB = '" . $noPB . "' ";
            $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
            $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
            $query .= "   And prc_pluidm = CPB_PLUIDM   ";
            $query .= "   AND prc_group = 'I'  ";
            $query .= "   AND prc_kodeigr = '" . session('KODECABANG') . "' ";
            $query .= "   AND COALESCE(prc_KodeTag,'0') IN ('A','R','N','G','X') ";
        }

        //! PLU IGR PADA TBTEMP_PLUIDM TIDAK ADA DI PRODMAST
        $query = "";
        $query .= "INSERT Into TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "( ";
        $query .= "   KOMI, ";
        $query .= "   TGL, ";
        $query .= "   NODOK, ";
        $query .= "   TGLDOK, ";
        $query .= "   PLU, ";
        $query .= "   PLUIGR, ";
        $query .= "   KETA, ";
        $query .= "   TAG, ";
        $query .= "   DESCR, ";
        $query .= "   QTYO, ";
        $query .= "   GROSS, ";
        $query .= "   KCAB, ";
        $query .= "   KODEIGR, ";
        $query .= "   REQ_ID ";
        $query .= ") ";
        $query .= "Select '', ";
        $query .= "       CURRENT_DATE,  ";
        $query .= "	      CPB_NoPB, ";
        $query .= "	      CPB_TglPB, ";
        $query .= "	      CPB_PLUIDM, ";
        $query .= "	      IDM_PLUIGR, ";
        $query .= "	      'PLU IGR PADA PLUIDM TIDAK ADA DI PRODMAST', ";
        $query .= "	      null, ";
        $query .= "	      null, ";
        $query .= "	      CPB_QTY, ";
        $query .= "	      null, ";
        $query .= "	      CPB_KodeToko, ";
        $query .= "	      '" . session('KODECABANG') . "', ";
        $query .= "	      '" . $ip . "' ";
        $query .= "	 FROM csv_pb_BUAH,TBTEMP_PLUIDM  ";
        $query .= " WHERE CPB_IP = '" . $ip . "' ";
        $query .= "   AND CPB_NoPB = '" . $noPB . "' ";
        $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
        $query .= "   AND NOT EXISTS ";
        $query .= "   ( ";
        $query .= "   SELECT PLUIGR  ";
        $query .= "	    FROM TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "	   WHERE REQ_ID = '" . $ip . "' ";
        $query .= "		 AND NODOK = '" . $noPB . "' ";
        $query .= "		 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "	     AND KCAB = '" . $KodeToko . "' ";
        $query .= "		 AND PLU = CPB_PLUIDM ";
        $query .= "   )    ";
        $query .= "   AND NOT EXISTS ";
        $query .= "   ( ";
        $query .= "      SELECT PRD_PRDCD  ";
        $query .= "        FROM tbMaster_ProdMast ";
        $query .= "       Where PRD_PRDCD = IDM_PLUIGR ";
        $query .= "         And PRD_KodeIGR = '" . session('KODECABANG') . "' ";
        $query .= "   )    ";
        $query .= "   AND CPB_PLUIDM = IDM_PLUIDM ";
        if($kodeDCIDM <> ""){
            $query .= "   AND IDM_KDIDM = '" . $kodeDCIDM . "' ";
        }

        //! AVG.COST <= 0 - 1
        $query = "";
        $query .= "INSERT Into TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "( ";
        $query .= "   KOMI, ";
        $query .= "   TGL, ";
        $query .= "   NODOK, ";
        $query .= "   TGLDOK, ";
        $query .= "   PLU, ";
        $query .= "   PLUIGR, ";
        $query .= "   KETA, ";
        $query .= "   TAG, ";
        $query .= "   DESCR, ";
        $query .= "   QTYO, ";
        $query .= "   GROSS, ";
        $query .= "   KCAB, ";
        $query .= "   KODEIGR, ";
        $query .= "   REQ_ID ";
        $query .= ") ";
        $query .= "Select '', ";
        $query .= "       CURRENT_DATE,  ";
        $query .= "	      CPB_NoPB, ";
        $query .= "	      CPB_TglPB, ";
        $query .= "	      CPB_PLUIDM, ";
        if($kodeDCIDM <> ""){
            $query .= "	      IDM_PLUIGR, ";
        }else{
            $query .= "	      PRC_PLUIGR, ";
        }
        $query .= "	      'AVG.COST IS NULL', ";
        $query .= "	      PRD_KodeTag, ";
        $query .= "	      SUBSTR(PRD_DESKRIPSIPANJANG,1,60), ";
        $query .= "	      CPB_QTY, ";
        $query .= "	      null, ";
        $query .= "	      CPB_KodeToko, ";
        $query .= "	      '" . session('KODECABANG') . "', ";
        $query .= "	      '" . $ip . "' ";
        if($kodeDCIDM <> ""){
            $query .= "	 FROM csv_pb_BUAH, TBMASTER_PRODMAST,tbMaster_Pluidm ";
        }else{
            $query .= "	 FROM csv_pb_BUAH, TBMASTER_PRODMAST,tbMaster_Prodcrm ";
        }
        $query .= " WHERE CPB_IP = '" . $ip . "' ";
        $query .= "   AND CPB_NoPB = '" . $noPB . "' ";
        $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
        $query .= "   AND NOT EXISTS ";
        $query .= "   ( ";
        $query .= "   SELECT PLUIGR  ";
        $query .= "	    FROM TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "	   WHERE REQ_ID = '" . $ip . "'		  ";
        $query .= "		 AND NODOK = '" . $noPB . "' ";
        $query .= "		 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "	     AND KCAB = '" . $KodeToko . "' ";
        $query .= "		 AND PLU = CPB_PLUIDM ";
        $query .= "   )    ";
        $query .= "   AND NOT EXISTS ";
        $query .= "   ( ";
        $query .= "      SELECT ST_AvgCost ";
        $query .= "        FROM tbMaster_Stock ";
        if($kodeDCIDM <> ""){
            $query .= "       Where ST_PRDCD Like SUBSTR(IDM_PLUIGR,1,6)||'%' ";
            $query .= "         And ST_Lokasi = '01'  ";
            $query .= "         And ST_KodeIGR = '" . session('KODECABANG') . "'  ";
            $query .= "         And ST_AvgCost IS NOT NULL ";
            $query .= "   ) ";
            $query .= "   AND PRD_KODEIGR = IDM_KODEIGR ";
            $query .= "   AND CPB_PLUIDM = IDM_PLUIDM ";
            $query .= "   AND IDM_KODEIDM = '" . $kodeDCIDM . "' ";
            $query .= "   AND PRD_PRDCD = IDM_PLUIGR ";
            $query .= "   AND NOT EXISTS ";
            $query .= "   ( ";
            $query .= "    SELECT PHP_PRDCD ";
            $query .= "      FROM PLU_HADIAH_PERISHABLE ";
            $query .= "     WHERE PHP_PRDCD Like SUBSTR(IDM_PLUIGR,1,6)||'%' ";
            $query .= "   )    ";
        }else{
            $query .= "       Where ST_PRDCD Like SUBSTR(PRC_PLUIGR,1,6)||'%' ";
            $query .= "         And ST_Lokasi = '01'  ";
            $query .= "         And ST_KodeIGR = '" . session('KODECABANG') . "'  ";
            $query .= "         And ST_AvgCost IS NOT NULL ";
            $query .= "   ) ";
            $query .= "   AND PRD_KODEIGR = PRC_KODEIGR ";
            $query .= "   AND CPB_PLUIDM = PRC_PLUIDM ";
            $query .= "   AND PRC_GROUP = 'I' ";
            $query .= "   AND PRD_PRDCD = PRC_PLUIGR ";
            $query .= "   AND NOT EXISTS ";
            $query .= "   ( ";
            $query .= "    SELECT PHP_PRDCD ";
            $query .= "      FROM PLU_HADIAH_PERISHABLE ";
            $query .= "     WHERE PHP_PRDCD Like SUBSTR(PRC_PLUIGR,1,6)||'%' ";
            $query .= "   )    ";
        }

        //! AVG.COST <= 0 - 2
        $query = "";
        $query .= "INSERT Into TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "( ";
        $query .= "   KOMI, ";
        $query .= "   TGL, ";
        $query .= "   NODOK, ";
        $query .= "   TGLDOK, ";
        $query .= "   PLU, ";
        $query .= "   PLUIGR, ";
        $query .= "   KETA, ";
        $query .= "   TAG, ";
        $query .= "   DESCR, ";
        $query .= "   QTYO, ";
        $query .= "   GROSS, ";
        $query .= "   KCAB, ";
        $query .= "   KODEIGR, ";
        $query .= "   REQ_ID ";
        $query .= ") ";
        $query .= "Select '', ";
        $query .= "       CURRENT_DATE,  ";
        $query .= "	      CPB_NoPB, ";
        $query .= "	      CPB_TglPB, ";
        $query .= "	      CPB_PLUIDM, ";
        if($kodeDCIDM <> ""){
            $query .= "	      IDM_PLUIGR, ";
        }else{
            $query .= "	      PRC_PLUIGR, ";
        }
        $query .= "	      'AVG.COST <= 100', ";
        $query .= "	      PRD_KodeTag, ";
        $query .= "	      SUBSTR(PRD_DESKRIPSIPANJANG,1,60), ";
        $query .= "	      CPB_QTY, ";
        $query .= "	      null, ";
        $query .= "	      CPB_KodeToko, ";
        $query .= "	      '" . session('KODECABANG') . "', ";
        $query .= "	      '" . $ip . "' ";
        if($kodeDCIDM <> ""){
            $query .= "	 FROM csv_pb_BUAH, TBMASTER_PRODMAST,tbMaster_Pluidm ";
        }else{
            $query .= "	 FROM csv_pb_BUAH, TBMASTER_PRODMAST,tbMaster_Prodcrm ";
        }
        $query .= " WHERE CPB_IP = '" . $ip . "' ";
        $query .= "   AND CPB_NoPB = '" . $noPB . "' ";
        $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
        $query .= "   AND NOT EXISTS ";
        $query .= "   ( ";
        $query .= "   SELECT PLUIGR  ";
        $query .= "	    FROM TEMP_CETAKPB_TOLAKAN_IDM ";
        $query .= "	   WHERE REQ_ID = '" . $ip . "'		  ";
        $query .= "		 AND NODOK = '" . $noPB . "' ";
        $query .= "		 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "	     AND KCAB = '" . $KodeToko . "' ";
        $query .= "		 AND PLU = CPB_PLUIDM ";
        $query .= "   )    ";
        $query .= "   AND EXISTS ";
        $query .= "   ( ";
        $query .= "      SELECT ST_AvgCost  ";
        $query .= "        FROM tbMaster_Stock  ";
        if($kodeDCIDM <> ""){
            $query .= "       Where ST_PRDCD Like SUBSTR(IDM_PLUIGR,1,6)||'%' ";
            $query .= "         And ST_Lokasi = '01'  ";
            $query .= "         And ST_KodeIGR = '" . session('KODECABANG') . "'  ";
            $query .= "         And COALESCE(ST_AvgCost,0) <= 100 ";
            $query .= "   )    ";
            $query .= "   AND PRD_KODEIGR = IDM_KODEIGR ";
            $query .= "   AND CPB_PLUIDM = IDM_PLUIDM ";
            $query .= "   AND IDM_KODEIDM = '" . $kodeDCIDM . "' ";
            $query .= "   AND PRD_PRDCD = IDM_PLUIGR ";
        }else{
            $query .= "       Where ST_PRDCD Like SUBSTR(PRC_PLUIGR,1,6)||'%' ";
            $query .= "         And ST_Lokasi = '01'  ";
            $query .= "         And ST_KodeIGR = '" . session('KODECABANG') . "'  ";
            $query .= "         And COALESCE(ST_AvgCost,0) <= 100 ";
            $query .= "   )    ";
            $query .= "   AND PRD_KODEIGR = PRC_KODEIGR ";
            $query .= "   AND CPB_PLUIDM = PRC_PLUIDM ";
            $query .= "   AND PRC_GROUP = 'I' ";
            $query .= "   AND PRD_PRDCD = PRC_PLUIGR ";
        }

        //! CEK TABLE
        // sb.AppendLine("Select COALESCE(COUNT(1),0)  ")
        // sb.AppendLine("  FROM information_schema.columns ")
        // sb.AppendLine(" Where UPPER(table_name) = 'TEMP_CETAKPB_TOLAKAN_IDM2' ")

        $count = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TEMP_CETAKPB_TOLAKAN_IDM2'")
            ->count();

        if($count == 0){
            //! CREATE TABLE TEMP_CETAKPB_TOLAKAN_IDM2-PRODMAST-NXQ
            $query = "";
            $query .= "CREATE TABLE TEMP_CETAKPB_TOLAKAN_IDM2 ";
            $query .= "AS ";
            $query .= "SELECT KOMI, ";
            $query .= "       TGL, ";
            $query .= "       NODOK, ";
            $query .= "       TGLDOK, ";
            $query .= "       PLU, ";
            $query .= "       PLUIGR, ";
            $query .= "       KETA, ";
            $query .= "       PRD_KODETAG AS TAG, ";
            $query .= "       DESCR, ";
            $query .= "       QTYO, ";
            $query .= "       KCAB, ";
            $query .= "       KODEIGR, ";
            $query .= "       REQ_ID ";
            $query .= "FROM ";
            $query .= "( ";
            $query .= "Select '' as KOMI,  ";
            $query .= "       CURRENT_DATE as TGL,   ";
            $query .= "	      CPB_NoPB as NODOK,  ";
            $query .= "	      CPB_TglPB as TGLDOK,  ";
            $query .= "	      CPB_PLUIDM as PLU,  ";
            if($kodeDCIDM <> ""){
                $query .= "	      IDM_PLUIGR as PLUIGR,  ";
            }else{
                $query .= "	      PRC_PLUIGR as PLUIGR,  ";
            }
            $query .= "	      'PRODMAST IGR DISCONTINUE Tag:NXQ' as KETA, ";
            $query .= "	      SUBSTR(PRD_DESKRIPSIPANJANG,1,60) as DESCR,  ";
            $query .= "	      CPB_QTY as QTYO,  ";
            $query .= "	      CPB_KodeToko as KCAB,  ";
            $query .= "	      '" . session('KODECABANG') . "' as KODEIGR,  ";
            $query .= "	      '" . $ip . "' as REQ_ID, ";
            $query .= "        Min(PRD_PRDCD) AS PLUKECIL  ";
            if($kodeDCIDM <> ""){
                $query .= "	 FROM CSV_PB_BUAH, TBMASTER_PRODMAST,tbMaster_Pluidm ";
            }else{
                $query .= "	 FROM CSV_PB_BUAH, TBMASTER_PRODMAST,tbMaster_Prodcrm ";
            }
            $query .= " WHERE CPB_IP = '" . $ip . "'  ";
            $query .= "   AND CPB_NoPB = '" . $noPB . "' ";
            $query .= "   AND CPB_TglPB = to_date('" . $tglPB. "','DD-MM-YYYY') ";
            $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
            $query .= "   AND NOT EXISTS  ";
            $query .= "   (  ";
            $query .= "   SELECT PLUIGR   ";
            $query .= "	    FROM TEMP_CETAKPB_TOLAKAN_IDM  ";
            $query .= "	   WHERE REQ_ID = '" . $ip . "' ";
            $query .= "		 AND NODOK = '" . $noPB . "'  ";
            $query .= "		 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')  ";
            $query .= "		 AND PLU = CPB_PLUIDM  ";
            $query .= "	     AND KCAB = '" . $KodeToko . "' ";
            $query .= "   )     ";
            if($kodeDCIDM <> ""){
                $query .= "   AND PRD_KODEIGR = IDM_KODEIGR  ";
                $query .= "   AND CPB_PLUIDM = IDM_PLUIDM  ";
                $query .= "   AND IDM_KODEIDM = '" . $kodeDCIDM . "' ";
                $query .= "   AND PRD_PRDCD like SubStr(IDM_PLUIGR,1,6)||'%'  ";
                $query .= "   AND SubStr(PRD_PRDCD,-1,1) <> '0'    ";
                $query .= " GROUP BY CPB_NoPB,  ";
                $query .= "	         CPB_TglPB,  ";
                $query .= "	         CPB_PLUIDM,  ";
                $query .= "	         IDM_PLUIGR,  ";
            }else{
                $query .= "   AND PRD_KODEIGR = PRC_KODEIGR  ";
                $query .= "   AND CPB_PLUIDM = PRC_PLUIDM  ";
                $query .= "   AND PRC_GROUP = 'I'  ";
                $query .= "   AND PRD_PRDCD like SubStr(PRC_PLUIGR,1,6)||'%'  ";
                $query .= "   AND SubStr(PRD_PRDCD,-1,1) <> '0'    ";
                $query .= " GROUP BY CPB_NoPB,  ";
                $query .= "	         CPB_TglPB,  ";
                $query .= "	         CPB_PLUIDM,  ";
                $query .= "	         PRC_PLUIGR,  ";
            }
            $query .= "	         SUBSTR(PRD_DESKRIPSIPANJANG,1,60),  ";
            $query .= "	         CPB_QTY,  ";
            $query .= "	         CPB_KodeToko ";
            $query .= ") X,tbMaster_Prodmast ";
            $query .= "WHERE PRD_PRDCD = PLUKECIL ";
            $query .= "  AND PRD_KodeTag IN ('N','X','Q') ";
        }else{
            //! DELETE FROM TEMP_CETAKPB_TOLAKAN_IDM2
            // sb.AppendLine("DELETE FROM TEMP_CETAKPB_TOLAKAN_IDM2 ")
            // sb.AppendLine(" WHERE REQ_ID = '" & IP & "' ")

            DB::table('temp_cetakpb_tolakan_idm2')
                ->where('req_id', $ip)
                ->delete();

            //! INSERT INTO TEMP_CETAKPB_TOLAKAN_IDM2 - 1-PRODMAST-NXQ
            $query = "";
            $query .= "INSERT INTO TEMP_CETAKPB_TOLAKAN_IDM2 ";
            $query .= "SELECT KOMI, ";
            $query .= "       TGL, ";
            $query .= "       NODOK, ";
            $query .= "       TGLDOK, ";
            $query .= "       PLU, ";
            $query .= "       PLUIGR, ";
            $query .= "       KETA, ";
            $query .= "       PRD_KODETAG AS TAG, ";
            $query .= "       DESCR, ";
            $query .= "       QTYO, ";
            $query .= "       KCAB, ";
            $query .= "       KODEIGR, ";
            $query .= "       REQ_ID ";
            $query .= "FROM ";
            $query .= "( ";
            $query .= "Select '' as KOMI,  ";
            $query .= "       CURRENT_DATE as TGL,   ";
            $query .= "	      CPB_NoPB as NODOK,  ";
            $query .= "	      CPB_TglPB as TGLDOK,  ";
            $query .= "	      CPB_PLUIDM as PLU,  ";
            if($kodeDCIDM <> ""){
                $query .= "	      IDM_PLUIGR as PLUIGR,  ";
            }else{
                $query .= "	      PRC_PLUIGR as PLUIGR,  ";
            }
            $query .= "	      'PRODMAST IGR DISCONTINUE Tag:NXQ' as KETA, ";
            $query .= "	      SUBSTR(PRD_DESKRIPSIPANJANG,1,60) as DESCR,  ";
            $query .= "	      CPB_QTY as QTYO,  ";
            $query .= "	      CPB_KodeToko as KCAB,  ";
            $query .= "	      '" . session('KODECABANG') . "' as KODEIGR,  ";
            $query .= "	      '" . $ip . "' as REQ_ID, ";
            $query .= "        Min(PRD_PRDCD) AS PLUKECIL  ";
            if($kodeDCIDM <> ""){
                $query .= "	 FROM CSV_PB_BUAH, TBMASTER_PRODMAST,tbMaster_Pluidm  ";
            }else{
                $query .= "	 FROM CSV_PB_BUAH, TBMASTER_PRODMAST,tbMaster_Prodcrm  ";
            }
            $query .= " WHERE CPB_IP = '" . $ip . "'  ";
            $query .= "   AND CPB_KodeToko = '" . $KodeToko . "'  ";
            $query .= "   AND CPB_NoPB = '" . $noPB . "' ";
            $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY')  ";
            $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
            $query .= "   AND NOT EXISTS  ";
            $query .= "   (  ";
            $query .= "   SELECT PLUIGR   ";
            $query .= "	    FROM TEMP_CETAKPB_TOLAKAN_IDM  ";
            $query .= "	   WHERE REQ_ID = '" . $ip . "' ";
            $query .= "		 AND NODOK = '" . $noPB . "'  ";
            $query .= "		 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')  ";
            $query .= "		 AND PLU = CPB_PLUIDM  ";
            $query .= "	     AND KCAB = '" . $KodeToko . "' ";
            $query .= "   )     ";
            $query .= "   AND NOT EXISTS  ";
            $query .= "   (  ";
            $query .= "   SELECT PLUIGR   ";
            $query .= "	    FROM TEMP_CETAKPB_TOLAKAN_IDM2  ";
            $query .= "	   WHERE REQ_ID = '" . $ip . "' ";
            $query .= "		 AND NODOK = '" . $noPB . "'  ";
            $query .= "		 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')  ";
            $query .= "		 AND PLU = CPB_PLUIDM  ";
            $query .= "	     AND KCAB = '" . $KodeToko . "' ";
            $query .= "   )     ";
            if($kodeDCIDM <> ""){
                $query .= "   AND PRD_KODEIGR = IDM_KODEIGR  ";
                $query .= "   AND CPB_PLUIDM = IDM_PLUIDM  ";
                $query .= "   AND IDM_KODEIDM = '" . $kodeDCIDM . "' ";
                $query .= "   AND PRD_PRDCD like SubStr(IDM_PLUIGR,1,6)||'%'  ";
                $query .= "   AND SubStr(PRD_PRDCD,-1,1) <> '0'    ";
                $query .= " GROUP BY CPB_NoPB,  ";
                $query .= "	        CPB_TglPB,  ";
                $query .= "	        CPB_PLUIDM,  ";
                $query .= "	        IDM_PLUIGR,  ";
            }else{
                $query .= "   AND PRD_KODEIGR = PRC_KODEIGR  ";
                $query .= "   AND CPB_PLUIDM = PRC_PLUIDM  ";
                $query .= "   AND PRC_GROUP = 'I'  ";
                $query .= "   AND PRD_PRDCD like SubStr(PRC_PLUIGR,1,6)||'%'  ";
                $query .= "   AND SubStr(PRD_PRDCD,-1,1) <> '0'    ";
                $query .= " GROUP BY CPB_NoPB,  ";
                $query .= "	        CPB_TglPB,  ";
                $query .= "	        CPB_PLUIDM,  ";
                $query .= "	        PRC_PLUIGR,	 ";
            }
            $query .= "	        SUBSTR(PRD_DESKRIPSIPANJANG,1,60),  ";
            $query .= "	        CPB_QTY,  ";
            $query .= "	        CPB_KodeToko ";
            $query .= ") X,tbMaster_Prodmast ";
            $query .= "WHERE PRD_PRDCD = PLUKECIL ";
            $query .= "  AND PRD_KodeTag IN ('N','X','Q') ";

            //! INSERT INTO TEMP_CETAKPB_TOLAKAN_IDM2 - 1-FLAGAKTIVASI-X
            $query = "";
            $query .= "INSERT INTO TEMP_CETAKPB_TOLAKAN_IDM2 ";
            $query .= "SELECT KOMI, ";
            $query .= "       TGL, ";
            $query .= "       NODOK, ";
            $query .= "       TGLDOK, ";
            $query .= "       PLU, ";
            $query .= "       PLUIGR, ";
            $query .= "       KETA, ";
            $query .= "       PRD_KODETAG AS TAG, ";
            $query .= "       DESCR, ";
            $query .= "       QTYO, ";
            $query .= "       KCAB, ";
            $query .= "       KODEIGR, ";
            $query .= "       REQ_ID ";
            $query .= "FROM ";
            $query .= "( ";
            $query .= "Select '' as KOMI,  ";
            $query .= "       CURRENT_DATE as TGL,   ";
            $query .= "	      CPB_NoPB as NODOK,  ";
            $query .= "	      CPB_TglPB as TGLDOK,  ";
            $query .= "	      CPB_PLUIDM as PLU,  ";
            if($kodeDCIDM <> ""){
                $query .= "	      IDM_PLUIGR as PLUIGR,  ";
            }else{
                $query .= "	      PRC_PLUIGR as PLUIGR,  ";
            }
            $query .= "	      'PRODMAST IGR FLAG AKTIVASI:X' as KETA, ";
            $query .= "	      SUBSTR(PRD_DESKRIPSIPANJANG,1,60) as DESCR,  ";
            $query .= "	      CPB_QTY as QTYO,  ";
            $query .= "	      CPB_KodeToko as KCAB,  ";
            $query .= "	      '" . session('KODECABANG') . "' as KODEIGR,  ";
            $query .= "	      '" . $ip . "' as REQ_ID, ";
            $query .= "        Min(PRD_PRDCD) AS PLUKECIL  ";
            if($kodeDCIDM <> ""){
                $query .= "	 FROM CSV_PB_BUAH, TBMASTER_PRODMAST,tbMaster_Pluidm  ";
            }else{
                $query .= "	 FROM CSV_PB_BUAH, TBMASTER_PRODMAST,tbMaster_Prodcrm  ";
            }
            $query .= " WHERE CPB_IP = '" . $ip . "'  ";
            $query .= "   AND CPB_KodeToko = '" . $KodeToko . "'  ";
            $query .= "   AND CPB_NoPB = '" . $noPB . "' ";
            $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY')  ";
            $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
            $query .= "   AND NOT EXISTS  ";
            $query .= "   (  ";
            $query .= "   SELECT PLUIGR   ";
            $query .= "	    FROM TEMP_CETAKPB_TOLAKAN_IDM  ";
            $query .= "	   WHERE REQ_ID = '" . $ip . "' ";
            $query .= "		 AND NODOK = '" . $noPB . "'  ";
            $query .= "		 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')  ";
            $query .= "		 AND PLU = CPB_PLUIDM  ";
            $query .= "	     AND KCAB = '" . $KodeToko . "' ";
            $query .= "   )     ";
            $query .= "   AND NOT EXISTS  ";
            $query .= "   (  ";
            $query .= "   SELECT PLUIGR   ";
            $query .= "	    FROM TEMP_CETAKPB_TOLAKAN_IDM2  ";
            $query .= "	   WHERE REQ_ID = '" . $ip . "' ";
            $query .= "		 AND NODOK = '" . $noPB . "'  ";
            $query .= "		 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')  ";
            $query .= "		 AND PLU = CPB_PLUIDM  ";
            $query .= "	     AND KCAB = '" . $KodeToko . "' ";
            $query .= "   )     ";
            if($kodeDCIDM <> ""){
                $query .= "   AND PRD_KODEIGR = IDM_KODEIGR  ";
                $query .= "   AND CPB_PLUIDM = IDM_PLUIDM  ";
                $query .= "   AND IDM_KODEIDM = '" . $kodeDCIDM . "' ";
                $query .= "   AND PRD_PRDCD like SubStr(IDM_PLUIGR,1,6)||'%'  ";
                $query .= "   AND SubStr(PRD_PRDCD,-1,1) <> '0'    ";
                $query .= " GROUP BY CPB_NoPB,  ";
                $query .= "	        CPB_TglPB,  ";
                $query .= "	        CPB_PLUIDM,  ";
                $query .= "	        IDM_PLUIGR,  ";
            }else{
                $query .= "   AND PRD_KODEIGR = PRC_KODEIGR  ";
                $query .= "   AND CPB_PLUIDM = PRC_PLUIDM  ";
                $query .= "   AND PRC_GROUP = 'I'  ";
                $query .= "   AND PRD_PRDCD like SubStr(PRC_PLUIGR,1,6)||'%'  ";
                $query .= "   AND SubStr(PRD_PRDCD,-1,1) <> '0'    ";
                $query .= " GROUP BY CPB_NoPB,  ";
                $query .= "	        CPB_TglPB,  ";
                $query .= "	        CPB_PLUIDM,  ";
                $query .= "	        PRC_PLUIGR,	 ";
            }
            $query .= "	        SUBSTR(PRD_DESKRIPSIPANJANG,1,60),  ";
            $query .= "	        CPB_QTY,  ";
            $query .= "	        CPB_KodeToko ";
            $query .= ") X,tbMaster_Prodmast ";
            $query .= ", TBMASTER_FLAGAKT ";
            $query .= "WHERE PRD_PRDCD = PLUKECIL ";
            $query .= "  AND prd_flag_aktivasi IN ('X') ";
            $query .= "  AND prd_flag_aktivasi = AKT_KODEFLAG ";
        }

        //! MERGE INTO TEMP_CETAKPB_TOLAKAN_IDM2 - KOMI
        DB::insert("
            MERGE INTO
                TEMP_CETAKPB_TOLAKAN_IDM2 a
            USING
            (
            SELECT *
                FROM TBMASTER_TOKOIGR
            WHERE COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE
            ) b
            ON
            (
            a.KCAB = b.TKO_KODEOMI
            and REQ_ID = '" . $ip . "'
                AND NODOK = '" . $noPB . "'
                AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    AND KCAB = '" . $KodeToko . "'
            )
            WHEN MATCHED THEN
            UPDATE SET KOMI = b.TKO_KodeCustomer
        ");

        //! INSERT Into TEMP_CETAKPB_TOLAKAN_IDM
        DB::insert("
            INSERT Into TEMP_CETAKPB_TOLAKAN_IDM
            (
                KOMI,
                TGL,
                NODOK,
                TGLDOK,
                PLU,
                PLUIGR,
                KETA,
                TAG,
                DESCR,
                QTYO,
                GROSS,
                KCAB,
                KODEIGR,
                REQ_ID
            )
            Select KOMI,
                TGL,
                NODOK,
                TGLDOK,
                PLU,
                PLUIGR,
                KETA,
                TAG,
                DESCR,
                QTYO,
                ST_AVGCOST * QTYO as GROSS,
                KCAB,
                KODEIGR,
                REQ_ID
            FROM TEMP_CETAKPB_TOLAKAN_IDM2 IDM2,tbMaster_Stock
            Where ST_PRDCD Like SUBSTR(PLUIGR,1,6)||'%'
            And ST_Lokasi = '01'
            And COALESCE(ST_RecordID,'0') <> '1'
            And REQ_ID = '" . $ip . "'
            AND KCAB = '" . $KodeToko . "'
            AND NODOK = '" . $noPB . "'
            AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    AND KCAB = '" . $KodeToko . "'
            AND NOT EXISTS
            (
            SELECT PLUIGR
                    FROM TEMP_CETAKPB_TOLAKAN_IDM IDM
                WHERE REQ_ID = '" . $ip . "'
                    AND NODOK = '" . $noPB . "'
                    AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    AND IDM.PLU = IDM2.PLU
                    AND KCAB = '" . $KodeToko . "'
            )
        ");

        //! DELETE FROM TEMP_PBIDM_READY2
        // sb.AppendLine("DELETE FROM TEMP_PBIDM_READY2 ")
        // sb.AppendLine(" WHERE REQ_ID = '" & IP & "' ")

        DB::table('temp_pbidm_ready2')
            ->where('req_id', $ip)
            ->delete();

        //! INSERT INTO TEMP_PBIDM_READY2
        $query = "";
        $query .= "INSERT INTO TEMP_PBIDM_READY2 ( ";
        $query .= "  FDRCID, ";
        $query .= "  FDNOUO, ";
        $query .= "  FDKODE, ";
        $query .= "  FDQTYB, ";
        $query .= "  FDKCAB, ";
        $query .= "  FDTGPB, ";
        $query .= "  FDKSUP, ";
        $query .= "  REQ_ID, ";
        $query .= "  NAMA_FILE, ";
        $query .= "  PRC_PLUIGR ";
        $query .= ")";
        $query .= "Select '', ";
        $query .= "	      CPB_NoPB, ";
        $query .= "	      CPB_PLUIDM, ";
        $query .= "	      CPB_QTY, ";
        $query .= "	      CPB_KodeToko, ";
        $query .= "	      CPB_TglPB, ";
        $query .= "	      '', ";
        $query .= "	      CPB_IP, ";
        $query .= "	      CPB_FILENAME, ";
        if($kodeDCIDM <> ""){
            $query .= "	      IDM_PLUIGR ";
            $query .= "  From CSV_PB_BUAH A, tbMaster_pluidm ";
        }else{
            $query .= "	      PRC_PLUIGR ";
            $query .= "  From CSV_PB_BUAH A, tbMaster_prodcrm ";
        }
        $query .= " Where CPB_IP = '" . $ip . "'   ";
        $query .= "   AND CPB_NoPB = '" . $noPB . "'   ";
        $query .= "   AND DATE_TRUNC('DAY', CPB_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "   AND CPB_KodeToko = '" . $KodeToko . "' ";
        $query .= "   AND NOT EXISTS   ";
        $query .= "           (   ";
        $query .= "              SELECT PLUIGR    ";
        $query .= "                FROM TEMP_CETAKPB_TOLAKAN_IDM   ";
        $query .= "               WHERE REQ_ID = '" . $ip . "' ";
        $query .= "                 AND NODOK = '" . $noPB . "'   ";
        $query .= "                 AND DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY')  ";
        $query .= "                 AND PLU = CPB_PLUIDM  ";
        $query .= "	                AND KCAB = '" . $KodeToko . "' ";
        $query .= "           )  ";
        if($kodeDCIDM <> ""){
            $query .= "    AND IDM_KODEIDM = '" . $kodeDCIDM . "' ";
            $query .= "    AND IDM_pluidm = CPB_PLUIDM ";
        }else{
            $query .= "    AND PRC_GROUP = 'I'  ";
            $query .= "    AND PRC_pluidm = CPB_PLUIDM ";
        }
        $query .= "    AND (CPB_Flag IS NULL OR CPB_Flag = '') ";

        //! CEK TABLE
        // sb.AppendLine("Select COALESCE(COUNT(1),0)  ")
        // sb.AppendLine("  FROM information_schema.columns ")
        // sb.AppendLine(" Where UPPER(table_name) = 'TEMP_PBIDM_READY' ")

        $count = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TEMP_PBIDM_READY'")
            ->count();

        if($count == 0){
            //! CREATE TABLE TEMP_PBIDM_READY
            DB::insert("
                CREATE TABLE TEMP_PBIDM_READY
                AS
                Select E.*,ST_AvgCost as AVGCOST, 0 QTY_EKONOMIS
                From
                (
                    Select D.*,
                        0 as QTYB,
                        FDQTYB as QTYK,
                        CASE WHEN
                            CASE WHEN FracKarton = 1 THEN FDQTYB ELSE DATE_TRUNC('DAY', FDQTYB / FracKecil) END < PRD_MinJual
                        THEN 'T'
                        ELSE '' END AS TolakMinJ
                    From
                    (
                    Select C.*,PRD_Unit as UnitKecil,PRD_Frac as FracKecil,PRD_MinJual
                    From
                    (
                        Select B.*, CASE WHEN min(prd_prdcd) IS NULL THEN PluKarton ELSE min(prd_prdcd) END as PLUKecil
                        From
                        (
                        Select A.FDRCID,
                            A.FDNOUO,
                            A.FDKODE,
                            MAX(A.FDQTYB) as FDQTYB,
                            A.FDKCAB,
                            A.FDTGPB,
                            A.FDKSUP,
                            A.REQ_ID,
                            A.NAMA_FILE,
                            prd_deskripsipanjang as DESK,
                            prd_flagbkp1 as BKP,
                            prd_prdcd as PluKarton,
                            prd_unit as UnitKarton,
                            prd_frac as FracKarton
                        From temp_pbidm_ready2 A, tbmaster_prodmast
                        Where REQ_ID = '" . $ip . "'
                        AND FDNOUO = '" . $noPB . "'
                        AND DATE_TRUNC('DAY', FDTGPB) = to_date('" . $tglPB. "','DD-MM-YYYY')
                        AND prd_prdcd = prc_pluigr
                        GROUP By A.FDRCID,
                                A.FDNOUO,
                                A.FDKODE,
                                A.FDTGPB,
                                A.FDKCAB,
                                A.FDKSUP,
                                A.REQ_ID,
                                A.NAMA_FILE,
                                prd_deskripsipanjang,
                                prd_flagbkp1,
                                prd_prdcd,
                                prd_unit,
                                prd_frac
                        ) B, tbMaster_Prodmast
                        Where PRD_PRDCD(+) <> SUBSTR(PLUKarton,1,6)||'0'
                        And PRD_PRDCD(+) Like SUBSTR(PLUKarton,1,6)||'%'
                        AND COALESCE(prd_KodeTag,'A') NOT IN ('N','X','Q')
                        Group By fdrcid,
                            FDNOUO,
                            FDKODE,
                            FDQTYB,
                            FDKCAB,
                            FDTGPB,
                            fdksup,
                            REQ_ID,
                            nama_file,
                            Desk,
                            PluKarton,
                            UnitKarton,
                            FracKarton,
                            BKP
                    ) C, tbMaster_prodmast
                    Where PRD_PRDCD = PluKecil
                    )D
                ) E, tbMaster_Stock
                Where ST_PRDCD = PLUKARTON
                And ST_Lokasi = '01'
                And COALESCE(ST_RecordID,'0') <> '1'
            ");
        }else{
            //! DELETE FROM TEMP_PBIDM_READY
            // sb.AppendLine("DELETE FROM TEMP_PBIDM_READY ")
            // sb.AppendLine(" WHERE REQ_ID = '" & IP & "' ")
            DB::table('temp_pbidm_ready')
                ->where('req_id', $ip)
                ->delete();

            //! INSERT INTO TEMP_PBIDM_READY
            DB::insert("
                INSERT INTO TEMP_PBIDM_READY (
                    FDRCID,
                    FDNOUO,
                    FDKODE,
                    FDQTYB,
                    FDKCAB,
                    FDTGPB,
                    FDKSUP,
                    REQ_ID,
                    NAMA_FILE,
                    DESK,
                    BKP,
                    PLUKARTON,
                    UNITKARTON,
                    FRACKARTON,
                    PLUKECIL,
                    UNITKECIL,
                    FRACKECIL,
                    PRD_MINJUAL,
                    QTYB,
                    QTYK,
                    TOLAKMINJ,
                    AVGCOST
                )
                SELECT E.*, st_avgcost as avgcost
                FROM
                (
                    SELECT D.*, 0 as qtyb,
                            fdqtyb as qtyk,
                            CASE WHEN
                                CASE WHEN FracKarton = 1 THEN FDQTYB ELSE FLOOR(FDQTYB / FracKecil) END < PRD_MinJual
                                THEN 'T'
                                ELSE ''
                            END AS TolakMinJ
                    FROM
                    (
                        SELECT C.*, PRD_Unit as UnitKecil,
                            PRD_Frac as FracKecil,
                            PRD_MinJual
                        FROM
                        (
                            SELECT B.*,
                                    CASE WHEN (MIN(prd_prdcd) IS NULL OR MIN(prd_prdcd) = '')
                                    THEN PluKarton
                                    ELSE MIN(prd_prdcd)
                                    END as PLUKecil
                            FROM
                            (
                                SELECT A.FDRCID,
                                        A.FDNOUO,
                                        A.FDKODE,
                                        MAX(A.FDQTYB) as FDQTYB,
                                        A.FDKCAB,
                                        A.FDTGPB,
                                        A.FDKSUP,
                                        A.REQ_ID,
                                        A.NAMA_FILE,
                                        prd_deskripsipanjang as DESK,
                                        prd_flagbkp1 as BKP,
                                        prd_prdcd as PluKarton,
                                        prd_unit as UnitKarton,
                                        prd_frac as FracKarton
                                FROM temp_pbidm_ready2 A
                                JOIN tbmaster_prodmast
                                ON prd_prdcd = prc_pluigr
                                WHERE REQ_ID = '" . $ip . "'
                                AND FDNOUO = '" . $noPB . "'
                                AND DATE_TRUNC('DAY', FDTGPB) = TO_DATE('" . $tglPB. "','DD-MM-YYYY')
                                GROUP BY A.FDRCID, A.FDNOUO, A.FDKODE, A.FDTGPB, A.FDKCAB, A.FDKSUP, A.REQ_ID, A.NAMA_FILE,
                                        prd_deskripsipanjang, prd_flagbkp1, prd_prdcd, prd_unit, prd_frac
                            ) B
                            LEFT JOIN tbMaster_Prodmast
                                ON PRD_PRDCD <> SUBSTR(pluKarton,1,6)||'0'
                                AND PRD_PRDCD LIKE SUBSTR(PLUKarton,1,6)||'%'
                            WHERE COALESCE(prd_KodeTag,'A') NOT IN ('N','X','Q')
                            GROUP BY fdrcid, FDNOUO, FDKODE, FDQTYB, FDKCAB, FDTGPB, fdksup, REQ_ID, nama_file,
                                Desk, PluKarton, UnitKarton, FracKarton, BKP
                        ) C
                        JOIN tbMaster_prodmast
                        ON PRD_PRDCD = PluKecil
                    ) D
                ) E
                JOIN tbMaster_Stock
                ON ST_PRDCD = PLUKARTON
                AND ST_Lokasi = '01'
                AND COALESCE(ST_RecordID,'0') <> '1'
            ");
        }

        //! INSERT INTO TBTR_TOLAKANPBOMI
        DB::insert("
            INSERT INTO TBTR_TolakanPBOMI
            (
                TLKO_KodeIGR,
                TLKO_KodeOMI,
                TLKO_TglPB,
                TLKO_NoPB,
                TLKO_PluIGR,
                TLKO_PluOMI,
                TLKO_PTAG,
                TLKO_DESC,
                TLKO_KetTolakan,
                TLKO_QtyOrder,
                TLKO_LastCost,
                TLKO_Nilai,
                TLKO_Create_By,
                TLKO_Create_Dt
            )
            Select KODEIGR,
                KCAB,
                TGLDOK,
                NODOK,
                PLUIGR,
                PLU,
                TAG,
                DESCR,
                KETA,
                QTYO,
                ST_AVGCOST,
                GROSS,
                '" . session('userid') . "',
                CURRENT_TIMESTAMP
            From TEMP_CETAKPB_TOLAKAN_IDM LEFT OUTER JOIN tbMaster_Stock ON
                ( ST_PRDCD = SUBSTR(PLUIGR,1,6)||'0'
                And ST_Lokasi = '01')
            Where REQ_ID = '" . $ip . "'
        ");

        //! MERGE INTO TBTR_TOLAKANPBOMI-IDM_Tag
        $query = "";
        $query .= "MERGE INTO ";
        $query .= "    TBTR_TOLAKANPBOMI a ";
        $query .= "USING ";
        $query .= "( ";
        if($kodeDCIDM <> ""){
            $query .= "  SELECT IDM_PLUIDM, ";
            $query .= "         IDM_KodeTag ";
            $query .= "    FROM tbMaster_Pluidm ";
            $query .= "   Where IDM_KodeIDM = '" . $kodeDCIDM . "' ";
            $query .= "     And Exists ( ";
            $query .= "      Select tlko_pluomi ";
            $query .= "	       From tbtr_TolakanPbOMI ";
            $query .= "	      Where tlko_PluOMI = IDM_PLUIDM ";
            $query .= "		    And tlko_NoPB = '" . $noPB . "' ";
            $query .= "		    And tlko_TglPB = to_date('" . $tglPB. "','DD-MM-YYYY') ";
            $query .= "		    AND tlko_KodeOmi = '" . $KodeToko . "' ";
            $query .= "   ) ";
            $query .= ") b ";
            $query .= "ON(a.TLKO_PLUOMI = b.IDM_PLUIDM ";
            $query .= "	  and tlko_NoPB = '" . $noPB . "' ";
            $query .= "		 And DATE_TRUNC('DAY', tlko_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
            $query .= "		 AND tlko_KodeOmi = '" . $KodeToko . "') ";
            $query .= "WHEN MATCHED THEN ";
            $query .= "UPDATE SET TLKO_TAG_MD = b.IDM_KodeTag ";
        }else{
            $query .= "  SELECT PRC_PLUIDM, ";
            $query .= "         PRC_KodeTag ";
            $query .= "    FROM tbMaster_Prodcrm ";
            $query .= "   Where Exists ";
            $query .= "   ( ";
            $query .= "      Select tlko_pluomi ";
            $query .= "	       From tbtr_TolakanPbOMI ";
            $query .= "	      Where tlko_PluOMI = PRC_PLUIDM ";
            $query .= "		    And tlko_NoPB = '" . $noPB . "' ";
            $query .= "		    And tlko_TglPB = to_date('" . $tglPB. "','DD-MM-YYYY') ";
            $query .= "		    AND tlko_KodeOmi = '" . $KodeToko . "' ";
            $query .= "   ) ";
            $query .= ") b ";
            $query .= "ON(a.TLKO_PLUOMI = b.PRC_PLUIDM ";
            $query .= "	  and tlko_NoPB = '" . $noPB . "' ";
            $query .= "		 And DATE_TRUNC('DAY', tlko_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
            $query .= "		 AND tlko_KodeOmi = '" . $KodeToko . "') ";
            $query .= "WHEN MATCHED THEN ";
            $query .= "UPDATE SET TLKO_TAG_MD = b.PRC_KodeTag ";
        }

        //! MERGE INTO TBTR_TOLAKANPBOMI-PRD_KodeTag
        DB::insert("
            MERGE INTO
                TBTR_TOLAKANPBOMI a
            USING
            (
                SELECT PRD_PRDCD,
                        PRD_KodeTAG
                FROM TbMaster_Prodmast
                Where Exists
                (
                    Select tlko_pluomi
                    From tbtr_TolakanPbOMI
                    Where tlko_PluIGR = PRD_PRDCD
                        And tlko_NoPB = '" . $noPB . "'
                        And tlko_TglPB = to_date('" . $tglPB. "','DD-MM-YYYY')
                        AND tlko_KodeOmi = '" . $KodeToko . "'
                )
            ) b
            ON(a.TLKO_PLUOMI = b.PRD_PRDCD
                and tlko_NoPB = '" . $noPB . "'
                And tlko_TglPB = to_date('" . $tglPB. "','DD-MM-YYYY')
                AND tlko_KodeOmi = '" . $KodeToko . "')
            WHEN MATCHED THEN
            UPDATE SET TLKO_TAG_IGR = b.PRD_KodeTag
        ");

        //! MERGE INTO TBTR_TOLAKANPBOMI-ST_AvgCost
        DB::insert("
            MERGE INTO
                TBTR_TOLAKANPBOMI a
            USING
            (
                SELECT ST_PRDCD,
                    round(st_avgcost / CASE WHEN PRD_UNIT = 'KG' THEN 1000 ELSE 1 END * (1 + COALESCE(MPI_MARGIN,3)/100)) as RUPIAH,
                    round(st_avgcost / CASE WHEN PRD_UNIT = 'KG' THEN 1000 ELSE 1 END * (COALESCE(MPI_MARGIN,3)/100)) as MARGIN,
                    COALESCE(ST_SALDOAKHIR,0) as LPP
                FROM TbMaster_Stock LEFT OUTER JOIN
                    TbMaster_MarginPluIDM ON
                    (ST_PRDCD = MPI_PluIGR)
                    LEFT OUTER JOIN  TbMaster_Prodmast ON
                    (ST_PRDCD = PRD_PRDCD)
                Where Exists
                (
                    Select tlko_pluomi
                    From tbtr_TolakanPbOMI
                    Where tlko_PluIGR = ST_PRDCD
                        And tlko_NoPB = '" . $noPB . "'
                        And DATE_TRUNC('DAY', tlko_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY')
                        AND tlko_KodeOmi = '" . $KodeToko . "'
                )
                And ST_Lokasi = '01'
            ) b
            ON(a.TLKO_PLUIGR = b.ST_PRDCD
                and tlko_NoPB = '" . $noPB . "'
                And DATE_TRUNC('DAY', tlko_TglPB) = to_date('" . $tglPB. "','DD-MM-YYYY')
                AND tlko_KodeOmi = '" . $KodeToko . "')
            WHEN MATCHED THEN
            UPDATE SET TLKO_NILAI = TLKO_QTYORDER *  b.RUPIAH,
                TLKO_MARGIN = TLKO_QTYORDER * b.MARGIN,
                TLKO_LPP = b.LPP
        ");

        //! FORCE VARIABLE
        $CounterKecil = 1;
        $CounterKarton = 2;
        $PersenMargin = 3;
        $KodeSBU = "I";

        //! CEK TABLE
        // sb.AppendLine("Select COALESCE(COUNT(1),0)  ")
        // sb.AppendLine("  FROM information_schema.columns ")
        // sb.AppendLine(" Where UPPER(table_name) = 'TBMASTER_MARGINPLUIDM' ")
        $count = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TBMASTER_MARGINPLUIDM'")
            ->count();

        if($count > 0){
            //! INSERT KE MASDPB BULKY
            DB::insert("
                Insert Into tbMaster_PBOmi
                (
                    pbo_kodeigr,
                    pbo_recordid,
                    pbo_nourut,
                    pbo_batch,
                    pbo_tglpb,
                    pbo_nopb,
                    pbo_kodesbu,
                    pbo_kodemember,
                    pbo_kodeomi,
                    pbo_kodedivisi,
                    pbo_kodedepartemen,
                    pbo_kodekategoribrg,
                    pbo_pluomi,
                    pbo_pluigr,
                    pbo_hrgsatuan,
                    pbo_qtyorder,
                    pbo_qtyrealisasi,
                    pbo_nilaiorder,
                    pbo_ppnorder,
                    pbo_distributionfee,
                    pbo_create_by,
                    pbo_create_dt,
                    pbo_TglStruk
                )
                Select '" . session('KODECABANG') . "',
                    '2',
                    row_number() OVER () ROWNUM,
                    '" . $CounterKarton . "',
                    FDTGPB,
                    FDNOUO,
                    '" . $KodeSBU . "',
                    '',
                    FDKCAB,
                    prd_kodedivisi,
                    prd_kodedepartement,
                    prd_kodekategoribarang,
                    FDKODE,
                    plukecil,
                    round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + (COALESCE(MPI_MARGIN,3)/100) )),
                    QtyB * CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE FracKarton END,
                    QtyB * CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE FracKarton END,
                    QtyB * round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + " . $PersenMargin . ")),
                    QtyB * round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + " . $PersenMargin . ")) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END,
                    0,
                    '" . session('userid') . "',
                    CURRENT_TIMESTAMP,
                    CURRENT_TIMESTAMP
                From temp_pbidm_ready
                JOIN tbmaster_prodmast
                    ON prd_prdcd = PLUKarton
                LEFT JOIN tbMaster_MarginPluIDM
                    ON MPI_PluIGR = PLUKARTON
                Where REQ_ID = '" . $ip . "'
                    and FDNOUO = '" . $noPB . "'
                    and DATE_TRUNC('DAY', FDTGPB) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    and FDKCAB = '" . $KodeToko . "'
                    and qtyb > 0
                    and COALESCE(TolakMinJ,'X') <> 'T'
            ");
        }else{
            //! INSERT KE MASDPB BULKY
            DB::insert("
                Insert Into tbMaster_PBOmi
                (
                    pbo_kodeigr,
                    pbo_recordid,
                    pbo_nourut,
                    pbo_batch,
                    pbo_tglpb,
                    pbo_nopb,
                    pbo_kodesbu,
                    pbo_kodemember,
                    pbo_kodeomi,
                    pbo_kodedivisi,
                    pbo_kodedepartemen,
                    pbo_kodekategoribrg,
                    pbo_pluomi,
                    pbo_pluigr,
                    pbo_hrgsatuan,
                    pbo_qtyorder,
                    pbo_qtyrealisasi,
                    pbo_nilaiorder,
                    pbo_ppnorder,
                    pbo_distributionfee,
                    pbo_create_by,
                    pbo_create_dt,
                    pbo_TglStruk
                )
                Select '" . session('KODECABANG') . "',
                    NULL,
                    ROW_NUMBER() OVER() + " . $PBO_NoUrut . " AS rownum,
                    '" . $CounterKecil . "',
                    FDTGPB,
                    FDNOUO,
                    '" . $KodeSBU . "',
                    '',
                    FDKCAB,
                    prd_kodedivisi,
                    prd_kodedepartement,
                    prd_kodekategoribarang,
                    FDKODE,
                    plukecil,
                    round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + (COALESCE(MPI_MARGIN,3) / 100))),
                    QtyK * CASE WHEN UnitKecil = 'KG' THEN 1 ELSE FracKecil END,
                    QtyK * CASE WHEN UnitKecil = 'KG' THEN 1 ELSE FracKecil END,
                    QtyK * round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + (COALESCE(MPI_MARGIN,3) / 100))),
                    QtyK * round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + (COALESCE(MPI_MARGIN,3) / 100))) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END,
                    0,
                    '" . session('userid') . "',
                    CURRENT_DATE,
                    CURRENT_DATE
                From temp_pbidm_ready
                JOIN tbmaster_prodmast
                    ON prd_prdcd = PLUKarton
                LEFT JOIN tbMaster_MarginPluIDM
                    ON MPI_PLUIGR = PLUKARTON
                Where REQ_ID = '" . $ip . "'
                    and FDNOUO = '" . $noPB . "'
                    and DATE_TRUNC('DAY', FDTGPB) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    and FDKCAB = '" . $KodeToko . "'
                    and qtyK > 0
                    and COALESCE(TolakMinJ,'X') <> 'T'
            ");
        }

        //! VARIABLE PBO_NoUrut
        // sb.AppendLine("Select COALESCE(Max(pbo_nourut),1) ")
        // sb.AppendLine("  From tbMaster_PbOMI ")
        // sb.AppendLine(" Where PBO_KodeIGR = '" & KDIGR & "' ")
        // sb.AppendLine("   And PBO_NoPB = '" & noPB & "' ")
        // sb.AppendLine("   And DATE_TRUNC('DAY', PBO_TglPB) = to_date('" & tglPB & "','DD-MM-YYYY')")
        // sb.AppendLine("   And PBO_KodeOMI = '" & KodeToko & "' ")

        $PBO_NoUrut = DB::table('tbmaster_pbomi')
            ->select('COALESCE(Max(pbo_nourut),1) as count')
            ->where([
                'pbo_kodeigr' => $KDIGR,
                'pbo_nopb' => $noPB,
                'pbo_kodeomi' => $KodeToko,
            ])
            ->whereRaw("DATE_TRUNC('DAY', pbo_tglpb) = to_date('" . $tglPB . "','DD-MM-YYYY')")
            ->first()->count;

        //! CEK TABLE
        // sb.AppendLine("Select COALESCE(COUNT(1),0)  ")
        // sb.AppendLine("  FROM information_schema.columns ")
        // sb.AppendLine(" Where UPPER(table_name) = 'TBMASTER_MARGINPLUIDM' ")

        $count = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TBMASTER_MARGINPLUIDM'")
            ->count();

        if($count > 0){
            //! INSERT KE MASDPB PIECES
            DB::insert("
                Insert Into tbMaster_PBOmi
                (
                    pbo_kodeigr,
                    pbo_recordid,
                    pbo_nourut,
                    pbo_batch,
                    pbo_tglpb,
                    pbo_nopb,
                    pbo_kodesbu,
                    pbo_kodemember,
                    pbo_kodeomi,
                    pbo_kodedivisi,
                    pbo_kodedepartemen,
                    pbo_kodekategoribrg,
                    pbo_pluomi,
                    pbo_pluigr,
                    pbo_hrgsatuan,
                    pbo_qtyorder,
                    pbo_qtyrealisasi,
                    pbo_nilaiorder,
                    pbo_ppnorder,
                    pbo_distributionfee,
                    pbo_create_by,
                    pbo_create_dt,
                    pbo_TglStruk
                )
                Select '" . session('KODECABANG') . "',
                    NULL,
                    rownum + " . $PBO_NoUrut . ",
                    '" . $CounterKecil . "',
                    FDTGPB,
                    FDNOUO,
                    '" . $KodeSBU . "',
                    '',
                    FDKCAB,
                    prd_kodedivisi,
                    prd_kodedepartement,
                    prd_kodekategoribarang,
                    FDKODE,
                    plukecil,
                    round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + (COALESCE(MPI_MARGIN,3) / 100)),0),
                    QtyK * CASE WHEN UnitKecil = 'KG' THEN 1 ELSE FracKecil END,
                    QtyK * CASE WHEN UnitKecil = 'KG' THEN 1 ELSE FracKecil END,
                    QtyK * round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + (COALESCE(MPI_MARGIN,3) / 100)),0),
                    QtyK * round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + (COALESCE(MPI_MARGIN,3) / 100)),0) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END,
                    0,
                    '" . session('userid') . "',
                    CURRENT_DATE,
                    CURRENT_DATE
                From temp_pbidm_ready,tbmaster_prodmast LEFT OUTER JOIN tbMaster_MarginPluIDM
                    ON (MPI_PLUIGR = PLUKARTON)
                Where REQ_ID = '" . $ip . "'
                    and FDNOUO = '" . $noPB . "'
                    and DATE_TRUNC('DAY', FDTGPB) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    and FDKCAB = '" . $KodeToko . "'
                    and qtyK > 0
                    and prd_prdcd = PLUKarton
                    and COALESCE(TolakMinJ,'X') <> 'T'
            ");
        }else{
            //! INSERT KE MASDPB PIECES
            DB::insert("
                Insert Into tbMaster_PBOmi
                (
                    pbo_kodeigr,
                    pbo_recordid,
                    pbo_nourut,
                    pbo_batch,
                    pbo_tglpb,
                    pbo_nopb,
                    pbo_kodesbu,
                    pbo_kodemember,
                    pbo_kodeomi,
                    pbo_kodedivisi,
                    pbo_kodedepartemen,
                    pbo_kodekategoribrg,
                    pbo_pluomi,
                    pbo_pluigr,
                    pbo_hrgsatuan,
                    pbo_qtyorder,
                    pbo_qtyrealisasi,
                    pbo_nilaiorder,
                    pbo_ppnorder,
                    pbo_distributionfee,
                    pbo_create_by,
                    pbo_create_dt,
                    pbo_TglStruk
                )
                Select '" . session('KODECABANG') . "',
                    NULL,
                    rownum + " . $PBO_NoUrut . ",
                    '" . $CounterKecil . "',
                    FDTGPB,
                    FDNOUO,
                    '" . $KodeSBU . "',
                    '',
                    FDKCAB,
                    prd_kodedivisi,
                    prd_kodedepartement,
                    prd_kodekategoribarang,
                    FDKODE,
                    plukecil,
                    round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + " . $PersenMargin . "),0),
                    QtyK * CASE WHEN UnitKecil = 'KG' THEN 1 ELSE FracKecil END,
                    QtyK * CASE WHEN UnitKecil = 'KG' THEN 1 ELSE FracKecil END,
                    QtyK * round(avgcost / CASE WHEN UnitKarton = 'KG' THEN 1000 ELSE 1 END * (1 + " . $PersenMargin . "),0),
                    QtyK * CASE WHEN UnitKecil = 'KG' THEN 1 ELSE FracKecil END * round(avgcost * (1 + " . $PersenMargin . "),0) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END,
                    0,
                    '" . session('userid') . "',
                    CURRENT_TIMESTAMP,
                    CURRENT_TIMESTAMP
                From temp_pbidm_ready,tbmaster_prodmast
                Where REQ_ID = '" . $ip . "'
                    and FDNOUO = '" . $noPB . "'
                    and DATE_TRUNC('DAY', FDTGPB) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    and FDKCAB = '" . $KodeToko . "'
                    and qtyK > 0
                    and prd_prdcd = PLUKarton
                    and COALESCE(TolakMinJ,'X') <> 'T'
            ");
        }

        //! UPDATE PBO_KodeMember
        DB::insert("
            MERGE INTO
                TBMASTER_PBOMI a
            USING
            (
                Select *
                    FROM tbMaster_TokoIGR
                WHERE COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE
            ) b
            ON (a.PBO_KodeOMI = b.TKO_KodeOMI
            and PBO_NOPB = '" . $noPB . "'
                AND DATE_TRUNC('DAY', PBO_TglPB) = TO_DATE('" . $tglPB. "','DD-MM-YYYY')
                And PBO_KodeOMI = '" . $KodeToko . "')
            WHEN MATCHED THEN
            UPDATE SET PBO_KodeMember = b.TKO_KodeCustomer,
                PBO_RecordID = '3'
        ");

        //! VARIABLE jumItmCSV
        // sb.AppendLine("Select COALESCE(COUNT(1),0)  ")
        // sb.AppendLine("  From CSV_PB_BUAH ")
        // sb.AppendLine("	Where CPB_IP = '" & IP & "' ")
        // sb.AppendLine("   And CPB_NoPB = '" & noPB & "' ")
        // sb.AppendLine("   And DATE_TRUNC('DAY', CPB_TglPB) = to_date('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("   AND CPB_KodeToko = '" & KodeToko & "' ")

        $jumItmCSV = DB::table('CSV_PB_BUAH')
            ->where([
                'CPB_IP' => $ip,
                'CPB_NoPB' => $noPB,
                'CPB_KodeToko' => $KodeToko,
            ])
            ->where(DB::raw("DATE_TRUNC('DAY', CPB_TglPB)"), Carbon::parse($tglPB)->format('d-m-Y'))
            ->count();

        //! VARIABLE jumTolakan
        // sb.AppendLine("Select COALESCE(Count(1),0)  ")
        // sb.AppendLine("  From temp_cetakpb_tolakan_idm ")
        // sb.AppendLine(" Where REQ_ID = '" & IP & "'   ")
        // sb.AppendLine("   And nodok = '" & noPB & "'   ")
        // sb.AppendLine("   And DATE_TRUNC('DAY', tgldok) = to_date('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("	  AND KCAB = '" & KodeToko & "' ")

        $jumTolakan = DB::table('temp_cetakpb_tolakan_idm')
            ->where([
                'REQ_ID' => $ip,
                'nodok' => $noPB,
                'KCAB' => $KodeToko,
            ])
            ->where(DB::raw("DATE_TRUNC('DAY', tgldok)"), Carbon::parse($tglPB)->format('d-m-Y'))
            ->count();

        //! VARIABLE rphOrder
        // sb.AppendLine("Select sum(COALESCE(pbo_nilaiorder,0))  ")
        // sb.AppendLine("  From tbMaster_PBOMI ")
        // sb.AppendLine(" Where PBO_KodeIGR = '" & KDIGR & "' ")
        // sb.AppendLine("   And PBO_NoPB = '" & noPB & "' ")
        // sb.AppendLine("   And DATE_TRUNC('DAY', PBO_TglPB) = to_date('" & tglPB & "','DD-MM-YYYY') ")
        // sb.AppendLine("   And PBO_KodeOMI = '" & KodeToko & "' ")

        DB::table('tbmaster_pbomi')
            ->selectRaw("sum(COALESCE(pbo_nilaiorder,0)) as sum")
            ->where([
                'pbo_kodeigr' => $KDIGR,
                'pbo_nopb' => $noPB,
                'pbo_kodeomi' => $KodeToko,
            ])
            ->where(DB::raw("DATE_TRUNC('DAY', pbo_tglpb)"), Carbon::parse($tglPB)->format('Y-m-d'))
            ->first()->sum;

        $JumlahKontainer = 0;
        $JumlahBronjong = 0;
        $KubikasiKontainer = 0;
        $KubikasiBronjong = 0;

        //! Insert Into TBTR_Header_Buah
        DB::insert("
            INSERT INTO TBTR_Header_Buah
            (
                HDB_kodeigr,
                HDB_Flag,
                HDB_tgltransaksi,
                HDB_kodetoko,
                HDB_nopb,
                HDB_tglpb,
                HDB_itempb,
                HDB_itemvalid,
                HDB_rphvalid,
                HDB_filepb,
                HDB_keterangan,
                HDB_create_by,
                HDB_create_dt
            )
            Select pbo_kodeigr,
                '1',
                CURRENT_TIMESTAMP,
                pbo_kodeomi,
                pbo_noPB,
                pbo_tglPB,
                " . $jumItmCSV . ",
                    Count(PBO_PLUIGR),
                    SUM(PBO_NilaiOrder),
                '" . $FilePB ."',
                '" . $JenisPB . "',
                '" . session('userid') . "',
                    CURRENT_TIMESTAMP
            FROM tbMaster_pbomi
            Where pbo_noPB = '" . $noPB . "'
            And DATE_TRUNC('DAY', pbo_tglPB) = TO_DATE('" . $tglPB. "','DD-MM-YYYY')
            And PBO_KodeOMI = '" . $KodeToko . "'
            GROUP BY pbo_kodeigr,
                pbo_kodeomi,
                pbo_noPB,
                pbo_tglPB
        ");

        //! MERGE TBTR_Header_Buah-SET NoUrut
        DB::insert("
            MERGE INTO
                TBTR_Header_Buah a
            USING
            (
                SELECT CLB_Kode,
                    CLB_Toko,
                    CLB_NoUrut
                FROM CLUSTER_BUAH
            ) B
            ON
            (
                a.HDB_KodeToko = b.CLB_Toko
                and HDB_NOPB = '" . $noPB . "'
                AND DATE_TRUNC('DAY', HDB_tglPB) = TO_DATE('" . $tglPB. "','DD-MM-YYYY')
                AND HDB_Flag = '1'
                AND HDB_KodeToko = '" . $KodeToko . "'
            )
            WHEN MATCHED THEN
            UPDATE SET HDB_KodeCluster = b.CLB_Kode,
                HDB_NoUrut = b.CLB_NoUrut
        ");

        //! INSERT INTO DCP_DATA_BUAH
        DB::insert("
            INSERT INTO DCP_DATA_BUAH
            (
                DDB_KodeSBU,
                DDB_KodeToko,
                DDB_NoPB,
                DDB_TglPB,
                DDB_PRDCD,
                DDB_PLUIDM,
                DDB_Deskripsi,
                DDB_Unit,
                DDB_Frac,
                DDB_FlagBKP1,
                DDB_FlagBKP2,
                DDB_QtyOrder,
                DDB_TglUpload,
                DDB_IP,
                DDB_JenisPB,
                DDB_NoUrutJenisPB
            )
            SELECT '" . $KodeSBU . "' as KodeSBU,
                PBO_KodeOMI,
                PBO_NoPB,
                PBO_TglPB,
                PBO_PluIGR,
                PBO_PluOMI,
                SUBSTR(PRD_DeskripsiPendek,1,20),
                PRD_Unit,
                PRD_Frac,
                PRD_FlagBKP1,
                PRD_FlagBKP2,
                PBO_QtyOrder,
                CURRENT_timestamp,
                '" . $ip . "',
                '" . $JenisPB . "',
                " . $NoUrJenisPB . "
            From tbMaster_PBOMI,
                tbMaster_Prodmast
            WHERE PBO_NOPB = '" . $noPB . "'
                AND DATE_TRUNC('DAY', PBO_TglPB) = TO_DATE('" . $tglPB. "','DD-MM-YYYY')
                And PBO_KodeOMI = '" . $KodeToko . "'
                AND PBO_PLUIGR = PRD_PRDCD
        ");

        //! MERGE DCP_DATA_BUAH SET DDB_KodeCluster,DDB_NoUrutToko
        DB::insert("
            MERGE INTO
                DCP_DATA_BUAH  A
            USING
            (
                SELECT *
                FROM CLUSTER_BUAH
            ) B
            ON (
                A.DDB_KodeToko = B.CLB_Toko
                AND DDB_IP = '" . $ip . "'
                AND DDB_KodeToko = '" . $KodeToko . "'
                AND DDB_NOPB = '" . $noPB . "'
                AND DATE_TRUNC('DAY', DDB_TglPB) = TO_DATE('" . $tglPB. "','DD-MM-YYYY')
                AND DDB_JeniSPB = '" . $JenisPB . "'
                AND DDB_RecordID IS NULL
            )
            WHEN MATCHED THEN
            UPDATE SET DDB_NoUrutToko  = B.CLB_NoUrut,
                DDB_KodeCluster = B.CLB_Kode
        ");

        //! MERGE DCP_DATA_BUAH SET DDB_NoUrutPLU
        DB::insert("
            MERGE INTO
                DCP_DATA_BUAH A
            USING
            (
                SELECT *
                FROM TEMP_URUTAN_BUAH
                WHERE IP = '" . $ip . "'
            ) B
            ON (
                A.DDB_PLUIDM = B.PLU
                AND A.DDB_JenisPB = B.Jenis
                AND DDB_IP = '" . $ip . "'
                AND DDB_KodeToko = '" . $KodeToko . "'
                AND DDB_NOPB = '" . $noPB . "'
                AND DATE_TRUNC('DAY', DDB_TglPB) = TO_DATE('" . $tglPB. "','DD-MM-YYYY')
                AND DDB_JeniSPB = '" . $JenisPB . "'
                AND DDB_RecordID IS NULL
            )
            WHEN MATCHED THEN
            UPDATE SET DDB_NoUrutPLU = B.NoUrut
        ");

        //! INSERT INTO HISTORY_DCP_DATA_BUAH
        DB::insert("
            INSERT INTO HISTORY_DCP_DATA_BUAH
            (
                HDDB_RecordID,
                HDDB_ID,
                HDDB_KodeSBU,
                HDDB_KodeToko,
                HDDB_NoPB,
                HDDB_TglPB,
                HDDB_PRDCD,
                HDDB_PLUIDM,
                HDDB_Deskripsi,
                HDDB_Unit,
                HDDB_Frac,
                HDDB_FlagBKP1,
                HDDB_FlagBKP2,
                HDDB_QtyOrder,
                HDDB_QtyScan,
                HDDB_TglUpload,
                HDDB_TglScan,
                HDDB_UserScan,
                HDDB_IP,
                HDDB_KodeCluster,
                HDDB_JenisPB,
                HDDB_NoUrutJenisPB,
                HDDB_NoUrutPLU,
                HDDB_NoUrutToko,
                HDDB_NoKoli
            )
            SELECT DDB_RecordID,
                DDB_ID,
                DDB_KodeSBU,
                DDB_KodeToko,
                DDB_NoPB,
                DDB_TglPB,
                DDB_PRDCD,
                DDB_PLUIDM,
                DDB_Deskripsi,
                DDB_Unit,
                DDB_Frac,
                DDB_FlagBKP1,
                DDB_FlagBKP2,
                DDB_QtyOrder,
                DDB_QtyScan,
                DDB_TglUpload,
                DDB_TglScan,
                DDB_UserScan,
                DDB_IP,
                DDB_KodeCluster,
                DDB_JenisPB,
                DDB_NoUrutJenisPB,
                DDB_NoUrutPLU,
                DDB_NoUrutToko,
                DDB_NoKoli
            FROM DCP_DATA_BUAH
            WHERE DATE_TRUNC('DAY', DDB_TGLUPLOAD) < CURRENT_DATE - 90
        ");

        //! DELETE FROM DCP_DATA_BUAH
        // sb.AppendLine("DELETE FROM DCP_DATA_BUAH ")
        // sb.AppendLine(" WHERE DATE_TRUNC('DAY', DDB_TGLUPLOAD) < CURRENT_DATE - 90 ")
        DB::table('dcp_data_buah')
            ->whereRaw("DATE_TRUNC('DAY', ddb_tglupload) < CURRENT_DATE - 90")
            ->delete();

        // CetakALL_1(PersenMargin, CounterKarton, CounterKecil)
        // CetakALL_2(PersenMargin, CounterKarton, CounterKecil)
        // CetakALL_3(PersenMargin, CounterKarton, CounterKecil)
        // CetakALL_4(PersenMargin, CounterKarton, CounterKecil)
        // CetakALL_5(PersenMargin, CounterKarton, CounterKecil)
        // CetakALL_6(PersenMargin, CounterKarton, CounterKecil)
    }

    public function CetakALL_1(){

        //! VARIABLE
        $ip = $this->getIP();
        $KodeToko = "";
        $noPB = "";
        $tglPB = "";
        $PersenMargin = "";

        //! GET HEADER CETAKAN
        // sb.AppendLine("Select PRS_NamaCabang ")
        // sb.AppendLine("  From tbMaster_perusahaan ")

        $data['namaCabang'] = DB::table('tbmaster_perusahaan')
            ->select('prs_namacabang')
            ->first()->prs_namacabang;

        // sb.AppendLine("Select TKO_NamaOMI ")
        // sb.AppendLine("  From tbMaster_TokoIGR ")
        // sb.AppendLine(" Where TKO_KodeIGR = '" & KDIGR & "' ")
        // sb.AppendLine("   And TKO_KodeOMI = '" & KodeToko & "' ")
        // sb.AppendLine("   And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE ")

        $data['namaToko'] = DB::table('tbmaster_tokoigr')
            ->select('tko_namaomi')
            ->where([
                'tko_kodeigr' => session('KODECABANG'),
                'tko_kodeomi' => $KodeToko,
            ])
            ->whereRaw("coalesce(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE")
            ->first()->tko_namaomi;

        //! f = "LIST ORDER PB"

        //! CEK TABLE
        // sb.AppendLine("Select COALESCE(COUNT(1),0)  ")
        // sb.AppendLine("  FROM information_schema.columns ")
        // sb.AppendLine(" Where UPPER(table_name) = 'TBMASTER_MARGINPLUIDM' ")

        $count = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TBMASTER_MARGINPLUIDM'")
            ->count();

        if($count > 0){
            //! INSERT INTO PBIDM_LISTORDER
            DB::insert("
                INSERT INTO PBIDM_LISTORDER
                (
                    PBL_KODETOKO,
                    PBL_NOPB,
                    PBL_TGLPB,
                    PBL_PLU,
                    PBL_DESKRIPSI,
                    PBL_UNIT,
                    PBL_FRAC,
                    PBL_QTYB,
                    PBL_QTYK,
                    PBL_QTYO,
                    PBL_HRGSATUAN,
                    PBL_NILAI,
                    PBL_PPN,
                    PBL_TOTAL,
                    PBL_CREATE_BY,
                    PBL_CREATE_DT
                )
                Select '" . $KodeToko . "' as KODETOKO,
                    '" . $noPB . "' as NoPB,
                    TO_DATE('" . $tglPB. "','DD-MM-YYYY') as TglPB,
                    plukarton as plu,
                    desk,
                    unitkarton as unit,
                    frackarton as frac,
                    qtyb as qty,
                    qtyk as frc,
                    fdqtyb as inpcs,
                    Round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+(COALESCE(MPI_MARGIN,3)/100))) as Harga,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+(COALESCE(MPI_MARGIN,3)/100))) as Nilai,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+(COALESCE(MPI_MARGIN,3)/100))) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END as PPN,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+(COALESCE(MPI_MARGIN,3)/100))) * (1 + CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN (COALESCE(PRD_PPN,0)/100) ELSE 0 END) as TOTAL,
                    '" . session('userid') . "',
                    CURRENT_TIMESTAMP
                From temp_pbidm_ready
                JOIN tbmaster_prodmast ON prd_prdcd = plukarton
                LEFT JOIN tbmaster_marginpluidm ON MPI_PluIGR = PLUKARTON
                Where req_id = '" . $ip . "'
                    and fdnouo = '" . $noPB . "'
                    and DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
            ");

            //! ISI dtListOrder
            DB::select("
                Select plukarton as plu,
                    desk,
                    unitkarton ||'/'|| frackarton as unit,
                    qtyb as qty,
                    qtyk as frc,
                    fdqtyb as inpcs,
                    Round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+(COALESCE(MPI_MARGIN,3)/100))) as Harga,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+(COALESCE(MPI_MARGIN,3)/100))) as Nilai,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+(COALESCE(MPI_MARGIN,3)/100))) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END as PPN,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+(COALESCE(MPI_MARGIN,3)/100))) * (1 + CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN (COALESCE(PRD_PPN,0)/100) ELSE 0 END) as TOTAL
                From temp_pbidm_ready
                JOIN tbmaster_prodmast ON prd_prdcd = plukarton
                LEFT JOIN tbmaster_marginpluidm ON MPI_PluIGR = PLUKARTON
                Where req_id = '" . $ip . "'
                    and fdnouo = '" . $noPB . "'
                    and DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                Order By plukarton,fdqtyb desc
            ");
        }else{
            //! INSERT INTO PBIDM_LISTORDER
            DB::insert("
                INSERT INTO PBIDM_REKAPORDER
                (
                    PBL_KODETOKO,
                    PBL_NOPB,
                    PBL_TGLPB,
                    PBL_PLU,
                    PBL_DESKRIPSI,
                    PBL_UNIT,
                    PBL_QTYB,
                    PBL_QTYK,
                    PBL_QTYO,
                    PBL_HRGSATUAN,
                    PBL_NILAI,
                    PBL_PPN,
                    PBL_TOTAL,
                    PBL_CREATE_BY,
                    PBL_CREATE_DT
                )
                Select '" . $KodeToko . "' as KODETOKO
                    '" . $noPB . "' as NoPB,
                    TO_DATE('" . $tglPB. "','YYYYMMDD') as TglPB,
                    plukarton as plu,
                    desk,
                    unitkarton ||'/'|| frackarton as unit,
                    qtyb as qty,
                    qtyk as frc,
                    fdqtyb as inpcs,
                    Round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+ " . $PersenMargin . ")) as Harga,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+" . $PersenMargin . ")) as Nilai,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+" . $PersenMargin . ")) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END as PPN,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+" . $PersenMargin . ")) * (1 + CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN (COALESCE(PRD_PPN,0)/100) ELSE 0 END) as TOTAL,
                    '" . session('userid') . "',
                    CURRENT_DATE
                From temp_pbidm_ready, tbMaster_prodmast
                Where req_id = '" . $ip . "'
                    and fdnouo = '" . $noPB . "'
                    and DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    and prd_prdcd = plukarton
            ");

            //! ISI dtListOrder
            DB::select("
                Select plukarton as plu,
                    desk,
                    unitkarton ||'/'|| frackarton as unit,
                    qtyb as qty,
                    qtyk as frc,
                    fdqtyb as inpcs,
                    Round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+ " . $PersenMargin . ")) as Harga,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+" . $PersenMargin . ")) as Nilai,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+" . $PersenMargin . ")) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END as PPN,
                    fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END * (1+" . $PersenMargin . ")) * (1 + CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN (COALESCE(PRD_PPN,0)/100) ELSE 0 END) as TOTAL
                From temp_pbidm_ready, tbMaster_prodmast
                Where req_id = '" . $ip . "'
                    and fdnouo = '" . $noPB . "'
                    and DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    and prd_prdcd = plukarton
                Order By plukarton, FDQTYB
            ");
        }

        //? rptListOrder.SetParameterValue("NamaCabang", NamaCab)
        //? rptListOrder.SetParameterValue("NamaToko", NamaToko)
        //? rptListOrder.SetParameterValue("KodeToko", KodeToko)
        //? rptListOrder.SetParameterValue("Nopb", noPB)
        //? rptListOrder.SetParameterValue("Tglpb", tglPB)
    }

    public function CetakALL_2(){

        //! VARIABLE
        $ip = $this->getIP();
        $KodeToko = "";
        $noPB = "";
        $tglPB = "";
        $PersenMargin = "";

        //! GET HEADER CETAKAN
        // sb.AppendLine("Select PRS_NamaCabang ")
        // sb.AppendLine("  From tbMaster_perusahaan ")

        $data['namaCabang'] = DB::table('tbmaster_perusahaan')
            ->select('prs_namacabang')
            ->first()->prs_namacabang;

        // sb.AppendLine("Select TKO_NamaOMI ")
        // sb.AppendLine("  From tbMaster_TokoIGR ")
        // sb.AppendLine(" Where TKO_KodeIGR = '" & KDIGR & "' ")
        // sb.AppendLine("   And TKO_KodeOMI = '" & KodeToko & "' ")
        // sb.AppendLine("   And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE ")

        $data['namaToko'] = DB::table('tbmaster_tokoigr')
            ->select('tko_namaomi')
            ->where([
                'tko_kodeigr' => session('KODECABANG'),
                'tko_kodeomi' => $KodeToko,
            ])
            ->whereRaw("coalesce(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE")
            ->first()->tko_namaomi;

        //! f = "REKAP ORDER PB"

        //! CEK TABLE
        // sb.AppendLine("Select COALESCE(COUNT(1),0)  ")
        // sb.AppendLine("  FROM information_schema.columns ")
        // sb.AppendLine(" Where UPPER(table_name) = 'TBMASTER_MARGINPLUIDM' ")

        $count = DB::table('information_schema.columns')
            ->whereRaw("upper(table_name) = 'TBMASTER_MARGINPLUIDM'")
            ->count();

        if($count > 0){
            //! INSERT INTO PBIDM_REKAPORDER
            DB::insert("
                INSERT INTO PBIDM_REKAPORDER
                (
                    PBR_KODETOKO,
                    PBR_NOPB,
                    PBR_TGLPB,
                    PBR_NAMADIVISI,
                    PBR_KODEDIVISI,
                    PBL_ITEM,
                    PBL_NILAI,
                    PBL_PPN,
                    PBL_SUBTOTAL,
                    PBL_CREATE_BY,
                    PBL_CREATE_DT
                )
                Select '" . $KodeToko . "' as KODETOKO,
                    '" . $noPB . "' as NoPB,
                    TO_DATE('" . $tglPB. "','DD-MM-YYYY') as TglPB,
                    DIV_NamaDivisi as NamaDivisi,
                    PRD_KodeDivisi as KodeDivisi,
                    Count(PLUKARTON) as Item,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+(COALESCE(MPI_MARGIN,3)/100)))) as Nilai,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+(COALESCE(MPI_MARGIN,3)/100)) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END)) as PPN,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+(COALESCE(MPI_MARGIN,3)/100)) * (1 + CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN (COALESCE(PRD_PPN,0)/100) ELSE 0 END))) as SUBTOTAL,
                    '" . session('userid') . "',
                    CURRENT_DATE
                From temp_pbidm_ready
                JOIN tbmaster_prodmast ON prd_prdcd = plukarton
                JOIN tbMaster_Divisi ON DIV_KodeDivisi = PRD_KodeDivisi
                LEFT JOIN tbmaster_marginpluidm ON MPI_PluIGR = PLUKARTON
                Where req_id = '" . $ip . "'
                    and fdnouo = '" . $noPB . "'
                    and DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                Group By DIV_NamaDivisi,
                        PRD_KodeDivisi
            ");

            //! ISI dtRekapOrder
            DB::select("
                Select DIV_NamaDivisi as NamaDivisi,
                    PRD_KodeDivisi as KodeDivisi,
                    Count(PLUKARTON) as Item,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+(COALESCE(MPI_MARGIN,3)/100)))) as Nilai,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+(COALESCE(MPI_MARGIN,3)/100)) * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END)) as PPN,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+(COALESCE(MPI_MARGIN,3)/100)) * (1 + CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN (COALESCE(PRD_PPN,0)/100) ELSE 0 END))) as SUBTOTAL
                From temp_pbidm_ready
                JOIN tbmaster_prodmast ON prd_prdcd = plukarton
                JOIN tbMaster_Divisi ON DIV_KodeDivisi = PRD_KodeDivisi
                LEFT JOIN tbmaster_marginpluidm ON MPI_PluIGR = PLUKARTON
                Where req_id = '" . $ip . "'
                    and fdnouo = '" . $noPB . "'
                    and DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                Group By DIV_NamaDivisi,
                        PRD_KodeDivisi
                Order By PRD_KodeDivisi
            ");
        }else{
            //! INSERT INTO PBIDM_REKAPORDER
            DB::insert("
                INSERT INTO PBIDM_REKAPORDER
                (
                    PBR_KODETOKO,
                    PBR_NOPB,
                    PBR_TGLPB,
                    PBR_NAMADIVISI,
                    PBR_KODEDIVISI,
                    PBL_ITEM,
                    PBL_NILAI,
                    PBL_PPN,
                    PBL_SUBTOTAL,
                    PBL_CREATE_BY,
                    PBL_CREATE_DT
                )
                Select '" . $KodeToko . "' as KODETOKO
                    '" . $noPB . "' as NoPB,
                    TO_DATE('" . $tglPB. "','YYYYMMDD') as TglPB,
                    DIV_NamaDivisi as NamaDivisi,
                    PRD_KodeDivisi as KodeDivisi,
                    Count(PLUKARTON) as Item,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+" . $PersenMargin . "))) as Nilai,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+" . $PersenMargin . ") * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END)) as PPN,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+" . $PersenMargin . ") * (1 + CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN (COALESCE(PRD_PPN,0)/100) ELSE 0 END))) as SUBTOTAL,
                    '" . session('userid') . "',
                    CURRENT_DATE
                From temp_pbidm_ready, tbMaster_prodmast, tbMaster_Divisi
                Where req_id = '" . $ip . "'
                    and fdnouo = '" . $noPB . "'
                    and DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    and prd_prdcd = plukarton
                    and DIV_KodeDivisi = PRD_KodeDivisi
                Group By DIV_NamaDivisi,
                        PRD_KodeDivisi
            ");

            //! ISI dtRekapOrder
            DB::select("
                Select DIV_NamaDivisi as NamaDivisi,
                    PRD_KodeDivisi as KodeDivisi,
                    Count(PLUKARTON) as Item,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+" . $PersenMargin . "))) as Nilai,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+" . $PersenMargin . ") * (COALESCE(PRD_PPN,0)/100) * CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN 1 ELSE 0 END)) as PPN,
                    SUM(fdqtyb * round(avgcost / CASE WHEN PRD_UNIT='KG' THEN 1000 ELSE 1 END  * (1+" . $PersenMargin . ") * (1 + CASE WHEN COALESCE(PRD_FlagBKP1,'X') = 'Y' THEN (COALESCE(PRD_PPN,0)/100) ELSE 0 END))) as SUBTOTAL
                From temp_pbidm_ready, tbMaster_prodmast, tbMaster_Divisi
                Where req_id = '" . $ip . "'
                    and fdnouo = '" . $noPB . "'
                    and DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                    and prd_prdcd = plukarton
                    and DIV_KodeDivisi = PRD_KodeDivisi
                Group By DIV_NamaDivisi,
                        PRD_KodeDivisi
                Order By PRD_KodeDivisi
            ");
        }

        //? rptRekap.SetParameterValue("NamaCabang", NamaCab)
        //? rptRekap.SetParameterValue("NamaToko", NamaToko)
        //? rptRekap.SetParameterValue("KodeToko", KodeToko)
        //? rptRekap.SetParameterValue("Nopb", noPB)
        //? rptRekap.SetParameterValue("Tglpb", tglPB)
    }

    public function CetakALL_3(){

        //! VARIABLE
        $ip = $this->getIP();
        $KodeToko = "";
        $noPB = "";
        $tglPB = "";

        //! GET HEADER CETAKAN
        // sb.AppendLine("Select PRS_NamaCabang ")
        // sb.AppendLine("  From tbMaster_perusahaan ")

        $data['namaCabang'] = DB::table('tbmaster_perusahaan')
            ->select('prs_namacabang')
            ->first()->prs_namacabang;

        // sb.AppendLine("Select TKO_NamaOMI ")
        // sb.AppendLine("  From tbMaster_TokoIGR ")
        // sb.AppendLine(" Where TKO_KodeIGR = '" & KDIGR & "' ")
        // sb.AppendLine("   And TKO_KodeOMI = '" & KodeToko & "' ")
        // sb.AppendLine("   And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE ")

        $data['namaToko'] = DB::table('tbmaster_tokoigr')
            ->select('tko_namaomi')
            ->where([
                'tko_kodeigr' => session('KODECABANG'),
                'tko_kodeomi' => $KodeToko,
            ])
            ->whereRaw("coalesce(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE")
            ->first()->tko_namaomi;

        //! f = "KARTON NON DPD"

        //! INSERT INTO PBIDM_KARTONNONDPD
        $userid = session('userid');
        DB::insert(`
            INSERT INTO PBIDM_KARTONNONDPD
            (
                PBD_KODETOKO,
                PBD_NOPB,
                PBD_TGLPB,
                PBD_NAMAGROUP,
                PBD_KODERAK,
                PBD_SUBRAK,
                PBD_TIPERAK,
                PBD_PLU,
                PBD_NOURUT,
                PBD_DESKRIPSI,
                PBD_TAG,
                PBD_QTY,
                PBD_UNIT,
                PBD_FRAC,
                PBD_STOK,
                PBD_CREATE_BY,
                PBD_CREATE_DT
            )
            Select '$KodeToko' as KODETOKO,
                '$noPB' as NoPB,
                TO_DATE('$tglPB','DD-MM-YYYY') as TglPB,
                GRR_GroupRak as NamaGroup,
                LKS_KodeRak as KodeRak,
                LKS_KodeSubRak as SubRak,
                LKS_TipeRak as TipeRak,
                PLUKARTON as PLU,
                LKS_NoUrut as NoUrut,
                Desk,
                PRD_KodeTag as TAG,
                QTYB as ""Order"",
                UNITKarton ,
                FracKarton,
                    Stok,
                '$userid',
                CURRENT_TIMESTAMP
            From temp_karton_nondpd_idm,tbMaster_Prodmast
            Where REQ_ID = '$ip'
                And FDKCAB = '$KodeToko'
                And FDNOUO = '$noPB'
                And DATE_TRUNC('DAY', FDTGPB) = to_date('$tglPB','DD-MM-YYYY')
                And PRD_PRDCD = PLUKARTON
        `);

        //! ISI dtKartonNonDPD
        DB::select(`
            Select DISTINCT GRR_GroupRak as NamaGroup,
                LKS_KodeRak as KodeRak,
                LKS_KodeSubRak as SubRak,
                LKS_TipeRak as TipeRak,
                PLUKARTON as PLU,
                LKS_NoUrut as NoUrut,
                Desk,
                PRD_KodeTag as TAG,
                QTYB as ""Order"",
                UNITKarton ||'/'|| FracKarton as UNIT,
                    Stok
            From temp_karton_nondpd_idm,tbMaster_Prodmast
            Where REQ_ID = '$ip'
                And FDKCAB = '$KodeToko'
                And FDNOUO = '$noPB'
                And DATE_TRUNC('DAY', FDTGPB) = to_date('$tglPB','DD-MM-YYYY')
                And PRD_PRDCD = PLUKARTON
            Order By GRR_GroupRak,LKS_KodeRak,LKS_KodeSubRak,LKS_TipeRak,LKS_NoUrut
        `);

        //? rptKarton.SetParameterValue("NamaCabang", NamaCab)
        //? rptKarton.SetParameterValue("NamaToko", NamaToko)
        //? rptKarton.SetParameterValue("KodeToko", KodeToko)
        //? rptKarton.SetParameterValue("Nopb", noPB)
        //? rptKarton.SetParameterValue("Tglpb", tglPB)
        //? rptKarton.SetParameterValue("Batch", CounterKarton)
    }

    public function CetakALL_4(){

        //! VARIABLE
        $ip = $this->getIP();
        $KodeToko = "";
        $noPB = "";
        $tglPB = "";

        //! GET HEADER CETAKAN
        // sb.AppendLine("Select PRS_NamaCabang ")
        // sb.AppendLine("  From tbMaster_perusahaan ")

        $data['namaCabang'] = DB::table('tbmaster_perusahaan')
            ->select('prs_namacabang')
            ->first()->prs_namacabang;

        // sb.AppendLine("Select TKO_NamaOMI ")
        // sb.AppendLine("  From tbMaster_TokoIGR ")
        // sb.AppendLine(" Where TKO_KodeIGR = '" & KDIGR & "' ")
        // sb.AppendLine("   And TKO_KodeOMI = '" & KodeToko & "' ")
        // sb.AppendLine("   And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE ")

        $data['namaToko'] = DB::table('tbmaster_tokoigr')
            ->select('tko_namaomi')
            ->where([
                'tko_kodeigr' => session('KODECABANG'),
                'tko_kodeomi' => $KodeToko,
            ])
            ->whereRaw("coalesce(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE")
            ->first()->tko_namaomi;

        //! f = "ORDER DITOLAK"

        $kodeDCIDM = $this->getKodeDC($KodeToko);

        //! ISI dtOrderDitolak
        $query = "";
        $query .= "Select PLU as PLUIDM, ";
        $query .= "       PLUIGR, ";
        $query .= "       PRD_DeskripsiPanjang as DESK, ";
        $query .= "       PRD_UNIT||'/'||PRD_Frac as UNIT, ";
        $query .= "       QTYO as QTY, ";
        $query .= "       KETA as Keterangan         ";
        $query .= "  From temp_cetakpb_tolakan_idm,tbMaster_Prodmast ";
        $query .= " Where REQ_ID = '" . $ip . "' ";
        $query .= "   And KCAB = '" . $KodeToko . "' ";
        $query .= "   And NODOK = '" . $noPB . "' ";
        $query .= "   And DATE_TRUNC('DAY', TGLDOK) = to_date('" . $tglPB. "','DD-MM-YYYY') ";
        $query .= "   And PRD_PRDCD = PLUIGR ";

        if($kodeDCIDM <> ""){
            $query .= "   And KETA <> 'PLU TIDAK TERDAFTAR DI TBMASTER_PRODCRM' ";
        }else{
            $query .= "   And KETA <> 'PLU TIDAK TERDAFTAR DI TBMASTER_PRODCRM' ";
        }

        DB::select($query);

        //? rptDitolak.SetParameterValue("NamaCabang", NamaCab)
        //? rptDitolak.SetParameterValue("NamaToko", NamaToko)
        //? rptDitolak.SetParameterValue("KodeToko", KodeToko)
        //? rptDitolak.SetParameterValue("Nopb", noPB)
        //? rptDitolak.SetParameterValue("Tglpb", tglPB)

    }

    public function CetakALL_5(){

        //! VARIABLE
        $ip = $this->getIP();
        $KodeToko = "";
        $noPB = "";
        $tglPB = "";

        //! GET HEADER CETAKAN
        // sb.AppendLine("Select PRS_NamaCabang ")
        // sb.AppendLine("  From tbMaster_perusahaan ")

        $data['namaCabang'] = DB::table('tbmaster_perusahaan')
            ->select('prs_namacabang')
            ->first()->prs_namacabang;

        // sb.AppendLine("Select TKO_NamaOMI ")
        // sb.AppendLine("  From tbMaster_TokoIGR ")
        // sb.AppendLine(" Where TKO_KodeIGR = '" & KDIGR & "' ")
        // sb.AppendLine("   And TKO_KodeOMI = '" & KodeToko & "' ")
        // sb.AppendLine("   And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE ")

        $data['namaToko'] = DB::table('tbmaster_tokoigr')
            ->select('tko_namaomi')
            ->where([
                'tko_kodeigr' => session('KODECABANG'),
                'tko_kodeomi' => $KodeToko,
            ])
            ->whereRaw("coalesce(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE")
            ->first()->tko_namaomi;

        //! f = "RAK JALUR TIDAK KETEMU"

        //! INSERT INTO PBIDM_RAKJALUR_TIDAKKETEMU
        DB::insert("
            INSERT INTO PBIDM_RAKJALUR_TIDAKKETEMU
            (
                PBT_KODETOKO,
                PBT_NOPB,
                PBT_TGLPB,
                PBT_PLU,
                PBT_DESKRIPSI,
                PBT_KODERAK,
                PBT_SUBRAK,
                PBT_TIPERAK,
                PBT_SHELVINGRAK,
                PBT_QTYB,
                PBT_QTYK,
                PBT_UNITKARTON,
                PBT_FRACKARTON,
                PBT_RECORDID,
                PBT_CREATE_BY,
                PBT_CREATE_DT
            )
            Select DISTINCT '" . $KodeToko . "' as KODETOKO,
                '" . $noPB . "' as NoPB,
                TO_DATE('" . $tglPB. "','DD-MM-YYYY') as TglPB,
                NJI.PluKarton as PLU,
                NJI.DESK,
                CASE WHEN NJI.FDRCID = 'B' THEN '' ELSE COALESCE(lks_KodeRak,'') END as KodeRak,
                CASE WHEN NJI.FDRCID = 'B' THEN '' ELSE COALESCE(lks_KodeSubrak,'') END as SubRak,
                CASE WHEN NJI.FDRCID = 'B' THEN '' ELSE COALESCE(lks_TipeRak,'') END as TipeRak,
                CASE WHEN NJI.FDRCID = 'B' THEN '' ELSE COALESCE(lks_ShelvingRak,'') END as ShelvingRak,
                NJI.QTYB as OrderCTN,
                NJI.QTYK as OrderPCS,
                NJI.UnitKarton,
                NJI.FracKarton,
                COALESCE(NJI.FDRCID,'X') as RECID,
                '" . session('userid') . "',
                CURRENT_TIMESTAMP
            From TEMP_NOJALUR_IDM NJI LEFT OUTER JOIN tbMaster_Lokasi
            ON ( LKS_KodeIGR = '" . session('KODECABANG') . "'
                And LKS_PRDCD = PLUKARTON
                And LKS_KodeRak Not Like 'D%'
                And LKS_TIPERAK NOT LIKE  'S%')
            WHERE REQ_ID = '" . $ip . "'
                And FDKCAB = '" . $KodeToko . "'
                And fdnouo = '" . $noPB . "'
                And DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                And Not EXISTS
                (
                    Select grr_grouprak
                    from tbmaster_grouprak,tbmaster_lokasi lks2
                    where grr_koderak = lks2.lks_koderak
                        and grr_subrak = lks2.lks_kodesubrak
                        and LKS_KodeRak Like 'D%'
                        And LKS_TIPERAK NOT LIKE 'S%'
                        and lks_prdcd = plukarton
                )
        ");

        //! ISI dtRakJalurTidakKetemu
        DB::select("
            Select DISTINCT NJI.PluKarton as PLU,
                NJI.DESK,
                CASE WHEN NJI.FDRCID = 'B' THEN '' ELSE COALESCE(lks_KodeRak,'') END as KodeRak,
                CASE WHEN NJI.FDRCID = 'B' THEN '' ELSE COALESCE(lks_KodeSubrak,'') END as SubRak,
                CASE WHEN NJI.FDRCID = 'B' THEN '' ELSE COALESCE(lks_TipeRak,'') END as TipeRak,
                CASE WHEN NJI.FDRCID = 'B' THEN '' ELSE COALESCE(lks_ShelvingRak,'') END as ShelvingRak,
                NJI.QTYB as OrderCTN,
                NJI.QTYK as OrderPCS,
                NJI.UnitKarton||'/'||NJI.FracKarton as UNIT,
                COALESCE(NJI.FDRCID,'X') as RECID
            From TEMP_NOJALUR_IDM NJI
            LEFT OUTER JOIN tbMaster_Lokasi
                ON (LKS_KodeIGR = '" . session('KODECABANG') . "'
                And LKS_PRDCD = PLUKARTON
                And LKS_KodeRak Not Like 'D%'
                And LKS_TIPERAK NOT LIKE  'S%')
            WHERE REQ_ID = '" . $ip . "'
                And FDKCAB = '" . $KodeToko . "'
                And fdnouo = '" . $noPB . "'
                And DATE_TRUNC('DAY', fdtgpb) = to_date('" . $tglPB. "','DD-MM-YYYY')
                And Not EXISTS
                (
                    Select grr_grouprak
                    from tbmaster_grouprak,tbmaster_lokasi lks2
                    where grr_koderak = lks2.lks_koderak
                        and grr_subrak = lks2.lks_kodesubrak
                        and LKS_KodeRak Like 'D%'
                        And LKS_TIPERAK NOT LIKE 'S%'
                        and lks_prdcd = plukarton
                )
            Order By NJI.PLUKarton
        ");

        //? rptTidakKetemu.SetParameterValue("NamaCabang", NamaCab)
        //? rptTidakKetemu.SetParameterValue("NamaToko", NamaToko)
        //? rptTidakKetemu.SetParameterValue("KodeToko", KodeToko)
        //? rptTidakKetemu.SetParameterValue("NoPB", noPB)
        //? rptTidakKetemu.SetParameterValue("TglPB", tglPB)
        //? rptTidakKetemu.SetParameterValue("Batch", CounterKecil)

    }

    public function CetakALL_6(){

        //! VARIABLE
        $ip = $this->getIP();
        $KodeToko = '';
        $noPB = '';
        $tglPB = '';

        //! GET HEADER CETAKAN
        // sb.AppendLine("Select PRS_NamaCabang ")
        // sb.AppendLine("  From tbMaster_perusahaan ")

        $data['namaCabang'] = DB::table('tbmaster_perusahaan')
            ->select('prs_namacabang')
            ->first()->prs_namacabang;

        // sb.AppendLine("Select TKO_NamaOMI ")
        // sb.AppendLine("  From tbMaster_TokoIGR ")
        // sb.AppendLine(" Where TKO_KodeIGR = '" & KDIGR & "' ")
        // sb.AppendLine("   And TKO_KodeOMI = '" & KodeToko & "' ")
        // sb.AppendLine("   And COALESCE(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE ")

        $data['namaToko'] = DB::table('tbmaster_tokoigr')
            ->select('tko_namaomi')
            ->where([
                'tko_kodeigr' => session('KODECABANG'),
                'tko_kodeomi' => $KodeToko,
            ])
            ->whereRaw("coalesce(TKO_TGLTUTUP,CURRENT_DATE+1) > CURRENT_DATE")
            ->first()->tko_namaomi;

        //! f = "JALUR CETAK KERTAS"

        //! INSERT INTO PBIDM_JALURKERTAS
        $userid = session('userid');
        DB::insert(`
            INSERT INTO PBIDM_JALURKERTAS
            (
                PBK_KODETOKO,
                PBK_NOPB,
                PBK_TGLPB,
                PBK_NAMAGROUP,
                PBK_KODERAK,
                PBK_SUBRAK,
                PBK_TIPERAK,
                PBK_PLU,
                PBK_NOURUT,
                PBK_DESKRIPSI,
                PBK_TAG,
                PBK_QTY,
                PBK_UNIT,
                PBK_FRAC,
                PBK_STOK,
                PBK_CREATE_BY,
                PBK_CREATE_DT
            )
            Select DISTINCT '$KodeToko' as KODETOKO,
                '$noPB' as NoPB,
                TO_DATE('$tglPB','DD-MM-YYYY') as TglPB,
                GRR_GroupRak as NamaGroup,
                PLUKARTON as PLU,
                LKS_KodeRak as KodeRak,
                LKS_KodeSubRak as Subrak,
                LKS_TipeRak as TipeRak,
                LKS_NoUrut as NoUrut,
                DESK,
                PRD_KodeTag,
                QTYK as ""ORDER"",
                UNITKECIL,
                FRACKECIL,
                STOK,
                '$userid',
                CURRENT_TIMESTAMP
            From TEMP_JALURKERTAS_IDM, tbMaster_Prodmast
            Where REQ_ID = '$ip'
                And FDKCAB = '$KodeToko'
                And FDNOUO = '$noPB'
                And DATE_TRUNC('DAY', FDTGPB) = to_date('$tglPB','DD-MM-YYYY')
                And PRD_PRDCD = PLUKARTON
        `);

        //! ISI dtJalurCetakKertas
        DB::insert(`
            Select GRR_GroupRak as NamaGroup,
                PLUKARTON as PLU,
                LKS_KodeRak as KodeRak,
                LKS_KodeSubRak as Subrak,
                LKS_TipeRak as TipeRak,
                LKS_NoUrut as NoUrut,
                DESK,
                PRD_KodeTag,
                QTYK as ""ORDER"",
                UNITKECIL ||' /'|| FRACKECIL as UNIT,
                STOK
            From TEMP_JALURKERTAS_IDM, tbMaster_Prodmast
            Where REQ_ID = '$ip'
                And FDKCAB = '$KodeToko'
                And FDNOUO = '$noPB'
                And DATE_TRUNC('DAY', FDTGPB) = to_date($tglPB','DD-MM-YYYY')
                And PRD_PRDCD = PLUKARTON
            Order By COALESCE(GRR_GROUPRAK,'0'),LKS_KodeRak,LKS_KodeSubRak,LKS_TipeRak,LKS_NoUrut
        `);

        //? rptKertas.SetParameterValue("NamaCabang", NamaCab)
        //? rptKertas.SetParameterValue("NamaToko", NamaToko)
        //? rptKertas.SetParameterValue("KodeToko", KodeToko)
        //? rptKertas.SetParameterValue("Nopb", noPB)
        //? rptKertas.SetParameterValue("Tglpb", tglPB)
        //? rptKertas.SetParameterValue("Batch", CounterKecil)
    }


}
