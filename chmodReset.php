<?php
@session_start();
require_once 'ftpCon.php';
$f=new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));
$f->chmodreset($_POST['nomePropriedades'].DIRECTORY_SEPARATOR);
if(count($f->errorChmod)>0){
    ?>

    <script type="text/javascript">
        bootstrapErro("<ul style='list-style-type: none'><?php foreach ($f->errorChmod as $error) { echo '<li>Erro ao alterar as permissoes de '.$error.'</li>';}?></ul><br><input type='button' class='btn btn-danger' data-dismiss='modal' value='Fechar'>");
    </script>
    <?php
}
else{
    ?>
    <script>
        $(document).ready(function () {
            activeClick.parent().parent().find('.permissaoArquivo').html('<?= $_POST['isdirPropriedades']=='true'?'drwxr-xr-x':'-rw-r--r--';?>');
            $('#propriedadesModal').modal('hide');
        })
    </script>
    <?php
}
$f->logout();