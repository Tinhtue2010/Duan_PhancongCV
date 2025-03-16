<?php 

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MainExport implements WithMultipleSheets
{
    protected $danhSachCanBo;
    protected $boPhan;
    protected $baoCao;
    protected $congViec;

    public function __construct($danhSachCanBo, $boPhan, $baoCao, $congViec)
    {
        $this->danhSachCanBo = $danhSachCanBo;
        $this->boPhan = $boPhan;
        $this->baoCao = $baoCao;
        $this->congViec = $congViec;
    }

    public function sheets(): array
    {
        return [
            new DanhSachCanBoSheet($this->danhSachCanBo),
            new BoPhanSheet($this->boPhan),
            new BaoCaoSheet($this->baoCao),
            new CongViecSheet($this->congViec),
        ];
    }
}
