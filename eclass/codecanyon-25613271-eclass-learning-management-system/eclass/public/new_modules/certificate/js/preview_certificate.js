"use Strict";

$('body').on('change', 'input[data-toggle="itemCheckBox"]', function () {
    if ($(this).is(":checked")) {
        window.location.href = "{{ route('setting.certificate',1)}}";
    } else {
        window.location.href = "{{ route('setting.certificate',0)}}";
    }
});