$(document).ready(function () {
    $(document).on('select2:open', function () {
        $('.select2-search__field').attr('placeholder', 'Nhập để tìm kiếm'); // Set the placeholder
    });

    $('#trang-thai-dropdown-search').select2();
    $('#bo-phan-dropdown-search').select2();

    $('#thongTinModal ').on('shown.bs.modal', function () {
        $('#trang-thai-dropdown-search').select2('destroy');
        $('#trang-thai-dropdown-search').select2({
            placeholder: "Chọn trạng thái",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $('#thongTinModal .modal-body'),
        });

        $('#bo-phan-dropdown-search').select2('destroy');
        $('#bo-phan-dropdown-search').select2({
            placeholder: "Chọn bộ phận",
            allowClear: true,
            language: "vi",
            minimumInputLength: 0,
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $('#thongTinModal .modal-body'),
        });


    });

    $('.select2-search__field').attr('placeholder', 'Tìm kiếm...');
});

$(document).ready(function () {
    $('#can-bo-dropdown-search').select2({
        placeholder: "Chọn công chức",
        allowClear: true,
    });
});


document.addEventListener("DOMContentLoaded", function () {
    // Select all forms on the page
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            // Find the submit button within the form
            const submitButton = form.querySelector('button[type="submit"]');

            if (submitButton) {
                // Save the original button text
                const originalText = submitButton.textContent;

                // Disable the button to prevent multiple submissions
                submitButton.disabled = true;
                submitButton.textContent = "Đang xử lý..."; // Feedback for users

                // Re-enable the button and restore its text after 3 seconds
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalText; // Restore the original text
                }, 3000); // 3000ms = 3 seconds
            }
        });
    });
});



setTimeout(() => {
    const alertElement = document.getElementById('myAlert');
    if (alertElement) { // Ensure the element exists before attempting to remove it
        alertElement.remove();
    }
}, 5000);
