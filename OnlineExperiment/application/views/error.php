<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<title>错误页面</title>
	</head>
	<body>
		<h1 style="margin:100px" align="center">对不起，请求出现错误</h1>
		<?php if (isset($error_message)&&$error_message): ?>
			<h2 style="margin:100px" align="center"><?=$error_message?></h2>
		<?php endif ?>
	</body>
</html>

