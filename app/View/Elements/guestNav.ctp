<div class="collapse navbar-collapse" id="navbarResponsive">
	<ul class="navbar-nav ml-auto">
		<?php $action = $this->params['action']; ?>
		<li class="nav-item <?php echo $action == 'login' ? 'active' : ''?>">
			<?php echo $this->Html->link('Login', '/users/login', ['class' => 'nav-link']); ?>
		</li>
		<li class="nav-item <?php echo $action == 'registration' ? 'active' : ''?>">
			<?php echo $this->Html->link('Register', '/users/registration', ['class' => 'nav-link']); ?>
		</li>
	</ul>
</div>