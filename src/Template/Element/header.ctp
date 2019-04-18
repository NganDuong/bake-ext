<meta charset="UTF-8">

<title>Dashboard | JSOFT Themes | JSOFT-Admin</title>
<meta name="keywords" content="HTML5 Admin Template" />
<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
<meta name="author" content="JSOFT.net">
<link rel="icon" href="<?= $this->Url->build('/img/favicon.ico', true);?>" type="image/x-icon" />

<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- Web Fonts  -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

<!-- Vendor CSS -->
<?php echo $this->Html->css('/vendor/bootstrap/css/bootstrap.css'); ?>
<?php echo $this->Html->css('/vendor/font-awesome/css/font-awesome.css'); ?>
<?php echo $this->Html->css('/vendor/magnific-popup/magnific-popup.css'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-datepicker/css/datepicker3.css'); ?>

<!-- Specific Page Vendor CSS -->
<?php echo $this->Html->css('/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css'); ?>
<?php echo $this->Html->css('/vendor/bootstrap-multiselect/bootstrap-multiselect.css'); ?>
<?php echo $this->Html->css('/vendor/morris/morris.css'); ?>

<!-- Specific Page Vendor CSS -->
<?php echo $this->Html->css('/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css'); ?>

<!-- Theme CSS -->
<?= $this->Html->css('theme.css') ?>

<!-- Skin CSS -->
<?= $this->Html->css('/css/skins/default.css') ?>

<!-- Theme Custom CSS -->
<?= $this->Html->css('theme-custom.css') ?>

<!-- Head Libs -->
<?php echo $this->Html->script('/vendor/modernizr/modernizr.js'); ?>