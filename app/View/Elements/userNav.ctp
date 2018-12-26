<div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <?php echo $this->Html->link($authUser['name'], '/users/profile', ['class' => 'nav-link']); ?>
        </li>
        <?php 
        	echo $this->Html->link('Logout', '/users/logout', ['class' => 'nav-link']); 
        ?>
    </ul>
</div>
