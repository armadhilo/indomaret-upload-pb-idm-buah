<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    }

    //? plu buah hanya bisa di input angka

    public function actionAdd(){
        //! Cek Sudah Ada PLUIGR nya??
        //* PLUIGR " & txtPLUIGR.Text & " Sudah Terdaftar!!
        // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
        // sb.AppendLine("  FROM Master_TimbanganBuah ")
        // sb.AppendLine(" WHERE MTB_PLUIGR = '" & txtPLUIGR.Text & "' ")

        //! Cek Sudah Ada BUAH nya??
        //* PLU Buah " & txtPluBuah.Text & " Sudah Terdaftar!!
        // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
        // sb.AppendLine("  FROM Master_TimbanganBuah ")
        // sb.AppendLine(" WHERE MTB_PLUBH = '" & txtPluBuah.Text & "' ")

        //! Cek Table TBTR_UMURBARANG Sudah Ada??
        // sb.AppendLine("SELECT COALESCE(Count(0),0)  ")
        // sb.AppendLine("  FROM information_schema.columns ")
        // sb.AppendLine(" WHERE UPPER(table_name) = 'TBTR_UMURBARANG' ")

        // if jum = 0 $BelumAdaExpired = true;

        //! Cek Sudah Ada Di Stock Belum??"
        //* PLUIGR " & txtPLUIGR.Text & " Belum Terdaftar Di tbMaster_Stock!!
        // sb.AppendLine("SELECT COALESCE(Count(0),0) ")
        // sb.AppendLine("  FROM tbMaster_Stock ")
        // sb.AppendLine(" WHERE ST_PRDCD = '" & txtPLUIGR.Text & "' ")

        //! ADD MASTER_TimbanganBuah
        // sb.AppendLine("INSERT INTO MASTER_TimbanganBuah ")
        // sb.AppendLine("( ")
        // sb.AppendLine("  MTB_PLUIDM, ")
        // sb.AppendLine("  MTB_PLUIGR, ")
        // sb.AppendLine("  MTB_PLUBH, ")
        // sb.AppendLine("  MTB_Deskripsi, ")
        // sb.AppendLine("  MTB_AvgCost, ")
        // sb.AppendLine("  MTB_BestBefore, ")
        // sb.AppendLine("  MTB_ShopName, ")
        // sb.AppendLine("  MTB_WeightType, ")
        // sb.AppendLine("  MTB_KodeDepartement, ")
        // sb.AppendLine("  MTB_Create_By, ")
        // sb.AppendLine("  MTB_Create_Dt ")
        // sb.AppendLine(") ")
        // sb.AppendLine("Select PRC_PLUIDM, ")
        // sb.AppendLine("       PRC_PLUIGR, ")
        // sb.AppendLine("	      '" & txtPluBuah.Text & "', ")
        // sb.AppendLine("	      BRG_Singkatan, ")
        // sb.AppendLine("	      ST_AvgCost, ")
        // If BelumAdaExpired Then
        //     sb.AppendLine("	      1, ")
        // Else
        //     sb.AppendLine("	  ROUND(COALESCE(UBR_MAX_UMUR_BRG,0) * CASE WHEN UBR_MAX_UMUR_BRG_S = 'B' THEN 30 ELSE 1 END / CASE WHEN UBR_MAX_UMUR_BRG_S = 'J' THEN 24 ELSE 1 END,0), ")
        // End If
        // sb.AppendLine("	      '" & NamaCabang & "', ")
        // sb.AppendLine("	      CASE WHEN BRG_Kemasan = 'WHL' Then 0 Else 1 END, ")
        // sb.AppendLine("	      PRD_KodeDepartement, ")
        // sb.AppendLine("	      '" & UserID & "', ")
        // sb.AppendLine("	      CURRENT_TIMESTAMP ")
        // sb.AppendLine("  From tbMaster_Prodcrm, ")
        // sb.AppendLine("       tbMaster_ProdMast, ")
        // sb.AppendLine("       tbMaster_Stock, ")
        // sb.AppendLine("	      tbMaster_Barang ")
        // If BelumAdaExpired = False Then
        //     sb.AppendLine("	   LEFT OUTER JOIN   tbtr_UmurBarang ")
        // End If
        // sb.AppendLine("   ON (BRG_PRDCD = UBR_PRDCD) ")
        // sb.AppendLine(" Where PRC_PLUIGR = '" & txtPLUIGR.Text & "' ")
        // sb.AppendLine("   And PRC_PLUIGR = ST_PRDCD ")
        // sb.AppendLine("   And ST_Lokasi = '01' ")
        // sb.AppendLine("   And PRC_PLUIGR = PRD_PRDCD ")
        // sb.AppendLine("   And PRC_PLUIGR = BRG_PRDCD ")
        // sb.AppendLine("   And PRD_PRDCD = BRG_PRDCD ")
        // sb.AppendLine("   And PRD_PRDCD = ST_PRDCD ")
        // sb.AppendLine("   And BRG_PRDCD = ST_PRDCD ")

        //* PLU BERHASIL DITAMBAHKAN
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
    }

    //! ADA ACTION HAPUS
    public function actionHapus(){
        //* Hapus '" & NamaBarang & "' ??

        //! DELETE FROM Master_TimbanganBuah
        // sb.AppendLine("DELETE FROM Master_TimbanganBuah ")
        // sb.AppendLine(" WHERE MTB_PLUIGR = '" & dgv.CurrentRow.Cells(0).Value & "' ")

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

        //* MASTER TIMBANGAN BERHASIL DIUPDATE !!" & vbNewLine & "JANGAN LUPA KIRIM ULANG DATA KE TIMBANGAN
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

        //* Kirim Ke Folder Timbangan Selesai, Harap Tunggu 1 Menit Untuk Timbangan Mengambil Data

        //! terdapat file yang didownload check word
    }

}
