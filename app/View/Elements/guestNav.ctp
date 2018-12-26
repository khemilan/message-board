<div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <?php echo $this->Html->link('Login', '/users/login', ['class' => 'nav-link']); ?>
            <!-- <a class="nav-link" href="#">Login -->
                <!-- <span class="sr-only">(current)</span> -->
            <!-- </a> -->
        </li>
        <li class="nav-item">
            <?php echo $this->Html->link('Register', '/users/registration', ['class' => 'nav-link']); ?>
        </li>
    </ul>
</div>