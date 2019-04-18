<?php $this->layout = false;?>
<!DOCTYPE html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<?= $this->element('header') ?>

	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo pull-left">
					<img src="assets/images/logo.png" height="54" alt="Porto Admin" />
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Recover Password</h2>
					</div>
					<div class="panel-body">
						<div class="alert alert-info">
							<p class="m-none text-semibold h6">Enter your e-mail below and we will send you reset instructions!</p>
						</div>

						<?= $this->Form->create(null) ?>
							<div class="form-group mb-none">
								<div class="input-group">
									<input name="email" type="email" placeholder="E-mail" class="form-control input-lg" />
									<span class="input-group-btn">
										<button class="btn btn-primary btn-lg" type="submit">Reset!</button>
									</span>
								</div>
							</div>

							<p class="text-center mt-lg">Remembered? <a href="pages-signin.html">Sign In!</a>
						<?= $this->Form->end() ?>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md">&copy; Copyright 2014. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<?= $this->element('footer') ?>

	</body>
</html>