@extends('layout.user-layout')

@section('title', 'Danh sách điều chuyển')

@section('content')
    <div id="layoutSidenav_content">
        <div class="container-fluid px-4">
            @if (session('alert-success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="myAlert">
                    <strong>{{ session('alert-success') }}</strong>
                </div>
            @elseif (session('alert-danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="myAlert">
                    <strong>{{ session('alert-danger') }}</strong>
                </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-header pt-3">
                    <div class="row">
                        <div class="col-9">
                            <h4 class="font-weight-bold text-primary">Danh sách điều chuyển</h4>
                        </div>
                        <div class="col-3">
                            @if (Auth::user()->quyen_han === 'CBQL2')
                                <button data-bs-toggle="modal" data-bs-target="#themModal"
                                    class="btn btn-success float-end">Thêm điều chuyển mới</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <th>
                                    STT
                                </th>
                                <th>
                                    Mã điều chuyển
                                </th>
                                <th>
                                    Tên cán bộ
                                </th>
                                <th>
                                    Thời gian điều chuyển
                                </th>
                                <th>
                                    Bộ phận chuyển đến
                                </th>
                                <th>
                                    Lý do
                                </th>
                            </thead>
                            <tbody class="clickable-row">
                                @foreach ($data as $index => $boPhan)
                                    <tr data-ma-dieu-chuyen="{{ $boPhan->ma_bo_phan }}"
                                        data-ma-can-bo="{{ $boPhan->ma_can_bo }}"
                                        data-chuc-nang-nhiem-vu="{{ $boPhan->chuc_nang_nhiem_vu }}"
                                        data-thoi-gian-thanh-lap="{{ $boPhan->thoi_gian_thanh_lap }}"
                                        data-ten-bo-phan-chuyen-den="{{ $boPhan->thoi_gian_giai_the }}"
                                        data-ly-do="{{ $boPhan->trang_thai }}"
                                        >
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $boPhan->ma_bo_phan }}</td>
                                        <td>{{ $boPhan->ten_bo_phan }}</td>
                                        <td>{{ $boPhan->chuc_nang_nhiem_vu }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Thông tin Modal -->
    <div class="modal fade" id="thongTinModal" tabindex="-1" aria-labelledby="thongTinModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thongTinModalLabel">Thông tin điều chuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dieu-chuyen.update-dieu-chuyen') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="mt-2"><strong>Mã điều chuyển:</strong> <span id="modalMaDieuChuyen"></span></p>
                                <input type="hidden" class="form-control" id="modalMaDieuChuyenInput" name="ma_bo_phan">

                                <label class="mt-1" for="ten_bo_phan"><strong>Cán bộ</strong></label>
                                <input type="text" class="form-control" id="modalTenBoPhan" name="ten_bo_phan"
                                    max="255" placeholder="Nhập tên điều chuyển" required>

                                <label class="mt-1" for="chuc_nang_nhiem_vu"><strong>Chức năng nhiệm vụ</strong></label>
                                <input type="text" class="form-control" id="modalChucNangNhiemVu"
                                    name="chuc_nang_nhiem_vu" max="255" placeholder="Nhập chức năng nhiệm vụ" required>

                                <label class="mt-1" for="thoi_gian_thanh_lap"><strong>Thời gian thành lập</strong></label>
                                <input type="text" id="modalThanhLap" class="form-control" placeholder="dd/mm/yyyy"
                                    name="thoi_gian_thanh_lap" autocomplete="off">

                                <label class="mt-1" for="thoi_gian_giai_the"><strong>Thời gian giải thể</strong></label>
                                <input type="text" id="modalGiaiThe" class="form-control" placeholder="dd/mm/yyyy"
                                    name="thoi_gian_giai_the" autocomplete="off">

                                <label class="mt-1" for="trang_thai"><strong>Trạng thái</strong></label>
                                <select class="form-control" id="trang-thai-dropdown-search" name="trang_thai">
                                    <option value=''></option>
                                    <option value='1'>Đang hoạt động</option>
                                    <option value='0'>Ngừng hoạt động</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (Auth::user()->quyen_han === 'CBQL2')
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Thêm -->
    <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm điều chuyển mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dieu-chuyen.them-dieu-chuyen') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <label class="mt-1" for="ten_bo_phan"><strong>Cán bộ</strong></label>
                        <select class="form-control" id="can-bo-dropdown-search" name="ma_can_bo">
                            <option value=''></option>
                            @foreach ($canBos as $canBo)
                                <option value="{{ $canBo->ma_can_bo }}">
                                    {{ $canBo->ten_can_bo }}
                                </option>
                            @endforeach
                        </select>

                        <label class="mt-1" for="thoi_gian_dieu_chuyen"><strong>Thời gian điều chuyển</strong></label>
                        <input type="text" class="form-control" name="thoi_gian_dieu_chuyen"
                            max="50" placeholder="Nhập thời gian điều chuyển" required>

                        <label class="mt-1" for="ma_bo_phan_chuyen_den"><strong>Bộ phận chuyển đến</strong></label>
                        <select class="form-control" id="bo-phan-dropdown-search" name="ma_bo_phan_chuyen_den">
                            <option value=''></option>
                            @foreach ($boPhans as $boPhan)
                                <option value="{{ $boPhan->ma_bo_phan }}">
                                    {{ $boPhan->ten_bo_phan }}
                                </option>
                            @endforeach
                        </select>

                        <label class="mt-1" for="chuc_danh_moi"><strong>Chức danh mới</strong></label>
                        <input type="text" class="form-control" name="chuc_danh_moi"
                            max="50" placeholder="Nhập chức danh mới" required>

                        <label class="mt-1" for="ly_do"><strong>Lý do</strong></label>
                        <select class="form-control" id="ly-do-dropdown-search" name="ly_do">
                            <option value='Điều chuyển bộ phận' selected>Điều chuyển bộ phận</option>
                            <option value='Nghỉ hưu'>Nghỉ hưu</option>
                            <option value='Chuyển công tác sang cơ quan khác'>Chuyển công tác sang cơ quan khác</option>
                            <option value='Đình chỉ'>Đình chỉ</option>
                            <option value='Khác'>Khác</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Thêm mới</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Xóa Modal -->
    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Xác nhận xóa điều chuyển</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dieu-chuyen.xoa-dieu-chuyen') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <h6 class="text-danger">Xác nhận xóa điều chuyển này?</h6>
                        <div>
                            <label><strong>Mã điều chuyển:</strong></label>
                            <p class="d-inline" id="modalMaDieuChuyenXoa"></p>
                        </div>
                        <div>
                            <label><strong>Tên điều chuyển:</strong></label>
                            <p class="d-inline" id="modalTenBoPhanXoa"></p>
                        </div>
                        <input type="hidden" name="ma_bo_phan" id="modalInputMaDieuChuyenXoa">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            
        });

    </script>
    {{-- Script áp dụng cho 3 cột đầu --}}
    <script>
        $(document).ready(function() {
            $('#dataTable tbody').on('click', 'tr', function(event) {
                if ($(event.target).closest('td:last-child').length) {
                    return;
                }
                var maDieuChuyen = $(this).data('ma-dieu-chuyen');
                var tenDieuChuyen = $(this).data('ten-dieu-chuyen');
                var chucNangNhiemVu = $(this).data('chuc-nang-nhiem-vu');
                var thoiGianGiaiThe = $(this).data('thoi-gian-giai-the');
                var thoiGianThanhLap = $(this).data('thoi-gian-thanh-lap');
                var trangThai = $(this).data('trang-thai');

                document.getElementById('modalMaDieuChuyen').value = maDieuChuyen;
                document.getElementById('modalTenBoPhan').value = tenDieuChuyen;
                document.getElementById('modalChucNangNhiemVu').value = chucNangNhiemVu;

                var thoiGianThanhLapFormatted = thoiGianThanhLap.split('-').reverse().join('/');
                document.getElementById('modalThanhLap').value = thoiGianThanhLapFormatted;
                var thoiGianThanhLapFormatted = thoiGianThanhLap.split('-').reverse().join('/');
                document.getElementById('modalGiaiThe').value = thoiGianThanhLapFormatted;

                // document.getElementById('modalTrangThai').value = trangThai;

                const modalMaDieuChuyen = document.getElementById('modalMaDieuChuyen');
                modalMaDieuChuyen.textContent = maDieuChuyen;

                const selectTrangThai = document.getElementById('trang-thai-dropdown-search');
                if (trangThai == 0) {
                    selectTrangThai.value = "0";
                } else {
                    selectTrangThai.value = "1";
                }


                const modalInputMaDieuChuyen = document.getElementById('modalMaDieuChuyenInput');
                modalInputMaDieuChuyen.value = maDieuChuyen;


                $('#thongTinModal').modal('show');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]');
            const modalMaDieuChuyen = document.getElementById('modalMaDieuChuyenXoa');
            const modalInputMaDieuChuyen = document.getElementById('modalInputMaDieuChuyenXoa');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get data from the clicked button
                    const maDieuChuyen = this.getAttribute('data-ma-dieu-chuyen');
                    const tenDieuChuyen = this.getAttribute('data-ten-dieu-chuyen');

                    modalMaDieuChuyen.textContent = maDieuChuyen;
                    modalInputMaDieuChuyen.value = maDieuChuyen;
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    searchPlaceholder: "Tìm kiếm",
                    search: "",
                    "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    "sInfoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                    "sInfoFiltered": "Lọc từ _MAX_ mục",
                    "sLengthMenu": "Hiện _MENU_ mục",
                    "sEmptyTable": "Không có dữ liệu",
                },
                stateSave: true,
                dom: '<"clear"><"row"<"col"l><"col"f>>rt<"row"<"col"i><"col"p>><"row"<"col"B>>',
                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)',
                        },
                        title: ''
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)',
                        },
                        title: ''
                    }
                ]
            });

            $('.dataTables_filter input[type="search"]').css({
                width: '350px',
                display: 'inline-block',
                height: '40px',
            });
        });
    </script>
@stop
