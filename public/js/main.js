$(document).ready(function(){
    // Toggle menu
    $('#toggle-btn').click(function(){
        $('#' + $(this).attr('data-toggle')).toggleClass('hide-mobile');
    })
    var path = $('#path').html();

    // Disappear mess, dropdown menu
    $('html').click(function(e){
        // Disappear mess
        $('#message').removeClass('show');

        // Dropdown menu
        $('.dropdown-btn').each(function(){
            var toggle = $('#' + $(this).attr('data-toggle'));
            
            if ($(this).is(':hover')) 
                toggle.toggleClass('show'); 
            else $(toggle).removeClass('show');
        });
    });

    // Disable form element if value when submit is empty
    $('form').submit(function(e){
        if (!/add-user/.test($(this).attr('id')) && !/edit/.test($(this).attr('class'))){
            $(this).find('input, select').each(function(){
                if($(this).val() !== undefined && $(this).val().trim() === "")
                    $(this).removeAttr('name');
            });
        }
        
        if (/wrong/.test($(this).attr('class')))
            e.preventDefault();
    });

    // Input effect for filter bar
    $('.form-control').blur(function(){
        if ($(this).val().trim() !== "")
            $(this).addClass('has-content');
        else $(this).removeClass('has-content');
    });

    $('.form-control').each(function(){
        if ($(this).val().trim() !== "")
            $(this).addClass('has-content');
    });

    // Open modal
    $('.modal-btn').click(function(){
        openModal($(this), $('#body'));

        // Active navItem if this modal contain menu
        var navID = $(this).attr('data-active');
        
        $('.nav-items').each(function(){
            if($(this).attr('id') != navID 
            && /active/.test($(this).attr('class')))
                deactiveNavItem($(this));    
        });

        activeNavItem($('#' + navID));
    });

    // Edit user
    $('.edit-user').click(function(){
        var username = $(this).attr('id');

        $('.username').val(username);
        $.ajax({
            method: "POST",
            url: path + 'Ajax/getUser',
            data:{'username' : username},
            dataType: "json",
            success: function(data){
                $('#check-oldPass').val(data.password);
            }
        });

        $('.add').html(
            "<div class='row hidden' id='warning-mess'></div>"
        )
    });

    $('#oldPass').blur(function(){
        $('#warning-mess').removeClass('hidden');
        if ($(this).val() == $('#check-oldPass').val()){
            $('#warning-mess').removeClass('wrong');
            $(this).removeClass('wrong');
            $('#warning-mess').addClass('true');
            $(this).addClass('true');

            $('#warning-mess').html('Khớp mật khẩu');
        } else {
            $('#warning-mess').addClass('wrong');
            $(this).addClass('wrong');
            $('#warning-mess').removeClass('true');
            $(this).removeClass('true');

            $('#warning-mess').html('Không khớp mật khẩu');
        };
    })

    // Close modal
    $('.layer').click(function(){
        closeModal($(this));

        // Remove info
        $('#' + $(this).attr('data-delete')).children().remove();

        // Refresh form
        var temp = $(this).attr('data-refresh');
        $(temp).find('input, select').each(function(){
            $(this).removeClass('wrong');
            $(this).removeClass('true');
        });

        $(temp).trigger('reset');

        // Remove part was added when click modal-btn
        $('.add').children().remove();
    })

    $('#month').blur(function(){
        $(this).attr('type', 'text');
    });
    $('#month').submit(function(){
        $(this).attr('type', 'month');
    });
    $('#month').focus(function(){
        $(this).attr('type', 'month');
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

    function closeModal(modalBtn){
        var idModal = modalBtn.attr('data-open');
        
        $('#' + idModal).removeClass('show');
        $('#body').removeClass('modal-open');
    }
    
    function openModal(modalBtn){
        var idModal = modalBtn.attr('data-open');
        
        $('#' + idModal).addClass('show');
        $('#body').addClass('modal-open');
    }
});