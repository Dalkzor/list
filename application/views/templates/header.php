<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery-cookie -->
    <script src="<?php echo base_url(); ?>plugins/jQueryCookie/jquery.cookie.js"></script>
    <!-- jQuery-ui CSS -->
    <link href="<?php echo base_url(); ?>plugins/jQueryUI/jquery-ui.min.css" rel="stylesheet">
    <!-- Chosen CSS -->
    <link href="<?php echo base_url(); ?>plugins/chosen/chosen.min.css" rel="stylesheet">
    <!-- jQuery UI 1.12.1 -->
    <script src="<?php echo base_url(); ?>plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Chosen -->
    <script type="text/javascript" src="<?php echo base_url(); ?>/plugins/chosen/chosen.jquery.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/plugins/datatables/dataTables.bootstrap4.css">
    <script src="<?php echo base_url(); ?>/plugins/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>/plugins/datatables/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- InputMask -->
    <script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.js"></script>
    <!-- MyCode -->
    <script src="<?php echo base_url(); ?>dist/js/scripts.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/style.css">
</head>
<body class="hold-transition <?php echo $body_param; echo isset($_COOKIE['sidebar'])?' '.$_COOKIE['sidebar']:'' ?>">
  <div class="wrapper">