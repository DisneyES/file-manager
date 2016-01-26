<?php
@session_start();
require_once 'ftpCon.php';
include_once 'arquivosSuportados.php';
$f=new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));
if(!$f->conect(base64_decode($_SESSION[MD5('server')]))){
    ?>
    <script type="text/javascript">
        bootstrapErro("Erro ao se conectar com o servidor<br><a href='login.php' class='btn btn-warning'>Login</a>");
    </script>
    <?php
    $erro=true;

}
elseif(!$erro){
    if(!$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]))){
        ?>
        <script type="text/javascript">
            bootstrapErro("Erro ao efetuar login<br><a href='login.php' class='btn btn-warning'>Login</a>");
        </script>
        <?php
        $erro=true;

    }
}
if(!$erro) {
    $dirAtual = !empty($_POST['local']) ? $_POST['local'] : '.';
    if (is_array($children = $f->nlist($dirAtual))) {
        $f->logout();
        $items = array();

        foreach ($children as $child) {
            $chunks = preg_split("/\s+/", $child);
            list($item['permissao'], $item['numero'], $item['usuario'], $item['grupo'], $item['tamanho'], $item['mes'], $item['dia'], $item['hora']) = $chunks;
            $item['tipo'] = $chunks[0]{0} === 'd' ? 'Diretório' : 'Arquivo';
            array_splice($chunks, 0, 8);
            $items[implode(" ", $chunks)] = $item;


        }
    }

    if ($dirAtual != '.') {
        ?>
        <tr>
            <?php

            $back = explode(DIRECTORY_SEPARATOR, $dirAtual);
            array_pop($back);
            array_pop($back);
            $caminho = '';
            foreach ($back as $volta) {
                $caminho .= $volta . DIRECTORY_SEPARATOR;
            }
            unset($back, $volta);
            ?>
            <td></td>
            <td><a href="javascript:void(0)" class="diretorio" data-dir="<?= $caminho; ?>"><span
                        class="glyphicon glyphicon-arrow-left"></span> Voltar</a></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php
    }
    $dirAtual = $dirAtual == '.' ? '' : $dirAtual;

    $nomeArquivos = array_keys($items);
    for ($i = 0; $i < count($nomeArquivos); $i++) {
        if ($nomeArquivos[$i] != '.' && $nomeArquivos[$i] != '..') {

            $dir = $items[$nomeArquivos[$i]]['tipo'] == 'Diretório' ? true : false;

            ?>
            <tr>
                <td><input type="checkbox" class="homeCheck"></td>
                <td class="nomeArquivo"><?= $dir ? '<a href="javascript:void(0);" class="diretorio" data-dir="' . $dirAtual . $nomeArquivos[$i] . DIRECTORY_SEPARATOR . '"><i class="glyphicon glyphicon-folder-open"></i> ' . $nomeArquivos[$i] . '</a>' : '<i class="glyphicon glyphicon-file"></i> ' . $nomeArquivos[$i]; ?></td>
                <td class="tamanhoArquivo"><?php
                    if ($dir) {
                        echo '------';
                    } else {
                        if ($items[$nomeArquivos[$i]]['tamanho'] > 1048576) {
                            echo number_format($items[$nomeArquivos[$i]]['tamanho'] / 1048576, 2, '.', '') . ' MB';
                        } elseif ($items[$nomeArquivos[$i]]['tamanho'] > 1024) {
                            echo number_format($items[$nomeArquivos[$i]]['tamanho'] / 1024, 2, '.', '') . ' KB';

                        } else {
                            echo number_format($items[$nomeArquivos[$i]]['tamanho']) . ' B';
                        }
                    }

                    ?></td>
                <?php
                if ($items[$nomeArquivos[$i]]['dia'] < 10) {
                    $items[$nomeArquivos[$i]]['dia'] = '0' . $items[$nomeArquivos[$i]]['dia'];
                }

                ?>
                <td class="dataArquivo"><?= $items[$nomeArquivos[$i]]['dia'] . '/' . $items[$nomeArquivos[$i]]['mes'] . ' ' . $items[$nomeArquivos[$i]]['hora']; ?></td>
                <td class="permissaoArquivo"><?= $items[$nomeArquivos[$i]]['permissao']; ?></td>
                <td class="opcoes-icones">
                    <?php

                    if (in_array(end(explode('.', strtolower($nomeArquivos[$i]))), $arquivosSuportados) && !$dir) {
                        echo '<i class="fa fa-pencil-square-o editar-icone" title="Editar" arq-location="' . $dirAtual . $nomeArquivos[$i] . '"></i>';
                    }
                    ?>
                    <i class="fa fa-times remover-icone" title="Remover" arq-location="<?= $dirAtual . $nomeArquivos[$i]; ?>"></i>
                    <i class="fa fa-cogs propriedades-icone" title="Propriedades" arq-location='<?= $dirAtual . $nomeArquivos[$i]; ?>'></i>
                    <?php
                    if(!$dir && $items[$nomeArquivos[$i]]['tamanho']<=209715200) {
                        echo "<a href='download.php?p=" . $dirAtual . $nomeArquivos[$i] . "' class='fa fa-cloud-download' title='Fazer download'></a>";
                    }
                    ?>
                    <i class='fa fa-exchange <?= !$dir?'rename-icone-nd':'rename-icone-d';?>' title='Renomear' arq-location='<?= $dirAtual . $nomeArquivos[$i]; ?>'></i>
                </td>
            </tr>
            <?php
        }

    }

    ?>
    <script>$(document).ready(function () {
            $('.path-location-required').attr('location-path', '<?= $dirAtual;?>');
            $('.breadcrumb').html('<li><span class="diretorio" data-dir=""><i class="fa fa-folder-open-o"></i> Home</span></li><?php $pager=explode('/',$dirAtual);array_pop($pager);$p='';for($i=0;$i<count($pager);$i++){$p.=$pager[$i].DIRECTORY_SEPARATOR;echo "<li><span class=\"diretorio\" data-dir=\"$p\"><i class=\"fa fa-folder-open-o\"></i> $pager[$i]</span></li>";}?>');

        });</script>
    <?php
}