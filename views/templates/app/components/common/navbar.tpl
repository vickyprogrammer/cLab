<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:void(0);">{$title}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <button class="btn btn-info btn-round dropdown-toggle" href="javascript:void(0);" id="navbarDropdownProfile" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false" style="text-transform: none;">
                        <i class="material-icons">account_circle</i> {$account_name}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="{$baseUrl}/app/user">
                            <i class="material-icons mr-3">person</i> Profile
                        </a>
{*                        <a class="dropdown-item" href="#">*}
{*                            <i class="material-icons mr-3">settings</i> Settings*}
{*                        </a>*}
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{$baseUrl}/auth/logout">
                            <i class="material-icons mr-3">power_settings_new</i> Log out
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>