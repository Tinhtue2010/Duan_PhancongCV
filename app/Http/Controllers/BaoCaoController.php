<?php

namespace App\Http\Controllers;

use App\Exports\BaoCaoTonDoanhNghiepExport;
use App\Models\DoanhNghiep;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaoCaoController extends Controller
{
    public function index()
    {
        return view('bao-cao/bao-cao-hang-ton'); // Pass the data to the view
    }
}
