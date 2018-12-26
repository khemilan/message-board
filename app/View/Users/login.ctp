<div class="login-form">
    <div class="main-div">
        <div class="panel">
            <h2>LOGIN</h2>
            <p>Please enter your email and password</p>
        </div>

        <?php 
            echo $this->Flash->render('error');
            echo $this->Form->create('User', ['novalidate' => true]);
            echo $this->Form->input('email', [
                'class' => 'form-control',
                'placeholder' => 'Email Address',
                'label' => false,
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);
            echo $this->Form->input('password', [
                'class' => 'form-control',
                'placeholder' => 'Password',
                'label' => false,
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);
        ?>
        <button type="submit" class="btn btn-primary">Login</button>

        <?php echo $this->Form->end();?>
    </div>
</div>