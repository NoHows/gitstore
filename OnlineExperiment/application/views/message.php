
<?php if ($this->session->flashdata('message')):?> 

<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/jBox.css"/>
<script type="text/javascript" src="<?php echo base_url()?>js/jBox.js"></script>
<script tyep="text/javascript">
  $().ready(function(){
  	new jBox('Notice', {
  		attributes:{x:'left',y:'top'},
  		theme:'NoticeBorder',
  		color:'green',
  		animation:{open:'slide:left',close:'slide:left'},
    	content: '<?php echo $this->session->flashdata('message') ?>'
	});
  });
</script>

<?php endif ?>