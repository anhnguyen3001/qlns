$(document).ready(function(){
    $('.edit').click(function(){
        var id = $(this).attr('id'); 

        $('#currentID').val(id);
        $('#currentName').val($('#name-' + id).html());
    });        
})