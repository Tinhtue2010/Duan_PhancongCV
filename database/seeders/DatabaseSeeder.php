<?php

namespace Database\Seeders;
use App\Models\ChuHang;
use App\Models\DoanhNghiep;
use App\Models\HangHoa;
use App\Models\HangTrongCont;
use App\Models\NhapHang;
use App\Models\PhuongTienVanTai;
use App\Models\PTVTXuatCanh;
use App\Models\TheoDoiTruLui;
use App\Models\TienTrinh;
use App\Models\ToKhaiPhuongTienVT;
use App\Models\XuatHang;
use App\Models\XuatHangCont;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SecondDB\NhapHangSecond;
use App\Models\SecondDB\HangHoaSecond;
use App\Models\SecondDB\HangTrongContSecond;
use App\Models\SecondDB\XuatHangContSecond;
use App\Models\SecondDB\XuatHangSecond;
use App\Models\TaiKhoan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    }
}
