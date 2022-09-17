<?php require_once 'system/function.php';
if (isset($_SESSION['admin']) != @sha1(md5(IP() . $_SESSION['id']))) {
  session_destroy();
  go(site . "/login.php");
}

$ayarsor = $db->prepare("SELECT * FROM ayar_tbl WHERE ayar_id=?");
$ayarsor->execute(array(0));
$ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $ayarcek['ayar_title'] ?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= site ?>/assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= site ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= site ?>/assets/css/components.css">
  <link rel="stylesheet" href="<?= site ?>/assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="<?= site ?>/assets/bundles/flag-icon-css/css/flag-icon.min.css">
  <!-- dropzone css -->
  <link rel="stylesheet" href="<?= site ?>/assets/dropzone/dist/dropzone.css">
  <link rel="stylesheet" href="<?= site ?>/assets/dropzone/dist/basic.css">
  <!--Bootstrap-->
  <link rel="stylesheet" href="<?= site ?>/assets/css/bootstrap.min.css">
  <!--favicon-->
  <link rel='shortcut icon' type='image/x-icon' href='<?= site ?>/assets/img/favicon.ico' />
	<!-- sweetalert CSS -->
	<link rel="stylesheet" href="<?= site ?>/assets/css/sweetalert2.min.css">
  <!--datatable-->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css" />

</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i class="fas fa-expand"></i>
              </a>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="<?= site ?>/assets/img/users/avatar.png" class="user-img-radious-style">
              <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Hoşgeldin Admin</div>
              <div class="dropdown-divider"></div>
              <a href="logout.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Çıkış Yap
              </a>
            </div>
          </li>
        </ul>
      </nav>