<?php
if (!$_POST["login"] || !$_POST["oldpw"] || $_POST["submit"] != "OK" ||
	!$_POST["newpw"] || !file_exists("../private/passwd") ||
	$_POST["oldpw"] == $_POST["newpw"]) {
	header("Location: index.html");
	echo "ERROR\n";
	exit;
}
$data = unserialize(file_get_contents("../private/passwd"));
if ($data)
{
	foreach ($data as &$val) {
		if ($val["login"] === $_POST["login"] && $val["passwd"] === hash("sha256", $_POST["oldpw"]))
		{
			$val["passwd"] = hash("sha256", $_POST["newpw"]);
			file_put_contents("../private/passwd", serialize($data));
			header("Location: index.html");
			echo "OK\n";
			exit;
		}
	}
	header("Location: index.html");
	echo "ERROR\n";
}
?>