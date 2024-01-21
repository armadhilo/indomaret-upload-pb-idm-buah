<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ClusterBuahSaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClusterBuahController extends Controller
{

    public function __construct(Request $request)
    {
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }

    public function index(){

        $this->CreateTabelBuah();

        return view("master_timbangan");
    }

    public function loadToko(){
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

        $data = DB::table('tbmaster_tokoigr')
            ->select('tko_kodeomi', 'tko_namaomi')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('cluster_buah')
                    ->whereRaw('clb_toko = tko_kodeomi');
            })
            ->orderBy('tko_kodeomi')
            ->get();

        $message = 'Data toko berhasil di load';
        return ApiFormatter::success(200, $message, $data);
    }

    public function datatables(){
        //! RefreshGrid
        // sb.AppendLine("Select CLB_Kode, ")
        // sb.AppendLine("       CLB_Toko, ")
        // sb.AppendLine("       CLB_NoUrut ")
        // sb.AppendLine("  From CLUSTER_BUAH ")
        // sb.AppendLine(" ORDER BY CLB_KODE,CLB_NoUrut ")

        $data = DB::table('cluster_buah')
            ->select('clb_kode','clb_toko','clb_nourut')
            ->orderBy('clb_kode')
            ->orderBy('clb_nourut')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //? KODE MOBIL -> INPUT BEBAS
    //? NO URUT -> INPUT INTEGER
    public function actionSave(ClusterBuahSaveRequest $request){
        //! CEK CLUSTER_BUAH SUDAH TERDAFTAR
        // sb.AppendLine("Select CLB_Kode ")
        // sb.AppendLine("  From CLUSTER_BUAH ")
        // sb.AppendLine(" Where CLB_Toko = '" & cboKodeToko.Text & "' ")

        $check = DB::table('cluster_buah')
            ->select('clb_kode')
            ->where('clb_toko', $request->kode_toko)
            ->first();

        //* Toko " & cboKodeToko.Text & " Sudah Terdaftar Di Cluster " & ClusterAda
        if(!empty($check)){
            $message = "Toko $request->kode_toko Sudah Terdaftar di Cluster";
            return ApiFormatter::error(400, $message);
        }

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

        DB::table('cluster_buah')->insert([
            'clb_kode' => $request->kode_toko,
            'clb_toko' => $request->kode_cluster,
            'clb_nourut' => $request->jarak_kirim,
            'clb_create_by' => session('userid'),
            'clb_create_dt' => Carbon::now(),
        ]);

        //* Toko " & cboKodeToko.Text & " Berhasil Ditambahkan!!
        $message = "Toko $request->kode_toko Berhasil Ditambahkan!!";
        return ApiFormatter::success(200, $message);
    }

    //! CLICK KEYBOARD DEL
    //? langsung dari table
    public function actionHapus($kode_cluster){
        //* Anda Yakin Untuk Menghapus Toko " & dgvCluster.CurrentRow.Cells(1).Value & " ??

        //! DELETE FROM CLUSTER_BUAH
        // sb.AppendLine("DELETE FROM CLUSTER_BUAH ")
        // sb.AppendLine(" WHERE CLB_Toko = '" & dgvCluster.CurrentRow.Cells(1).Value & "' ")

        DB::table('cluster_buah')
            ->where([
                'clb_toko' => $kode_cluster
            ])
            ->delete();

        //* Toko " & dgvCluster.CurrentRow.Cells(1).Value & " Berhasil Dihapus
        $message = "Toko $kode_cluster Berhasil Dihapus";
        return ApiFormatter::success(200, $message);
    }
}
