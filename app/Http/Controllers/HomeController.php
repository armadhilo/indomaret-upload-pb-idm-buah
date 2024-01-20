<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct(Request $request)
    {
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }

    function index(){
        return view("home");
    }

    public function actionLogin(AuthRequest $request){
        // sb.AppendLine("Select coalesce(Count(1),0) ")
        // sb.AppendLine("  From tbmaster_user ")
        // sb.AppendLine(" Where kodeigr = '" & KDIGR & "' ")
        // sb.AppendLine("   And userid = '" & Replace(txtUser.Text, "'", "") & "' ")
        // sb.AppendLine("   And userpassword = '" & Replace(txtPassword.Text, "'", "") & "'  ")


        $data = DB::table('tbmaster_user')
            ->where([
                'kodeigr' => session('KODECABANG'),
                'userid' => $request->user,
                'userpassword' => $request->password,
            ])->first();

        if(empty($data)){
            $message = 'Username atau Password Salah!!';
            return ApiFormatter::error(400, $message);
        }

        return ApiFormatter::success(200, "Login Berhasil..!");
    }
}
