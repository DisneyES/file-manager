
<?php
@session_start();
require_once 'ftpCon.php';
$f=new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));
$c=0;
if($_POST['c5da39db1424d6b7ee693d9b23ee5a39']=='.'){
    $_POST['c5da39db1424d6b7ee693d9b23ee5a39']='';
}
$local=$_POST['c5da39db1424d6b7ee693d9b23ee5a39'];
for($i=0;$i<count($_FILES['file']['name']);$i++){

    if(!empty($_FILES['file']['name'][$i])){
$c++;
        if($_FILES['file']['size'][$i]<=4194304){
            if($f->upload($local.$_FILES['file']['name'][$i],$_FILES['file']['tmp_name'][$i])){

            }
            else{
                $_SESSION['erroUpload'][]='Não foi possível enviar o arquivo '.$_FILES['file']['name'][$i];

            }
        }
        else{

            $_SESSION['erroUpload'][]='Não foi possível enviar o arquivo '.$_FILES['file']['name'][$i].", pois o mesmo excede o tamanho limite de upload";
        }
    }
}
if($c>0) {
    if (count($_SESSION['erroUpload']) == 0) {
        $_SESSION['erroUpload'] = 'OK';
    }
}
else{
    $_SESSION['erroUpload'] = 'N';

}
?>
<script>
	window.location.href='index.php?Diretorio=<?= $local;?>';
</script>