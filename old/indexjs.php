var between = false;
var activeClick;
$(document).ready(function () {
$('.btn-rename').click(function () {
$btn = $(this);
$btn.button('loading');
$.post('rename.php', $('[name=renameForm]').serialize(), function (data) {
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
}); <?php include 'restart.php'; ?> $('.btn-delete-all').click(function () {
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
$btn = $(this);
$btn.val('Removendo');
$btn.attr('disabled', 'true');
$.post("delete.php", {
"arq": $('#3b1510b2670381f1dd3277ab4bdb824b').val()
}, function (data) {
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
$btn = $(this);
$btn.val('Criando');
$btn.attr('disabled', 'true');
$.post("mkdir.php", {
"path": $('#335e5656746940bfa10649e34be58887').val(),
"file": $('[name=folderName]').val()
}, function (data) {
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
$btn = $(this);
$btn.val('Criando');
$btn.attr('disabled', 'true');
$.post("touch.php", {
"path": $('#955895f4878c22d49ec956a7e8d52c19').val(),
"file": $('[name=nameFile]').val()
}, function (data) {
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
})
})
});

function pager(local) {
$('.btn').attr('disabled',true);
history.pushState('data', '', '?Diretorio=' + local);
$.post("pager.php", {
"local": local
}, function (data) {
$('.table').DataTable().destroy();
$('.table-arquivos').html(data);
removeMenu(); <?php include 'restart.php'; ?>
$('.btn').attr('disabled',false);
})
}