<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php if (isset($toko->logo_toko)) { ?> 
  <link href="<?php echo base_url('assets/') ?>img/profil/<?php echo $toko->logo_toko ?>" rel="icon">
  <?php } ?>
  <title><?php echo $title ?> | POS</title>
  <link href="<?php echo base_url('assets/') ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/') ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/') ?>vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/') ?>vendors/animate.css/animate.min.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/') ?>build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login" style="background-image:url('<?= base_url() ?>assets/img/3330919584.jpg');background-size:cover;";>
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>
    <div class="login_wrapper">