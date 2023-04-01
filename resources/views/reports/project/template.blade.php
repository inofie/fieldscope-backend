<?php
/**
 * Created by PhpStorm.
 * User: dnasir
 * Date: 7/9/2019
 * Time: 12:11 PM
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style type="text/css">

        @page {
            background-image: url('{{ public_path("image/bg.png") }}') center center no-repeat;
            /*-webkit-background-size: cover;*/
            background-image-resize: 6;
            margin: 0%;
            size: auto;
            background: url('{{ public_path("images/bg.png") }}') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;

        }

        @font-face {
            font-family: AxiformaRegular;
            src: url('{{ base_path('public/font/Axiforma/Kastelov-AxiformaRegular.otf') }}');
        }

        @font-face {
            font-family: AxiformaBold;
            src: url('{{ base_path('public/font/Axiforma/Kastelov-AxiformaBold.otf') }}');
        }

        table {
            page-break-inside: auto
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-footer-group
        }

        .page-break {
            page-break-after: always;
        }

        /*@page {*/
            /*background: url('/home/retrocubedev/public_html/qa/field_scope/public/assets/images/pdf-bg.png') no-repeat 0 0;*/
            /*background-image-resize: 6;*/
        /*}*/
    </style>
</head>
<body>
@include('reports.project.header')

@include('reports.project.images_bk')
</body>
</html>