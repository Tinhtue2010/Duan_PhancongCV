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
                            @if (Auth::user()->quyen_han === 'CBQL2')
                                <button data-bs-toggle="modal" data-bs-target="#themModal"
                                    class="btn btn-success float-end">Thêm bộ phận mới</button>
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
                                    Mã bộ phận
                                </th>
                                <th>
                                    Tên bộ phận
                                </th>
                                <th>
                                    Chức năng nhiệm vụ
                                </th>
                                <th>
                                    Trạng thái
                                </th>
                                @if (Auth::user()->quyen_han === 'CBQL2')
                                    <th>
                                        Thao tác
                                    </th>
                                @endif
                            </thead>
                            <tbody class="clickable-row">
                                @foreach ($data as $index => $boPhan)
                                    <tr data-ma-bo-phan="{{ $boPhan->ma_bo_phan }}"
                                        data-ten-bo-phan="{{ $boPhan->ten_bo_phan }}"
                                        data-chuc-nang-nhiem-vu="{{ $boPhan->chuc_nang_nhiem_vu }}"
                                        data-thoi-gian-thanh-lap="{{ $boPhan->thoi_gian_thanh_lap }}"
                                        data-thoi-gian-giai-the="{{ $boPhan->thoi_gian_giai_the }}"
                                        data-trang-thai="{{ $boPhan->trang_thai }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $boPhan->ma_bo_phan }}</td>
                                        <td>{{ $boPhan->ten_bo_phan }}</td>
                                        <td>{{ $boPhan->chuc_nang_nhiem_vu }}</td>
                                        <td>
                                            @if ($boPhan->trang_thai == 1)
                                                Đang hoạt động
                                            @elseif($boPhan->trang_thai == 0)
                                                Ngừng hoạt động
                                            @endif

                                        </td>
                                        <td>
                                            <button class="btn btn-primary" onclick="window.location.href='{{ route('bo-phan.can-bo-cua-bo-phan', ['ma_bo_phan' => $boPhan->ma_bo_phan]) }}'">
                                                Cán bộ
                                            </button>
                                            
                                            @if (Auth::user()->quyen_han === 'CBQL2')
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#xoaModal" data-ma-bo-phan="{{ $boPhan->ma_bo_phan }}"
                                                    data-ten-bo-phan="{{ $boPhan->ten_bo_phan }}">
                                                    Xóa
                                                </button>
                                            @endif

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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thongTinModalLabel">Thông tin bộ phận</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bo-phan.update-bo-phan') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="mt-2"><strong>Mã bộ phận:</strong> <span id="modalMaBoPhan"></span></p>
                                <input type="hidden" class="form-control" id="modalMaBoPhanInput" name="ma_bo_phan">

                                <label class="mt-1" for="ten_bo_phan"><strong>Tên bộ phận</strong></label>
                                <input type="text" class="form-control" id="modalTenBoPhan" name="ten_bo_phan"
                                    max="255" placeholder="Nhập tên bộ phận" required>

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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm bộ phận mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bo-phan.them-bo-phan') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <label class="mt-1" for="ten_bo_phan"><strong>Tên bộ phận</strong></label>
                        <input type="text" class="form-control" id="modalTenBoPhan" name="ten_bo_phan"
                            max="255" placeholder="Nhập tên bộ phận" required>

                        <label class="mt-1" for="chuc_nang_nhiem_vu"><strong>Chức năng nhiệm vụ</strong></label>
                        <input type="text" class="form-control" id="modalChucNangNhiemVu" name="chuc_nang_nhiem_vu"
                            max="255" placeholder="Nhập chức năng nhiệm vụ" required>

                        <label class="mt-1" for="thoi_gian_thanh_lap"><strong>Thời gian thành lập</strong></label>
                        <input type="text" id="thoi_gian_thanh_lap" class="form-control" placeholder="dd/mm/yyyy"
                            name="thoi_gian_thanh_lap" autocomplete="off">

                        <label class="mt-1" for="trang_thai"><strong>Trạng thái</strong></label>
                        <select class="form-control" id="trang-thai-dropdown-search-2" name="trang_thai">
                            <option value=''></option>
                            <option value='1' selected>Đang hoạt động</option>
                            <option value='0'>Ngừng hoạt động</option>
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
                    <h4 class="modal-title">Xác nhận xóa bộ phận</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bo-phan.xoa-bo-phan') }}" method="POST">
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
            $('#thoi_gian_thanh_lap').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });
            $('#thoi_gian_giai_the').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });
            $('#modalGiaiThe').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });
            $('#modalThanhLap').datepicker({
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
                var chucNangNhiemVu = $(this).data('chuc-nang-nhiem-vu');
                var thoiGianGiaiThe = $(this).data('thoi-gian-giai-the');
                var thoiGianThanhLap = $(this).data('thoi-gian-thanh-lap');
                var trangThai = $(this).data('trang-thai');

                document.getElementById('modalMaBoPhan').value = maBoPhan;
                document.getElementById('modalTenBoPhan').value = tenBoPhan;
                document.getElementById('modalChucNangNhiemVu').value = chucNangNhiemVu;

                var thoiGianThanhLapFormatted = thoiGianThanhLap.split('-').reverse().join('/');
                document.getElementById('modalThanhLap').value = thoiGianThanhLapFormatted;
                var thoiGianThanhLapFormatted = thoiGianThanhLap.split('-').reverse().join('/');
                document.getElementById('modalGiaiThe').value = thoiGianThanhLapFormatted;

                // document.getElementById('modalTrangThai').value = trangThai;

                const modalMaBoPhan = document.getElementById('modalMaBoPhan');
                modalMaBoPhan.textContent = maBoPhan;

                const selectTrangThai = document.getElementById('trang-thai-dropdown-search');
                if (trangThai == 0) {
                    selectTrangThai.value = "0";
                } else {
                    selectTrangThai.value = "1";
                }


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
