<div class="login-form">
    <div class="regist-div">
        <div class="panel">
            <h2>REGISTER</h2>
            <p>Please enter your email and password</p>
        </div>

        <?php
            $errors = '';
            foreach ($this->validationErrors['User'] as $validationError) {
              $errors .= $this->Html->tag('li', $validationError[0]);
            }
            if (!empty($errors)) {
                echo $this->Html->div('alert alert-danger', 'Registration failed. Please correct the following errors:' . $this->Html->tag('ul', $errors, ['class' => "regist-errors"]));
            }

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