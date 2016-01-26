<?php
@session_start();
require_once 'ftpCon.php';
$f=new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));
$bool=$f->ftp_rdel($_POST['arq']);

$f->logout();


    if(!empty($f->error)){
        ?>
        <script>
            bootstrapErro("Não foi possível remover <?= $_POST['arq'];?><br><input type='button' class='btn btn-danger' value='Fechar' data-dismiss='modal'>");
        </script>
        <?php
    }
else{
    echo true;

}
?>