<div class="messaging">
    <div class="inbox_msg">
        <div class="inbox_people">
            <div class="headind_srch">
                <div class="recent_heading">
                    <h4>Messages</h4>
                </div>
                <div class="srch_bar">
                    <div class="stylish-input-group">
                        <?php echo $this->Html->link('New Message', '/messages/add', ['class' => 'btn btn-success']);  ?>
                    </div>
                </div>
            </div>
          <div class="inbox_chat">
                <?php foreach ($messages as $message): ?>
                    <div class="chat_list active_chat" id="message-<?php echo $message['id']; ?>">
                        <div class="chat_people">
                            <div class="chat_img">
                                <?php 
                                    if(empty($message['image'])) {
                                        echo $this->Html->image('users/' . Configure::read('default.image'), ['class' => 'img-circle img-responsive']) ;
                                    } else {
                                        echo $this->Html->image('users/' . $message['image'], ['class' => 'img-circle img-responsive']);
                                    }
                                ?>
                            </div>
                            <div class="chat_ib">
                                <h5>
                                    <?php echo $this->Html->link($message['name'], '/messages/detail/' . $message['id']);?>  
                                    <span class="chat_date">
                                        <?php echo $message['date']; ?>
                                            <button class="delete-message" data-id="<?php echo $message['id'] ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </span>
                                </h5>
                                <p><?php 
                                    echo $message['isSentByUser'] ? 'You: ' : '';
                                    echo $message['content']; 
                                ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            
          </div>
          <?php 
                if ($this->Paginator->counter('{:current}') < $this->Paginator->counter('{:count}')) {
                    echo "<a href='".$this->request->here."?n=".$nextLimit."' class='btn btn-primary btn-lg btn-block'> Show More</a>";
                }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.delete-message').click(function() {
        var messageId = $(this).data('id');
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array('controller'=>'messages','action'=>'delete'));?>',
            data: ({id: messageId}),
            success: function (data) {
                var obj = JSON.parse(data);
                $('#message-' + obj.id).fadeOut();
            },
        });
    });
</script>