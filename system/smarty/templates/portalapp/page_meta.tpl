<!DOCTYPE html>
<html lang="en-us">
<head>
    <title>Boom Health</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="icon" type="image/png" href="{$URL_ASSETS}/images/favicon.png">

    {if $PRODUCTION eq FALSE}
        <link rel="stylesheet" href="{$URL_ASSETS}/css/normalize.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/header.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/buttons.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/animate.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/icomoon.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/selectboxes/cs-select.css?v={$NOCACHE}" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/selectboxes/cs-skin-border.css?v={$NOCACHE}" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/fonts.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/font-awesome.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/checkbox.css?v={$NOCACHE}" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/login.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/simple-sidebar.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/administration.css?v={$NOCACHE}" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/calendar.css?v={$NOCACHE}" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/jquery.timepicker.css?v={$NOCACHE}" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/bootstrap-datepicker.css?v={$NOCACHE}" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/styles.css?v={$NOCACHE}" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/droparea.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/jquery-ui.css" type="text/css" />
        <link rel="stylesheet" href="{$URL_ASSETS}/css/toast.css" type="text/css" />
        <link href=https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/dataTables.bootstrap.min.css rel=stylesheet />
    {else}{/if}

    <script type="text/javascript" src="{$URL_ASSETS}/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/jquery.form.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/jquery.sheepItPlugin-1.1.1.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/classie.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/selectFx2.js"></script>
    {* <script type="text/javascript" src="{$URL_ASSETS}/js/notify.js"></script> *}
    <script type="text/javascript" src="{$URL_ASSETS}/js/toast.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/spin.min.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/droparea.min.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/jquery-ui.js"></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/dataTables.bootstrap.min.js></script>

    <script type="text/javascript" src="{$URL_ASSETS}/js/adminstration.js?v={$NOCACHE}"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/app.js"></script>
    
    
    <!--<script type="text/javascript" src="{$URL_ASSETS}/js/login.js"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/admin.js?v={$NOCACHE}"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/popups-schedules.js?v={$NOCACHE}"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/adminstration.js?v={$NOCACHE}"></script>
    <script type="text/javascript" src="{$URL_ASSETS}/js/popups.js?v={$NOCACHE}"></script>-->
    <script type="text/javascript" src="{$URL_ASSETS}/js/sidebar_menu.js"></script>
</head>
<body>
