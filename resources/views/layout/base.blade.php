<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'HẢI QUAN CỬA KHẨU CẢNG VẠN GIA')</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
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

                    <!-- Menu có dropdown Giới thiệu-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="courseDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hoạt động
                        </a>
                        @if (Auth::user())
                            @if (Auth::user()->quyen_han == 'Admin')
                                <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                                    <li><a class="dropdown-item" href="/quan-ly-tai-khoan">Quản lý tài khoản</a>
                                    <li><a class="dropdown-item" href="/quan-ly-can-bo">Quản lý cán bộ</a>
                                    </li>
                                </ul>
                            @elseif(Auth::user()->quyen_han != 'Admin')
                                <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                                    <li><a class="dropdown-item" href="/quan-ly-bo-phan">Quản lý bộ phận</a>
                                    </li>
                                </ul>
                            @endif
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
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/dang-nhap">Đăng nhập</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')

    <!--- tạo Footer-->
    <footer class="pt-4 pb-2 text-white" style="background-color: blue;">
        <div class="container">
            <div class="row">

                <!-- Phần Giới thiệu -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-white">Giới thiệu</h5>
                    <p>Website này cung cấp ...</p>
                </div>

                <!-- Phần liên hệ -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-white">Liên hệ</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-geo-alt-fill"></i> Địa chỉ: Vĩnh Thực, Móng Cái, Quảng Ninh</li>
                        <li><i class="bi bi-telephone-fill"></i> Điện thoại: 0901581975 </li>
                        <li><i class="bi bi-envelope-fill"></i> Email: haiquanvangia@customs.gov.vn</li>
                    </ul>
                </div>

                <!-- Phần Liên kết mạng xã hội -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-white">Theo dõi chúng tôi</h5>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#" class="text-white"><i class="bi bi-facebook"></i>
                                Facebook</a></li>
                        <li class="list-inline-item"><a href="#" class="text-white"><i class="bi bi-twitter"></i>
                                Twitter</a></li>
                        <li class="list-inline-item"><a href="#" class="text-white"><i
                                    class="bi bi-instagram"></i> Instagram</a>
                        </li>
                        <li class="list-inline-item"><a href="#" class="text-white"><i class="bi bi-linkedin"></i>
                                LinkedIn</a></li>
                    </ul>
                </div>

            </div>

            <!-- Dòng Bản Quyền -->
            <div class="text-center pt-3">
                <p>Used by VanGia Port Border Gate Customs Branch ©2024
                    rights reserved</p>
            </div>
        </div>
    </footer>

    <!-- Đặt lệnh để các thành phần động của Bootstrap hoạt động -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
</body>

</html>
