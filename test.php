<?php

	echo 'hello world <br/><strong>\"how\'s it going world\"</strong>';
	$a = "taco";
	$g = array();
	echo "<br/>" . substr($a, 0, 1) . substr($a, 1, 3);
	
	array_push($g, 213, "pie");
	
	for ($i = 0; i < array_count_values($g); $i++) {
		echo "<br/>" . $g[$i];
	}
?>