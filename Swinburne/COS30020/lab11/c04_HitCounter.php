<!DOCTYPE html>
<html>

<head>
	<title>Hit Counter</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="php_styles.css" type="text/css" />
</head>

<body>
	<?php
	// Create directory if it doesn't exist
	umask(0007);
	$dir = "../../data/lab11"; // assumes php file is inside lab11
	if (!file_exists($dir)) {
		mkdir($dir, 02770);
	}

	$CounterFile = $dir . "/hitcount.txt";
	if (file_exists($CounterFile)) {
		$Hits = file_get_contents($CounterFile);
		++$Hits;
	} else {
		$Hits = 1;
	}
	echo "<h1>There have been $Hits hits to this page!</h1>";
	if (file_put_contents($CounterFile, $Hits))
		echo "<p>The counter file has been updated.</p>";

	?>
</body>

</html>