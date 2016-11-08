<!DOCTYPE html>

<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <meta http-equiv="X-UA-Compatible" content="chrome=1" />
		<title><?php echo $title; ?></title>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/bootstrap-select.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/question-content.css"/>

    <script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/messages_cn.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-select.js"></script>

	</head>
<body>
	

<style type="text/css"> 
	.navbar-inverse {z-index:2}
</style> 

	
	
<div class="navbar navbar-inverse">
	<div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo site_url('student_home/index')?>">你好,<?php echo $this->session->userdata('e_name')?></a>
  </div>
  <div class="navbar-collapse collapse navbar-inverse-collapse">
   
    <ul class="nav navbar-nav navbar-right">
      
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $this->session->userdata('e_username')?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo site_url('student_home/change_password')?>">修改密码</a></li>
          <li><a href="<?php echo site_url('student_home/logout') ?>">退出</a></li>
        </ul>
      </li>

    </ul>
    </div>
  </div>
</div>