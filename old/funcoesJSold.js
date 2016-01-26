function bootstrapErro(erro) {
    setTimeout(function(){
        $('#modalError').modal('show');
        $('#modalError').find('.modal-body').html(erro);
    },100);
}
function activeMenu(){
    $('#menuSelector').slideDown('1000');
    var list='';
    $('.homeCheck:checked').each(function () {
        list=list+$(this).parent().parent().find('.opcoes-icones').find('.fa-times').attr('arq-location')+'|||||';
    });
    $('.delete-all,.propriedades-all').attr('data-arqs',list);

}
function removeMenu(){
    $('#menuSelector').slideUp('1000');
    $('.delete-all,.propriedades-all').attr('data-arqs','');

}
function selectBetween(currentIndex) {

    try {

        if ($('.homeCheck:checked').length > 1) {
            var startIndex = $('.homeCheck').index($('.homeCheck:checked')[0]);

            if (startIndex != undefined && startIndex != null && startIndex != -1 && currentIndex > startIndex) {

                for (var indx = startIndex; indx <= currentIndex; indx++) {
                    $('.homeCheck').eq(indx).prop("checked", true);
                }
            }
        }
    }
    catch (e) {

        $(".homeCheck").prop("checked", false);
    }
}
function checkPermission() {
    user=[0,''];
    group=[0,''];
    other=[0,''];

    if($('#user1').prop('checked')===true){user[0]+=4;user[1]=user[1]+'r'}else{user[1]=user[1]+'-';}if($('#user2').prop('checked')===true){user[0]+=2;user[1]=user[1]+'w';}else{user[1]=user[1]+'-';}if($('#user3').prop('checked')===true){user[0]+=1;user[1]=user[1]+'x';}else{user[1]=user[1]+'-';}
    if($('#group1').prop('checked')===true){group[0]+=4;group[1]=group[1]+'r'}else{group[1]=group[1]+'-';}if($('#group2').prop('checked')===true){group[0]+=2;group[1]=group[1]+'w';}else{group[1]=group[1]+'-';}if($('#group3').prop('checked')===true){group[0]+=1;group[1]=group[1]+'x';}else{group[1]=group[1]+'-';}
    if($('#other1').prop('checked')===true){other[0]+=4;other[1]=other[1]+'r'}else{other[1]=other[1]+'-';}if($('#other2').prop('checked')===true){other[0]+=2;other[1]=other[1]+'w';}else{other[1]=other[1]+'-';}if($('#other3').prop('checked')===true){other[0]+=1;other[1]=other[1]+'x';}else{other[1]=other[1]+'-';}

    $('.permissao-label').html(user[0]+''+group[0]+''+other[0]);
    $('[name=newPermissionN]').val(user[0]+''+group[0]+''+other[0]);
    $('[name=newPermissionT]').val(user[1]+''+group[1]+''+other[1])
}
function checkPermissionAll() {
    user=[6];
    group=[0];
    other=[0];

    if($('#userAll3').prop('checked')===true){
        user[0]+=1;
    }
    if($('#groupAll1').prop('checked')===true) {
        group[0] += 4;
    }
    if($('#groupAll2').prop('checked')===true){
        group[0]+=2;
    }
    if($('#groupAll3').prop('checked')===true){
        group[0]+=1;
    }
    if($('#otherAll1').prop('checked')===true){
        other[0]+=4;
    }
    if($('#otherAll2').prop('checked')===true){
        other[0]+=2;
    }
    if($('#otherAll3').prop('checked')===true){
        other[0]+=1;
    }

    $('.permissaoAll-label').html(user[0]+''+group[0]+''+other[0]);

}
function loadingState(){
    //$('.overlay').css({"width": $(window).width(),"height": $(window).height()});
    $('.overlay').css({"width": "100%","height": "100%"});
    $('body').css("cursor","progress");
}
function finishLoading(){
    $('.overlay').css({"width": "0px","height": "0px"});
    $('body').css("cursor","auto");

}