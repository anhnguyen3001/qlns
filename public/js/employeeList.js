$(document).ready(function(){
    var path = $('#path').html();
    // Limit bar autosubmit when change the limit input
    $('#limit').change(function(){
        $('#filter-form').submit();
    });    

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

    // Generate new employeeID 
    $('.add-btn.employee').click(function(){
        $.ajax({
            method: "POST",
            url: path +'Ajax/getNewEmployeeID',
            data:{'getID' : true},
            dataType: "json",
            success: function(data){
                $('#newEmpID').val(data);
            }
        });

        $('#add-message').removeClass('show');
    });

    $('.typeAccount').click(function(){
        if (/employee/.test($(this).attr('class')) && $('.employee:checked').length > 1){
            $('#add-message').html('Chọn không hợp lệ');
            $('#add-message').addClass('show');
            return false;
        }

        if ($('#manager').is(':checked')){
            if($('#position :checked').html().trim() != $(this).attr('data-position')){
                $('#add-message').html('Loại tài khoản không phù hợp');
                $('#add-message').addClass('show');
                return false;
            };
        };

        if ($('.employee').is(':checked')){
            if($('#department :checked').html().trim() != $(this).attr('data-department')){
                $('#add-message').html('Loại tài khoản không phù hợp');
                $('#add-message').addClass('show');
                return false;
            }
        }
    });

    // Get info when click edit: employee
    $('.edit-employee').click(function(){
        if ($('#modal-employeeID').val() === ''){
            var employeeID = $(this).attr('id'); 
            $.ajax({
                method: "POST",
                url: path + 'Ajax/getEmployee',
                data:{'id' : employeeID},
                dataType: "json",
                success: function(data){
                    $('#modal-employeeID').val(data.employeeID);
                    $('#modal-fullname').val(data.fullName);
                    $('#modal-startDate').val(data.startDate);
                    $('#modal-dob').val(converToBlankString(data.dob));
                    $('#modal-gender').val(converToBlankString(data.gender));
                    $('#modal-address').val(converToBlankString(data.address));
                    $('#modal-phone').val(converToBlankString(data.phone));
                    $('#modal-resignDate').val(converToBlankString(data.resignDate));

                    // Education
                    var education = data.educationID;
                    if (education != ''){
                        $('#' + education).attr('default', true);
                        $('#' + education).attr('selected', true);
                    } else {
                        $('#default-edu').attr('defaulted', true);
                        $('#default-edu').attr('selected', true);
                    }

                    // Position
                    var posID = data.positionID;
                    $('#' + education).attr('default', true);
                    $('#' + education).attr('selected', true);

                    // Education
                    var depID = data.departmentID;
                    $('#' + depID).attr('default', true);
                    $('#' + depID).attr('selected', true);
                    
                    $('#modal-currentDate').val(data.date);

                    // Wage
                    $('#modal-wage').html(formatMoney(data.wage));
                    $('#modal-level').html(data.level);
                    $('#modal-dateWage').html(converDateToString(data.validDate));

                    // Current state
                    $('.empID-hidden').val(data.employeeID);
                    $('#currentPos').val(data.positionID);
                    $('#currentDep').val(data.departmentID);
                    $('#currentPosDate').val(converDateToString(data.date));
                    $('#currentWage').val(data.wage);
                    $('#currentLevel').val(data.level);
                    $('#currentDateWage').val(converDateToString(data.validDate));

                    posID = $('#currentPos').val();
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

    function converToBlankString(value){
        return (value === 'N/A') ? '' : value;
    }

    function converDateToString(date){
        date = date.split('-');
        return date[2] + '-' + date[1] + '-' + date[0];
    }

    function formatMoney (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }
});