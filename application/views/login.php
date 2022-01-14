<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GSC-BILLING | Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/theme/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon">

    <link href="<?php echo base_url('assets/theme/vendor/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

</head>

<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a href="#" class="navbar-brand"> Billing</a> 
        <ul class="navbar-nav mr-auto"></ul> 
        <ul>
            <li class="nav-item">
                <a href="http://localhost:8000/login" class="nav-link">Go to Other-Billing</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <form role="form" method="post" action="<?php echo base_url('login'); ?>">
                            <div class="form-group error error-text text-center">
                                    <i><?php echo @$message; ?></i>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" name="username" required autocomplete="email" autofocus class="form-control ">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" name="password" required class="form-control ">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
