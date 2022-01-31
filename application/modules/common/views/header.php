<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $site_title; ?></title>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo $assets_path; ?>plugins/fontawesome-free/css/all.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="<?php echo $assets_path; ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo $css_path; ?>adminlte.min.css">

        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="<?php echo $assets_path; ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo $assets_path; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="<?php echo $assets_path; ?>plugins/daterangepicker/daterangepicker.css">
        <link href="<?php echo $css_path; ?>bootstrap-toggle.min.css" rel="stylesheet">
  
        <link rel="stylesheet" href="<?php echo $css_path; ?>multiple-select-bootstrap.css">
        <link rel="stylesheet" href="<?php echo $css_path; ?>multiple-select.css">  
        <!-- jQuery -->
        <script src="<?php echo $assets_path; ?>plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo $assets_path; ?>plugins/jquery-ui/jquery-ui.min.js"></script>
        
        <!-- daterangepicker -->
        <script src="<?php echo $assets_path; ?>plugins/moment/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_path; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo $assets_path; ?>plugins/daterangepicker/daterangepicker.js"></script>
        <style type="text/css">
            body {font-size: 0.9rem;}
            .datepicker{
                z-index: 10000 !important;
            }
        </style>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    </head>
    <body class="sidebar-mini control-sidebar-slide-open" style="height: auto;">
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center d-none">
                <img class="animation__shake" src="<?php echo $img_path . 'Logo.png' ?>" alt="AdminLTELogo" height="60" width="60">
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <?php if($this->session->userdata($this->data['sess_code'] . 'profile_picture') !== ''){?>
                                <?php if ($this->session->userdata($this->data['sess_code'] . 'profile_picture') !== '' && $this->session->userdata($this->data['sess_code'] . 'profile_picture') !== NULL && file_exists('./assets/uploads/profile_pictures/' . $this->session->userdata($this->data['sess_code'] . 'profile_picture'))) { ?>
                                    <?php $image_src = site_url('assets/uploads/profile_pictures/' . $this->session->userdata($this->data['sess_code'] . 'profile_picture'));?>
                                    <img src="<?php echo $image_src;?>" class="img-circle mr-2" width="30" alt="User Image">
                                <?php }else{?>
                                    <img src="<?php echo $img_path . 'avatar4.png' ?>" class="img-circle mr-2" width="30" alt="User Image">
                                <?php }?>
                            <?php }else{?>
                                <img src="<?php echo $img_path . 'avatar4.png' ?>" class="img-circle mr-2" width="30" alt="User Image">
                            <?php }?>
                            <?php echo $this->session->userdata($this->data['sess_code'] . 'user_name');?>
                            <i class="fas fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo site_url('logout'); ?>" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Log out
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="<?php echo site_url('dashboard'); ?>" class="brand-link">
                    <img src="<?php echo $img_path . 'Logo.png' ?>" alt="Main Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><?php echo $title;?></span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <?php if($this->session->userdata($this->data['sess_code'] . 'profile_picture') !== ''){?>
                                <?php if ($this->session->userdata($this->data['sess_code'] . 'profile_picture') !== '' && $this->session->userdata($this->data['sess_code'] . 'profile_picture') !== NULL && file_exists('./assets/uploads/profile_pictures/' . $this->session->userdata($this->data['sess_code'] . 'profile_picture'))) { ?>
                                    <?php $image_src = site_url('assets/uploads/profile_pictures/' . $this->session->userdata($this->data['sess_code'] . 'profile_picture'));?>
                                    <img src="<?php echo $image_src;?>" class="img-circle mr-2" width="30" alt="User Image">
                                <?php }else{?>
                                    <img src="<?php echo $img_path . 'avatar4.png' ?>" class="img-circle mr-2" width="30" alt="User Image">
                                <?php }?>
                            <?php }else{?>
                                <img src="<?php echo $img_path . 'avatar4.png' ?>" class="img-circle mr-2" width="30" alt="User Image">
                            <?php }?>
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><?php echo $this->session->userdata($this->data['sess_code'] . 'user_name');?></a>
                        </div>
                    </div>

                    <!------------- Sidebar --------------->
                    <?php echo $this->load->view('sidebar', $this->data, TRUE);?>
                </div>
                <!-- /.sidebar -->
            </aside>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0"><?php echo ucfirst(strtolower(str_replace("_"," ",$controller)));?></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo site_url() . $controller; ?>"><?php echo ucfirst(strtolower(str_replace("_"," ",$controller)));?></a></li>
                                <li class="breadcrumb-item active"><?php echo ucfirst(strtolower(str_replace("_"," ",$method)));?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">