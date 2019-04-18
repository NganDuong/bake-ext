<aside id="sidebar-left" class="sidebar-left">
				
	<div class="sidebar-header">
		<div class="sidebar-title">
			Navigation
		</div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<?php foreach ($menuList as $title => $options):?>
						<li class="<?= !empty($options['active']) ? 'nav-active' : ''?> <?= !empty($options['actions']) ? 'nav-parent' : ''?>">
							<a>
								<i class="fa fa-copy" aria-hidden="true"></i>
								<span><?= $title;?></span>
							</a>
							<ul class="nav nav-children">
								<?php foreach($options['actions'] as $action):?>
									<li>
										<a href="<?= $action['url']?>">
											<?= $action['name']?>
										</a>
									</li>
								<?php endforeach;?>									
							</ul>
						</li>
					<?php endforeach;?>
				</ul>
			</nav>
		</div>

	</div>

</aside>