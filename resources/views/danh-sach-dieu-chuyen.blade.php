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
                                    Số
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
                                @foreach ($data as $index => $dieuChuyen)
                                    <tr data-ma-dieu-chuyen="{{ $dieuChuyen->ma_dieu_chuyen }}"
                                        data-ten-can-bo="{{ $dieuChuyen->ten_can_bo }}"
                                        data-thoi-gian-dieu-chuyen="{{ $dieuChuyen->thoi_gian_dieu_chuyen }}"
                                        data-ten-bo-phan-chuyen-den="{{ $dieuChuyen->ten_bo_phan }}"
                                        data-chuc-danh-moi="{{ $dieuChuyen->chuc_danh_moi }}"
                                        data-ly-do="{{ $dieuChuyen->ly_do }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $dieuChuyen->ma_dieu_chuyen }}</td>
                                        <td>{{ $dieuChuyen->ten_can_bo }}</td>
                                        <td>{{ $dieuChuyen->thoi_gian_dieu_chuyen }}</td>
                                        <td>{{ $dieuChuyen->ten_bo_phan }}</td>
                                        <td>{{ $dieuChuyen->ly_do }}</td>
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
                                <p class="mt-2"><strong>Tên cán bộ:</strong> <span id="modalTenCanBo"></span></p>
                                <p class="mt-2"><strong>Thời gian điều chuyển:</strong> <span
                                        id="modalThoiGianDieuChuyen"></span></p>
                                <p class="mt-2"><strong>Tên bộ phận mới chuyển đến:</strong> <span
                                        id="modalTenBoPhanChuyenDen"></span></p>
                                <p class="mt-2"><strong>Chức danh mới:</strong> <span id="modalChucDanhMoi"></span></p>
                                <p class="mt-2"><strong>Lý do:</strong> <span id="modalLyDo"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- @if (Auth::user()->quyen_han === 'CBQL2')
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                        @endif --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
                        <input type="text" class="form-control" name="thoi_gian_dieu_chuyen" max="50"
                            placeholder="Nhập thời gian điều chuyển">

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
                        <input type="text" class="form-control" name="chuc_danh_moi" max="50"
                            placeholder="Nhập chức danh mới">

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
    <script>
        $(document).ready(function() {
            $('#dataTable tbody').on('click', 'tr', function(event) {
                var maDieuChuyen = $(this).data('ma-dieu-chuyen');
                var tenCanBo = $(this).data('ten-can-bo');
                var thoiGianDieuChuyen = $(this).data('thoi-gian-dieu-chuyen');
                var tenBoPhanChuyenDen = $(this).data('ten-bo-phan-chuyen-den');
                var chucDanhMoi = $(this).data('chuc-danh-moi');
                var lyDo = $(this).data('ly-do');

                document.getElementById('modalMaDieuChuyen').textContent = maDieuChuyen;
                document.getElementById('modalTenCanBo').textContent = tenCanBo;
                document.getElementById('modalThoiGianDieuChuyen').textContent = thoiGianDieuChuyen;
                document.getElementById('modalTenBoPhanChuyenDen').textContent = tenBoPhanChuyenDen;
                document.getElementById('modalChucDanhMoi').textContent = chucDanhMoi;
                document.getElementById('modalLyDo').textContent = lyDo;

                // const modalInputMaDieuChuyen = document.getElementById('modalMaDieuChuyenInput');
                // modalInputMaDieuChuyen.value = maDieuChuyen;


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
