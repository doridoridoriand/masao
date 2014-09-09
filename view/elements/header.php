<?php
// header.php
require('./helpers/navigationHelper.php');
echo '
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>MASAO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NUDE">
    <meta name="author" content="doridoridoriand">

    <link href="./assets/bootstrap-3.2.0-dist/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/style.css" rel="stylesheet">
    <link href="./assets/pygments-manni.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-botton: 40px;
      }
    </style>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="html5shiv/src/html5shiv.js"></script>
    <![endif]-->
  </head>
  <div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-nabvar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-brand">MASAO</div>
      </div>
      <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
        <ul class="nav navbar-nav">';
        $navigationHelper->navigate();
        echo '
        </ul>
      </nav>
    </div>
  </div>';
