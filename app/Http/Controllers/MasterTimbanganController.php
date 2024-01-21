<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\MasterTimbanganAddRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MasterTimbanganController extends Controller
{

    public function __construct(Request $request)
    {
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }

    function index(){

        $this->CreateTabelTimbangan();

        return view("master_timbangan");
    }

    //! BAGIAN A
    //? nanti onclick dapet deskripsinya
    public function detail($pluigr){
        //! GET DESKRIPSI
        // sb.AppendLine("SELECT PRD_DESKRIPSIPENDEK as DESK ")
        // sb.AppendLine("  FROM tbMaster_Prodmast,tbMaster_Prodcrm ")
        // sb.AppendLine(" WHERE PRD_KodeDepartement IN ('31','32','33','34','35','36','37','38','41','44','50','51','52','53') ")
        // sb.AppendLine("   AND PRD_PRDCD LIKE '%0' ")
        // sb.AppendLine("   AND PRC_PLUIGR = PRD_PRDCD ")
        // sb.AppendLine("   AND PRC_PLUIGR = '" & txtPLUIGR.Text & "' ")
        // sb.AppendLine(" ORDER BY prd_deskripsipendek ")

        $data = DB::table('tbmaster_prodmast')
            ->select('prd_deskripsipendek as desc')
            ->join('tbmaster_prodcrm',function($join){
                $join->on('prc_pluigr','=','prd_prdcd');
            })
            ->whereIn('prd_kodedepartement', ['31','32','33','34','35','36','37','38','41','44','50','51','52','53'])
            ->where('prc_pluigr', $pluigr)
            ->where('prd_prdcd', 'like', '%0')
            ->orderBy('prd_deskripsipendek')
            ->first();

        $message = 'Detail data berhasil ditampilkan';
        return ApiFormatter::success(200, $message, $data);
    }

    //! NANTI KLIK F1 KELUARIN MODAL HELP TIMBANGAN BUAH
    //? nanti di doble click otomatis nempel ke pluigr dan desc
    public function datatablesHelpTimbangan(){
        //! GET HELP TIMBANGAN
        // sb.AppendLine("SELECT PRD_PRDCD as PLUIGR,PRD_DESKRIPSIPENDEK as DESK ")
        // sb.AppendLine("  FROM tbMaster_Prodmast,tbMaster_Prodcrm ")
        // sb.AppendLine(" WHERE PRD_KodeDepartement IN ('31','32','33','34','35','36','37','38','41','44','50','51','52','53') ")
        // sb.AppendLine("   AND PRD_PRDCD LIKE '%0' ")
        // sb.AppendLine("   AND PRC_PLUIGR = PRD_PRDCD ")
        // sb.AppendLine(" ORDER BY prd_deskripsipendek ")

        $data = DB::table('tbmaster_prodmast')
            ->select('prd_deskripsipendek as desc')
            ->join('tbmaster_prodcrm',function($join){
                $join->on('prc_pluigr','=','prd_prdcd');
            })
            ->whereIn('prd_kodedepartement', ['31','32','33','34','35','36','37','38','41','44','50','51','52','53'])
            ->where('prd_prdcd', 'like', '%0')
            ->orderBy('prd_deskripsipendek')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //? plu buah hanya bisa di input angka

    public function actionAdd(MasterTimbanganAddRequest $request){
        //! Cek Sudah Ada PLUIGR nya??
        //* PLUIGR " & txtPLUIGR.Text & " Sudah Terdaftar!!
        // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
        // sb.AppendLine("  FROM Master_TimbanganBuah ")
        // sb.AppendLine(" WHERE MTB_PLUIGR = '" & txtPLUIGR.Text & "' ")

        $check = DB::table('master_timbanganbuah')
            ->where('mtb_pluigr', $request->pluigr)
            ->count();

        if($check > 0){
            $message = "PLUIGR $request->pluigr Sudah Terdaftar !!";
            return ApiFormatter::error(400, $message);
        }

        //! Cek Sudah Ada BUAH nya??
        //* PLU Buah " & txtPluBuah.Text & " Sudah Terdaftar!!
        // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
        // sb.AppendLine("  FROM Master_TimbanganBuah ")
        // sb.AppendLine(" WHERE MTB_PLUBH = '" & txtPluBuah.Text & "' ")

        $check = DB::table('master_timbanganbuah')
            ->where('mtb_plubh', $request->plubuah)
            ->count();

        if($check > 0){
            $message = "PLU Buah $request->plubuah Sudah Terdaftar !!";
            return ApiFormatter::error(400, $message);
        }

        //! Cek Table TBTR_UMURBARANG Sudah Ada??
        // sb.AppendLine("SELECT COALESCE(Count(0),0)  ")
        // sb.AppendLine("  FROM information_schema.columns ")
        // sb.AppendLine(" WHERE UPPER(table_name) = 'TBTR_UMURBARANG' ")

        $check = DB::table('information_schema.columns')
            ->whereRaw("UPPER(table_name) = 'TBTR_UMURBARANG'")
            ->count();

        // if jum = 0 $BelumAdaExpired = true;
        $BelumAdaExpired = false;
        if($check == 0) $BelumAdaExpired = true;

        //! Cek Sudah Ada Di Stock Belum??"
        //* PLUIGR " & txtPLUIGR.Text & " Belum Terdaftar Di tbMaster_Stock!!
        // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
        // sb.AppendLine("  FROM tbMaster_Stock ")
        // sb.AppendLine(" WHERE ST_PRDCD = '" & txtPLUIGR.Text & "' ")

        $check = DB::table('tbmaster_stock')
            ->where('st_prdcd', $request->pluigr)
            ->count();

        if($check > 0){
            $message = "PLUIGR $request->pluigr Belum Terdaftar Di tbMaster_Stock!!";
            return ApiFormatter::error(400, $message);
        }

        //! ADD MASTER_TimbanganBuah
        $query = '';
        $query .= "INSERT INTO MASTER_TimbanganBuah ";
        $query .= "( ";
        $query .= "  MTB_PLUIDM, ";
        $query .= "  MTB_PLUIGR, ";
        $query .= "  MTB_PLUBH, ";
        $query .= "  MTB_Deskripsi, ";
        $query .= "  MTB_AvgCost, ";
        $query .= "  MTB_BestBefore, ";
        $query .= "  MTB_ShopName, ";
        $query .= "  MTB_WeightType, ";
        $query .= "  MTB_KodeDepartement, ";
        $query .= "  MTB_Create_By, ";
        $query .= "  MTB_Create_Dt ";
        $query .= ") ";
        $query .= "Select PRC_PLUIDM, ";
        $query .= "       PRC_PLUIGR, ";
        $query .= "	      '" . $request->plubuah . "', ";
        $query .= "	      BRG_Singkatan, ";
        $query .= "	      ST_AvgCost, ";
        if($BelumAdaExpired){
            $query .= "	      1, ";
        }else{
            $query .= "	  ROUND(COALESCE(UBR_MAX_UMUR_BRG,0) * CASE WHEN UBR_MAX_UMUR_BRG_S = 'B' THEN 30 ELSE 1 END / CASE WHEN UBR_MAX_UMUR_BRG_S = 'J' THEN 24 ELSE 1 END,0), ";
        }
        $query .= "	      '" . $request->nama_cabang . "', ";
        $query .= "	      CASE WHEN BRG_Kemasan = 'WHL' Then 0 Else 1 END, ";
        $query .= "	      PRD_KodeDepartement, ";
        $query .= "	      '" . session('userid') . "', ";
        $query .= "	      CURRENT_TIMESTAMP ";
        $query .= "  From tbMaster_Prodcrm, ";
        $query .= "       tbMaster_ProdMast, ";
        $query .= "       tbMaster_Stock, ";
        $query .= "	      tbMaster_Barang ";
        if($BelumAdaExpired == False){
            $query .= "	   LEFT OUTER JOIN   tbtr_UmurBarang ";
        }
        $query .= "   ON (BRG_PRDCD = UBR_PRDCD) ";
        $query .= " Where PRC_PLUIGR = '" . $request->pluigr . "' ";
        $query .= "   And PRC_PLUIGR = ST_PRDCD ";
        $query .= "   And ST_Lokasi = '01' ";
        $query .= "   And PRC_PLUIGR = PRD_PRDCD ";
        $query .= "   And PRC_PLUIGR = BRG_PRDCD ";
        $query .= "   And PRD_PRDCD = BRG_PRDCD ";
        $query .= "   And PRD_PRDCD = ST_PRDCD ";
        $query .= "   And BRG_PRDCD = ST_PRDCD ";

        DB::insert($query);

        //* PLU BERHASIL DITAMBAHKAN
        $message = 'PLU BERHASIL DITAMBAHKAN';
        return ApiFormatter::success(200, $message);
    }

    //! BAGIAN D
    public function datatables(){
        //! ISI TABLE D
        // sb.AppendLine("SELECT MTB_PLUIGR AS PLUIGR, ")
        // sb.AppendLine("       MTB_PLUBH AS PLU_BH, ")
        // sb.AppendLine("       MTB_Deskripsi AS DESK, ")
        // sb.AppendLine("       ST_AVGCOST AS ACOST, ")
        // sb.AppendLine("       MTB_BestBefore AS EXP_DATE ")
        // sb.AppendLine("  FROM Master_TimbanganBuah, ")
        // sb.AppendLine("       tbMaster_Stock ")
        // sb.AppendLine(" WHERE ST_PRDCD = MTB_PLUIGR ")
        // sb.AppendLine("   AND ST_LOKASI = '01' ")
        // sb.AppendLine(" ORDER BY MTB_PLUBH ")

        $data = DB::table('master_timbanganbuah')
            ->select(
                'mtb_pluigr AS pluigr',
                'mtb_plubh AS plu_bh',
                'mtb_deskripsi AS desk',
                'st_avgcost AS acost',
            )
            ->join('tbmaster_stock',function($join){
                $join->on('st_prdcd','=','mtb_pluigr');
                $join->where('st_lokasi', '01');
            })
            ->orderBy('mtb_plubh')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //! ADA ACTION HAPUS
    public function actionHapus($pluigr, $nama_barang){
        //* Hapus '" & NamaBarang & "' ??

        //! DELETE FROM Master_TimbanganBuah
        // sb.AppendLine("DELETE FROM Master_TimbanganBuah ")
        // sb.AppendLine(" WHERE MTB_PLUIGR = '" & dgv.CurrentRow.Cells(0).Value & "' ")

        DB::table('master_timbanganbuah')
            ->where('mtb_pluigr', $pluigr)
            ->delete();

        $message = "$nama_barang Berhasil Dihapus !!";
        return ApiFormatter::success(200, $message);

        //* NamaBarang & " Berhasil Dihapus !!"
    }

    //! BAGIAN E
    public function actionUpdateAllData(){
        //! UPDATE MASTER_TimbanganBuah
        // sb.AppendLine("MERGE INTO Master_TimbanganBuah a ")
        // sb.AppendLine("USING ")
        // sb.AppendLine("( ")
        // sb.AppendLine("     SELECT UBR_PRDCD, ")
        // sb.AppendLine("            BRG_Singkatan AS DESK,  ")
        // sb.AppendLine("	          ST_AvgCost AS ACOST,  ")
        // sb.AppendLine("	          ROUND(COALESCE(UBR_MAX_UMUR_BRG,0) * CASE WHEN UBR_MAX_UMUR_BRG_S = 'B' THEN 30 ELSE 1 END / CASE WHEN UBR_MAX_UMUR_BRG_S = 'J' THEN 24 ELSE 1 END,0) AS BestBefore, 	        ")
        // sb.AppendLine("	          CASE WHEN BRG_Kemasan = 'WHL' Then 0 Else 1 END AS TIPEBERAT,  ")
        // sb.AppendLine("	          PRD_KodeDepartement AS DEPT   ")
        // sb.AppendLine("       FROM tbMaster_ProdMast, ")
        // sb.AppendLine("            tbMaster_Stock,  ")
        // sb.AppendLine("            tbMaster_Barang  ")
        // sb.AppendLine("	    LEFT OUTER JOIN      tbtr_UmurBarang  ")
        // sb.AppendLine("        ON (BRG_PRDCD = UBR_PRDCD) ")
        // sb.AppendLine("      WHERE PRD_PRDCD = BRG_PRDCD ")
        // sb.AppendLine("        AND PRD_PRDCD LIKE '%0' ")
        // sb.AppendLine("        AND ST_LOKASI = '01'  ")
        // sb.AppendLine("        And PRD_PRDCD = ST_PRDCD  ")
        // sb.AppendLine("        And BRG_PRDCD = ST_PRDCD  ")
        // sb.AppendLine(") b ")
        // sb.AppendLine("ON ")
        // sb.AppendLine("( ")
        // sb.AppendLine("  a.MTB_PLUIGR = b.UBR_PRDCD ")
        // sb.AppendLine(") ")
        // sb.AppendLine("WHEN MATCHED THEN ")
        // sb.AppendLine("  UPDATE SET MTB_BestBefore = b.BestBefore, ")
        // sb.AppendLine("             MTB_DESKRIPSI = b.DESK, ")
        // sb.AppendLine("             MTB_AVGCOST = b.ACOST, ")
        // sb.AppendLine("             MTB_WEIGHTTYPE = b.TIPEBERAT, ")
        // sb.AppendLine("             MTB_KodeDepartement = b.DEPT ")

        DB::select("
            MERGE INTO Master_TimbanganBuah a
            USING
            (
                SELECT UBR_PRDCD,
                        BRG_Singkatan AS DESK,
                        ST_AvgCost AS ACOST,
                        ROUND(COALESCE(UBR_MAX_UMUR_BRG,0) * CASE WHEN UBR_MAX_UMUR_BRG_S = 'B' THEN 30 ELSE 1 END / CASE WHEN UBR_MAX_UMUR_BRG_S = 'J' THEN 24 ELSE 1 END,0) AS BestBefore,
                        CASE WHEN BRG_Kemasan = 'WHL' Then 0 Else 1 END AS TIPEBERAT,
                        PRD_KodeDepartement AS DEPT
                FROM tbMaster_ProdMast,
                        tbMaster_Stock,
                        tbMaster_Barang
                    LEFT OUTER JOIN      tbtr_UmurBarang
                    ON (BRG_PRDCD = UBR_PRDCD)
                WHERE PRD_PRDCD = BRG_PRDCD
                    AND PRD_PRDCD LIKE '%0'
                    AND ST_LOKASI = '01'
                    And PRD_PRDCD = ST_PRDCD
                    And BRG_PRDCD = ST_PRDCD
            ) b
            ON (
                a.MTB_PLUIGR = b.UBR_PRDCD
            )
            WHEN MATCHED THEN
            UPDATE SET MTB_BestBefore = b.BestBefore,
                MTB_DESKRIPSI = b.DESK,
                MTB_AVGCOST = b.ACOST,
                MTB_WEIGHTTYPE = b.TIPEBERAT,
                MTB_KodeDepartement = b.DEPT
        ");

        //* MASTER TIMBANGAN BERHASIL DIUPDATE !!" & vbNewLine & "JANGAN LUPA KIRIM ULANG DATA KE TIMBANGAN
        $message = "MASTER TIMBANGAN BERHASIL DIUPDATE !!, JANGAN LUPA KIRIM ULANG DATA KE TIMBANGAN";
        return ApiFormatter::success(200, $message);
    }

    //! BAGIAN F
    public function actionKirim(){
        //! GET DATA INDOMARCO.CSV
        //? FLAG1,FLAG2,PLU,ITEM CODE,COMM_NAME,UNIT PRICE,USED_DATE,S.MSG,WEIGHT_TYPE
        // sb.AppendLine("SELECT SubStr(MTB_PLUIDM,1,1) AS FLAG1, ")
        // sb.AppendLine("       SubStr(MTB_PLUIDM,2,1) AS FLAG2, ")
        // sb.AppendLine("       MTB_PLUBH AS PLU, ")
        // sb.AppendLine("       SubStr(MTB_PLUIDM,3,6) AS ITEM_CODE, ")
        // sb.AppendLine("       SubStr(MTB_DESKRIPSI,1,20) AS COMM_NAME, ")
        // sb.AppendLine("       MTB_AvgCost AS UNIT_PRICE, ")
        // sb.AppendLine("       MTB_BestBefore AS USED_DATE, ")
        // sb.AppendLine("       MTB_ShopName AS Special_Message, ")
        // sb.AppendLine("       MTB_WeightType AS WeightType ")
        // sb.AppendLine("  FROM Master_TimbanganBuah ")
        // sb.AppendLine(" WHERE MTB_RecordID IS NULL ")

        $data = DB::table('master_timbanganbuah')
            ->selectRaw("
                SubStr(MTB_PLUIDM,1,1) AS FLAG1,
                SubStr(MTB_PLUIDM,2,1) AS FLAG2,
                MTB_PLUBH AS PLU,
                SubStr(MTB_PLUIDM,3,6) AS ITEM_CODE,
                SubStr(MTB_DESKRIPSI,1,20) AS COMM_NAME,
                MTB_AvgCost AS UNIT_PRICE,
                MTB_BestBefore AS USED_DATE,
                MTB_ShopName AS Special_Message,
                MTB_WeightType AS WeightType
            ")
            ->whereNull('mtb_recordid')
            ->get();

        //* Kirim Ke Folder Timbangan Selesai, Harap Tunggu 1 Menit Untuk Timbangan Mengambil Data

        //! terdapat file yang didownload check word
    }

}
