{$sidebar=[1, 2, 3, 4]}
<div class="sidebar" data-color="azure" data-background-color="black" data-image="{$baseUrl}/views/templates/app/assets/img/sidebar-{$sidebar[array_rand($sidebar)]}.jpg{$cache}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <a href="{$baseUrl}/app" class="simple-text logo-normal">
            <img src="{$baseUrl}/views/images/logo.png{$cache}" height="50" alt="..."/>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {if $page eq 'dashboard'}active{/if}">
                <a class="nav-link" href="{$baseUrl}/app/dashboard">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item {if $page eq 'categories'}active{/if}">
                <a class="nav-link" href="{$baseUrl}/app/categories">
                    <i class="material-icons">category</i>
                    <p>Categories</p>
                </a>
            </li>
            <li class="nav-item {if $page eq 'products'}active{/if}">
                <a class="nav-link" href="{$baseUrl}/app/products">
                    <i class="material-icons">shopping_basket</i>
                    <p>Products</p>
                </a>
            </li>
            <li class="nav-item {if $page eq 'suppliers'}active{/if}">
                <a class="nav-link" href="{$baseUrl}/app/suppliers">
                    <i class="material-icons">group</i>
                    <p>Suppliers</p>
                </a>
            </li>
            <li class="nav-item {if $page eq 'supplies'}active{/if}">
                <a class="nav-link" href="{$baseUrl}/app/supplies">
                    <i class="material-icons">local_shipping</i>
                    <p>Supplies</p>
                </a>
            </li>
          <li class="nav-item {if $page eq 'orders'}active{/if}">
            <a class="nav-link" href="{$baseUrl}/app/orders">
              <i class="material-icons">shopping_cart</i>
              <p>Orders</p>
            </a>
          </li>
            {if $data.user->role eq 1}
              <li class="nav-item {if $page eq 'accounts'}active{/if}">
                <a class="nav-link" href="{$baseUrl}/app/accounts">
                  <i class="material-icons">supervised_user_circle</i>
                  <p>Accounts</p>
                </a>
              </li>
            {/if}
            <li class="nav-item {if $page eq 'user'}active{/if}">
                <a class="nav-link" href="{$baseUrl}/app/user">
                    <i class="material-icons">person</i>
                    <p>User Profile</p>
                </a>
            </li>
            <li class="nav-item {if $page eq 'logout'}active{/if}">
                <a class="nav-link" href="{$baseUrl}/auth/logout">
                    <i class="material-icons">power_settings_new</i>
                    <p>Log Out</p>
                </a>
            </li>
        </ul>
    </div>
</div>