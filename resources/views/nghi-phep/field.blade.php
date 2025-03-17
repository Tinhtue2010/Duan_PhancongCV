<div class="row">
    <div class="col-md-6">
        <label for="ma_can_bo" class="form-label"><strong>Mã cán bộ</strong></label>
        <select class="form-control" id="ma_can_bo" name="ma_can_bo" required>
            <option value="" disabled selected>Chọn mã cán bộ</option>
            @foreach ($danhSachCanBo as $canBo)
                <option value="{{ $canBo->ma_can_bo }}">{{ $canBo->ma_can_bo }} - {{ $canBo->ten_can_bo }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6">
        <label for="ngay_lam_viec" class="form-label"><strong>Ngày làm việc</strong></label>
        <input type="date" class="form-control" id="ngay_lam_viec" name="ngay_lam_viec">
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label for="tu_gio" class="form-label"><strong>Từ giờ</strong></label>
        <input type="time" class="form-control" id="tu_gio" name="tu_gio">
    </div>
    <div class="col-md-6">
        <label for="den_gio" class="form-label"><strong>Đến giờ</strong></label>
        <input type="time" class="form-control" id="den_gio" name="den_gio">
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label for="ngay_bat_dau" class="form-label"><strong>Ngày bắt đầu</strong></label>
        <input type="date" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau" required>
    </div>
    <div class="col-md-6">
        <label for="ngay_ket_thuc" class="form-label"><strong>Ngày kết thúc</strong></label>
        <input type="date" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc" required>
    </div>
</div>

<div class="mt-3">
    <label for="ly_do_vang" class="form-label"><strong>Lý do vắng</strong></label>
    <select class="form-control" id="ly_do_vang" name="ly_do_vang" required>
        <option value="" selected disabled>Chọn lý do</option>
        <option value="Nghỉ phép">Nghỉ phép</option>
        <option value="Nghỉ bù">Nghỉ bù</option>
        <option value="Đi học">Đi học</option>
        <option value="Đi công tác">Đi công tác</option>
        <option value="Nghỉ ốm">Nghỉ ốm</option>
    </select>
</div>

