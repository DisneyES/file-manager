<?php
@session_start();
require_once 'ftpCon.php';
$f=new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));
$items=$f->readDir($_POST['path']);
if(!in_array($_POST['file'],$items)){
if($_POST['path']=='.'){
    $_POST['path']='';
}
if($f->mkdir($_POST['path'].$_POST['file'])){
    ?>
    <script>
        $(document).ready(function() {
                    $('.table').DataTable().destroy();

            $('.table-arquivos').prepend('<tr>' +
                '<td><input type="checkbox" class="homeCheck"></td>' +
                '<td class="nomeArquivo"><a href="javascript:void(0);" class="diretorio" data-dir="<?= $_POST['path'].$_POST['file'].DIRECTORY_SEPARATOR;?>"><i class="glyphicon glyphicon-folder-open"></i> <?= $_POST['file'];?></a></td>' +
                '<td class="tamanhoArquivo">------</td>' +
                '<td class="dataArquivo"><?= date('d/M H:i');?></td>'+
                '<td class="permissaoArquivo">drwxr-xr-x</td>' +
                '<td class="opcoes-icones"><i class="fa fa-times remover-icone" title="Remover" arq-location="<?= $_POST['path'].$_POST['file'];?>"></i> <i class="fa fa-cogs propriedades-icone" title="Propriedades" arq-location="<?= $_POST['path'].$_POST['file'];?>"></i> <i class="fa fa-exchange rename-icone-d" title="Renomear" arq-location="<?= $_POST['path'].$_POST['file']; ?>"></i></td></td></tr>');

            <?php include 'restart.php';?>



            $('#folderCreateModal').modal('hide');
        });

    </script>
<?php
}
else {
    ?>
<script>
        $(document).ready(function () {

            $('#folderCreateModal').modal('hide');
            $('body').animate({"top": 0},500);
        });

    </script>
    <div class="alert alert-danger"><button class="close" data-dismiss="alert">&times;</button> Nome invalido.</div>    <?php
}
}
else {
?>
    <script type="text/javascript">
        bootstrapErro("Esta pasta já possuí um arquivo ou diretório com este nome.<br><input type='button' class='btn btn-danger' data-dismiss='modal' value='Fechar'>");
    </script>
<?php
}