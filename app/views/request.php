<!DOCTYPE html>
<html>
	<head>
		<title>View</title>
		<base href="/project-router/">
		<meta charset="utf-8">
	</head>
	<body>
		<h1>View - Sample Request</h1>
		<label>Foo: <?= $request['foo']; ?></label><br>
		<label>Bar: <?= $request['bar']; ?></label><br><br>

		<a href="">Back</a>
		<a href="list">List</a>
	</body>
</html>