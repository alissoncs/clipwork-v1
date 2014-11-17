<?php
	$post = $_POST;


	if(isset($post)) {

		$post["editor"] = htmlentities($post["editor"]);
		echo $post["editor"];

	}

?>