class Alert {
    /**
     * Return the required icon and color
     * @param {string} type warning, error, success, info, and question
     * @returns {{icon: string, confirmButtonClass: string}}
     * @private
     * @method
     */
    _buildAlertType(type) {
        switch (type) {
            case 'success':
                return {icon: 'success', confirmButtonClass: 'btn btn-success'};
            case 'error':
                return {icon: 'error', confirmButtonClass: 'btn btn-danger'};
            case 'warning':
                return {icon: 'warning', confirmButtonClass: 'btn btn-warning'};
            case 'info':
                return {icon: 'info', confirmButtonClass: 'btn btn-info'};
            case 'question':
                return {icon: 'question', confirmButtonClass: 'btn btn-primary'};
            default:
                return {icon: 'info', confirmButtonClass: 'btn btn-info'};
        }
    }

    /**
     * Create and display a toast
     * @param {string} msg the message to display in the toast
     * @param {string} type warning, error, success, info, and question
     * @method
     */
    toast(msg, type) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        const option = Object.assign({
            icon: 'info',
            title: msg,
        }, this._buildAlertType(type));

        return Toast.fire(option);
    }

    /**
     * Create and display a notification
     * @param {string} title notification title
     * @param {string} message notification message
     * @param {string} type warning, error, success, info, and question
     * @return {Promise<void>}
     * @method
     */
    notify(title, message, type) {
        const option = Object.assign({
            title,
            backdrop: false,
            text: message,
            buttonsStyling: false,
            allowOutsideClick: false,
        }, this._buildAlertType(type));

        return Swal.fire(option);
    }

    /**
     * Show validation message
     * @param {string} msg
     */
    validation(msg) {
        Swal.showValidationMessage(msg);
    }

    /**
     * Display a dialog with form
     * @param {string} title
     * @param {string} body
     * @param {string} buttonText
     * @param {function: Promise<Response>} onConfirm
     * @param {string} type
     * @param {boolean} showButton
     * @returns {Promise<void>}
     * @method
     */
    dialogWizard(title, body, buttonText, onConfirm, type = 'info', showButton = true) {
        const button = this._buildAlertType(type);
        return Swal.fire({
            title,
            html: body,
            focusConfirm: false,
            showLoaderOnConfirm: true,
            showCancelButton: true,
            showConfirmButton: showButton,
            confirmButtonText: buttonText,
            preConfirm: onConfirm,
            confirmButtonClass: button.confirmButtonClass,
            cancelButtonClass: 'btn btn-default',
            buttonsStyling: false,
        })
    }
}