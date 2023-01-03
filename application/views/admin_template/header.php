<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?= $name ?> | Admin Panel</title>

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Font Awesome Icons -->
    <link href="<?= base_url() ?>public/plugins/font-icons/fontawesome/css/all.css" rel="stylesheet" type="text/css" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>public/admin/dist/css/adminlte.min.css">
    <script src="<?= base_url() ?>public/assets/js/libs/jquery-3.1.1.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- SEARCH FORM -->
      <div class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Id or Email (eg tungaqhd for tungaqhd@gmail.com)" aria-label="Search" id="user_id">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="button" id="search">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= site_url('/admin') ?>" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?= site_url('admin/overview') ?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Overview</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/users') ?>" class="nav-link">
                <i class="fas fa-users"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/delete_history') ?>" class="nav-link">
                <i class="fas fa-users"></i>
                <p>Delete History</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/settings') ?>" class="nav-link">
                <i class="fas fa-cogs"></i>
                <p>Settings</p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-mouse"></i>
                <p>
                  PTC
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url('admin/ptc') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage Campaigns</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= site_url('admin/option') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage Options</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/links') ?>" class="nav-link">
                <i class="fas fa-link"></i>
                <p>Short Links</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/lottery') ?>" class="nav-link">
                <i class="far fa-star"></i>
                <p>Lottery</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/add') ?>" class="nav-link">
                <i class="fas fa-hand-holding-usd"></i>
                <p>Add money to user</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/withdrawals') ?>" class="nav-link">
                <i class="fas fa-file-invoice-dollar"></i>
                <p>Withdrawals</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/pages') ?>" class="nav-link">
                <i class="far fa-file"></i>
                <p>Page</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/banned') ?>" class="nav-link">
                <i class="fas fa-user-slash"></i>
                <p>Banned</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>