@extends('layout.user-layout')

@section('title', 'Danh sách công việc')

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
                            <h4 class="font-weight-bold text-primary">Danh sách công việc</h4>
                        </div>
                        <div class="col-3">
                            @if (Auth::user()->quyen_han === 'CBQL2')
                                <a href="{{ route('cong-viec.them-cong-viec') }}"><button
                                        class="btn btn-success float-end">Thêm công việc</button></a>
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
                                    Số
                                </th>
                                <th>
                                    Tên công việc
                                </th>
                                <th>
                                    Bộ phận
                                </th>
                                <th>
                                    Loại công việc
                                </th>
                                <th>
                                    Thời hạn hoàn thành
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
                                @foreach ($data as $index => $congViec)
                                    <tr data-ma-cong-viec="{{ $congViec->ma_cong_viec }}"
                                        data-ten-cong-viec="{{ $congViec->ten_cong_viec }}"
                                        data-ten-bo-phan="{{ $congViec->ten_bo_phan }}"
                                        data-loai-cong-viec="{{ $congViec->loai_cong_viec }}"
                                        data-noi-nhan="{{ $congViec->noi_nhan }}"
                                        data-trang-thai="{{ $congViec->trang_thai }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $congViec->ma_cong_viec }}</td>
                                        <td>{{ $congViec->ten_cong_viec }}</td>
                                        <td>{{ $congViec->ten_bo_phan }}</td>
                                        <td>{{ $congViec->loai_cong_viec }}</td>
                                        <td></td>

                                        @if ($congViec->trang_thai == 1)
                                            <td class="text-success">Đang hoạt động</td>
                                        @elseif($congViec->trang_thai == 0)
                                            <td class="text-danger">Đã hủy</td>
                                        @endif


                                        @if (Auth::user()->quyen_han === 'CBQL2')
                                            @if ($congViec->trang_thai == 1)
                                                <td>
                                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#xoaModal"
                                                        data-ma-cong-viec="{{ $congViec->ma_cong_viec }}"
                                                        data-ten-cong-viec="{{ $congViec->ten_cong_viec }}">
                                                        Hủy
                                                    </button>
                                                </td>
                                            @elseif($congViec->trang_thai == 0)
                                                <td>
                                                    <button class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#kichHoatModal"
                                                        data-ma-cong-viec="{{ $congViec->ma_cong_viec }}"
                                                        data-ten-cong-viec="{{ $congViec->ten_cong_viec }}">
                                                        Kích hoạt
                                                    </button>
                                                </td>
                                            @endif
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
                    <h5 class="modal-title" id="thongTinModalLabel">Thông tin công việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="mt-2">
                                <strong>Mã công việc:</strong>
                                <span id="modalMaCongViec"></span>
                            </p>
                            <p class="mt-2">
                                <strong>Tên công việc:</strong>
                                <span id="modalTenCongViec"></span>
                            </p>
                            <p class="mt-2">
                                <strong>Bộ phận:</strong>
                                <span id="modalBoPhan"></span>
                            </p>
                            <p class="mt-2">
                                <strong>Loại công việc:</strong>
                                <span id="modalLoaiCongViec"></span>
                            </p>
                            <p class="mt-2">
                                <strong>Nơi nhận:</strong>
                                <span id="modalNoiNhan"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (Auth::user()->quyen_han === 'CBQL2')
                        <a id="suaCongViec" href="#"><button class="btn btn-success">Sửa công việc</button></a>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Xóa Modal -->
    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Xác nhận hủy công việc</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('cong-viec.xoa-cong-viec') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <h6 class="text-danger">Xác nhận hủy công việc này?</h6>
                        <div>
                            <label><strong>Mã công việc:</strong></label>
                            <p class="d-inline" id="modalMaCongViecXoa"></p>
                        </div>
                        <div>
                            <label><strong>Tên công việc:</strong></label>
                            <p class="d-inline" id="modalTenCongViecXoa"></p>
                        </div>
                        <input type="hidden" name="ma_cong_viec" id="modalInputmaCongViecXoa">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kích hoạt Modal -->
    <div class="modal fade" id="kichHoatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Xác nhận kích hoạt công việc</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('cong-viec.kich-hoat-cong-viec') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <h6 class="text-danger">Xác nhận kích hoạt công việc này?</h6>
                        <div>
                            <label><strong>Mã công việc:</strong></label>
                            <p class="d-inline" id="modalMaCongViecKichHoat"></p>
                        </div>
                        <div>
                            <label><strong>Tên công việc:</strong></label>
                            <p class="d-inline" id="modalTenCongViecKichHoat"></p>
                        </div>
                        <input type="hidden" name="ma_cong_viec" id="modalInputmaCongViecKichHoat">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Xác nhận kích hoạt</button>
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
                var maCongViec = $(this).data('ma-cong-viec');
                var tenCongViec = $(this).data('ten-cong-viec');
                var tenBoPhan = $(this).data('ten-bo-phan');
                var loaiCongViec = $(this).data('loai-cong-viec');
                var noiNhan = $(this).data('noi-nhan');
                var trangThai = $(this).data('trang-thai');

                document.getElementById('modalMaCongViec').textContent = maCongViec;
                document.getElementById('modalTenCongViec').textContent = tenCongViec;
                document.getElementById('modalBoPhan').textContent = tenBoPhan;
                document.getElementById('modalLoaiCongViec').textContent = loaiCongViec;
                document.getElementById('modalNoiNhan').textContent = noiNhan;

                let suaCongViec = document.getElementById("suaCongViec");
                if(suaCongViec){
                    suaCongViec.href = `/sua-cong-viec/` + encodeURIComponent(maCongViec);
                }
                $('#thongTinModal').modal('show');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baoCaoButtons = document.querySelectorAll('.btn-primary[data-bs-toggle="modal"]');
            const deleteButtons = document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]');
            const activateButtons = document.querySelectorAll('.btn-success[data-bs-toggle="modal"]');

            const modalTenCongViec = document.getElementById('modalTenCongViecXoa');
            const modalMaCongViec = document.getElementById('modalMaCongViecXoa');
            const modalInputmaCongViec = document.getElementById('modalInputmaCongViecXoa');



            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get data from the clicked button
                    const maCongViec = this.getAttribute('data-ma-cong-viec');
                    const tenCongViec = this.getAttribute('data-ten-cong-viec');

                    // Set data in the modal
                    modalTenCongViec.textContent = tenCongViec;
                    modalMaCongViec.textContent = maCongViec;
                    modalInputmaCongViec.value = maCongViec;
                });
            });
            const modalTenCongViecKichHoat = document.getElementById('modalTenCongViecKichHoat');
            const modalMaCongViecKichHoat = document.getElementById('modalMaCongViecKichHoat');
            const modalInputmaCongViecKichHoat = document.getElementById('modalInputmaCongViecKichHoat');
            activateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get data from the clicked button
                    const maCongViec = this.getAttribute('data-ma-cong-viec');
                    const tenCongViec = this.getAttribute('data-ten-cong-viec');
                    console.log("a");
                    // Set data in the modal
                    modalTenCongViecKichHoat.textContent = tenCongViec;
                    modalMaCongViecKichHoat.textContent = maCongViec;
                    modalInputmaCongViecKichHoat.value = maCongViec;
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
