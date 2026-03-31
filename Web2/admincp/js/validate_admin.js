document.addEventListener('DOMContentLoaded', function() {
    const inputSL = document.getElementById('nhap_soluong');
    const inputGia = document.getElementById('nhap_gianhap');
    const inputTyle = document.getElementById('nhap_tyle');
    const inputThreshold = document.getElementById('threshold_input');

    function blockNegativeKey(e) {
        if (['-', 'e', 'E', '+'].includes(e.key)) {
            e.preventDefault();
        }
    }

    function handleInput(e) {
        if (this.value < 0) {
            this.value = Math.abs(this.value);
        }
    }

    const numericInputs = [inputSL, inputGia, inputTyle, inputThreshold];
    
    numericInputs.forEach(input => {
        if (input) {
            input.addEventListener('keydown', blockNegativeKey);
            input.addEventListener('input', handleInput);
        }
    });

    const inputsTyleClass = document.querySelectorAll('.nhap_tyle_loinhuan');
    inputsTyleClass.forEach(input => {
        input.addEventListener('keydown', blockNegativeKey);
        input.addEventListener('input', handleInput);
    });

    const allForms = document.querySelectorAll('form');
    allForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let hasError = false;
            let msg = "";

            // Kiểm tra Tỷ lệ lợi nhuận
            const fieldTyle = form.querySelector('#nhap_tyle, .nhap_tyle_loinhuan');
            if (fieldTyle) {
                const val = parseFloat(fieldTyle.value);
                if (isNaN(val) || val < 0) {
                    hasError = true;
                    msg = "Tỷ lệ lợi nhuận không được để trống hoặc là số âm!";
                    fieldTyle.focus();
                }
            }

            const fieldSL = form.querySelector('#nhap_soluong');
            const fieldGia = form.querySelector('#nhap_gianhap');
            if (fieldSL && fieldGia) {
                if (parseInt(fieldSL.value) <= 0) {
                    hasError = true;
                    msg = "Số lượng phải lớn hơn 0!";
                    fieldSL.focus();
                } else if (parseFloat(fieldGia.value) < 0) {
                    hasError = true;
                    msg = "Giá nhập không được là số âm!";
                    fieldGia.focus();
                }
            }

            if (hasError) {
                e.preventDefault();
                alert(msg);
            }
        });
    });
});