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

    public function hangTonDoanhNghiep(Request $request)
    {
        $date = $this->formatDateNow();
        $ma_doanh_nghiep = $request->get('ma_doanh_nghiep');
        $ten_doanh_nghiep = DoanhNghiep::find($ma_doanh_nghiep)->ten_doanh_nghiep;
        $fileName = 'Báo cáo hàng tồn của doanh nghiệp ' . $ten_doanh_nghiep . ' ngày ' . $date . '.xlsx';
        return Excel::download(new BaoCaoTonDoanhNghiepExport($ma_doanh_nghiep, $ten_doanh_nghiep), $fileName);
    }
}
