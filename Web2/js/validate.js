document.addEventListener('DOMContentLoaded', function() {
    const nameRegex = /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/;
    const phoneRegex = /^[0-9]{10}$/;
    const addressRegex = /^[a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s,.\-\/]+$/;

    function bindValidation(inputId, regex, errorId, isPhone = false) {
        const input = document.getElementById(inputId);
        const error = document.getElementById(errorId);
        if (!input || !error) return;

        input.addEventListener('input', function() {
            if (isPhone) this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value !== "" && !regex.test(this.value)) {
                error.style.display = 'block';
                this.style.borderColor = 'red';
            } else {
                error.style.display = 'none';
                this.style.borderColor = '';
            }
        });
    }

    bindValidation('hovaten', nameRegex, 'name-error');
    bindValidation('dienthoai', phoneRegex, 'phone-error', true);
    bindValidation('diachi', addressRegex, 'address-error');
    bindValidation('shipping_name', nameRegex, 'error-name');
    bindValidation('shipping_phone', phoneRegex, 'error-phone', true);
    bindValidation('shipping_address', addressRegex, 'error-address');

    const allForms = document.querySelectorAll('form');
    allForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const n = form.querySelector('#hovaten, #shipping_name');
            const p = form.querySelector('#dienthoai, #shipping_phone');
            const a = form.querySelector('#diachi, #shipping_address');

            let hasError = false;
            if (n && !nameRegex.test(n.value)) hasError = true;
            if (p && !phoneRegex.test(p.value)) hasError = true;
            if (a && !addressRegex.test(a.value)) hasError = true;

            if (hasError) {
                e.preventDefault();
                e.stopPropagation();
                alert('Vui lòng kiểm tra lại các thông tin nhập sai');
            }
        });
    });
});