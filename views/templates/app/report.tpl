<!DOCTYPE html>
<html lang="en">

<head>
    {include file='./components/common/head.tpl'}
    <style>
        .report-table {
            border-radius: 10px 10px 0 0;
            overflow: hidden;
            width: 100%;
            margin: 1em auto 0;
        }

        table {
            margin: 0;
            border: 1px solid  black;
        }

        table > tbody > tr > td {
            padding: 4px 0 4px 8px !important;
        }

        table > thead > tr > th {
            padding: 8px 0 8px 8px !important;
        }
    </style>
</head>

<body class="">
<div class="wrapper bg-white" style="height: unset;">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="report-table row bg-dark border border-dark">
                        <div class="col-3">
                            <p class="text-left mt-4 d-print-block d-none">
                                <small>From: {$params['from']|date_format}</small>
                            </p>
                            <p class="text-left mt-4 text-white d-print-none">
                                <small>From: {$params['from']|date_format}</small>
                            </p>
                        </div>
                        <div class="col-6">
                            <h3 class="title text-center d-print-block d-none">{$params['title']}</h3>
                            <h3 class="title text-center text-white d-print-none">{$params['title']}</h3>
                        </div>
                        <div class="col-3">
                            <p class="text-right mt-4 d-print-block d-none">
                                <small>To: {$params['to']|date_format}</small>
                            </p>
                            <p class="text-right mt-4 text-white d-print-none">
                                <small>To: {$params['to']|date_format}</small>
                            </p>
                        </div>
                    </div>
                    <table class="table table-hover table-striped table-shopping bg-white border-top border-dark">
                        <thead class="text-dark">
                        <tr>
                            <th class="font-weight-bold">#</th>
                            {foreach $headers as $head}
                                <th class="font-weight-bold">{$head}</th>
                            {/foreach}
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $data as $key => $row}
                            <tr>
                                <td>{$key + 1}</td>
                                {foreach array_keys($headers) as $index}
                                    <td>{$row[$index]}</td>
                                {/foreach}
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{*  Fixed Plugin Template here *}
<!--   Core JS Files   -->
{include file="./components/common/foot.tpl"}
<!-- End Core JS Files -->
</body>

</html>
