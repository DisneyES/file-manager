<?php
@session_start();

include_once 'arquivosSuportados.php';
?>
<!doctype html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de arquivos</title>
    <script src="js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="jquery.dataTables.min.js"></script>
    <script src="dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <script type="text/javascript" src="js/funcoesJS.js"></script>

    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <script>
        var between = false;var activeClick;var k2=1;
        $(document).ready(function () {
            $('.overlay').css({"width": "0px","height": "0px"});

            $('.btn-rename').click(function () {
                loadingState;
                $btn = $(this);
                $btn.button('loading');
                $.post('rename.php', $('[name=renameForm]').serialize(), function (data) {
                    finishLoading();
                    $('#resultExclude').html(data);
                    $btn.button('reset')
                })
            });
            $('[name=newnameRename]').keypress(function (e) {
                if (e.which == 13) {
                    $('.btn-rename').click()
                }
            });
            $('[name=folderName]').keypress(function (e) {
                if (e.which == 13) {
                    $('.btn-create-folder').click()
                }
            });
            $('[name=nameFile]').keypress(function (e) {
                if (e.which == 13) {
                    $('.btn-create-file').click()
                }
            });
            $(window).keydown(function (e) {
                if (e.which == 16) {
                    between = true
                }
            });
            $(window).keyup(function () {
                between = false
            }); <?php include 'restart.php'; ?>

            $('.btn-delete-all').click(function () {
                $(this).button('loading')
            });
            $('.delete-all').click(function () {
                $('#deleteallModal').modal('show');
                $('[name=locationpathexcluirall]').val($(this).attr('location-path'));
                $('[name=arquivosaexcluir]').val($(this).attr('data-arqs'))
            });
            $('.uploadFile-buttom').click(function () {
                $('#fileUploadModal').modal('show');
                $('#c5da39db1424d6b7ee693d9b23ee5a39').val($(this).attr('location-path'))
            });
            $('.btn-upload-file').click(function () {
                $btn = $(this);
                $btn.button('loading');
                var $fileUpload = $("#file");
                if (parseInt($fileUpload.get(0).files.length) > <?= ini_get("max_file_uploads"); ?> ) {
                    bootstrapErro("Só é possível enviar <?= ini_get("max_file_uploads ");?> arquivos de cada vez<br><input type='button' class='btn btn-danger' value='Fechar' data-dismiss='modal'>");
                    $btn.button('reset');
                    return false
                }
                else {
                    var size = 0;
                    var count = $fileUpload.get(0).files.length;
                    for (i = 0; i < count; i++) {
                        size += $fileUpload.get(0).files[i].size;
                        if ($fileUpload.get(0).files[i].size > 4194304) {
                            bootstrapErro("Seu arquivo " + $fileUpload.get(0).files[i].name + " possuí um tamanho maior que 4 MB, portanto não será possível enviá-lo<br><input type='button' class='btn btn-danger' value='Fechar' data-dismiss='modal'>");
                            $btn.button('reset');
                            return false
                        }
                    }
                    size /= (1024 * 1024);
                    if (size > <?= (int) ini_get('post_max_size'); ?> ) {
                        bootstrapErro("Só é possível enviar <?= ini_get("
                post_max_size ");?> MB de arquivos de uma vez<br><input type='button' class='btn btn-danger' value='Fechar' data-dismiss='modal'>");
                        alert(size.toFixed(2));
                        $btn.button('reset');
                        return false
                    }
                }
            });
            $('.check-all').click(function () {
                $('.table').find('.homeCheck').prop('checked', true);
                if ($('.homeCheck:checked').length > 0) {
                    activeMenu()
                }
                else {
                    removeMenu()
                }
            });
            $('.reverse-check').click(function () {
                $('.table').find('.homeCheck:checked').attr('class', 'homeCheck desmarcar');
                $('.table').find('.homeCheck:not(:checked)').attr('class', 'homeCheck marcar');
                $('.desmarcar').prop('checked', false);
                $('.marcar').prop('checked', true);
                $('.table').find('.homeCheck').attr('class', 'homeCheck');
                if ($('.homeCheck:checked').length > 0) {
                    activeMenu()
                }
                else {
                    removeMenu()
                }
            });
            $('.uncheck-all').click(function () {
                $('.table').find('.homeCheck').prop('checked', false);
                if ($('.homeCheck:checked').length > 0) {
                    activeMenu()
                }
                else {
                    removeMenu()
                }
            });
            $('.btn-exclude-area').find('.btn-danger').click(function () {
                loadingState();
                $btn = $(this);
                $btn.val('Removendo');
                $btn.attr('disabled', 'true');
                $.post("delete.php", {
                    "arq": $('#3b1510b2670381f1dd3277ab4bdb824b').val()
                }, function (data) {
                    finishLoading();
                    if (data == true) {
                        activeClick.parent().parent().fadeOut(500);
                        setTimeout(function () {
                            $('.table').DataTable().destroy();
                            activeClick.parent().parent().remove(); <?php include 'datatables.php'; ?>
                            if ($('.homeCheck:checked').length > 0) {
                                activeMenu()
                            }
                            else {
                                removeMenu()
                            }
                        }, 600);
                        $('#deleteModal').modal('hide')
                    }
                    else {
                        $('#deleteModal').modal('hide');
                        $('#resultExclude').html(data)
                    }
                    $btn.val('Sim');
                    $btn.attr('disabled', false)
                })
            });
            $('.tooltip-glyphicon').tooltip();
            $('.diretorio').click(function () {
                pager($(this).attr('data-dir'))
            });
            $('.createFolder-buttom').click(function () {
                $('#folderCreateModal').modal('show');
                $('#335e5656746940bfa10649e34be58887').val($(this).attr('location-path'))
            });
            $('.createFile-buttom').click(function () {
                $('#fileCreateModal').modal('show');
                $('#955895f4878c22d49ec956a7e8d52c19').val($(this).attr('location-path'))
            });
            $('.btn-create-folder').click(function () {
                loadingState();
                $btn = $(this);
                $btn.val('Criando');
                $btn.attr('disabled', 'true');
                $.post("mkdir.php", {
                    "path": $('#335e5656746940bfa10649e34be58887').val(),
                    "file": $('[name=folderName]').val()
                }, function (data) {
                    finishLoading();
                    $('#resultExclude').html(data);
                    $('[name=folderName]').val('');
                    $btn.val('Criar');
                    $btn.attr('disabled', false);
                    $(".homeCheck").change(function (event, index) {
                        if (between) {
                            $s = $(this);
                            if ($s.is(":checked")) {
                                selectBetween($('.homeCheck').index($s))
                            }
                        }
                        if ($('.homeCheck:checked').length > 0) {
                            activeMenu()
                        }
                        else {
                            removeMenu()
                        }
                    })
                })
            });
            $('.btn-create-file').click(function () {
                loadingState();
                $btn = $(this);
                $btn.val('Criando');
                $btn.attr('disabled', 'true');
                $.post("touch.php", {
                    "path": $('#955895f4878c22d49ec956a7e8d52c19').val(),
                    "file": $('[name=nameFile]').val()
                }, function (data) {
                    finishLoading();
                    $('#resultExclude').html(data);
                    $('[name=nameFile]').val('');
                    $btn.val('Criar');
                    $btn.attr('disabled', false);
                    $(".homeCheck").change(function (event, index) {
                        if (between) {
                            $s = $(this);
                            if ($s.is(":checked")) {
                                selectBetween($('.homeCheck').index($s))
                            }
                        }
                        if ($('.homeCheck:checked').length > 0) {
                            activeMenu()
                        }
                        else {
                            removeMenu()
                        }
                    })
                });
            });

            $('.permissaoCheck').change(checkPermission);
            $('.btn-calc-size').click(function () {
                $btn=$(this);
                $btn.button('loading');
                $('.dirSize').html('');

                $.post('dirSize.php',{"D": $(this).attr('location-path')}, function (data) {
                    $btn.button('reset');
                    $('.dirSize').html(data);
                })
            });
            $('.btn-prop').click(function(){
                loadingState();
                $btn=$(this);
                $btn.button('loading');
                checkPermission();
                $.post('chmod.php',$('[name=propriedadesForm]').serialize(), function (data) {
                    finishLoading();
                    $('#resultExclude').html(data);
                    $btn.button('reset');

                });
            });
            $('.btn-permissao-padrao').click(function(){
                $btn=$(this);
                $btn.button('loading');
                $.post('chmodReset.php',$('[name=propriedadesForm]').serialize(), function (data) {
                    $('#resultExclude').html(data);
                    $btn.button('reset');

                });
            });
            $('.propriedades-all').click(function () {
                $('[name=arqspropriedadesAll]').val($(this).attr('data-arqs'));
                $('[name=locationAtualpropriedadesAll]').val($(this).attr('location-path'));
                $('.permissaoCheckAll').prop('checked',false);
                $('.permissaoAll-label').html('600');
                $('#propriedadesModalall').modal('show');
            });
            $('.permissaoCheckAll').change(checkPermissionAll);
        });

        function pager(local) {
            loadingState();
            $('.btn').attr('disabled',true);
            history.pushState('data', '', '?Diretorio=' + local);
            $.post("pager.php", {
                "local": local
            }, function (data) {
                finishLoading();
                $('.table').DataTable().destroy();
                $('.table-arquivos').html(data);
                removeMenu(); <?php include 'restart.php'; ?>
                $('.btn').attr('disabled',false);
                $('.dirSize').html('');

            })
        }
    </script>
    <link rel="stylesheet" href="lib/codemirror.css">
    <link rel="stylesheet" href="addon/fold/foldgutter.css">
    <link rel="stylesheet" href="addon/dialog/dialog.css">
    <link rel="stylesheet" href="theme/neo.css">
    <script src="lib/codemirror.js"></script>
    <script src="addon/search/searchcursor.js"></script>
    <script src="addon/search/search.js"></script>
    <script src="addon/dialog/dialog.js"></script>
    <script src="addon/edit/matchbrackets.js"></script>
    <script src="addon/edit/closebrackets.js"></script>
    <script src="addon/comment/comment.js"></script>
    <script src="addon/wrap/hardwrap.js"></script>
    <script src="addon/fold/foldcode.js"></script>
    <script src="addon/fold/brace-fold.js"></script>
    <script src="mode/javascript/javascript.js"></script>
    <script src="keymap/sublime.js"></script>
    <link rel="stylesheet" href="addon/hint/show-hint.css">
    <script src="addon/hint/show-hint.js"></script>
    <script src="addon/hint/anyword-hint.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container-fluid">
    <?php

    require_once 'ftpCon.php';
    $f=new ftpCon();
    $erro=false;
    $error=null;



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
    $dirAtual=!empty($_GET['Diretorio'])?$_GET['Diretorio']:'.';
    if(!$erro){


        ?>

        <div class="row">
            <div id="resultExclude"></div>
            <div id="resultUpload">
                <?php
                if(isset($_SESSION['erroUpload'])) {
                    if (count($_SESSION['erroUpload']) > 0 && $_SESSION['erroUpload']!='OK' && $_SESSION['erroUpload']!='N') {
                        ?>
                        <script type="text/javascript">
                            bootstrapErro("<ul style='list-style-type: none'><?php foreach ($_SESSION['erroUpload'] as $error) { echo '<li>'.$error.'</li>';}?></ul><br><input type='button' class='btn btn-danger' data-dismiss='modal' value='Fechar'>");
                        </script>
                    <?php
                    } elseif($_SESSION['erroUpload']=='OK') {
                    ?>
                        <script type="text/javascript">
                            bootstrapErro(" Arquivos enviados com sucesso.<br><input type='button' class='btn btn-success' data-dismiss='modal' value='Fechar'>");
                        </script>

                    <?php
                    }
                    elseif($_SESSION['erroUpload']=='N') {
                    ?>
                        <script type="text/javascript">
                            bootstrapErro("Nenhum arquivo foi enviado.<br><input type='button' class='btn btn-warning' data-dismiss='modal' value='Fechar'>");
                        </script>

                        <?php
                    }
                    unset($_SESSION['erroUpload']);

                }
                ?>
            </div>
        </div>
        <div class="row">

            <button class="btn btn-primary createFile-buttom path-location-required" location-path="<?= $dirAtual; ?>">Novo arquivo</button>
            <button class="btn btn-primary createFolder-buttom path-location-required" location-path="<?= $dirAtual; ?>">Nova pasta</button>
            <button class="btn btn-primary uploadFile-buttom path-location-required" location-path="<?= $dirAtual; ?>">Enviar arquivo</button>
            <a href="logout.php" class="btn btn-danger pull-right">Sair</a>

        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                <th class="tooltip-all">
                    <i class="tooltip-glyphicon fa fa-check-square check-all" title="Marcar todos"></i>
                    <i class="tooltip-glyphicon fa fa-check-square-o reverse-check" title="Inverter seleção"></i>
                    <i class="tooltip-glyphicon fa fa-square-o uncheck-all" title="Desmarcar todos"></i>
                </th>
                <th>Nome</th>
                <th>Tamanho</th>
                <th>Data</th>
                <th>Atributos</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody class="table-arquivos">
            <?php
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
                            <i class="fa fa-cogs propriedades-icone" title="Propriedades" arq-location="<?= $dirAtual . $nomeArquivos[$i]; ?>"></i>
                            <?php
                            if(!$dir && $items[$nomeArquivos[$i]]['tamanho']<=209715200) {
                                echo "<a href='download.php?p=" . $dirAtual . $nomeArquivos[$i] . "' class='fa fa-cloud-download' title='Fazer download'></a>";
                            }
                            ?>
                            <i class="fa fa-exchange <?= !$dir?'rename-icone-nd':'rename-icone-d';?>" title='Renomear' arq-location="<?= $dirAtual . $nomeArquivos[$i]; ?>"></i>

                        </td>
                    </tr>
                    <?php
                }

            }
            ?>
            </tbody>
        </table>
        <button class="btn btn-default pull-right btn-calc-size path-location-required" location-path="<?= $dirAtual; ?>" data-loading-text="Calculando"><i class="fa fa-balance-scale"></i>
            Calcular tamanho</button>
        <p class="dirSize"></p>
        <div class="modal fade in" id="editarModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editor de arquivos</h4>

                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="hidden">
                            <input type="hidden" id="3b1510b2670381f1dd3277ab4bdb824b">
                        </div>
                        <h5 class="modal-title">Excluir permanentemente ?</h5>

                        <div class="btn-exclude-area" style="text-align: center;margin-top: 20px;"><input type="button" data-dismiss='modal' class="btn btn-default btn-lg" value="Não">
                            <input type="button" class="btn btn-danger btn-lg" value="Sim"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="folderCreateModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Criar pasta</h4>
                    </div>
                    <div class="modal-body">

                        <div class="hidden">
                            <input type="hidden" id="335e5656746940bfa10649e34be58887">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Digite o nome da pasta</label>
                            <input type="text" name="folderName" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="button" class="btn btn-success btn-create-folder" value="Criar">

                        </div>
                    </div>
                    <div class="modal-footer"><input type="button" class="btn btn-danger" value="Fechar"
                                                     data-dismiss="modal"></div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="fileCreateModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Criar arquivo</h4>
                    </div>
                    <div class="modal-body">

                        <div class="hidden">
                            <input type="hidden" id="955895f4878c22d49ec956a7e8d52c19">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Digite o nome do arquivo</label>
                            <input type="text" name="nameFile" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="button" class="btn btn-success btn-create-file" value="Criar">

                        </div>
                    </div>
                    <div class="modal-footer"><input type="button" class="btn btn-danger" value="Fechar"
                                                     data-dismiss="modal"></div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="fileUploadModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enviar arquivos</h4>
                    </div>
                    <div class="modal-body">
                        <form action="uploader.php" method="post" enctype="multipart/form-data" onsubmit="loadingState()">
                            <div class="hidden">
                                <input type="hidden" id="c5da39db1424d6b7ee693d9b23ee5a39" name="c5da39db1424d6b7ee693d9b23ee5a39">
                            </div>
                            <div class="alert alert-primary">Máximo de <?= ini_get("max_file_uploads");?> arquivos por vez.</div>
                            <div class="form-group">
                                <label for="" class="control-label">Selecione o arquivo</label>
                                <input type="file" name="file[]" class="form-control" multiple id="file">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success btn-upload-file" value="Enviar" data-loading-text="Enviando">

                            </div>
                        </form>

                    </div>
                    <div class="modal-footer"><input type="button" class="btn btn-danger" value="Fechar" data-dismiss="modal"></div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="deleteallModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="deleteall.php" method="post" onsubmit="loadingState()">
                            <div class="hidden">
                                <input type="hidden" name="arquivosaexcluir">
                                <input type="hidden" name="locationpathexcluirall">
                            </div>
                            <h5 class="modal-title">Excluir permanentemente ?</h5>

                            <div class="btn-exclude-all-area" style="text-align: center;margin-top: 20px;">
                                <input type="button" data-dismiss='modal' class="btn btn-default btn-lg" value="Não">
                                <input type="submit" class="btn btn-danger btn-lg btn-delete-all" value="Sim" data-loading-text="Removendo">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="renameModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Renomear <span class="rename-old-name"></span></h5>                    </div>
                    <div class="modal-body">
                        <form name="renameForm" onsubmit="return false;">
                            <div class="hidden">
                                <input type="hidden" name="oldnameRename">
                                <input type="hidden" name="isdirRename">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Digite o novo nome</label>
                                <input type="text" class="form-control" name="newnameRename">
                            </div>

                            <div class="form-group">
                                <input type="button" class="btn btn-success btn-rename" value="Renomear" data-loading-text="Renomeando">
                            </div>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-danger" value="Fechar" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="propriedadesModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Propriedades</h5>
                    </div>
                    <div class="modal-body">
                        <form name="propriedadesForm" onsubmit="return false;">
                            <div class="hidden">
                                <input type="hidden" name="nomePropriedades">
                                <input type="hidden" name="isdirPropriedades">
                                <input type="hidden" name="newPermissionT">
                                <input type="hidden" name="newPermissionN">
                            </div>
                            <div class="row" >
                                <p style="text-align: center"><span class="label label-primary permissao-label"></span></p>

                                <div class="col-md-4 user-div-propriedades">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align: center">Dono: </div>
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <label for="user1" class="list-group-item"><input type="checkbox" name="user1" id="user1" class="permissaoCheck"> Ler</label>
                                                <label for="user2" class="list-group-item"><input type="checkbox" name="user2" id="user2" class="permissaoCheck"> Escrever</label>
                                                <label for="user3" class="list-group-item"><input type="checkbox" name="user3" id="user3" class="permissaoCheck"> Executar</label>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4 group-div-propriedades">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align: center">Grupo: </div>
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <label for="group1" class="list-group-item"><input type="checkbox" name="group1" id="group1" class="permissaoCheck"> Ler</label>
                                                <label for="group2" class="list-group-item"><input type="checkbox" name="group2" id="group2" class="permissaoCheck"> Escrever</label>
                                                <label for="group3" class="list-group-item"><input type="checkbox" name="group3" id="group3" class="permissaoCheck"> Executar</label>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4 other-div-propriedades">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align: center">Outros: </div>
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <label for="other1" class="list-group-item"><input type="checkbox" name="other1" id="other1" class="permissaoCheck"> Ler</label>
                                                <label for="other2" class="list-group-item"><input type="checkbox" name="other2" id="other2" class="permissaoCheck"> Escrever</label>
                                                <label for="other3" class="list-group-item"><input type="checkbox" name="other3" id="other3" class="permissaoCheck"> Executar</label>
                                            </ul>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="form-group recursivePermissao">
                                <label for="recursivePermissao" class="list-group-item"><input type="checkbox" name="recursivePermissao" id="recursivePermissao" class="permissaoCheck"> Recursivo</label>
                            </div>



                            <div class="form-group">
                                <input type="button" class="btn btn-success btn-prop" value="Alterar" data-loading-text="Alterando">
                                <input type="button" class="btn btn-success btn-permissao-padrao" value="Aplicar permissões recomendadas" data-loading-text="Aplicando">
                            </div>
                        </form>

                        <div class="alert alert-primary">A permissão recomendada para é: 755 para diretórios e 644 para arquivos.</div>
                    </div>
                    <div class="modal-footer">

                        <input type="button" class="btn btn-danger" value="Fechar" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="propriedadesModalall">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Propriedades</h5>
                    </div>
                    <div class="modal-body">

                        <form name="propriedadesAllForm" method="post" action="chmodAll.php" onsubmit="loadingState();">
                            <div class="hidden">
                                <input type="hidden" name="arqspropriedadesAll">
                                <input type="hidden" name="locationAtualpropriedadesAll">

                            </div>
                            <div class="row" >
                                <p style="text-align: center"><span class="label label-primary permissaoAll-label">000</span></p>

                                <div class="col-md-4 userAll-div-propriedades">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align: center">Dono: </div>
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <label class="list-group-item"><input type="checkbox" class="permissaoCheckall" checked disabled> Ler</label>
                                                <label class="list-group-item"><input type="checkbox" class="permissaoCheckall" checked disabled> Escrever</label>
                                                <label for="userAll3" class="list-group-item"><input type="checkbox" name="userAll3" id="userAll3" class="permissaoCheckAll"> Executar</label>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4 groupAll-div-propriedades">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align: center">Grupo: </div>
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <label for="groupAll1" class="list-group-item"><input type="checkbox" name="groupAll1" id="groupAll1" class="permissaoCheckAll"> Ler</label>
                                                <label for="groupAll2" class="list-group-item"><input type="checkbox" name="groupAll2" id="groupAll2" class="permissaoCheckAll"> Escrever</label>
                                                <label for="groupAll3" class="list-group-item"><input type="checkbox" name="groupAll3" id="groupAll3" class="permissaoCheckAll"> Executar</label>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4 otherAll-div-propriedades">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align: center">Outros: </div>
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <label for="otherAll1" class="list-group-item"><input type="checkbox" name="otherAll1" id="otherAll1" class="permissaoCheckAll"> Ler</label>
                                                <label for="otherAll2" class="list-group-item"><input type="checkbox" name="otherAll2" id="otherAll2" class="permissaoCheckAll"> Escrever</label>
                                                <label for="otherAll3" class="list-group-item"><input type="checkbox" name="otherAll3" id="otherAll3" class="permissaoCheckAll"> Executar</label>
                                            </ul>
                                        </div>
                                    </div>

                                </div>


                            </div>




                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Alterar" data-loading-text="Alterando" onclick="$(this).button('loading');">
                            </div>
                        </form>

                        <div class="alert alert-primary">A permissão recomendada para é: 755 para diretórios e 644 para arquivos.</div>
                    </div>
                    <div class="modal-footer">

                        <input type="button" class="btn btn-danger" value="Fechar" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


    <div class="modal fade in" id="modalError" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body"><?= $GLOBALS['error'];?>
                    <br>
                    <a href="login.php" class="btn btn-warning">Login</a></div>
            </div>

        </div>

    </div>


    <div id="menuSelector" class="menuSelector">
        <input type="button" class="btn btn-danger delete-all path-location-required" value="Remover" data-arqs="" location-path="<?= $dirAtual; ?>">
        <input type="button" class="btn btn-primary propriedades-all path-location-required" value="Propriedades" data-arqs="" location-path="<?= $dirAtual; ?>">
    </div>

</div>
<div class="overlay"></div>


</body>
</html>