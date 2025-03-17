@extends('layout.user-layout')

@section('title', 'Danh sách phân công')

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
                            <h4 class="font-weight-bold text-primary">Danh sách phân công</h4>
                        </div>
                        <div class="col-3">
                            @if (Auth::user()->quyen_han === 'CBQL2' || Auth::user()->quyen_han === 'Admin')
                                <button data-bs-toggle="modal" data-bs-target="#themModal"
                                    class="btn btn-success float-end">Thêm phân công mới</button>
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
                                    Cán bộ giao
                                </th>
                                <th>
                                    Cán bộ nhận
                                </th>
                                <th>
                                    Ngày phân công
                                </th>
                                @if (Auth::user()->quyen_han === 'CBQL1' || Auth::user()->quyen_han === 'CBQL2')
                                    <th>
                                        Thao tác
                                    </th>
                                @endif
                            </thead>
                            <tbody class="clickable-row">
                                @foreach ($data as $index => $phanCong)
                                    <tr data-ma-phan-cong="{{ $phanCong->ma_phan_cong }}"
                                        data-ma-cong-viec="{{ $phanCong->ma_cong_viec }}"
                                        data-ten-can-bo-giao="{{ $phanCong->ten_can_bo_giao }}"
                                        data-ten-can-bo-nhan="{{ $phanCong->ten_can_bo_nhan }}"
                                        data-ngay-phan-cong="{{ $phanCong->ngay_phan_cong }}"
                                        data-ngay-nhan-viec="{{ $phanCong->ngay_nhan_viec }}"
                                        data-chi-tiet="{{ $phanCong->chi_tiet }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $phanCong->ma_phan_cong }}</td>
                                        <td>{{ $phanCong->ten_cong_viec }}</td>
                                        <td>{{ $phanCong->ten_can_bo_giao }}</td>
                                        <td>{{ $phanCong->ten_can_bo_nhan }}</td>
                                        <td>{{ \Carbon\Carbon::parse($phanCong->ngay_phan_cong)->format('d-m-Y') }}</td>
                                        @if (Auth::user()->quyen_han === 'CBQL1' || Auth::user()->quyen_han === 'CBQL2')
                                            <td>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#xoaModal"
                                                    data-ma-phan-cong="{{ $phanCong->ma_phan_cong }}"
                                                    data-ten-cong-viec="{{ $phanCong->ten_cong_viec }}">
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
                    <h5 class="modal-title" id="thongTinModalLabel">Thông tin phân công</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('phan-cong.update-phan-cong') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <p class="mt-2"><strong>Cán bộ giao:</strong> <span id="modalCanBoGiao"></span></p>
                            <p class="mt-2"><strong>Cán bộ nhận:</strong> <span id="modalCanBoNhan"></span></p>
                            <p class="mt-2"><strong>Ngày phân công:</strong> <span id="modalNgayPhanCong"></span></p>
                            <input type="hidden" class="form-control" id="modalMaPhanCongInput" name="ma_phan_cong">

                            <label class="mt-1" for="loai_cong_viec"><strong>Loại công việc</strong></label>
                            <select class="form-control" id="loai-cong-viec-dropdown-search-2" name="loai_cong_viec">
                                <option value=''></option>
                                <option value='Nghiệp vụ'>Nghiệp vụ</option>
                                <option value='Báo cáo'>Báo cáo</option>
                                <option value='Văn bản'>Văn bản</option>
                            </select>

                            <label class="mt-1" for="ma_cong_viec"><strong>Công việc</strong></label>
                            <select class="form-control" id="cong-viec-dropdown-search-2" name="ma_cong_viec">
                                <option value=''></option>
                                @foreach ($congViecs as $congViec)
                                    @if ($congViec->ma_cong_viec == $phanCong->ma_cong_viec)
                                        <option value="{{ $congViec->ma_cong_viec }}" selected>
                                            {{ $congViec->ten_cong_viec }}
                                        </option>
                                    @else
                                        <option value="{{ $congViec->ma_bo_phan }}">
                                            {{ $congViec->ten_cong_viec }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="row">
                                <div class="col-12">
                                    <label class="mt-1" for="ngay_nhan_viec"><strong>Ngày nhận việc</strong></label>
                                    <input type="text" id="modalNgayNhanViec" class="form-control px-2"
                                        placeholder="dd/mm/yyyy" name="ngay_nhan_viec" autocomplete="off">
    
                                    <label class="mt-3" for="chuc_danh"><strong>Chi tiết phân công</strong></label>
                                    <textarea class="form-control" id="modalChiTiet" rows="3" name="chi_tiet"></textarea>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (Auth::user()->quyen_han === 'CBQL2')
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm phân công mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('phan-cong.them-phan-cong') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="ma_can_bo_giao" value={{ Auth::user()->canBo->ma_can_bo ?? '' }}>
                            <label class="mt-1"><strong>Cán bộ phân công:
                                    {{ Auth::user()->canBo->ten_can_bo ?? '' }}</strong></label>

                            <label class="mt-1" for="loai_cong_viec"><strong>Loại công việc</strong></label>
                            <select class="form-control" id="loai-cong-viec-dropdown-search" name="loai_cong_viec">
                                <option value=''></option>
                                <option value='Nghiệp vụ'>Nghiệp vụ</option>
                                <option value='Báo cáo'>Báo cáo</option>
                                <option value='Văn bản'>Văn bản</option>
                            </select>


                            <label class="mt-1" for="ma_cong_viec"><strong>Công việc</strong></label>
                            <select class="form-control" id="cong-viec-dropdown-search" name="ma_cong_viec">
                                <option value=''></option>
                            </select>

                        </div>


                        <label class="mt-1" for="chuc_danh"><strong>Cán bộ nhận</strong></label>
                        <select class="form-control" id="can-bo-dropdown-search" name="ma_can_bo_nhan">
                            <option value=''></option>
                            @foreach ($canBos as $canBo)
                                <option value="{{ $canBo->ma_can_bo }}">
                                    {{ $canBo->ten_can_bo }}
                                </option>
                            @endforeach
                        </select>

                        <label class="mt-1" for="ngay_nhan_viec"><strong>Ngày nhận việc</strong></label>
                        <input type="text" id="ngay_nhan_viec" class="form-control" placeholder="dd/mm/yyyy"
                            name="ngay_nhan_viec" autocomplete="off">

                        <label class="mt-3" for="chuc_danh"><strong>Chi tiết phân công</strong></label>
                        <textarea type="text" class="form-control" rows="3" name="chi_tiet"></textarea>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Thêm mới</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Xóa Modal -->
        <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Xác nhận xóa phân công</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('phan-cong.xoa-phan-cong') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <h6 class="text-danger">Xác nhận xóa phân công này?</h6>
                            <div>
                                <label><strong>Mã phân công:</strong></label>
                                <p class="d-inline" id="modalMaCongChucXoa"></p>
                            </div>
                            <div>
                                <label><strong>Tên phân công:</strong></label>
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
        {{-- Script áp dụng cho 3 cột đầu --}}
        <script>
            $(document).ready(function() {
                $('#ngay_nhan_viec').datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    language: 'vi',
                    endDate: '0d'
                });
                $('#modalNgayNhanViec').datepicker({
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

                    var maPhanCong = $(this).data('ma-phan-cong');
                    var maCongViec = $(this).data('ma-cong-viec');
                    var tenCanBoGiao = $(this).data('ten-can-bo-giao');
                    var tenCanBoNhan = $(this).data('ten-can-bo-nhan');
                    var ngayPhanCong = $(this).data('ngay-phan-cong');
                    var ngayPhanCong = new Date(ngayPhanCong).toLocaleDateString('vi-VN');
                    var ngayNhanViec = $(this).data('ngay-nhan-viec');
                    var chiTiet = $(this).data('chi-tiet');

                    var ngayNhanViec = ngayNhanViec.split('-').reverse().join('/');
                    document.getElementById('modalNgayNhanViec').value = ngayNhanViec;

                    document.getElementById('modalCanBoGiao').textContent = tenCanBoGiao;
                    document.getElementById('modalCanBoNhan').textContent = tenCanBoNhan;
                    document.getElementById('modalNgayPhanCong').textContent = ngayPhanCong;
                    document.getElementById('modalChiTiet').value = chiTiet;

                    const selectCongViec = document.getElementById('cong-viec-dropdown-search');
                    selectCongViec.value = maCongViec;

                    const modalMaPhanCongInput = document.getElementById('modalMaPhanCongInput');
                    modalMaPhanCongInput.value = maPhanCong;


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
                        const maCongChuc = this.getAttribute('data-ma-phan-cong');
                        const tenCongChuc = this.getAttribute('data-ten-phan-cong');

                        // Set data in the modal
                        modalTenCongChuc.textContent = tenCongChuc;
                        modalMaCongChuc.textContent = maCongChuc;
                        modalInputMaCongChuc.value = maCongChuc;
                    });
                });

                $(document).on('change', '#loai-cong-viec-dropdown-search', function() {
                    let loai_cong_viec = $(this).val();
                    let congViecDropdown = $("#cong-viec-dropdown-search");
                    congViecDropdown.empty();
                    $.ajax({
                        url: "{{ route('phan-cong.get-cong-viec') }}", // Adjust with your route
                        type: "GET",
                        data: {
                            loaiCongViec: loai_cong_viec,
                        },
                        success: function(response) {
                            $.each(response.congViecs, function(index, congViec) {
                                congViecDropdown.append(
                                    `<option value="${congViec.ma_cong_viec}">${congViec.ten_cong_viec}</option>`
                                );
                            });
                        }
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
