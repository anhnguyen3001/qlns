$(document).ready(function(){
    $('.edit-position').click(function(){
        var id = $(this).attr('id');
        $('#currentID').val(id);
        $('#currentName').val($('#name-' + id).html());
        $('#currentAllowance').val($('#allowance-' + id).html());
    })
});