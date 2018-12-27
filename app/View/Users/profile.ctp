<div class="profile-div">
	<div class="card card-outline-secondary my-4">
		<div class="card-header">
			<div class="recent_heading">
				<h4><i class="fa fa-user"></i>  Profile</h4>
			</div>
			<div class="srch_bar">
				<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')) . ' Edit', '/users/edit', ['class' => 'btn btn-primary', 'escape' => false, 'id' => 'edit-profile-button']);  ?>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div>
					<figure>
						<?php
							$image = $user['User']['image'] ?: Configure::read('default.image');
							echo $this->Html->image('users/' . $image, ['class' => 'img-circle img-responsive',  'height' => '200', 'width' => '200']) ;
						?>
					</figure>
				</div>
				<div id="profile-data">
					<div>
						<div>
							<h2><?php echo $user['User']['name']; ?></h2>
							<p><strong>Gender: </strong><?php echo Configure::read('gender.' . $user['User']['gender']); ?> </p>
							<p><strong>Birthdate: </strong>
							<?php
								if (!empty($user['User']['birthdate'])) {
									echo date('F d, Y', strtotime($user['User']['birthdate']));
								}
							?>
							</p>
							<p><strong>Joined: </strong> <?php echo date('F d, Y ha', strtotime($user['User']['created'])); ?> </p>
							<p><strong>Last Login: </strong> <?php echo date('F d, Y ha', strtotime($user['User']['last_login_time'])); ?> </p>
						</div>
					</div>
				</div>
				<div class="col-lg-12" id="hobby">
					<p><strong>Hobby: </strong> <?php echo $user['User']['hobby']; ?> </p>
				</div>
			</div>
		</div>
	</div>
</div>
