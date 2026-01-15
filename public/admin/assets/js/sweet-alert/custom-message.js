/**
 * =====================
 * SweetAlert Utility
 * =====================
 */

window.AppAlert = {

    success(message, title = "Success") {
        swal({
            title: title,
            text: message, 
            icon: "success",
            button: "OK",
        });
    },

    error(message, title = "Error") {
    swal({
        title: title,
        content: {
            element: "div",
            attributes: {
                innerHTML: message   // 🔥 allows HTML
            }
        },
        icon: "error",
        button: "OK",
    });
},

    info(message, title = "Info") {
        swal({
            title: title,
            text: message,
            icon: "info",
            button: "OK",
        });
    },

    warning(message, title = "Warning") {
        swal({
            title: title,
            text: message,
            icon: "warning",
            button: "OK",
        });
    },

    confirm(options = {}) {
        return swal({
            title: options.title || "Are you sure?",
            text: options.text || "This action cannot be undone.",
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: options.confirmText || "Yes, proceed",
                    value: true,
                },
            },
            dangerMode: true,
        });
    },

    autoClose(message, icon = "success", time = 3000) {
        swal({
            text: message,
            icon: icon,
            buttons: false,
            timer: time,
        });
    }
};
