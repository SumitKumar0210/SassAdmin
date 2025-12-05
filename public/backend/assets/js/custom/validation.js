function validateField(fieldId, type, errorClass) {
    let value = $(fieldId).val();
    let field = $(fieldId); // Get the id from the jQuery object
    let field_ID = $(fieldId).attr('id'); // Get the id from the jQuery object
    let error = $(errorClass);
    let label = document.querySelector(`label[for="${field_ID}"]`); // Use the id
    let field_txt ='';
    if(label){
      field_txt = label.textContent; // Corrected property name
    }else{
        field_txt = ''; // Corrected property name
    }
    if (value === "") {
        field.focus();
        field.removeClass("dark-only");
        field.addClass("is_field_invalid");
        error.html(field_txt + " is required").addClass("is_invalid");
        return false;
    } else {
        if (type === "mobile") {
            let isValid = /^[0-9]{10}$/.test(value);
            if (!isValid) {
                field.addClass("is_field_invalid");
                error.text("Must be 10 digits").addClass("is_invalid");
                return false;
            } else {
                field.removeClass("is_field_invalid");
                error.html("");
                return true;
            }
        } else if (type === "select") {
            if (value !== "") {
                field.removeClass("is_field_invalid");
                error.text("");
                return true;
            } else {
                field.addClass("is_field_invalid");
                error.text("This field is required").addClass("is_invalid");
                return false;
            }
        } else if (type === "email") {
            let isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            if (!isValid) {
                field.addClass("is_field_invalid");
                error.text("Invalid email format").addClass("is_invalid");
                return false;
            } else {
                field.removeClass("is_field_invalid");
                error.html("");
                return true;
            }
        } else if (type === "pin") {
            let isValid = /^[0-9]{6}$/.test(value);
            if (!isValid) {
                field.addClass("is_field_invalid");
                error.text("Must be 6 digits").addClass("is_invalid");
                return false;
            } else {
                field.removeClass("is_field_invalid");
                error.html("");
                return true;
            }
        } else if (type === "amount") {
            if (value !== undefined && value !== null) {
                let valueLength = value.length;
                if (valueLength < 1) {
                    field.addClass("is_field_invalid");
                    error.text("Input Minimum 1 digit").addClass("is_invalid");
                    return false;
                }else if(value <= 0){
                    field.addClass("is_field_invalid");
                    error.text("Amount Should be greater then 0").addClass("is_invalid");
                    return false;
                } else {
                    field.removeClass("is_field_invalid");
                    error.html("");
                    return true;
                }
            }
        } else {
            if (value !== undefined && value !== null) {
                let valueLength = value.length;
                if (valueLength < 3) {
                    field.addClass("is_field_invalid");
                    error.text("Input Minimum 3 characters").addClass("is_invalid");
                    return false;
                } else {
                    field.removeClass("is_field_invalid");
                    error.html("");
                    return true;
                }
            }
        }
    }
}