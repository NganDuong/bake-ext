<?= $this->Form->create(null) ?>
	<?php foreach ($fields as $field => $fieldInfo):?>
		<div class="form-group">
			<label class="col-md-3 control-label" for="<?= $fieldInfo['lable']?>"><?= $fieldInfo['lable']?></label>
			<div class="col-md-6">
				<?php if ($fieldInfo['type'] == 'checkbox'): ?>
				   <div class="checkbox-default">
						<input 
							type="<?= $fieldInfo['type']?>" id="<?= $fieldInfo['lable']?>" 
							<?= !empty($fieldInfo['value']) ? "checked" : '';?>							
						>
					</div>
				<?php elseif ($fieldInfo['type'] == 'textarea'): ?>
					<textarea class="form-control" rows="3" id="<?= $fieldInfo['lable']?>">
						<?= !empty($fieldInfo['value']) ? $fieldInfo['value'] : '';?>
					</textarea>
				<?php elseif ($fieldInfo['type'] == 'file'): ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-append">
							<div class="uneditable-input">
								<i class="fa fa-file fileupload-exists"></i>
								<span class="fileupload-preview"></span>
							</div>
							<span class="btn btn-default btn-file">
								<span class="fileupload-exists">Change</span>
								<span class="fileupload-new">Select file</span>
								<input type="<?= $fieldInfo['type']?>" />
							</span>
							<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
						</div>
					</div>
				<?php elseif ($fieldInfo['type'] == 'dropdown'): ?>
					<select class="form-control mb-md">
						<?php foreach ($fieldInfo['options'] as $option):?>
							<option value="<?= $option?>" <?= (!empty($fieldInfo['value']) && ($option == $fieldInfo['value'])) ? 'selected="selected"' : ''; ?>><?= $option?></option>
						<?php endforeach;?>
					</select>
				<?php elseif ($fieldInfo['type'] == 'date'): ?>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						<input id="date" data-plugin-masked-input data-input-mask="99/99/9999" placeholder="__/__/____" class="form-control">
					</div>
				<?php else: ?>
				   	<input 
						name="<?= $fieldInfo['lable']?>" type="<?= $fieldInfo['type']?>" class="form-control" id="<?= $fieldInfo['lable']?>"
						placeholder="<?php !empty($fieldInfo['value']) ? $fieldInfo['value'] : $fieldInfo['lable']?>"
						value="<?= !empty($fieldInfo['value']) ? $fieldInfo['value'] : '';?>"
						<?= $fieldInfo['lable'] == 'id' ? 'readonly' : ''?>
					>
				<?php endif; ?>
				<?php if(!empty($fieldInfo['help'])): ?>
					<span class="help-block"><?= $fieldInfo['help']?></span>
				<?php endif;?>
			</div>
		</div>
	<?php endforeach; ?>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
				<button class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-default">Reset</button>
			</div>
		</div>
	</footer>
<?= $this->Form->end() ?>