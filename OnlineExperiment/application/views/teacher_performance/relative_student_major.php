<script type="text/javascript">
  	$().ready(function(){
 		$('#relative_major_select').selectpicker({});
 	});
</script>
	
		<select name="relative_major_select" id="relative_major_select" title="选择专业" class="selectpicker form-control"  data-live-search="true"  data-style="btn-primary">
		<option value="0">--不限--</option>
		<?php foreach ($student_major as $item):?>
			
			<option value="<?=$item['id']?>">
				<?=$item['name']?>
			</option>
		<?php endforeach; ?>
	</select>
	

