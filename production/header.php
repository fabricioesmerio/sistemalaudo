<?php
session_start();
require_once '../Config/functions.php';

verificaSessao();

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="shortcut icon" href="../img/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laudos... </title>

        <!-- Bootstrap -->
        <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- jQuery custom content scroller -->
        <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

        <!-- Custom Theme Style -->
        <link href="../build/css/custom.min.css" rel="stylesheet">
        <link href="../build/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css"/>
        <!-- DATATABLE CSS-->
        <!-- <link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/> -->
        <link href="//datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />

        <link href="../build/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../build/css/default.min.css" rel="stylesheet" type="text/css"/>
        <!-- Adicionando JQuery -->
        <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script> -->
        <link href="../build/css/print.css" rel="stylesheet" type="text/css" media="print"/>

        <script src="../build/js/sceditor.min.js" type="text/javascript"></script>
        <script src="../build/js/icons/monocons.js" type="text/javascript"></script>
        <script src="../build/js/formats/bbcode.js" type="text/javascript"></script>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="index.php" class="site_title"> <span>Logo</span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">

                            <div class="profile_info">
                                <span>Bem-vindo,</span>
                                <h2><?= $_SESSION['login']; ?></h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->
                       