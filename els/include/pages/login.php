<?php

	$doc.='
	
	<style>
	
	#loginWrapper {
	
	}
	
	#loginWrapper form {
		width: 200px;
		margin: 0px auto;
		padding: 50px;
	}
	
	#loginWrapper form input[type="text"],
	#loginWrapper form input[type="password"] {
		width: 190px;
		padding: 5px;
		margin-bottom: 5px;
	}
	
	#loginWrapper form input[type="submit"] {
		width: inherit;
		margin-bottom: 5px;
		color: inherit;
		background-color: rgb(184, 184, 184);
		padding: 5px 8px;
		font-family: \'bebas_neueregular\';
		font-size: 20px;
		letter-spacing: 1px;
	}
	
	#loginWrapper form input[type="submit"]:hover {
		background-color: rgb(170, 170, 170);
	}
	
	</style>
	
	<div id="loginWrapper">
		<form action="." method="post">
			<input type="text" style="display: none;" name="action" value="login"></input>
			<input type="text" name="username" alt="Username"></input>
			<input type="password" name="password" alt="Password"></input>
			<input class="pointer" type="submit" value="Login"></input>
		</form>
	</div>
	
	';
	
?>