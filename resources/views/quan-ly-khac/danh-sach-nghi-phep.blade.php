@extends('layout.user-layout')

@section('title', 'Quản lý nghỉ phép')

@section('content')
    <style>
        input[type="checkbox"] {
            transform: scale(1.5);
            /* Adjust size */
            margin-right: 10px;
        }
    </style>
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
                            <h4 class="font-weight-bold text-primary">Quản lý nghỉ phép</h4>
                        </div>
                        <div class="col-3">
                            <button data-bs-toggle="modal" data-bs-target="#themModal"
                                class="btn btn-success float-end">Thêm mới</button>
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
                                    Mã cán bộ
                                </th>
                                <th>
                                    Tên cán bộ
                                </th>
                                <th>
                                    Bộ phận
                                </th>
                                <th>
                                    Ngày làm việc
                                </th>
                                <th>
                                    Từ giờ
                                </th>
                                <th>
                                    đến giờ
                                </th>
                                <th>
                                    Ngày bắt đầu
                                </th>
                                <th>
                                    Ngày kết thúc
                                </th>
                                <th>
                                    Lý do vắng
                                </th>
                                <th>
                                    Thao tác
                                </th>
                            </thead>
                            <tbody class="clickable-row">
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->ma_can_bo }}</td>
                                        <td>{{ $item->ten_can_bo }}</td>
                                        <td>{{ $item->boPhan->ten_bo_phan }}</td>
                                        <td>{{ $item->ten_dang_nhap }}</td>
                                        <td>{{ $item->quyen_han }}</td>
                                        <td>


                                        </td>
                                        <td>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#xoaModal">
                                                Xóa
                                            </button>
                                        </td>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thongTinModalLabel">Thông tin cán bộ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('quan-ly-khac.update-can-bo') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="mt-2"><strong>Mã cán bộ:</strong> <span id="modalMaCongChuc"></span></p>
                                <input type="hidden" class="form-control" id="modalMaCongChucInput" name="ma_can_bo">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mt-1" for="ten_can_bo"><strong>Tên cán bộ</strong></label>
                                        <input type="text" class="form-control" id="modalTenCongChuc" name="ten_can_bo"
                                            max="255" placeholder="Nhập tên cán bộ" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-1" for="chuc_danh"><strong>Chức danh</strong></label>
                                        <input type="text" class="form-control" id="modalChucDanh" name="chuc_danh"
                                            max="255" placeholder="Nhập chức danh" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mt-1" for="nhom_vi_tri_lam_viec">
                                            <strong>Nhóm vị trí làm việc</strong>
                                        </label>
                                        <input type="text" class="form-control" id="modalNhomViTriLamViec"
                                            name="nhom_vi_tri_lam_viec" max="255" placeholder="Nhập vị trí làm việc"
                                            value=""
                                            required>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-1" for="bo_phan"><strong>Bộ phận</strong></label>
                                        <select class="form-control" id="bo-phan-dropdown-search" name="ma_bo_phan">
                                            <option value=''></option>
                                            @foreach ($boPhans as $boPhan)

                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <label class="mt-1" for="trang_thai"><strong>Trạng thái</strong></label>
                                <select class="form-control" id="trang-thai-dropdown-search" name="trang_thai">
                                    <option value=''></option>
                                    <option value='1' selected>Đang công tác</option>
                                    <option value='0'>Nghỉ công tác</option>
                                </select>

                                <hr />
                                <p class="mt-2"><strong>Tên đăng nhập:</strong> <span id="modalTenDangNhap"></span></p>
                                <h5>Chọn tài khoản khác cho cán bộ này</h5>
                                <p><strong>Tên đăng nhập: </strong></p>
                                <select class="form-control" id="tai-khoan-dropdown-search" name="ma_tai_khoan">
                                    <option value=''></option>
                                    @foreach ($taiKhoans as $taiKhoan)
                                        <option value="{{ $taiKhoan->ma_tai_khoan }}">
                                            {{ $taiKhoan->ten_dang_nhap }}
                                        </option>
                                    @endforeach
                                </select>
                                <label class="mt-1" for="trang_thai"><strong>Quyền tài khoản</strong></label>
                                <select class="form-control" id="quyen-han-dropdown-search" name="quyen_han">
                                    <option value='Cán bộ'>Cán bộ</option>
                                    <option value='CBQL1' selected>Cán bộ quản lý 1</option>
                                    <option value='CBQL2'>Cán bộ quản lý 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Thêm -->
    <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm cán bộ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('quan-ly-khac.them-can-bo') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mt-1" for="ten_can_bo"><strong>Tên cán bộ</strong></label>
                                        <input type="text" class="form-control" id="modalTenCongChuc"
                                            name="ten_can_bo" max="255" placeholder="Nhập tên cán bộ" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-1" for="chuc_danh"><strong>Chức danh</strong></label>
                                        <input type="text" class="form-control" id="modalChucDanh" name="chuc_danh"
                                            max="255" placeholder="Nhập chức danh" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mt-1" for="nhom_vi_tri_lam_viec">
                                            <strong>Nhóm vị trí làm việc</strong>
                                        </label>
                                        <input type="text" class="form-control" id="modalNhomViTriLamViec"
                                            name="nhom_vi_tri_lam_viec" max="255" placeholder="Nhập vị trí làm việc"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-1" for="bo_phan"><strong>Bộ phận</strong></label>
                                        <select class="form-control" id="bo-phan-dropdown-search" name="ma_bo_phan">
                                            <option value=''></option>
                                            @foreach ($boPhans as $boPhan)
                                                <option value="{{ $boPhan->ma_bo_phan }}">
                                                    {{ $boPhan->ten_bo_phan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <label class="mt-1" for="trang_thai"><strong>Trạng thái</strong></label>
                                <select class="form-control" id="trang-thai-dropdown-search" name="trang_thai">
                                    <option value=''></option>
                                    <option value='1' selected>Đang công tác</option>
                                    <option value='0'>Nghỉ công tác</option>
                                </select>

                                <hr />
                                <label class="mt-1" for="ten_dang_nhap"><strong>Tên đăng nhập</strong></label>
                                <input type="text" class="form-control" id="ten_dang_nhap" name="ten_dang_nhap"
                                    placeholder="Nhập tên đăng nhập"autocomplete="new-password" required>
                                <label class="mt-1" for="mat_khau"><strong>Mật khẩu</strong></label>
                                <input type="password" class="form-control" id="mat_khau" name="mat_khau"
                                    placeholder="Nhập mật khẩu" autocomplete="new-password" required>
                                <label class="mt-1" for="trang_thai"><strong>Quyền tài khoản</strong></label>
                                <select class="form-control" id="quyen-han-dropdown-search" name="quyen_han">
                                    <option value='Cán bộ' selected>Cán bộ</option>
                                    <option value='CBQL1'>Cán bộ quản lý 1</option>
                                    <option value='CBQL2'>Cán bộ quản lý 2</option>
                                </select>
                            </div>
                        </div>
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
                    <h4 class="modal-title">Xác nhận xóa cán bộ</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('quan-ly-khac.xoa-can-bo') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <h6 class="text-danger">Xác nhận xóa cán bộ này?</h6>
                        <div>
                            <label><strong>Mã cán bộ:</strong></label>
                            <p class="d-inline" id="modalMaCongChucXoa"></p>
                        </div>
                        <div>
                            <label><strong>Tên cán bộ:</strong></label>
                            <p class="d-inline" id="modalTenCongChucXoa"></p>
                        </div>
                        <input type="hidden" name="ma_can_bo" id="modalInputMaCongChucXoa">
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
            $('#tai-khoan-dropdown-search').select2();
            // Reinitialize Select2 when modal opens
            $('#thongTinModal').on('shown.bs.modal', function() {
                $('#tai-khoan-dropdown-search').select2('destroy');
                $('#tai-khoan-dropdown-search').select2({
                    placeholder: "Chọn tài khoản",
                    allowClear: true,
                    language: "vi",
                    minimumInputLength: 0,
                    dropdownAutoWidth: true,
                    width: '100%',
                    dropdownParent: $('#thongTinModal .modal-body'),
                });
            });
        });
    </script>
    {{-- Script áp dụng cho 3 cột đầu --}}
    <script>
        $(document).ready(function() {

            $('#dataTable tbody').on('click', 'tr', function(event) {
                if ($(event.target).closest('td:last-child').length) {
                    return;
                }

                var maCongChuc = $(this).data('ma-can-bo');
                var tenCongChuc = $(this).data('ten-can-bo');
                var tenDangNhap = $(this).data('ten-dang-nhap');
                var maTaiKhoan = $(this).data('ma-tai-khoan');
                var chucDanh = $(this).data('chuc-danh');
                var trangThai = $(this).data('trang-thai');
                var phanQuyen = $(this).data('quyen-han');
                var nhomViTriLamViec = $(this).data('nhom-vi-tri-lam-viec');

                document.getElementById('modalMaCongChuc').value = maCongChuc;
                document.getElementById('modalTenCongChuc').value = tenCongChuc;
                document.getElementById('modalChucDanh').value = chucDanh;

                $('#modalTenDangNhap').text(tenDangNhap);
                document.getElementById('modalMaCongChuc').value = maCongChuc;
                const modalMaCongChuc = document.getElementById('modalMaCongChuc');
                modalMaCongChuc.textContent = maCongChuc;

                const selectTrangThai = document.getElementById('trang-thai-dropdown-search');
                if (trangThai == 0) {
                    selectTrangThai.value = "0";
                } else {
                    selectTrangThai.value = "1";
                }




                const selectTaiKhoan = document.getElementById('tai-khoan-dropdown-search');
                const newOption = document.createElement('option');
                newOption.value = maTaiKhoan;
                newOption.text = tenDangNhap;
                selectTaiKhoan.add(newOption);
                newOption.selected = true;

                const selectQuyenHan = document.getElementById('quyen-han-dropdown-search');
                if (phanQuyen == "CBQL1") {
                    selectQuyenHan.value = "CBQL1";
                } else if (phanQuyen == "CBQL2") {
                    selectQuyenHan.value = "CBQL2";
                } else {
                    selectQuyenHan.value = "Cán bộ";
                }

                const modalInputMaCongChuc = document.getElementById('modalMaCongChucInput');
                modalInputMaCongChuc.value = maCongChuc;


                $('#thongTinModal').modal('show');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baoCaoButtons = document.querySelectorAll('.btn-primary[data-bs-toggle="modal"]');
            const deleteButtons = document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]');
            const modalTenCongChuc = document.getElementById('modalTenCongChucXoa');
            const modalMaCongChuc = document.getElementById('modalMaCongChucXoa');
            const modalInputMaCongChuc = document.getElementById('modalInputMaCongChucXoa');

            const modalTenCongChucBC = document.getElementById('modalTenCongChucBC');
            const modalMaCongChucBC = document.getElementById('modalMaCongChucBC');
            const modalInputMaCongChucBC = document.getElementById('modalInputMaCongChucBC');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get data from the clicked button
                    const maCongChuc = this.getAttribute('data-ma-can-bo');
                    const tenCongChuc = this.getAttribute('data-ten-can-bo');

                    // Set data in the modal
                    modalTenCongChuc.textContent = tenCongChuc;
                    modalMaCongChuc.textContent = maCongChuc;
                    modalInputMaCongChuc.value = maCongChuc;
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
