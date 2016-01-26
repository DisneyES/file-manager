<?php
@session_start();
require_once 'ftpCon.php';

$content = file_get_contents('ftp://'.base64_decode($_SESSION[MD5('user')]).':'.base64_decode($_SESSION[MD5('password')]).'@'.base64_decode($_SESSION[MD5('server')]).DIRECTORY_SEPARATOR.$_POST['arq']);
?>

    <form name="editArq">
        <div class="hidden">
    <input type="hidden" name="<?= MD5('fileLocation');?>" value="<?= base64_encode($_POST['arq']);?>">
</div>
<div class="form-group">
    <label class="control-label">Arquivo <?= end(explode(DIRECTORY_SEPARATOR,$_POST['arq']));?>:</label>
    <textarea class="form-control arquivo-edit-area hidden" name="content" wrap="hard"  ><?= htmlspecialchars($content);?></textarea>

</div>
<article id="arquivo-edit-area"></article>

<div class="form-group">
    <input type="button" class="btn btn-success btn-save-edit" value="Salvar">
</div>
<div id="result"></div>
    </form>
<?php
unset($content);
?>
<script>

    $(document).ready(function () {

        $('.btn-save-edit').click(function () {
            var line=editor.getValue();
            loadingState();
            $btn=$(this);
            $btn.val("Editando");
            $btn.attr('disabled','true');
            $.post("edit_t.php",{
                "<?= MD5('fileLocation');?>": $('[name=<?= MD5('fileLocation');?>]').val(),
                "content": line
            }, function (data) {
                finishLoading();
                $('#result').html(data);
                $btn.attr('disabled',false);
                $btn.val("Salvar");


            });
        });
        $('.modal').on('shown.bs.modal', function() {
            if(typeof editor == 'undefined'){

                editor=CodeMirror(document.getElementById('arquivo-edit-area'), {
                    value: $('.arquivo-edit-area').val(),
                    mode: "javascript",
                    keyMap: "sublime",
                    autoCloseBrackets: true,
                    matchBrackets: true,
                    theme: "neo",
                    lineNumbers: true,
                    showCursorWhenSelecting: true,
                    renderLine: true,
                    lineWrapping: true
                });

                editor.on("keyup", function (cm, event) {
                    if (!cm.state.completionActive &&
                        (event.keyCode >= 65 && event.keyCode<=90)
                    ){
                        CodeMirror.commands.autocomplete(cm, null, {completeSingle: false});

                    }
                });



            }
            else{
                $('.CodeMirror').remove();

                editor=CodeMirror(document.getElementById('arquivo-edit-area'), {
                    value: $('.arquivo-edit-area').val(),
                    mode: "javascript",
                    keyMap: "sublime",
                    autoCloseBrackets: true,
                    matchBrackets: true,
                    theme: "neo",
                    autofocus: true,
                    lineNumbers: true,
                    renderLine: true,
                    lineWrapping: true
                });
                editor.on("keyup", function (cm, event) {
                    if (!cm.state.completionActive &&
                        (event.keyCode >= 65 && event.keyCode<=90)
                    ){
                        CodeMirror.commands.autocomplete(cm, null, {completeSingle: false});

                    }
                });

            }

        });

    });
</script>
