<?php

$doc.=' <div style="padding: 10px;">
	
	<style>
	
		#contentWrapper textarea {
			width: 770px;
			height: 210px;
			padding: 10px;
			margin: 5px 0px;
			resize: none;
			background-color: inherit;
		}
	
	</style>
	
	<h3>API</h3>
	<textarea readonly="readonly">'.str_replace('#url#', "http://".$_SERVER["SERVER_ADDR"].$_SERVER["PHP_SELF"], file_get_contents("api.txt")).'</textarea>
	
	<h3>License</h3>
	<div style="padding: 10px;">
		<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png" /></a><br />
	</div>

	
</div>';

?>