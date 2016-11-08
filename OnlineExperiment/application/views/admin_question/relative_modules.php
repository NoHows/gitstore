<script type="text/javascript">
  	$().ready(function(){
 		$('#relative_module_select').selectpicker({});
 	});
</script>
	
		<select name="relative_module_select" id="relative_module_select" title="选择实验" class="selectpicker form-control"  data-live-search="true"  data-style="btn-primary">
	
		<?php foreach ($modules as $item):?>
			
			<option value="<?=$item['id']?>">
				<?=$item['name']?>
			</option>
		<?php endforeach; ?>
		</select>
	

