<div class="login-form">
    <div class="regist-div">
        <div class="panel">
            <h2>REGISTER</h2>
            <p>Please enter your email and password</p>
        </div>
        <?php
            echo $this->element('validationErrors', ['model' => 'User', 'text' => 'Registration failed. Please correct the following errors:']); 
            echo $this->Form->create('User', ['class' => 'form', 'novalidate' => true]);
            echo $this->Form->input('name', [
                'class' => 'form-control',
                'placeholder' => 'Name',
                'label' => false,
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);
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
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password',
                'label' => false,
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);
            echo $this->Form->input('confirmPassword', [
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Confirm Password',
                'label' => false,
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);
        ?>
        <button type="submit" class="btn btn-primary">Register</button>
        <?php echo $this->Form->end();?>
    </div>
</div>