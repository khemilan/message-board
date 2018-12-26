<div class="messaging">
    <div class="inbox_msg">
        <div class="mesgs">
            <div class="type_msg">
                <div class="input_msg_write">
                    <?php 
                        echo $this->Form->hidden('message_id', ['id' => 'message-id', 'value' => $messageId]);
                        echo $this->Form->input('content', [
                            'type' => 'text',
                            'id' => 'message-content',
                            'class' => 'write_msg',
                            'label' => false,
                            'required' => false,
                            'placeholder' => 'Message Reply',
                        ])
                    ?>
                    <button type="button" class="msg_send_btn" id="reply-button" disabled="">
                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="msg_history">
                <?php foreach ($replies as $reply): ?>
                    <?php if ($reply['isSentByUser']) : ?>
                        <div class="outgoing_msg" id="reply-<?php echo $reply['id']; ?>">
                            <div class="sent_msg">
                                <p><?php echo $reply['content']; ?></p>
                                <span class="time_date">
                                    <?php echo $reply['date']; ?>
                                    <button class="delete-reply" data-id="<?php echo $reply['id'] ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </span> 
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="incoming_msg">
                            <div class="incoming_msg_img">
                                <?php
                                     if (empty($reply['image'])) {
                                        echo $this->Html->image('users/' . Configure::read('default.image'), ['class' => 'img-circle img-responsive', 'width' => '100', 'height' => '50']);
                                     
                                     } else {
                                        echo $this->Html->image('users/' . $reply['image'], ['class' => 'img-circle img-responsive', 'width' => '100', 'height' => '50']);
                                     }
                                ?>
                            </div>
                            <div class="received_msg">
                                <div class="received_withd_msg">
                                    <p><?php echo $reply['content']; ?></p>
                                    <span class="time_date">
                                        <?php echo $reply['date']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php 
                if ($this->Paginator->counter('{:current}') < $this->Paginator->counter('{:count}')) {
                    echo "<a href='".$this->request->here."?n=".$nextLimit."' class='btn btn-primary btn-lg btn-block'>Show More</a>";
                }
            ?>
        </div>
    </div>
</div>

<script>
    $('#reply-button').click( function() {
        var messageId = $('#message-id').val();
        var content = $('#message-content').val();
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array('controller'=>'replies','action'=>'add'));?>',
            data: ({message_id: messageId, content: content}),
            success: function (data) {
                var obj = JSON.parse(data);
                $(".msg_history").prepend('<div class="outgoing_msg" id="reply-'+obj.id+'"><div class="sent_msg"><p>' + obj.content + '</p><span class="time_date">'+ obj.created +' <button class="delete-reply" data-id="'+obj.id+'"><i class="fa fa-trash"></i></button></span></div></div>');
                $('#message-content').val('');
                $('#reply-button').prop('disabled', true);
            },
        });
    });

    $(document).on('click', '.delete-reply', function(){
        var replyId = $(this).data('id');
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array('controller'=>'replies','action'=>'delete'));?>',
            data: ({id: replyId}),
            success: function (data) {
                var obj = JSON.parse(data);
                $('#reply-' + obj.id).fadeOut();
            },
        });
    });

    $("#message-content").on('change keydown paste input', function(){
      $('#reply-button').prop('disabled', false);
      if ($(this).val() == '') {
        $('#reply-button').prop('disabled', true);
      }
    });
</script>