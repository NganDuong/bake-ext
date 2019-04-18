<!DOCTYPE html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<?= $this->element('header') ?>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="<?= $this->Url->build('/img/logo.svg', true);?>" height="35" alt="JSOFT Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<?= $this->element('header_right') ?>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?= $this->element('sidebar_left') ?>				
				<!-- end: sidebar -->

				<section role="main" class="content-body">

					<!-- start: breadcrumb -->
					<?= $this->element('breadcrumb') ?>				
					<!-- end: breadcrumb -->

					<!-- start: page -->
					<?= $this->fetch('content') ?>
					<!-- end: page -->
				</section>
			</div>

			<!-- start: sidebar -->
			<!-- <?= $this->element('sidebar_right') ?> -->
			<!-- end: sidebar -->
		</section>

		<?= $this->element('footer') ?>
	</body>
</html>