<?php
if(@ftp_connect($_POST['servidor'])){
	$ftp=@ftp_connect($_POST['servidor']);
	if(@ftp_login($ftp, $_POST['usuario'], $_POST['pass'])){
		@session_start();
		$_SESSION[MD5('password')]=base64_encode($_POST['pass']);
		$_SESSION[MD5('server')]=base64_encode($_POST['servidor']);
		$_SESSION[MD5('user')]=base64_encode($_POST['usuario']);
		?>
		<script>
			window.location.href='index.php';
		</script>
		<?php
	}
	else{
	erro('Usuário ou senha incorretos');

	}
}
else{
	erro('Não foi possível conectar ao servidor');
}
function erro($erro){
	?>
	<div class="alert alert-danger"><a href="#" class="close" data-dismiss='alert'>&times;</a><?= $erro;?></div>
	<?php
}
