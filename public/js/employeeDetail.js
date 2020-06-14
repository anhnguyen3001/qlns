$(document).ready(function(){
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