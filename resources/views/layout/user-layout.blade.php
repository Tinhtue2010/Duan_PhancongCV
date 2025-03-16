<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title', 'HẢI QUAN CỬA KHẨU CẢNG VẠN GIA')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery (must be included before Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Bootstrap Datepicker CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.vi.min.js">
    </script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link rel="stylesheet" href="{{ asset('js/DataTables/datatables.min.css') }}">

    <style>
        .sidenavToggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1031;
            padding: 0.75rem;
            background-color: #fff;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sidenavToggle:hover {
            background-color: #f8f9fa;
        }

        .sidenavToggle i {
            font-size: 1.25rem;
            color: #212529;
        }

        @media (min-width: 992px) {
            .sb-sidenav-toggled .layoutSidenav_nav {
                transform: translateX(-225px);
            }

            .sb-sidenav-toggled .layoutSidenav_content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Tạo thanh điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <!-- Thêm logo vào .navbar-brand -->
            {{-- <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            </a> --}}
            <a class="navbar-brand" href="/">HỆ THỐNG HỖ TRỢ PHÂN CÔNG NHIỆM VỤ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Trang chủ</a>
                    </li>

                    <!-- Menu có dropdown Hoạt động-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="courseDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hoạt động
                        </a>
                        @if (Auth::user()->quyen_han == 'Admin')
                        <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                            <li><a class="dropdown-item" href="/quan-ly-tai-khoan">Quản lý tài khoản</a>
                            <li><a class="dropdown-item" href="/quan-ly-can-bo">Quản lý cán bộ</a></li>
                        </ul>
                        @elseif(Auth::user()->quyen_han != 'Admin')
                        <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                            <li><a class="dropdown-item" href="/quan-ly-can-bo">Quản lý cán bộ</a></li>
                            <li><a class="dropdown-item" href="/quan-ly-bo-phan">Quản lý bộ phận</a></li>
                        </ul>
                        @endif
                    </li>

                    @if (Auth::user())
                        <li class="nav-item">
                            <form action="{{ route('dang-xuat') }}" method="POST" style="display: none;"
                                id="logout-form">
                                @csrf
                            </form>
                            <a class="nav-link" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>
                        </li>
                        <li class="nav-item text-primary text-center ms-2">
                            @if (Auth::user()->quyen_han !== 'Admin')
                                <span class="text-primary">{{ Auth::user()->canBo->ten_can_bo ?? '' }}</span>
                                (<span>{{ Auth::user()->CanBo->ma_can_bo }}</span>)
                            @endif
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/dang-nhap">Đăng nhập</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <center>
        <div class="custom-line mb-2"></div>
    </center>
    <button class="sidenavToggle" id="sidebarToggle">
        <img class="side-bar-icon" src="{{ asset('images/icons/sidenav-toggle.png') }}">
    </button>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        @if (Auth::user()->quyen_han !== 'Admin')
                            <div class="sb-sidenav-menu-heading">Quản lý</div>
                            <a class="nav-link" href="/quan-ly-can-bo">
                                <div class="sb-nav-link-icon"><img class="side-bar-icon"
                                        src="{{ asset('images/icons/officer.png') }}"></div>
                                Danh sách cán bộ
                            </a>
                            <a class="nav-link" href="/quan-ly-bo-phan">
                                <div class="sb-nav-link-icon"><img class="side-bar-icon"
                                        src="{{ asset('images/icons/officer.png') }}"></div>
                                Danh sách bộ phận
                            </a>
                            <a class="nav-link" href="/quan-ly-dieu-chuyen">
                                <div class="sb-nav-link-icon"><img class="side-bar-icon"
                                        src="{{ asset('images/icons/officer.png') }}"></div>
                                Danh sách điều chuyển
                            </a>
                        @elseif (Auth::user()->quyen_han === 'Admin')
                            <div class="sb-sidenav-menu-heading">Quản lý thông tin</div>
                            <a class="nav-link" href="/quan-ly-tai-khoan">
                                <div class="sb-nav-link-icon"><img class="side-bar-icon"
                                        src="{{ asset('images/icons/account.png') }}"></div>
                                Danh sách tài khoản
                            </a>
                            <a class="nav-link" href="/quan-ly-can-bo">
                                <div class="sb-nav-link-icon"><img class="side-bar-icon"
                                        src="{{ asset('images/icons/officer.png') }}"></div>
                                Danh sách cán bộ
                            </a>
                        @endif
                        <div class="sb-sidenav-menu-heading">Tài khoản</div>
                        <a class="nav-link" href="/thay-doi-mat-khau">
                            <div class="sb-nav-link-icon"><img class="side-bar-icon"
                                    src="{{ asset('images/icons/password.png') }}"></div>
                            Thay đổi mật khẩu
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        @yield('content')
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/temp-input-table.js') }}"></script>
    <script src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
        });
        document.addEventListener('DOMContentLoaded', function() {
            const doanhNghiepElement = document.getElementById('doanh-nghiep-text');
            const text = doanhNghiepElement.innerText.trim();
            const words = text.split(/\s+/); // Split by whitespace
            const maxWordsPerLine = 6;
            let formattedText = '';

            for (let i = 0; i < words.length; i += maxWordsPerLine) {
                const line = words.slice(i, i + maxWordsPerLine).join(' ');
                formattedText += line + '\n'; // Add a newline after each line
            }

            doanhNghiepElement.innerText = formattedText.trim();
        });
    </script>
</body>

</html>
