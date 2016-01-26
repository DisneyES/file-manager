<?php
require_once 'ftpCon.php';

@session_start();

$content=$_POST['content'];
$file=$_POST[MD5('fileLocation')];
$fp = fopen('tmpedit', 'w+');
fwrite($fp, $content);
$f=new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));

if($f->upload(base64_decode($file),'tmpedit')){
    ?>
    <div class="alert alert-success alert-edit-res" style="display: none">Arquivo editado com sucesso.</div>
<?php
}
else{
    ?>
    <div class="alert alert-danger alert-edit-res" style="display: none">Erro ao editar o arquivo.</div>

    <?php
}

fclose($fp);
$fp = fopen('tmpedit', 'w+');
fwrite($fp, '');
fclose($fp);
$f->logout();
?>
<script>
    $(document).ready(function(){
        $('.alert-edit-res').slideDown();
        setTimeout(function(){
            $('.alert-edit-res').slideUp();
            setTimeout(function(){
                $('.alert-edit-res').remove();
            },2000);
        },2000);

    });
</script>
