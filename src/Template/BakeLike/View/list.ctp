<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a>
			<a href="#" class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Default</h2>
	</header>
	<div class="panel-body">
		<table class="table table-bordered table-striped mb-none" id="datatable-editable">
			<thead>
				<tr>
					<<?='?'?>php $header = $fields[0];?>
					<<?='?'?>php foreach($header as $field => $value):?>
						<th><<?='?'?>= $field?></th>
					<<?='?'?>php endforeach;?>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<<?='?'?>php foreach($fields as $item):?>
					<tr class="gradeA">
						<<?='?'?>php foreach($item as $field):?>
							<<?='?'?>php
								if($field['lable'] == 'id') {
									$id = $field['value'];
								}
							?>
							<td><<?='?'?>= $field['value'];?></td>
						<<?='?'?>php endforeach;?>	
						<td class="actions">
							<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
							<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
							<a href="/<<?='?'?>=$route;?>/update/<<?='?'?>= $id;?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
							<a href="/<<?='?'?>=$route;?>/delete/<<?='?'?>= $id;?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
						</td>
					</tr>
				<<?='?'?>php endforeach;?>
			</tbody>
		</table>
	</div>
	<div class="row datatables-footer">
		<div class="col-sm-12 col-md-6">
			<div class="dataTables_paginate paging_bs_normal" id="datatable-editable_paginate">
				<ul class="pagination">
					<li class="prev <<?='?'?>= empty($paging['previous']) ? 'disabled' : '';?>">
						<a href="<<?='?'?>= !empty($paging['previous']) ? $paging['previous'] : '#';?>"><span class="fa fa-chevron-left"></span></a>
					</li>
					<li class="next <<?='?'?>= empty($paging['next']) ? 'disabled' : '';?>">
						<a href="<<?='?'?>= !empty($paging['next']) ? $paging['next'] : '#';?>"><span class="fa fa-chevron-right"></span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
<div id="dialog" class="modal-block mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Are you sure?</h2>
		</header>
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<p>Are you sure that you want to delete this row?</p>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button id="dialogConfirm" class="btn btn-primary">Confirm</button>
					<button id="dialogCancel" class="btn btn-default">Cancel</button>
				</div>
			</div>
		</footer>
	</section>
</div>