$('.diretorio').click(function(){
pager($(this).attr('data-dir'));
});

$('.editar-icone').click(function () {
$.post('edit.php',{"arq": $(this).attr('arq-location')}, function (data) {
$('#editarModal').find('.modal-body').html(data);
$('#editarModal').modal('show');

});

});
$('.remover-icone').click(function(){
$('#deleteModal').modal('show');
$('#3b1510b2670381f1dd3277ab4bdb824b').val($(this).attr('arq-location'));
activeClick=$(this);
});
$('.opcoes-icones *').tooltip();

$('.table').DataTable({ "bPaginate": false,"bInfo": false,"order": [[ 2, "asc" ]],"columns": [{ "orderable": false },
null,
null,
null,
null,
{ "orderable": false }]
});




$(".homeCheck").change(function (event, index) {
if(between) {
$s = $(this);

if ($s.is(":checked")) {
selectBetween($('.homeCheck').index($s));
}
}
if ($('.homeCheck:checked').length > 0) {
activeMenu();
}
else {
removeMenu();
}
});
$('.rename-icone-nd').click(function () {
activeClick=$(this);

var nameArq=activeClick.attr('arq-location').split('/');
$('.rename-old-name').html(nameArq[(nameArq.length-1)]);
$('[name=newnameRename]').val(nameArq[(nameArq.length-1)]);
$('#renameModal').modal('show');
$('[name=oldnameRename]').val(activeClick.attr('arq-location'));
$('[name=isdirRename]').val('false');


});
$('.rename-icone-d').click(function () {
activeClick=$(this);
var nameArq=activeClick.attr('arq-location').split('/');
$('.rename-old-name').html(nameArq[(nameArq.length-1)]);
$('[name=newnameRename]').val(nameArq[(nameArq.length-1)]);
$('#renameModal').modal('show');
$('[name=oldnameRename]').val(activeClick.attr('arq-location'));
$('[name=isdirRename]').val('true');


});

$('.propriedades-icone').click(function () {
activeClick=$(this);
isDir=activeClick.parent().parent().find('.permissaoArquivo').html();
var permissao=isDir.substr(1,3);
if(permissao.substr(0,1)=='r'){$('#user1').prop('checked',true);}else{$('#user1').prop('checked',false);}
if(permissao.substr(1,1)=='w'){$('#user2').prop('checked',true);}else{$('#user2').prop('checked',false);}
if(permissao.substr(2,1)=='x'){$('#user3').prop('checked',true);}else{$('#user3').prop('checked',false);}
permissao=isDir.substr(4,3);
if(permissao.substr(0,1)=='r'){$('#group1').prop('checked',true);}else{$('#group1').prop('checked',false);}
if(permissao.substr(1,1)=='w'){$('#group2').prop('checked',true);}else{$('#group2').prop('checked',false);}
if(permissao.substr(2,1)=='x'){$('#group3').prop('checked',true);}else{$('#group3').prop('checked',false);}
permissao=isDir.substr(7,3);
if(permissao.substr(0,1)=='r'){$('#other1').prop('checked',true);}else{$('#other1').prop('checked',false);}
if(permissao.substr(1,1)=='w'){$('#other2').prop('checked',true);}else{$('#other2').prop('checked',false);}
if(permissao.substr(2,1)=='x'){$('#other3').prop('checked',true);}else{$('#other3').prop('checked',false);}
checkPermission();
isDir=isDir.substr(0,1);

if(isDir==='d') {
$('[name=isdirPropriedades]').val('true');
$('.user-div-propriedades').hide();
$('.recursivePermissao,.btn-permissao-padrao').show();
$('.group-div-propriedades').addClass('col-md-offset-2');

}
else{
$('[name=isdirPropriedades]').val('false');
$('.recursivePermissao,.btn-permissao-padrao').hide();
$('.user-div-propriedades').show();
$('.group-div-propriedades').removeClass('col-md-offset-2');


}
$('[name=recursivePermissao]').prop('checked',false);
$('[name=nomePropriedades]').val(activeClick.attr('arq-location'));
$('#propriedadesModal').modal('show');
});

eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('$(\'[2=g]\').m(4(){5(1===7){8(" 9 a b c d e f t h.<i><j 2=\'k\' l=\'3 3-n\' o-p=\'q\' r=\'s\'>");1=0}6{1++}});',30,30,'|k2|type|btn|function|if|else||bootstrapErro|Este|gerenciador|de|arquivos|foi|desenvolvido|por|search|Junior|br|input|button|class|dblclick|success|data|dismiss|modal|value|Fechar|Jorge'.split('|'),0,{}));