<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalKirimBuahController extends Controller
{

    public function __construct(Request $request)
    {
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }

    public function index(){

        $this->CreateTabelBuah();
        $this->LoadToko();

        return view("master_timbangan");
    }

    private function loadToko(){
        //! Load Toko
        // sb.AppendLine("SELECT TKO_KodeOMI, ")
        // sb.AppendLine("       TKO_NamaOMI ")
        // sb.AppendLine("  FROM tbMaster_TokoIGR ")
        // sb.AppendLine(" WHERE NOT EXISTS ")
        // sb.AppendLine(" ( ")
        // sb.AppendLine("   Select CLB_TOKO ")
        // sb.AppendLine("     From CLUSTER_BUAH ")
        // sb.AppendLine("	   Where CLB_Toko = TKO_KodeOMI ")
        // sb.AppendLine(" ) ")
        // sb.AppendLine(" ORDER BY TKO_KodeOMI ")
    }

    public function datatables(){
        //! RefreshGrid
        // sb.AppendLine("Select CLB_Kode, ")
        // sb.AppendLine("       CLB_Toko, ")
        // sb.AppendLine("       CLB_NoUrut ")
        // sb.AppendLine("  From CLUSTER_BUAH ")
        // sb.AppendLine(" ORDER BY CLB_KODE,CLB_NoUrut ")
    }

    //? KODE MOBIL -> INPUT BEBAS
    //? NO URUT -> INPUT INTEGER
    public function actionSave(){
        //! CEK CLUSTER_BUAH SUDAH TERDAFTAR
        // sb.AppendLine("Select CLB_Kode ")
        // sb.AppendLine("  From CLUSTER_BUAH ")
        // sb.AppendLine(" Where CLB_Toko = '" & cboKodeToko.Text & "' ")

        //* Toko " & cboKodeToko.Text & " Sudah Terdaftar Di Cluster " & ClusterAda

        //! INSERT INTO CLUSTER_BUAH
        // sb.AppendLine("INSERT INTO CLUSTER_BUAH ")
        // sb.AppendLine("( ")
        // sb.AppendLine("  CLB_Kode, ")
        // sb.AppendLine("  CLB_Toko, ")
        // sb.AppendLine("  CLB_NoUrut, ")
        // sb.AppendLine("  CLB_Create_By, ")
        // sb.AppendLine("  CLB_Create_Dt ")
        // sb.AppendLine(") ")
        // sb.AppendLine("VALUES ")
        // sb.AppendLine("( ")
        // sb.AppendLine("  '" & txtKodeCluster.Text & "', ")
        // sb.AppendLine("  '" & cboKodeToko.Text & "', ")
        // sb.AppendLine("  " & txtJarakKirim.Text & ", ")
        // sb.AppendLine("  '" & UserID & "', ")
        // sb.AppendLine("  CURRENT_TIMESTAMP ")
        // sb.AppendLine(") ")

        //* Toko " & cboKodeToko.Text & " Berhasil Ditambahkan!!
    }

    //? langsung dari table
    public function actionDelete(){
        //* Anda Yakin Untuk Menghapus Toko " & dgvCluster.CurrentRow.Cells(1).Value & " ??

        //! DELETE FROM CLUSTER_BUAH
        // sb.AppendLine("DELETE FROM CLUSTER_BUAH ")
        // sb.AppendLine(" WHERE CLB_Toko = '" & dgvCluster.CurrentRow.Cells(1).Value & "' ")

        //* Toko " & dgvCluster.CurrentRow.Cells(1).Value & " Berhasil Dihapus
    }
}
