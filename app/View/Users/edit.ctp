<div class="profile-div ">
    <div class="profile-edit">
        <?php 
            $errors = '';
            foreach ($this->validationErrors['User'] as $validationError) {
              $errors .= $this->Html->tag('li', $validationError[0]);
            }
            if (!empty($errors)) {
                echo $this->Html->div('alert alert-danger', 'Edit failed. Please correct the following errors:' . $this->Html->tag('ul', $errors, ['class' => "regist-errors"]));
            }
        ?>
        <div class="form-group">
            <?php echo $this->Html->image('users/' . $this->request->data['User']['image'], ['id' => 'image', 'class' => 'img-circle img-responsive', 'height' => '200', 'width' => '200']) ?>
        </div>
        <?php
            $birthdate = empty($this->request->data['User']['birthdate']) ? '' : date('m/d/Y', strtotime($this->request->data['User']['birthdate']));
            echo $this->Form->create('User', ['type' => 'file', 'novalidate' => true]);
            echo $this->Form->input('image', [
                'id' => 'new-image',
                'type' => 'file',
                'class' => 'form-control',
                'label' => [
                    'text' => 'Image',
                    'class' => 'control-label'
            ],
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);
        ?>
        <?php
            echo $this->Form->input('name', [
                'class' => 'form-control',
                'label' => [
                    'text' => 'Name',
                    'class' => 'control-label'
            ],
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);

            echo $this->Form->input('email', [
                'class' => 'form-control',
                'label' => [
                    'text' => 'Email',
                    'class' => 'control-label'
                ],
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);
        ?>

        <div class="form-group">
            <label class="control-label">Birthdate</label>
            <input type="text" class="form-control" id="datepicker" value="<?php echo $birthdate ?>" name="data[User][birthdate]"></p>
        </div>
        <span class="control-label">Gender</span><br>
        <?php
            echo $this->Form->radio('gender', [1 => 'Male', 2 => 'Female'],[
                'class' => 'form-radio',
                'required' => false,
                'legend' => false,
            ]);
            echo $this->Form->input('hobby', [
                'class' => 'form-control',
                'label' => [
                    'text' => 'Hobby',
                    'class' => 'control-label'
                ],
                'div' => [
                    'class' => 'form-group',
                ],
                'required' => false,
            ]);
        ?>
        <button type="submit" class="btn btn-primary">Update</button>
        <?php echo $this->Form->end();?>
    </div>
</div>