<script src="{$baseUrl}/views/templates/app/assets/js/core/jquery.min.js{$cache}"></script>
<script src="{$baseUrl}/views/templates/app/assets/js/core/popper.min.js{$cache}"></script>
<script src="{$baseUrl}/views/templates/app/assets/js/core/bootstrap-material-design.min.js{$cache}"></script>
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/perfect-scrollbar.jquery.min.js{$cache}"></script>
<!-- Plugin for the momentJs  -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/moment.min.js{$cache}"></script>
<!-- Forms Validations Plugin -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/jquery.validate.min.js{$cache}"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/jquery.bootstrap-wizard.js{$cache}"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/bootstrap-selectpicker.js{$cache}"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/bootstrap-datetimepicker.min.js{$cache}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/jquery.dataTables.min.js{$cache}"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/bootstrap-tagsinput.js{$cache}"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/jasny-bootstrap.min.js{$cache}"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/fullcalendar.min.js{$cache}"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/jquery-jvectormap.js{$cache}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/nouislider.min.js{$cache}"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/arrive.min.js{$cache}"></script>
<!-- Chartist JS -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/chartist.min.js{$cache}"></script>
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/chartist-tooltips.min.js{$cache}"></script>
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/chartist-pointlabels.min.js{$cache}"></script>
<!--  Notifications Plugin    -->
<script src="{$baseUrl}/views/templates/app/assets/js/plugins/bootstrap-notify.js{$cache}"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{$baseUrl}/views/templates/app/assets/js/material-dashboard.js{$cache}" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
{*<script src="{$baseUrl}/views/templates/app/assets/demo/demo.js{$cache}"></script>*}
{*<script src="{$baseUrl}/views/templates/app/assets/js/fixed_plugin.tpl.js{$cache}"></script>*}
<script>
    $(document).ready(function () {
        // Javascript method's body can be found in assets/js/demos.js
        new Api(`{$rootUrl}/app/chart`, 'POST')
            .then(data => {
                if (data.success) {
                    md.initDashboardPageCharts(data.data.income, data.data.expenses);
                } else {
                    new Alert().toast('Error: Loading Charts', 'error');
                }
            })
            .catch(reason => new Alert().toast(reason, 'error'));
    });
</script>