$(document).ready(function(){
    var path = $('#path').html();

    // Effect for nav-item: edit dialog
    $('.nav-items').click(function(){
        if (!/active/.test($(this).attr('class'))){
            $('.nav-items').each(function(){
                if (/active/.test($(this).attr('class'))){
                    deactiveNavItem($(this));
                }
            });
            
            activeNavItem($(this));
        }
    });

    // Get info when click edit: employee
    $('.edit-employee').click(function(){
        var posID = $('#currentPos').val();

        if (!/option/.test($('#level').html())){
            $.ajax({
                method: "POST",
                url: path + 'Ajax/getWageLevel',
                data:{'getWage':true, 'positionID' : posID},
                dataType: "json",
                success: function(data){
                    // Set wage-level select input
                    $('#level').append("<option value='' default selected></option>");
                    $('#wage').append("<option value='' default selected></option>");
    
                    for (var i = 0; i < data.length; i++){
                        $('#level').append(
                            '<option value="' + data[i].level +'">' + data[i].level +'</option>'
                        );
                        $('#wage').append(
                            '<option id="level' + data[i].level +'" ' + 'value="' + data[i].wage +'">' + formatMoney(data[i].wage) +'</option>'
                        );
                    }
                }
            });
        }

        $('#level').change(function(){
            var optionChoose = $('#level').find(':selected').val();
            $('#wage').children().attr('selected', false);
            $('#wage').children('#level' + optionChoose).attr('selected', true);
        })
    });

    function deactiveNavItem(navItem){
        navItem.removeClass('active');

        var formID = $(navItem).attr('data-toggle'); 
        $(formID).removeClass('show');
    }

    function activeNavItem(navItem){
        navItem.addClass('active');

        var formID = $(navItem).attr('data-toggle'); 
        $(formID).addClass('show');
    }

    function formatMoney (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }
});