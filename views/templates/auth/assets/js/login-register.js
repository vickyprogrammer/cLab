/*
 *
 * auth-register modal
 * Autor: Creative Tim
 * Web-autor: creative.tim
 * Web script: http://creative-tim.com
 * 
 */
function showRegisterForm(){
    $('.loginBox').fadeOut('fast',function(){
        $('.login-footer').hide();
        $('.register-footer').show();
        $('.registerBox').fadeIn('fast');
        $('.auth-footer').fadeOut('fast',function(){
            $('.register-footer').fadeIn('fast');
        });
        $('.auth-title').html('Register');
    }); 
    $('.error').removeClass('alert alert-danger').html('');
       
}
function showLoginForm(){
    $('#loginModal .registerBox').fadeOut('fast',function(){
        $('.login-footer').show();
        $('.register-footer').hide();
        $('.loginBox').fadeIn('fast');
        $('.register-footer').fadeOut('fast',function(){
            $('.auth-footer').fadeIn('fast');
        });
        $('.auth-title').html('Login');
    });       
     $('.error').removeClass('alert alert-danger').html(''); 
}

const modalOptions = {
    backdrop: false,
    keyboard: false,
    show: true,
};

function openLoginModal(){
    showLoginForm();
    setTimeout(function(){
        $('#loginModal').modal(modalOptions);
    }, 230);
    
}
function openRegisterModal(){
    showRegisterForm();
    setTimeout(function(){
        $('#loginModal').modal(modalOptions);
    }, 230);
    
}

function loginAction(url) {
    const form = $('#login-form')[0];
    const email = form[0];
    const pass = form[1];

    if (!email.validity.valid) {
        shakeModal('Email: ' + email.validationMessage);
    } else if (!pass.validity.valid) {
        shakeModal('Password: ' + pass.validationMessage);
    } else {
        const body = {
            email: email.value,
            password: pass.value,
        };
        loginAjax(url, body, data => {
            if (data.success) {
                location.assign('./app');
            } else {
                shakeModal(data.message);
            }
        });
    }
}

function registerAction(url) {
    const form = $('#reg-form')[0];
    const email = form[0];
    const pass = form[1];
    const pass_conf = form[2];

    if (!email.validity.valid) {
        shakeModal('Email: ' + email.validationMessage);
    } else if (!pass.validity.valid) {
        shakeModal('Password: ' + pass.validationMessage);
    } else if (!pass_conf.validity.valid) {
        shakeModal('Repeat Password: ' + pass_conf.validationMessage);
    } else if (pass.value !== pass_conf.value) {
        shakeModal('Passwords not matching')
    } else {
        const body = {
            email: email.value,
            password: pass.value,
        };
        loginAjax(url, body, data => {
            if (data.success) {
                location.assign('./app');
            } else {
                shakeModal(data.message);
            }
        });
    }
}

function loginAjax(url, data, cb){
    $.post(url, data, cb);
}

function shakeModal(error){
    $('#loginModal .modal-dialog').addClass('shake');
             $('.error').addClass('alert alert-danger').html(error);
             $('input[type="password"]').val('');
             setTimeout( function(){ 
                $('#loginModal .modal-dialog').removeClass('shake'); 
    }, 1000 ); 
}

   