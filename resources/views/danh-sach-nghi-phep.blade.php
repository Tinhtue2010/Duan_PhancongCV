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
                                @if (Auth::user()->quyen_han === 'CBQL1' || Auth::user()->quyen_han === 'CBQL2')
                                    <th>
                                        Thao tác
                                    </th>
                                @endif
                            </thead>
                            <tbody class="clickable-row">
                                @foreach ($data as $index => $item)
                                    <tr data-ma-can-bo="{{ $item->ma_can_bo }}"
                                        data-ngay-lam-viec="{{ $item->ngay_lam_viec ?? '' }}"
                                        data-tu-gio="{{ $item->tu_gio ?? '' }}" data-den-gio="{{ $item->den_gio ?? '' }}"
                                        data-ngay-bat-dau="{{ $item->ngay_bat_dau }}"
                                        data-ngay-ket-thuc="{{ $item->ngay_ket_thuc }}"
                                        data-ly-do-vang="{{ $item->ly_do_vang ?? '' }}"
                                        data-ma-nghi-phep="{{ $item->ma_nghi_phep }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->ma_can_bo }}</td>
                                        <td>{{ $item->canBo->ten_can_bo ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->ngay_lam_viec)->format('d-m-Y') }}</td>
                                        <td>{{ $item->tu_gio ?? 'N/A' }}</td>
                                        <td>{{ $item->den_gio ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->ngay_bat_dau)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->ngay_ket_thuc)->format('d-m-Y') }}</td>
                                        <td>{{ $item->ly_do_vang ?? 'Không có' }}</td>
                                        @if (Auth::user()->quyen_han === 'CBQL1' || Auth::user()->quyen_han === 'CBQL2')
                                            <td>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#xoaModal" data-ma-can-bo="{{ $item->ma_can_bo }}"
                                                    data-ma-nghi-phep="{{ $item->ma_nghi_phep }}"
                                                    data-ten-can-bo="{{ $item->ten_can_bo }}">
                                                    Xóa
                                                </button>
                                            </td>
                                        @endif
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
                    <h5 class="modal-title" id="thongTinModalLabel">Thông tin nghỉ phép</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nghi-phep.update-nghi-phep') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                @include('nghi-phep.field')
                                <input type="hidden" name="ma_nghi_phep" id="modalInputMaCongChucXoa">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (Auth::user()->quyen_han === 'CBQL1' || Auth::user()->quyen_han === 'CBQL2')
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                        @endif
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm nghỉ phép mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nghi-phep.them-nghi-phep') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                @include('nghi-phep.field')
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
                    <h4 class="modal-title">Xác nhận xóa nghỉ phép</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nghi-phep.xoa-nghi-phep') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <h6 class="text-danger">Xác nhận xóa nghỉ phép này?</h6>
                        <div>
                            <label><strong>Mã cán bộ:</strong></label>
                            <p class="d-inline" id="modalMaCongChucXoa"></p>
                        </div>
                        <div>
                            <label><strong>Tên cán bộ:</strong></label>
                            <p class="d-inline" id="modalTenCongChucXoa"></p>
                        </div>
                        <input type="hidden" name="ma_nghi_phep" id="modalInputMaCongChucXoa">
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

                var maCanBo = $(this).data('ma-can-bo');
                var ngayLamViec = $(this).data('ngay-lam-viec');
                var tuGio = $(this).data('tu-gio');
                var denGio = $(this).data('den-gio');
                var ngayBatDau = $(this).data('ngay-bat-dau');
                var ngayKetThuc = $(this).data('ngay-ket-thuc');
                var lyDoVang = $(this).data('ly-do-vang');
                var maNghiPhep = this.getAttribute('data-ma-nghi-phep');

                $('#thongTinModal [name="ma_can_bo"]').val(maCanBo);
                $('#thongTinModal [name="ngay_lam_viec"]').val(ngayLamViec);
                $('#thongTinModal [name="tu_gio"]').val(tuGio);
                $('#thongTinModal [name="den_gio"]').val(denGio);
                $('#thongTinModal [name="ngay_bat_dau"]').val(ngayBatDau);
                $('#thongTinModal [name="ngay_ket_thuc"]').val(ngayKetThuc);
                $('#thongTinModal [name="ly_do_vang"]').val(lyDoVang);
                $('#thongTinModal [name="ma_nghi_phep"]').val(maNghiPhep);

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
                    const maNghiPhep = this.getAttribute('data-ma-nghi-phep');


                    // Set data in the modal
                    modalTenCongChuc.textContent = tenCongChuc;
                    modalMaCongChuc.textContent = maCongChuc;
                    modalInputMaCongChuc.value = maNghiPhep;
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
