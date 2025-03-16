@extends('layout.user-layout')

@section('title', 'Kết xuất báo cáo')

@section('content')
    <div id="layoutSidenav_content">
        <div class=" px-4">
            <div class="card shadow mb-4">
                <div class="card-header pt-3">
                    <div class="row">
                        @if (session('alert-success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="myAlert">
                                <strong>{{ session('alert-success') }}</strong>
                            </div>
                        @elseif (session('alert-danger'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="myAlert">
                                <strong>{{ session('alert-danger') }}</strong>
                            </div>
                        @endif
                        <div class="col-9">
                            <h4 class="font-weight-bold text-primary">Kết xuất báo cáo</h4>
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                </div>
                    <div class="row justify-content-center">
                        <div class="card p-3 me-3 col-5">
                            @if (Auth::user()->quyen_han === 'Cán bộ')
                                <h4>Báo cáo hàng tồn theo Doanh nghiệp</h4>
                                <div class="form-group">
                                    <label class="label-text mb-2" for="ma_doanh_nghiep">Tên Doanh nghiệp/Công ty</label>
                                    <form action="{{ route('export.hang-ton-doanh-nghiep') }}" method="GET">
                                        <select class="form-control" id="doanh-nghiep-dropdown-search-3"
                                            name="ma_doanh_nghiep" required>
                                            <option value="" data-ten-doanh-nghiep="">Chọn doanh nghiệp</option>
                                            @foreach ($doanhNghieps as $doanhNghiep)
                                                <option value="{{ $doanhNghiep->ma_doanh_nghiep }}"
                                                    data-ten-doanh-nghiep="{{ $doanhNghiep->ten_doanh_nghiep }}">
                                                    {{ $doanhNghiep->ten_doanh_nghiep }}
                                                    ({{ $doanhNghiep->chuHang->ten_chu_hang ?? '' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <!-- Hidden input to send the ten_doanh_nghiep -->
                                        <center><button type="submit" class="btn btn-primary mt-2">Tải xuống báo
                                                cáo</button>
                                        </center>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="card p-3 ms-3 col-5">
                           
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function updateTenChuHang() {
            const dropdown = document.getElementById('chu-hang-dropdown-search');
            const selectedOption = dropdown.options[dropdown.selectedIndex];
            const tenChuHang = selectedOption.getAttribute('data-ten-chu-hang'); // Fixed variable name here

            // Update the hidden input field
            document.getElementById('ten-chu-hang').value = tenChuHang || '';
        }
    </script>
    <script>
        $(document).ready(function() {
            // Initialize the datepicker with Vietnamese localization
            $('#datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });
            $('#datepicker2').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize all datepickers
            $('[id^=datepicker]').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'vi',
                endDate: '0d'
            });

            // Function to validate date fields in a form
            function validateDateFields(form) {
                const tuNgay = $(form).find('[name="tu_ngay"]').val();
                const denNgay = $(form).find('[name="den_ngay"]').val();

                // if (!tuNgay || !denNgay) {
                //     alert("Vui lòng chọn đủ hai ngày trước khi tải xuống báo cáo.");
                //     return false; // Prevent form submission
                // }
                return true; // Allow form submission
            }

            // Attach submit event to all forms with date fields
            $('form').on('submit', function(event) {
                const formHasDates = $(this).find('[name="tu_ngay"], [name="den_ngay"]').length > 0;
                if (formHasDates && !validateDateFields(this)) {
                    event.preventDefault(); // Prevent submission if validation fails
                }
            });
        });
    </script>
    <script>
        $('#can-bo-dropdown-search-2').select2({
            placeholder: "Chọn",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,
            dropdownAutoWidth: true,
            ajax: {
                dataType: 'json',
                delay: 250, // Delay for AJAX search
                processResults: function(data) {
                    return {
                        results: data.items
                    };
                }
            },
        });
        $('#can-bo-dropdown-search-2').select2({
            placeholder: "Chọn công chức",
            allowClear: true,
        });
    </script>

@stop
