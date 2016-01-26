<?php
if(!empty($_POST['newnameRename']) && strpos($_POST['newnameRename'],DIRECTORY_SEPARATOR)===false) {
    @session_start();
    $a = explode('/', $_POST['oldnameRename']);
    array_pop($a);
    $path = implode('/', $a) . DIRECTORY_SEPARATOR;
    unset($a);
    $dir = $_POST['isdirRename'] == 'true' ? true : false;

    require_once 'ftpCon.php';
    $f = new ftpCon();
    $f->conect(base64_decode($_SESSION[MD5('server')]));
    $f->login(base64_decode($_SESSION[MD5('user')]), base64_decode($_SESSION[MD5('password')]));
    $items = $f->readDir($path);
    if (!in_array($_POST['newnameRename'], $items)) {

        if ($f->rename($_POST['oldnameRename'], $path . $_POST['newnameRename'])) {
            $f->logout();
            if ($dir) {
                ?>
                <script>
                    $('.table').DataTable().destroy();

                    activeClick.parent().parent().find('.nomeArquivo').html('<a href="javascript:void(0);" class="diretorio" data-dir="<?= $path.$_POST['newnameRename'].DIRECTORY_SEPARATOR;?>"><i class="glyphicon glyphicon-folder-open"></i> <?= $_POST['newnameRename'];?></a>');


                    activeClick.parent().parent().find('.opcoes-icones').html('<i class="fa fa-times remover-icone" title="" arq-location="<?= $path.$_POST['newnameRename'];?>" data-original-title="Remover"></i> <i class="fa fa-cogs propriedades-icone" title="" data-original-title="Propriedades" arq-location="<?= $path.$_POST['newnameRename'];?>"></i> <i class="fa fa-exchange rename-icone-d" title="" arq-location="<?= $path.$_POST['newnameRename'];?>" data-original-title="Renomear"></i>');
                    $('.rename-old-name').html('<?= $_POST['newnameRename'];?>');

                    <?php include 'restart.php';?>
                    $('#renameModal').modal('hide');

                </script>

                <?php
            } else {
                require_once 'arquivosSuportados.php';

                ?>
                <script>
                    $('.table').DataTable().destroy();

                    activeClick.parent().parent().find('.nomeArquivo').html('<i class="glyphicon glyphicon-file"></i> <?= $_POST['newnameRename'];?>');


                    activeClick.parent().parent().find('.opcoes-icones').html(<?php if(in_array(end(explode('.',strtolower($_POST['newnameRename']))),$arquivosSuportados)){ echo '\'<i class="fa fa-pencil-square-o editar-icone" title="Editar" arq-location="'.$path . $_POST['newnameRename'].'"></i> \'+'; }?>
                        '<i class="fa fa-times remover-icone" title="Remover" arq-location="<?= $path . $_POST['newnameRename'];?>"></i> ' +
                        '<i class="fa fa-cogs propriedades-icone" title="Propriedades" arq-location="<?= $path . $_POST['newnameRename'];?>"></i> ' +
                        "<a href='download.php?p=<?= $path . $_POST['newnameRename'];?>' class='fa fa-cloud-download' title='Fazer download'></a> " +
                        "<i class='fa fa-exchange rename-icone-nd' title='Renomear' arq-location='<?= $path . $_POST['newnameRename'];?>'></i>");
                    <?php include 'restart.php';?>
                    $('#renameModal').modal('hide');

                </script>
                <?php
            }
        } else {
            $f->logout();
            ?>
            <script>
                bootstrapErro("Erro ao modificar o nome <?= !$dir?'do arquivo':'da pasta';?>.<br><input type='button' class='btn btn-danger' value='Fechar' data-dismiss='modal'>");
            </script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            bootstrapErro("Esta pasta já possuí um arquivo ou diretório com este nome.<br><input type='button' class='btn btn-danger' data-dismiss='modal' value='Fechar'>");
        </script>
        <?php
    }
}
else{
    ?>
    <script type="text/javascript">
        bootstrapErro("Nome inválido.<br><input type='button' class='btn btn-danger' data-dismiss='modal' value='Fechar'>");
    </script>
    <?php
}
/*

?>
<script>
    $(document).ready(function(){
        //alert("<?= $_POST['isdirRename']=='true'?'É diretório':'É arquivo';?>");
        activeClick.parent().parent().find('.nomeArquivo').html('<i class="glyphicon glyphicon-file"></i> <?= $_POST['newnameRename'];?>');
    })
</script>*/