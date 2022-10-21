<!DOCTYPE html>
<html lang="en">

<head>
    {include file='./components/common/head.tpl'}
</head>

<body class="">
<div class="wrapper ">
    <!-- Sidebar -->
    {include file='./components/common/sidebar.tpl'}
    <!-- End Sidebar -->
    <div class="main-panel">
        <!-- Navbar -->
        {include file='./components/common/navbar.tpl'}
        <!-- End Navbar -->
        <!-- Page Content -->
        {include file="./pages/{$page}.tpl"}
        <!-- End Page Content -->
        <!-- Footer -->
        {include file="./components/common/footer.tpl"}
        <!-- End Footer -->
    </div>
</div>
{*  Fixed Plugin Template here *}
<!--   Core JS Files   -->
{include file="./components/common/foot.tpl"}
<!-- End Core JS Files -->
</body>

</html>