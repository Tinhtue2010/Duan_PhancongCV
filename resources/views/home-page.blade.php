@extends('layout.base')

@section('title', 'Trang chủ')

@section('content')
    <!-- Tạo banner /slider -->
    <div class="container mt-4">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/img/10.jpg') }}" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/25.jpg') }}" class="d-block w-100" alt="Banner 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/img/2.jpg') }}" class="d-block w-100" alt="Banner 3">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/img/3.jpg') }}" class="d-block w-100" alt="Banner 4">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/img/4.jpg') }}" class="d-block w-100" alt="Banner 5">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/img/5.jpg') }}" class="d-block w-100" alt="Banner 6">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
@stop
