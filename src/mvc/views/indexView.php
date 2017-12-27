<!DOCTYPE html>
<html>
	<head>
		<title>View</title>
		<base href="/php-project-router/">
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Show view</h1>

		<?php if(isset($message)): ?>
			<p><?php print_r($message); ?></p>
			<a href="list">List</a>
		<?php endif; ?>

		<?php if(isset($pedido)): ?>
			<p><?php echo $pedido; ?></p>
			<a href="">Back</a>
		<?php endif; ?>

		<a href="myfoo/mybar">request</a>
	</body>
</html>