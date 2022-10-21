<!doctype html>
<html lang="en">
<head>
  <title>{$title}</title>

  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="apple-touch-icon" sizes="76x76" href="{$baseUrl}/views/images/logo-dark.png{$cache}">
  <link rel="icon" type="image/png" href="{$baseUrl}/views/images/favicon.png{$cache}">

  <style>
    .slide-element-1 {
      background-image: url("{$baseUrl}/views/templates/auth/assets/images/banner-1.jpg{$cache}");
    }

    .slide-element-2 {
      background-image: url("{$baseUrl}/views/templates/auth/assets/images/banner-2.jpg{$cache}");
    }

    .slide-element-3 {
      background-image: url("{$baseUrl}/views/templates/auth/assets/images/banner-3.jpg{$cache}");
    }
  </style>

  <link href="{$baseUrl}/views/templates/auth/assets/css/bootstrap.css{$cache}" rel="stylesheet"/>

  <link href="{$baseUrl}/views/templates/auth/assets/css/login-register.css{$cache}" rel="stylesheet"/>
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

  <script src="{$baseUrl}/views/templates/auth/assets/js/jquery-1.10.2.js{$cache}" type="text/javascript"></script>
  <script src="{$baseUrl}/views/templates/auth/assets/js/bootstrap.js{$cache}" type="text/javascript"></script>
  <script src="{$baseUrl}/views/templates/auth/assets/js/login-register.js{$cache}" type="text/javascript"></script>

</head>
<body>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <div class="slide-element slide-element-1"></div>
    </div>
    <div class="item">
      <div class="slide-element slide-element-2"></div>
    </div>
    <div class="item">
      <div class="slide-element slide-element-3"></div>
    </div>
  </div>
</div>

<div class="container">
  <div class="logo-con">
    <img src="{$baseUrl}/views/images/logo-dark.png{$cache}" height="50" alt="..."/>
  </div>
  <div class="modal fade login" id="loginModal"
       style="display: flex; align-items: center; justify-content: flex-end;">
    <div class="modal-dialog login animated" style="margin: 0">
      <div class="modal-content">
        <div class="modal-header">
            {*                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>*}
          <h4 class="modal-title">User Authentication</h4>
        </div>
        <div class="modal-body">
          <div class="box">
            <div class="content">
              <div class="division">
                <div class="line l"></div>
                <span class="auth-title">Login</span>
                <div class="line r"></div>
              </div>
              <div class="error"></div>
              <div class="form loginBox">
                <form id="login-form" accept-charset="UTF-8">
                  <input id="login-email" required="required" class="form-control" type="email"
                         placeholder="Email" name="email">
                  <input id="login-password" required="required" minlength="6" class="form-control"
                         type="password" placeholder="Password"
                         name="password">
                  <input class="btn btn-default btn-login" type="button" value="Login"
                         onclick="loginAction('{$rootUrl}/auth/login')">
                </form>
              </div>
            </div>
          </div>

          <div class="box">
            <div class="content registerBox" style="display:none;">
              <div class="form">
                <form id="reg-form" data-remote="true" accept-charset="UTF-8">
                  <input id="reg-email" required="required" class="form-control" type="email"
                         placeholder="Email" name="email">
                  <input id="reg-password" required="required" minlength="6" class="form-control"
                         type="password" placeholder="Password"
                         name="password">
                  <input id="reg-password_conf" required="required" minlength="6" class="form-control"
                         type="password"
                         placeholder="Repeat Password" name="password_confirmation">
                  <input class="btn btn-default btn-register" type="button" value="Create account"
                         onclick="registerAction('{$rootUrl}/auth/register')">
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="forgot login-footer">
{*            <span>Looking to*}
{*                 <a href="javascript: showRegisterForm();">create an account</a>*}
{*            ?</span>*}
              <span>Registered users only!</span>
          </div>
          <div class="forgot register-footer" style="display:none">
            <span>Already have an account?</span>
            <a href="javascript: showLoginForm();">Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        openLoginModal();
    });
</script>


</body>
</html>
