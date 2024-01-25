<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\DaftarPluHadiahInsertRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DaftarPluHadiahController extends Controller
{

    public function __construct(Request $request)
    {
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }

    function index(){
        $this->createTableHadiahPerishable();
        return view("menu.plu-hadiah");
    }

    public function datatablesProdMaster(){
        // sb.AppendLine("Select DISTINCT PRD_PRDCD as PRDCD, ")
        // sb.AppendLine("  PRD_DESKRIPSIPANJANG as DESK ")
        // sb.AppendLine("FROM tbMaster_Prodmast ")
        // sb.AppendLine("WHERE PRD_PRDCD LIKE '%0' ")
        // sb.AppendLine("  AND prd_kodedivisi = '4' ")
        // sb.AppendLine("Order By PRD_PRDCD ")

        $data = DB::table('tbmaster_prodmast')
            ->select(
                'prd_prdcd as prdcd',
                'prd_deskripsipanjang as desk'
            )
            ->where('prd_prdcd','like', '%0')
            ->where('prd_kodedivisi','4')
            ->orderBy('prd_prdcd')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

    }

    public function datatablesHadiahPerishable(){
        // sb.AppendLine("SELECT PHP_PRDCD as PRDCD, ")
        // sb.AppendLine("       PHP_DeskripsiPanjang as DESK ")
        // sb.AppendLine("  FROM PLU_HADIAH_PERISHABLE ")
        // sb.AppendLine(" ORDER By PHP_PRDCD ")

        $data = DB::table('plu_hadiah_perishable')
            ->select(
                'php_prdcd as prdcd',
                'php_deskripsipanjang as desk'
            )
            ->orderBy('php_prdcd')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

    }

    //! action ini akan melakukan insert data dari table prodmaster ke hadiah perishable
    public function actionInsertHadiahPerishable(DaftarPluHadiahInsertRequest $request){
        //! CEK SUDAH ADA BELUM DI PLU_HADIAH_PERISHABLE
        // sb.AppendLine("SELECT COALESCE(COUNT(0),0) ")
        // sb.AppendLine("  FROM PLU_HADIAH_PERISHABLE ")
        // sb.AppendLine(" WHERE PHP_PRDCD = '" & dgvAsal.CurrentRow.Cells(0).Value & "' ")

        $check = DB::table('plu_hadiah_perishable')
            ->where('php_prdcd', $request->prdcd)
            ->count();

        if($check > 0){
            return ApiFormatter::error(400, 'PLU SUDAH TERDAFTAR!!');
        }

        //* PLU SUDAH TERDAFTAR!!

        //! INSERT INTO PLU_HADIAH_PERISHABLE
        // sb.AppendLine("INSERT INTO PLU_HADIAH_PERISHABLE ")
        // sb.AppendLine("(   ")
        // sb.AppendLine("  PHP_PRDCD, ")
        // sb.AppendLine("  PHP_DeskripsiPanjang, ")
        // sb.AppendLine("  PHP_CREATE_BY, ")
        // sb.AppendLine("  PHP_CREATE_DT ")
        // sb.AppendLine(") ")
        // sb.AppendLine("VALUES ")
        // sb.AppendLine("( ")
        // sb.AppendLine("  '" & dgvAsal.CurrentRow.Cells(0).Value & "', ")
        // sb.AppendLine("  '" & Replace(dgvAsal.CurrentRow.Cells(1).Value, "'", "''") & "', ")
        // sb.AppendLine("  '" & UserID & "', ")
        // sb.AppendLine("  CURRENT_TIMESTAMP ")
        // sb.AppendLine(") ")

        DB::table('plu_hadiah_perishable')
            ->insert([
                'php_prdcd' => $request->prdcd,
                'php_deskripsipanjang' => $request->desk,
                'php_create_by' => session('userid'),
                'php_create_dt' => Carbon::now(),
            ]);

        //* ("PLU " & dgvAsal.CurrentRow.Cells(0).Value & " BERHASIL DITAMBAHKAN!!
        $message = "PLU $request->prdcd BERHASIL DITAMBAHKAN";
        return ApiFormatter::success(200, $message);
    }

    //! action button delete
    public function actionHapusHadiahPerishable($prdcd){
        //* Anda Yakin Ingin Menghapus PLU " & dgvHasil.Rows(dgvHasil.CurrentRow.Index).Cells(0).Value.ToString

        //! DELETE FROM PLU_HADIAH_PERISHABLE
        // sb.AppendLine("DELETE FROM PLU_HADIAH_PERISHABLE ")
        // sb.AppendLine("WHERE PHP_PRDCD = '" &

        DB::table('plu_hadiah_perishable')
            ->where('php_prdcd', $prdcd)
            ->delete();

        //* PLU " & dgvHasil.Rows(dgvHasil.CurrentRow.Index).Cells(0).Value.ToString.Trim & " BERHASIL DIHAPUS!!
        $message = "PLU $prdcd berhasil dihapus";
        return ApiFormatter::success(200, $message);
    }

    private function createTableHadiahPerishable(){
        // sb.AppendLine("SELECT COALESCE(Count(0),0)  ")
        // sb.AppendLine("  from information_schema.tables ")
        // sb.AppendLine(" WHERE upper(table_name) = 'PLU_HADIAH_PERISHABLE'")

        $check = DB::table('information_schema.tables')
            ->whereRaw("upper(table_name) = 'PLU_HADIAH_PERISHABLE'")
            ->count();

        if($check == 0){
            //! CREATE TABLE PLU_HADIAH_PERISHABLE
            // sb.AppendLine("CREATE TABLE PLU_HADIAH_PERISHABLE ")
            // sb.AppendLine("( ")
            // sb.AppendLine("  PHP_PRDCD VARCHAR(15), ")
            // sb.AppendLine("  PHP_DeskripsiPanjang VARCHAR(250), ")
            // sb.AppendLine("  PHP_CREATE_BY VARCHAR(5), ")
            // sb.AppendLine("  PHP_CREATE_DT DATE   ")

            DB::statement("
                CREATE TABLE PLU_HADIAH_PERISHABLE (
                PHP_PRDCD VARCHAR(15),
                PHP_DeskripsiPanjang VARCHAR(250),
                PHP_CREATE_BY VARCHAR(5),
                PHP_CREATE_DT DATE
                )
            ");
        }
    }
}
