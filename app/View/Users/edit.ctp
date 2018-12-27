<div class="profile-div ">
	<div class="profile-edit">
		<?php echo $this->element('validationErrors', ['model' => 'User', 'text' => 'Edit failed. Please correct the following errors:']); ?>
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
			echo $this->Form->radio('gender', Configure::read('gender'), [
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
		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
		<?php echo $this->Form->end();?>
	</div>
</div>

<script>
	$(function() {
		$("#datepicker").datepicker();
	});

	function previewImage(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#image').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#new-image").change(function() {
		previewImage(this);
	});
</script>