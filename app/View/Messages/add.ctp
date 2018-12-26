<div class="message-div">
    <div class="col-lg-12">
        <div class="card card-outline-secondary my-4">
            <?php 
                $errors = '';
                if (isset($this->validationErrors['Message'])) {
                    foreach ($this->validationErrors['Message'] as $validationError) {
                      $errors .= $this->Html->tag('li', $validationError[0]);
                    }
                    if (!empty($errors)) {
                        echo $this->Html->div('alert alert-danger', 'Message sending failed. Please correct the following errors:' . $this->Html->tag('ul', $errors, ['class' => "regist-errors"]));
                    }
                }
            ?>
            <?php echo $this->Form->create('Message', ['novalidate' => true]); ?>
                <div class="card-header">
                   <?php 
                        $options = [];
                        foreach($users as $key => $user) {
                            $options[$key] = [
                                'name' => $user['User']['name'],
                                'value' => $user['User']['id'],
                                'data-image' => $user['User']['image'] ?: '',
                            ];
                        }
                        array_unshift($options, ['name' => '', 'value' => '', 'data-image' => '']);
                        echo $this->Form->input('to_id', [
                            'default' => '',
                            'options' => $options,
                            'class' => 'form-control',
                            'label' => [
                                'text' => 'To:',
                                'class' => 'control-label'
                            ],
                            'div' => [
                                'class' => 'form-group',
                            ],
                            'required' => false,
                        ]);
                    ?>
                </div>
                <div class="card-body">
                    <?php 
                        echo $this->Form->input('content', [
                            'class' => 'form-control',
                            'label' => false,
                            'div' => [
                                'class' => 'form-group',
                            ],
                            'required' => false,
                            'placeholder' => 'Message',
                        ]);
                    ?>
                </div>
                <button type="submit" class="btn btn-primary" id="send-button">Send</button>
            <?php echo $this->Form->end();?>
        </div>
    </div>
</div>

<script>
    $(function() {
        function format(state) {
            var originalOption = state.element;
            var image = $(originalOption).data('image');
            if (image == '') {
                image = 'default-photo.jpg';
            }

            var $state = $(
                '<span><img src="/messageBoard/img/users/' + image + '" class="img-flag" width="50" height="50"/> ' + state.text + '</span>'
            );
            return $state;
        }
        $('#MessageToId').select2({
            templateResult: format,
            placeholder: "Select a recipient"
        });
    });

</script>
