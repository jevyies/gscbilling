<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GSC Billing</title>
    <!-- <meta fragment="" content="!" /> -->
    <base href="<?php echo base_url(); ?>">

    <!-- Bootstrap Core CSS -->
    <link href="<?php  echo base_url('assets/theme/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- <link href="<?php  //echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet"> -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/logo.png'); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('assets/images/logo.png'); ?>" type="image/x-icon">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url('assets/theme/vendor/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/css/app.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/animate.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/vendors/angular-toastr/dist/angular-toastr.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-datepicker.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/ui-grid.min.css'); ?>" rel="stylesheet" />
    
</head>

<body ng-app="app" class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div class="loading-screen" id="loading-screen">
        <div class="flex-column">
            <div class="loading-gif">
                <img src="<?php echo base_url('assets/images/logo.png'); ?>" />
            </div>
            <div class="loading-text">
                <span style="--i:1">L</span>
                <span style="--i:2">o</span>
                <span style="--i:3">a</span>
                <span style="--i:4">d</span>
                <span style="--i:5">i</span>
                <span style="--i:6">n</span>
                <span style="--i:7">g</span>
                <span style="--i:8">.</span>
                <span style="--i:9">.</span>
                <span style="--i:10">.</span>
            </div>
        </div>
    </div>
    <ui-view></ui-view>
    <!-- /#wrapper -->
    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
    <input type="hidden" id="app_url" value="<?php echo base_url('ngapp/'); ?>">
    <input type="hidden" id="version" value="0.20201223">
    <script src="<?php echo base_url('assets/vendors/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/jquery-ui/jquery-ui.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular/angular.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/ng-idle/angular-idle.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/node_modules/angular-datatables/dist/angular-datatables.min.js'); ?>"></script>
    <script src="<?php  echo base_url('assets/theme/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php  echo base_url('assets/js/datepicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/mdb/js/mdb.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/ngMask/dist/ngMask.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-router/release/angular-ui-router.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/oclazyload/dist/ocLazyLoad.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-animate/angular-animate.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-sanitize/angular-sanitize.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui/angular-ui.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-loading-bar/build/loading-bar.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/angular-aria.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/pdfmake/build/pdfmake.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/pdfmake/build/vfs_fonts.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/lodash/dist/lodash.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/jszip/dist/jszip.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/excel-builder-js/dist/excel-builder.dist.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/angular-toastr/dist/angular-toastr.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/angular-toastr/dist/angular-toastr.tpls.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/ui-grid.core.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/ui-grid.exporter.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/ui-grid.pinning.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/ui-grid.cellnav.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/ui-grid.selection.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/ui-grid.resize-columns.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/angular-ui-grid/ui-grid.move-columns.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/bower_components/sheetjs-master/dist/xlsx.full.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/textangular/dist/textAngular.min.js'); ?>"></script>
    
    <!-- app -->
    <script src="<?php  echo base_url('ngapp/app.module.js'); ?>"></script>
    <script src="<?php  echo base_url('ngapp/app.routes.js'); ?>"></script>
    <script src="<?php  echo base_url('ngapp/app.controller.js'); ?>"></script>
    <script src="<?php  echo base_url('ngapp/common/http.service.js'); ?>"></script>
    <script src="<?php  echo base_url('ngapp/common/directives.js'); ?>"></script>
    <script src="<?php  echo base_url('ngapp/common/right_click.js'); ?>"></script>
    <script src="<?php  echo base_url('ngapp/app.service.js'); ?>"></script>
    <script src="<?php  echo base_url('ngapp/auth/auth.js'); ?>"></script>

</body>

</html>
