<div class="collapse navbar-collapse" id="navbarResponsive">
	<ul class="navbar-nav ml-auto">
		<li class="nav-item active">
			<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-user')) . ' ' . $authUser['name'], '/users/profile', ['class' => 'nav-link', 'escape' => false]); ?>
		</li>
		<?php
			echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-sign-out')) . ' Logout', '/users/logout', ['class' => 'nav-link', 'escape' => false]);
		?>
	</ul>
</div>
