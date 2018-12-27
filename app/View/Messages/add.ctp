<div class="message-div">
    <div class="col-lg-12">
        <?php echo $this->element('validationErrors', ['model' => 'Message', 'text' => 'Message sending failed. Please correct the following errors:']); ?>
        <div class="card card-outline-secondary my-4">
            <?php echo $this->Form->create('Message', ['novalidate' => true]); ?>
                <div class="card-header">
                   <?php 
                        echo $this->Form->input('to_id', [
                            'default' => '',
                            'options' => $users,
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
