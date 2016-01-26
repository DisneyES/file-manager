<?php
require_once 'ftpCon.php';
include "arquivosSuportados.php";
@session_start();

$nameFile=$_POST["file"];
if($_POST['path']=='.'){
    $_POST['path']='';
}
$fileLocation=$_POST["path"];
$fp = fopen('tmptouch', 'w+');
fwrite($fp, '');
$f=new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));
$items=$f->readDir($fileLocation);
if(!in_array($nameFile,$items)){

if ($f->upload($fileLocation .DIRECTORY_SEPARATOR. $nameFile, 'tmptouch')) {
    ?>
    <script>
        $(document).ready(function () {
            $('.table').DataTable().destroy();

            $('.table-arquivos').prepend('<tr>' +
                '<td><input type="checkbox" class="homeCheck"></td>' +
                '<td class="nomeArquivo"><i class="glyphicon glyphicon-file"></i> <?= $nameFile;?></a></td>' +
                '<td class="tamanhoArquivo">0 B</td>' +
                '<td class="dataArquivo"><?= date('d/M H:i');?></td>' +
                '<td class="permissaoArquivo">-rw-r--r--</td>' +
                '<td class="opcoes-icones">' +
                    <?php
                        if(in_array(end(explode('.',strtolower($nameFile))),$arquivosSuportados)){
                        echo '\'<i class="fa fa-pencil-square-o editar-icone" title="Editar" arq-location="'.$fileLocation.$nameFile.'"></i> \'+';
                    }
                    ?>
                '<i class="fa fa-times remover-icone" title="Remover" arq-location="<?= $fileLocation.$nameFile;?>"></i> ' +
                '<i class="fa fa-cogs propriedades-icone" title="Propriedades" arq-location="<?= $fileLocation.$nameFile;?>"></i> ' +
                "<a href='download.php?p=<?= $fileLocation.$nameFile;?>' class='fa fa-cloud-download' title='Fazer download'></a> " +
                "<i class='fa fa-exchange rename-icone-nd' title='Renomear' arq-location='<?= $fileLocation.$nameFile;?>'></i>" +
                '</td></tr>');

            <?php include 'restart.php';?>



            $('#fileCreateModal').modal('hide');
        });

    </script>
    <?php
} else {
    ?>
<script>
        $(document).ready(function () {

            $('#fileCreateModal').modal('hide');
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