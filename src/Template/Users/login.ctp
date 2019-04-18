<?php $this->layout = false;?>
<!DOCTYPE html>
<html class="fixed">
    <head>

        <!-- Basic -->
        <meta charset="UTF-8">

        <meta name="keywords" content="HTML5 Admin Template" />
        <meta name="description" content="Porto Admin - Responsive HTML5 Template">
        <meta name="author" content="okler.net">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Web Fonts  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <?php echo $this->Html->css('/vendor/bootstrap/css/bootstrap.css'); ?>
        <?php echo $this->Html->css('/vendor/font-awesome/css/font-awesome.css'); ?>
        <?php echo $this->Html->css('/vendor/magnific-popup/magnific-popup.css'); ?>
        <?php echo $this->Html->css('/vendor/bootstrap-datepicker/css/datepicker3.css'); ?>

        <!-- Theme CSS -->
        <?= $this->Html->css('theme.css') ?>

        <!-- Skin CSS -->
        <?= $this->Html->css('/css/skins/default.css') ?>

        <!-- Theme Custom CSS -->
        <?= $this->Html->css('theme-custom.css') ?>

        <!-- Head Libs -->
        <?php echo $this->Html->script('/vendor/modernizr/modernizr.js'); ?>

    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign">
            <?= $this->Flash->render() ?>
            <div class="center-sign">
                <a href="/" class="logo pull-left">
                    <img src="assets/images/logo.png" height="54" alt="Porto Admin" />
                </a>

                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
                    </div>
                    <div class="panel-body">
                        <?= $this->Form->create(null) ?>
                            <div class="form-group mb-lg">
                                <label>Email</label>
                                <div class="input-group input-group-icon">
                                    <input name="email" type="text" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                    <label class="pull-left">Password</label>
                                    <a href="pages-recover-password.html" class="pull-right">Lost Password?</a>
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="password" type="password" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="checkbox-custom checkbox-default">
                                        <input id="RememberMe" name="rememberme" type="checkbox"/>
                                        <label for="RememberMe">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
                                </div>
                            </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>

                <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
            </div>
        </section>
        <!-- end: page -->

        <!-- Vendor -->
        <?php echo $this->Html->script('/vendor/jquery/jquery.js'); ?>
        <?php echo $this->Html->script('/vendor/jquery-browser-mobile/jquery.browser.mobile.js'); ?>
        <?php echo $this->Html->script('/vendor/bootstrap/js/bootstrap.js'); ?>
        <?php echo $this->Html->script('/vendor/nanoscroller/nanoscroller.js'); ?>
        <?php echo $this->Html->script('/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>
        <?php echo $this->Html->script('/vendor/magnific-popup/magnific-popup.js'); ?>
        <?php echo $this->Html->script('/vendor/jquery-placeholder/jquery.placeholder.js'); ?>
        
        <!-- Theme Base, Components and Settings -->
        <?php echo $this->Html->script('theme.js'); ?>
        
        <!-- Theme Custom -->
        <?php echo $this->Html->script('theme.custom.js'); ?>
        
        <!-- Theme Initialization Files -->
        <?php echo $this->Html->script('theme.init.js'); ?>

    </body>
</html>