$(document).ready(function () {
    $(document).on('select2:open', function () {
        $('.select2-search__field').attr('placeholder', 'Nhập để tìm kiếm'); // Set the placeholder
    });

    $('#cong-viec-dropdown-search').select2();
    $('#cong-viec-dropdown-search-2').select2();
    $('#loai-cong-viec-dropdown-search').select2({
        placeholder: "Chọn loại công việc",
        allowClear: true,
        language: "vi",
        minimumInputLength: 0,
        width: '100%',
    });
    $('#loai-cong-viec-dropdown-search-2').select2();
    $('#trang-thai-dropdown-search').select2();
    $('#bo-phan-dropdown-search').select2({
        placeholder: "Chọn bộ phận",
        allowClear: true,
        language: "vi",
        minimumInputLength: 0,
        width: '100%',
    });
    $('#can-bo-dropdown-search').select2();

    $('#themModal').on('shown.bs.modal', function () {
        $('#can-bo-dropdown-search').select2('destroy');
        $('#can-bo-dropdown-search').select2({
            placeholder: "Chọn cán bộ",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,
            width: '100%',
            dropdownParent: $('#themModal'),
        });

        $('#bo-phan-dropdown-search').select2('destroy');
        $('#bo-phan-dropdown-search').select2({
            placeholder: "Chọn bộ phận",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#themModal '),
        });
        $('#cong-viec-dropdown-search').select2('destroy');
        $('#cong-viec-dropdown-search').select2({
            placeholder: "Chọn công việc",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#themModal '),
        });
        $('#cong-viec-dropdown-search-2').select2('destroy');
        $('#cong-viec-dropdown-search-2').select2({
            placeholder: "Chọn công việc",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#themModal'),
        });
        $('#loai-cong-viec-dropdown-search').select2('destroy');
        $('#loai-cong-viec-dropdown-search').select2({
            placeholder: "Chọn loại công việc",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,
            width: '100%',
            dropdownParent: $('#themModal'),
        });

    });

    $('#loai-cong-viec-dropdown-search-2').select2();

    $('#thongTinModal').on('shown.bs.modal', function () {
        $('#trang-thai-dropdown-search').select2('destroy');
        $('#trang-thai-dropdown-search').select2({
            placeholder: "Chọn trạng thái",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#thongTinModal '),
        });
        $('#can-bo-dropdown-search').select2('destroy');
        $('#can-bo-dropdown-search').select2({
            placeholder: "Chọn cán bộ",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#thongTinModal '),
        });

        $('#bo-phan-dropdown-search').select2('destroy');
        $('#bo-phan-dropdown-search').select2({
            placeholder: "Chọn bộ phận",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#thongTinModal '),
        });

        $('#cong-viec-dropdown-search').select2('destroy');
        $('#cong-viec-dropdown-search').select2({
            placeholder: "Chọn công việc",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#thongTinModal '),
        });

        $('#cong-viec-dropdown-search-2').select2('destroy');
        $('#cong-viec-dropdown-search-2').select2({
            placeholder: "Chọn công việc",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#thongTinModal'),
        });

        $('#loai-cong-viec-dropdown-search').select2('destroy');
        $('#loai-cong-viec-dropdown-search').select2({
            placeholder: "Chọn loại công việc",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#thongTinModal'),
        });
        $('#loai-cong-viec-dropdown-search-2').select2('destroy');
        $('#loai-cong-viec-dropdown-search-2').select2({
            placeholder: "Chọn loại công việc",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,

            width: '100%',
            dropdownParent: $('#thongTinModal'),
        });
    });


    $('.select2-search__field').attr('placeholder', 'Tìm kiếm...');
});

document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.textContent;

                submitButton.disabled = true;
                submitButton.textContent = "Đang xử lý...";

                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                }, 3000);
            }
        });
    });
});



setTimeout(() => {
    const alertElement = document.getElementById('myAlert');
    if (alertElement) {
        alertElement.remove();
    }
}, 5000);
