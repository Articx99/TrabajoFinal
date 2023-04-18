<!DOCTYPE html>
<html lang="en">

<head>
    <title>TaskLists</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="http://tasklist.localhost:8080/assets/css/style.css" rel="stylesheet">

</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <div class="hedaer">
                    <img src="http://tasklist.localhost:8080/assets/images/logo3.png" width="280" height="auto">
                </div>
                
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="<?php echo base_url() ?>">Home</a>
                    </li>
                   
                    <?php if(isset($_SESSION['admin_panel']) && $_SESSION['admin_panel']  == 'rwd'){ ?>
                        <li>
                            <a href="<?php echo base_url() . "usuarios" ?>">Usuarios</a>
                        </li>
                    <?php }?>
                    <li>
                        <a href="<?php echo base_url() . "etiquetas" ?>">Etiquetas</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() . "borrador" ?>">Borrador</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ."about"?>">Sobre Nosotros</a>
                    </li>
                </ul>

                <div class="footer">
                    <p>
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> All rights reserved

                    </p>
                </div>

            </div>
        </nav>
        <div id="content" class="p-4 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="<?php echo base_url() ?>">Home</a>
                            </li>

                            <li class="nav-item active">
                                <a class="nav-link" href="<?php echo base_url() ?>"><?php echo $_SESSION['username']['username']?></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-red" href="<?php echo base_url().'logout'?>"><i class="bi bi-box-arrow-left"></i>&nbsp;
                                    Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>