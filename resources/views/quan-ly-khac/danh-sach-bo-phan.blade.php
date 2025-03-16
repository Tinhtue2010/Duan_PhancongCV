@extends('layout.user-layout')

@section('title', 'Danh sách bộ phận')

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
                            <h4 class="font-weight-bold text-primary">Danh sách bộ phận</h4>
                        </div>
                        <div class="col-3">
                            <button data-bs-toggle="modal" data-bs-target="#themModal"
                                class="btn btn-success float-end">Thêm bộ phận mới</button>
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
                                    Mã bộ phận
                                </th>
                                <th>
                                    Tên bộ phận
                                </th>
                                <th>
                                    Trạng thái
                                </th>
                                <th>
                                    Thao tác
                                </th>
                            </thead>
                            <tbody class="clickable-row">
                                @foreach ($data as $index => $canBo)
                                    <tr data-ma-bo-phan="{{ $canBo->ma_bo_phan }}"
                                        data-ten-bo-phan="{{ $canBo->ten_bo_phan }}"
                                        data-chuc-nang-nhiem-vu="{{ $canBo->chuc_nang_nhiem_vu }}"
                                        data-thoi-gian-thanh-lap="{{ $canBo->thoi_gian_thanh_lap }}"
                                        data-thoi-gian-giai-the="{{ $canBo->thoi_gian_giai_the }}"
                                        data-trang-thai="{{ $canBo->trang_thai }}"
                                        >
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $canBo->ma_bo_phan }}</td>
                                        <td>{{ $canBo->ten_bo_phan }}</td>
                                        <td>
                                            @if ($canBo->trang_thai == 1)
                                                Đang công tác
                                            @elseif($canBo->trang_thai == 0)
                                                Nghỉ công tác
                                            @endif

                                        </td>
                                        <td>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#xoaModal"
                                                data-ma-bo-phan="{{ $canBo->ma_bo_phan }}"
                                                data-ten-bo-phan="{{ $canBo->ten_bo_phan }}">
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
                    <h5 class="modal-title" id="thongTinModalLabel">Thông tin bộ phận</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('quan-ly-khac.update-can-bo') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="mt-2"><strong>Mã bộ phận:</strong> <span id="modalMaBoPhan"></span></p>
                                <input type="hidden" class="form-control" id="modalMaBoPhanInput" name="ma_bo_phan">

                                <div class="row">
                                    <div class="col-6">
                                        <label class="mt-1" for="ten_bo_phan"><strong>Tên bộ phận</strong></label>
                                        <input type="text" class="form-control" id="modalTenBoPhan" name="ten_bo_phan"
                                            max="255" placeholder="Nhập tên bộ phận" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-1" for="chuc_danh"><strong>Chức danh</strong></label>
                                        <input type="text" class="form-control" id="modalChucDanh" name="chuc_danh"
                                            max="255" placeholder="Nhập chức danh" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mt-1" for="trinh_do"><strong>Trình độ</strong></label>
                                        <input type="text" class="form-control" id="modalTrinhDo" name="trinh_do"
                                            max="50" placeholder="Nhập trình độ" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-1" for="chuyen_mon"><strong>Chuyên môn</strong></label>
                                        <input type="text" class="form-control" id="modalChuyenMon" name="chuyen_mon"
                                            max="50" placeholder="Nhập chuyên môn" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mt-1" for="ngay_sinh"><strong>Ngày sinh</strong></label>
                                        <input type="text" id="modalNgaySinh" class="form-control"
                                            placeholder="dd/mm/yyyy" name="ngay_sinh" autocomplete="off">

                                    </div>
                                    <div class="col-6">
                                        <label class="mt-1" for="ngay_tuyen_dung"><strong>Ngày tuyển
                                                dụng</strong></label>
                                        <input type="text" id="modalNgayTuyenDung" class="form-control"
                                            placeholder="dd/mm/yyyy" name="ngay_tuyen_dung" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
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
                                    <div class="col-6">
                                        <label class="mt-1" for="trang_thai"><strong>Trạng thái</strong></label>
                                        <select class="form-control" id="trang-thai-dropdown-search" name="trang_thai">
                                            <option value=''></option>
                                            <option value='1'>Đang công tác</option>
                                            <option value='0'>Nghỉ công tác</option>
                                        </select>
                                    </div>
                                </div>

                                <hr />
                                <p class="mt-2"><strong>Tên đăng nhập:</strong> <span id="modalTenDangNhap"></span></p>
                                <h5>Chọn tài khoản khác cho bộ phận này</h5>
                                <em>(Danh sách chỉ hiện các tài khoản thuộc loại "Cán bộ" chưa được gán cho bộ phận
                                    nào)</em>
                                <p><strong>Tên đăng nhập: </strong></p>
                                <select class="form-control" id="tai-khoan-dropdown-search" name="ma_tai_khoan">
                                    <option value=''></option>
                                    @foreach ($taiKhoans as $taiKhoan)
                                        <option value="{{ $taiKhoan->ma_tai_khoan }}">
                                            {{ $taiKhoan->ten_dang_nhap }}
                                        </option>
                                    @endforeach
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm bộ phận mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('quan-ly-khac.them-can-bo') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="mt-1" for="ten_bo_phan"><strong>Tên bộ phận</strong></label>
                                <input type="text" class="form-control" id="ten_bo_phan" name="ten_bo_phan"
                                    max="255" placeholder="Nhập tên bộ phận" required>
                            </div>
                            <div class="col-6">
                                <label class="mt-1" for="chuc_danh"><strong>Chức danh</strong></label>
                                <input type="text" class="form-control" id="chuc_danh" name="chuc_danh"
                                    max="255" placeholder="Nhập chức danh" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="mt-1" for="trinh_do"><strong>Trình độ</strong></label>
                                <input type="text" class="form-control" id="trinh_do" name="trinh_do"
                                    max="50" placeholder="Nhập trình độ" required>
                            </div>
                            <div class="col-6">
                                <label class="mt-1" for="chuyen_mon"><strong>Chuyên môn</strong></label>
                                <input type="text" class="form-control" id="chuyen_mon" name="chuyen_mon"
                                    max="50" placeholder="Nhập chuyên môn" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="mt-1" for="ngay_sinh"><strong>Ngày sinh</strong></label>
                                <input type="text" id="ngay_sinh" class="form-control" placeholder="dd/mm/yyyy"
                                    name="ngay_sinh" autocomplete="off">

                            </div>
                            <div class="col-6">
                                <label class="mt-1" for="ngay_tuyen_dung"><strong>Ngày tuyển dụng</strong></label>
                                <input type="text" id="ngay_tuyen_dung" class="form-control" placeholder="dd/mm/yyyy"
                                    name="ngay_tuyen_dung" autocomplete="off">
                            </div>
                        </div>


                        <hr />
                        <label class="mt-1" for="ten_dang_nhap"><strong>Tên đăng nhập</strong></label>
                        <input type="text" class="form-control" id="ten_dang_nhap" name="ten_dang_nhap"
                            placeholder="Nhập tên đăng nhập"autocomplete="new-password" required>
                        <label class="mt-1" for="mat_khau"><strong>Mật khẩu</strong></label>
                        <input type="password" class="form-control" id="mat_khau" name="mat_khau"
                            placeholder="Nhập mật khẩu" autocomplete="new-password" required>
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
                    <h4 class="modal-title">Xác nhận xóa bộ phận</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('quan-ly-khac.xoa-can-bo') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <h6 class="text-danger">Xác nhận xóa bộ phận này?</h6>
                        <div>
                            <label><strong>Mã bộ phận:</strong></label>
                            <p class="d-inline" id="modalMaBoPhanXoa"></p>
                        </div>
                        <div>
                            <label><strong>Tên bộ phận:</strong></label>
                            <p class="d-inline" id="modalTenBoPhanXoa"></p>
                        </div>
                        <input type="hidden" name="ma_bo_phan" id="modalInputMaBoPhanXoa">
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
            $('#ngay_sinh').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });
            $('#ngay_tuyen_dung').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });
            $('#modalNgaySinh').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });
            $('#modalNgayTuyenDung').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });

            $('#dataTable tbody').on('click', 'tr', function(event) {
                if ($(event.target).closest('td:last-child').length) {
                    return;
                }

                var maBoPhan = $(this).data('ma-bo-phan');
                var tenBoPhan = $(this).data('ten-bo-phan');
                var tenDangNhap = $(this).data('ten-dang-nhap');
                var maTaiKhoan = $(this).data('ma-tai-khoan');
                var trangThai = $(this).data('trang-thai');

                document.getElementById('modalMaBoPhan').value = maBoPhan;
                document.getElementById('modalTenBoPhan').value = tenBoPhan;
                document.getElementById('modalTrinhDo').value = trinhDo;
                document.getElementById('modalChuyenMon').value = chuyenMon;
                document.getElementById('modalChucDanh').value = chucDanh;

                var ngayTuyenDungFormatted = ngayTuyenDung.split('-').reverse().join('/');
                document.getElementById('modalNgayTuyenDung').value = ngayTuyenDungFormatted;
                var ngaySinhFormatted = ngaySinh.split('-').reverse().join('/');
                document.getElementById('modalNgaySinh').value = ngaySinhFormatted;

                // document.getElementById('modalTrangThai').value = trangThai;

                $('#modalTenDangNhap').text(tenDangNhap);
                document.getElementById('modalMaBoPhan').value = maBoPhan;
                const modalMaBoPhan = document.getElementById('modalMaBoPhan');
                modalMaBoPhan.textContent = maBoPhan;

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


                const modalInputMaBoPhan = document.getElementById('modalMaBoPhanInput');
                modalInputMaBoPhan.value = maBoPhan;


                $('#thongTinModal').modal('show');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]');
            const modalTenBoPhan = document.getElementById('modalTenBoPhanXoa');
            const modalMaBoPhan = document.getElementById('modalMaBoPhanXoa');
            const modalInputMaBoPhan = document.getElementById('modalInputMaBoPhanXoa');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get data from the clicked button
                    const maBoPhan = this.getAttribute('data-ma-bo-phan');
                    const tenBoPhan = this.getAttribute('data-ten-bo-phan');

                    // Set data in the modal
                    modalTenBoPhan.textContent = tenBoPhan;
                    modalMaBoPhan.textContent = maBoPhan;
                    modalInputMaBoPhan.value = maBoPhan;
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
