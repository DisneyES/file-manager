<?php
if((int)substr($_POST['newPermissionN'],0,1)>=6) {
    @session_start();
    require_once 'ftpCon.php';
    $f = new ftpCon();
    $f->conect(base64_decode($_SESSION[MD5('server')]));
    $f->login(base64_decode($_SESSION[MD5('user')]), base64_decode($_SESSION[MD5('password')]));
    if ($_POST['recursivePermissao'] != 'on') {
        if ($f->chmod($_POST['nomePropriedades'], $_POST['newPermissionN'])) {
            ?>
            <script>
                $(document).ready(function () {
                    activeClick.parent().parent().find('.permissaoArquivo').html('<?= $_POST['isdirPropriedades']=='true'?'d'.$_POST['newPermissionT']:'-'.$_POST['newPermissionT'];?>');
                    $('#propriedadesModal').modal('hide');
                })
            </script>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                bootstrapErro("Houve um erro ao trocar as permissões. Tente efetuar o reset de usuários e grupos.<br><input type='button' class='btn btn-danger' data-dismiss='modal' value='Fechar'>");
            </script>
            <?php
        }

        $f->logout();
    }
else{
        $f->chmodr($_POST['nomePropriedades'].DIRECTORY_SEPARATOR, octdec(str_pad($_POST['newPermissionN'], 4, '0', STR_PAD_LEFT)));
        $f->logout();
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
                activeClick.parent().parent().find('.permissaoArquivo').html('<?= $_POST['isdirPropriedades']=='true'?'d'.$_POST['newPermissionT']:'-'.$_POST['newPermissionT'];?>');
                $('#propriedadesModal').modal('hide');
            })
        </script>
        <?php
    }


    }
}
else {
    ?>
    <script type="text/javascript">
        bootstrapErro("A permissão mínima para o dono é de leitura e escrita(6).<br><input type='button' class='btn btn-danger' data-dismiss='modal' value='Fechar'>");
    </script>
    <?php
}