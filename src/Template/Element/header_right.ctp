<div class="header-right">
			
	<form action="pages-search-results.html" class="search nav-form">
		<div class="input-group input-search">
			<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
			<span class="input-group-btn">
				<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</form>

	<span class="separator"></span>

	<div id="userbox" class="userbox">
		<a href="#" data-toggle="dropdown">
			<figure class="profile-picture">
				<img src="<?= $this->Url->build($user['avatar'], true);?>" alt="Joseph Doe" class="img-circle" data-lock-picture="<?= $user['avatar']?>" />
			</figure>
			<div class="profile-info" data-lock-name="John Doe" data-lock-email="<?= $user['email']?>">
				<span class="name"><?= $user['name']?></span>
				<span class="role"><?= $user['role']?></span>
			</div>

			<i class="fa custom-caret"></i>
		</a>

		<div class="dropdown-menu">
			<ul class="list-unstyled">
				<li class="divider"></li>
				<li>
					<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> My Profile</a>
				</li>
				<li>
					<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
				</li>
				<li>
					<a role="menuitem" tabindex="-1" href="pages-signin.html"><i class="fa fa-power-off"></i> Logout</a>
				</li>
			</ul>
		</div>
	</div>
</div>