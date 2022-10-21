const CustomFormValidation = (inputIds) => {
    for (let id of inputIds) {
        const input = document.getElementById(id);
        if (!input.checkValidity()) {
            return {valid: false, message: `${input.placeholder}: ${input.validationMessage}`};
        }
    }
    return {valid: true, message: ''};
};