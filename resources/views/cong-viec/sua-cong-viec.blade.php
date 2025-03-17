@extends('layout.user-layout')

@section('title', 'Sửa tờ khai')

@section('content')
    <div id="layoutSidenav_content">
        <div class="container-fluid px-5 mt-3">
            @if (session('alert-success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="myAlert">
                    <strong>{{ session('alert-success') }}</strong>
                </div>
            @elseif(session('alert-danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="myAlert">
                    <strong>{{ session('alert-danger') }}</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-6">
                    <a class="return-link" href="/quan-ly-cong-viec">
                        <p>
                            < Quay lại quản lý công việc</p>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card px-3 pt-3 mt-4">
                        <h3 class="text-center text-dark">Thông tin công việc</h3>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="label-text fw-bold" for="">Tên công việc</label> <span
                                        class="text-danger missing-input-text"></span>
                                    <input type="text" class="form-control mt-2" id="ten_cong_viec" maxlength="255"
                                        name="ten_cong_viec" placeholder="Nhập tên công việc"
                                        value={{ $congViec->ten_cong_viec }} required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="label-text mb-1 fw-bold" for="loai_cong_viec">Loại công việc</label>
                                    <select class="form-control" id="loai-cong-viec-dropdown-search" name="loai_cong_viec">
                                        <option value=''></option>
                                        @foreach ($loaiCongViecs as $loaiCongViec)
                                            @if ($loaiCongViec == $congViec->loai_cong_viec)
                                                <option value="{{ $loaiCongViec }}" selected>
                                                    {{ $loaiCongViec }}
                                                </option>
                                            @else
                                                <option value="{{ $loaiCongViec }}">
                                                    {{ $loaiCongViec }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="label-text mb-1 fw-bold" for="ma_bo_phan">Bộ phận</label>
                                    <select class="form-control" id="bo-phan-dropdown-search" name="ma_bo_phan">
                                        <option value=''></option>
                                        @foreach ($boPhans as $boPhan)
                                            @if ($boPhan->ma_bo_phan == $congViec->ma_bo_phan)
                                                <option value="{{ $boPhan->ma_bo_phan }}" selected>
                                                    {{ $boPhan->ten_bo_phan }}
                                                    ({{ $boPhan->ma_bo_phan }})
                                                </option>
                                            @else
                                                <option value="{{ $boPhan->ma_bo_phan }}">
                                                    {{ $boPhan->ten_bo_phan }}
                                                    ({{ $boPhan->ma_bo_phan }})
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="label-text fw-bold" for="">Nơi nhận</label>
                                <input type="text" class="form-control mt-2" id="noi_nhan" maxlength="50"
                                    name="noi_nhan" placeholder="Nơi nhận" required value={{ $congViec->noi_nhan }}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="text-center text-dark">Thông tin thời hạn</h3>

            <div class="row">
                <center>
                    <div class="col-8">
                        <div class="card p-3 mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="label-text mb-2 fw-bold" for="moc_thoi_gian">Mốc thời gian</label>
                                        <span class="text-danger missing-input-text"></span>
                                        <select class="form-control" id="moc-thoi-gian-dropdown-search"
                                            name="moc_thoi_gian">
                                            <option value=''></option>
                                            <option value='Hàng tháng'>Hàng tháng</option>
                                            <option value='Hàng quý'>Hàng quý (Tháng 3,6,9,12)</option>
                                            <option value='Hàng năm' selected>Hàng năm</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="label-text fw-bold" for="">Ngày hết hạn</label>
                                        <input type="number" class="form-control mt-2" id="ngay_het_han" maxlength="31"
                                            name="ngay_het_han" placeholder="Nhập ngày hết hạn" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="label-text fw-bold" for="">Tháng hết hạn</label>
                                        <input type="number" class="form-control mt-2" id="thang_het_han" maxlength="12"
                                            name="thang_het_han" placeholder="Nhập tháng hết hạn" autocomplete="off"
                                            required>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </center>
            </div>
            <div class="row mb-5">
                <center>
                    <button type="button" class="btn btn-primary mt-1" id="addRowButton">
                        Thêm dòng mới
                    </button>
                </center>
            </div>



            <!-- Your existing table -->
            <table class="table table-bordered" id="displayTableThoiHan">
                <thead style="vertical-align: middle; text-align: center;">
                    <tr>
                        <th>STT</th>
                        <th>Mốc thời gian</th>
                        <th>Ngày hết hạn</th>
                        <th>Tháng hết hạn</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <center>
                <button type="button" id="xacNhanBtn" class="btn btn-success mb-5">Sửa công việc</button>
            </center>
        </div>
    </div>

    {{-- Modal xác nhận --}}
    <div class="modal fade" id="xacNhanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận sửa công việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Xác nhận sửa công việc này?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('cong-viec.sua-cong-viec-submit') }}" method="POST" id="mainForm">
                        @csrf
                        <input type="hidden" name="rows_data" id="rowsDataInput">
                        <input type="hidden" name="ten_cong_viec" id="ten_cong_viec_hidden">
                        <input type="hidden" name="loai_cong_viec" id="loai_cong_viec_hidden">
                        <input type="hidden" name="ma_bo_phan" id="ma_bo_phan_hidden">
                        <input type="hidden" name="noi_nhan" id="noi_nhan_hidden">
                        <input type="hidden" name="ma_cong_viec" value={{ $congViec->ma_cong_viec }}>
                        <button type="submit" class="btn btn-success">Nhập công việc</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('bo-phan-dropdown-search').addEventListener('change', function() {
            document.getElementById('ma_bo_phan').value = this.value;
        });
        document.getElementById('loai-cong-viec-dropdown-search').addEventListener('change', function() {
            document.getElementById('loai_cong_viec').value = this.value;
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            let thoiHanRows = @json($thoiHanRows ?? []);
            let rowsData = [];
            // Populate the rowsData array
            rowsData = thoiHanRows.map(row => ({
                moc_thoi_gian: row.moc_thoi_gian,
                ngay_het_han: row.ngay_het_han,
                thang_het_han: row.thang_het_han,
            }));
            displayRows();

            function displayRows() {
                const tableBody = $("#displayTableThoiHan tbody");
                tableBody.empty();
                rowsData.forEach((row, index) => {
                    const newRow = `
                    <tr data-index="${index}">
                        <td>${index + 1}</td>
                        <td>${row.moc_thoi_gian}</td>
                        <td>${row.ngay_het_han}</td>
                        <td>${row.thang_het_han}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editRowButton">Sửa</button>
                            <button class="btn btn-danger btn-sm deleteRowButton">Xóa</button>
                        </td>
                    </tr>
                `;
                    tableBody.append(newRow);
                });
            }

            $("#addRowButton").click(function() {
                const moc_thoi_gian = $("#moc-thoi-gian-dropdown-search").val();
                const ngay_het_han = $("#ngay_het_han").val();
                const thang_het_han = $("#thang_het_han").val();
                let isValid = true;
                if (isValid) {
                    rowsData.push({
                        moc_thoi_gian,
                        ngay_het_han,
                        thang_het_han,
                    });

                    displayRows();
                    $(".reset-input").val('');
                    $("#moc-thoi-gian-dropdown-search").val('').trigger("change");
                }
            });

            $(document).on("click", ".editRowButton", function() {
                const rowIndex = $(this).closest("tr").data("index");
                const rowData = rowsData[rowIndex];
                $("#ngay_het_han").val(rowData.ngay_het_han);
                $("#thang_het_han").val(rowData.thang_het_han);
                $("#moc-thoi-gian-dropdown-search").val(rowData.moc_thoi_gian).trigger("change");
                rowsData.splice(rowIndex, 1);
                displayRows();
            });

            $(document).on("click", ".deleteRowButton", function() {
                const rowIndex = $(this).closest("tr").data("index");
                rowsData.splice(rowIndex, 1);
                displayRows();
            });

            const nhapYeuCauButton = document.getElementById('xacNhanBtn');
            nhapYeuCauButton.addEventListener('click', function() {
                // Get values from dropdowns
                const loaiCongViec = document.getElementById('loai-cong-viec-dropdown-search').value;
                const boPhan = document.getElementById('bo-phan-dropdown-search').value;
                const tenCongViec = $("#ten_cong_viec").val();
                const noiNhan = $("#noi_nhan").val();

                if (!loaiCongViec) {
                    alert('Vui lòng chọn loại công việc');
                    return;
                } else if (!boPhan) {
                    alert('Vui lòng chọn bộ phận');
                    return;
                } else if (!tenCongViec) {
                    alert('Vui lòng nhập tên công việc');
                    return;
                } else if (!noiNhan) {
                    alert('Vui lòng nhập nơi nhận');
                    return;
                }

                const tableRows = document.querySelectorAll('#displayTableThoiHan tbody tr');
                if (tableRows.length === 0) {
                    alert('Vui lòng sửa ít nhất một thời hạn');
                    return;
                }

                const rowsData = Array.from(tableRows).map(row => ({
                    moc_thoi_gian: row.cells[1].textContent,
                    ngay_het_han: row.cells[2].textContent,
                    thang_het_han: row.cells[3].textContent,
                }));

                // Set values for hidden inputs
                document.getElementById('rowsDataInput').value = JSON.stringify(rowsData);
                document.getElementById('ten_cong_viec_hidden').value = tenCongViec;
                document.getElementById('ma_bo_phan_hidden').value = boPhan;
                document.getElementById('loai_cong_viec_hidden').value = loaiCongViec;
                document.getElementById('noi_nhan_hidden').value = noiNhan;
                $('#xacNhanModal').modal('show');
            });

        });
    </script>
    <script>
        document.getElementById("moc-thoi-gian-dropdown-search").addEventListener("change", function() {
            let inputField = document.getElementById("thang_het_han");

            if (this.value === "Hàng tháng" || this.value === "Hàng quý") {
                inputField.value = "";
                inputField.disabled = true;
            } else {
                inputField.disabled = false;
            }
        });
        document.getElementById("ngay_het_han").addEventListener("input", function() {
            let value = parseInt(this.value);

            // If value is out of range, adjust it
            if (value < 1) {
                this.value = 1;
            } else if (value > 31) {
                this.value = 31;
            }
        });
        document.getElementById("thang_het_han").addEventListener("input", function() {
            let value = parseInt(this.value);

            // If value is out of range, adjust it
            if (value < 1) {
                this.value = 1;
            } else if (value > 12) {
                this.value = 12;
            }
        });
    </script>
@stop
