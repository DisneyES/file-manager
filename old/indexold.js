$(document).ready(function () {
    $('[name=newnameRename]').keypress(function (e) {
        if(e.which==13){
            $('.btn-rename').click();
        }

    });
    $('[name=folderName]').keypress(function (e) {
        if(e.which==13){
            $('.btn-create-folder').click();
        }
    });
    $('[name=nameFile]').keypress(function (e) {
        if(e.which==13){
            $('.btn-create-file').click();
        }
    });
    $(window).keydown(function (e) {
        if (e.which == 16) {
            between = true;
        }
    });
    $(window).keyup(function () {
        between=false;
    });
    $("[type=checkbox]").change(function (event, index) {
        if(between) {
            $s = $(this);

            if ($s.is(":checked")) {
                selectBetween($('[type=checkbox]').index($s));
            }
        }
        if ($('[type=checkbox]:checked').length > 0) {
            activeMenu();
        }
        else {
            removeMenu();
        }
    });
});
$('.btn-delete-all').click(function () {
    $(this).button('loading');
});
$('.delete-all').click(function () {
    $('#deleteallModal').modal('show');
    $('[name=locationpathexcluirall]').val($(this).attr('location-path'));
    $('[name=arquivosaexcluir]').val($(this).attr('data-arqs'));
});
$('.reverse-check').click(function(){
    $('.table').find('input[type=checkbox]:checked').attr('class','desmarcar');
    $('.table').find('input[type=checkbox]:not(:checked)').attr('class','marcar');
    $('.desmarcar').prop('checked',false);
    $('.marcar').prop('checked',true);
    $('.table').find('input[type=checkbox]').attr('class','');
    if($('[type=checkbox]:checked').length>0){
        activeMenu();
    }
    else{
        removeMenu();
    }
});
$('.uncheck-all').click(function(){
    $('.table').find('input[type=checkbox]').prop('checked',false);
    if($('[type=checkbox]:checked').length>0){
        activeMenu();
    }
    else{
        removeMenu();
    }
});
$('.editar-icone').click(function () {
    $('#editarModal').find('.modal-body').html('');

    $.post('edit.php',{"arq": $(this).attr('arq-location')}, function (data) {
        $('#editarModal').find('.modal-body').html(data);
        $('#editarModal').modal('show');

    });
});
$('.rename-icone-nd').click(function () {
    activeClick=$(this);
    var nameArq=activeClick.attr('arq-location').split('/');
    $('.rename-old-name').html(nameArq[(nameArq.length-1)]);
    $('#renameModal').modal('show');
    $('[name=oldnameRename]').val(activeClick.attr('arq-location'));
    $('[name=isdirRename]').val('false');


});
$('.rename-icone-d').click(function () {
    activeClick=$(this);
    var nameArq=activeClick.attr('arq-location').split('/');
    $('.rename-old-name').html(nameArq[(nameArq.length-1)]);
    $('#renameModal').modal('show');
    $('[name=oldnameRename]').val(activeClick.attr('arq-location'));
    $('[name=isdirRename]').val('true');


});