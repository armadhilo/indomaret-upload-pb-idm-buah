<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadPbPspController extends Controller
{

    public function __construct(Request $request)
    {
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }

    function index(){
        return view("home");
    }
}
