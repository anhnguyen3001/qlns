$(document).ready(function(){
    var path = $('#path').html();
    $('.add-btn').click(function(){
        $('#choosePos label-form span').remove();
        $('#empID label-form span').remove();
        $('#empName .form-input').html('');
        $('.register-info').removeClass('hidden');
        $('.nofound').remove();
        $('#add-message').removeClass('show');
    });

    $('#add-user').submit(function(){
        if ($('#add-user input[type=checkbox]:checked').length == 0){
            $('#add-message').html('Chưa chọn loại tài khoản');
        }

        if ($('.nofound').length != 0 || $('#empID select').val() == ''){
            $('#add-message').html('Chưa có nhân viên nào được chọn');
        }

        if ($('#add-message').html() != '') {
            $('#add-message').addClass('show');
            return false;
        }
    })

    // Choose type of account
    $('.typeAccount').click(function(){
        if (/employee/.test($(this).attr('class')) && $('.employee:checked').length > 1){
            $('#add-message').html('Chọn không hợp lệ');
            $('#add-message').addClass('show');
            return false;
        }

        $('#empName .form-input').html('');
        $('#choosePos select').val('');
        $('#empID select').val('');

        var pos = '', dep = '';
        
        if ($('.employee').is(':checked')){
            dep = $('.employee:checked').attr('data-department');

            if (!$('#manager').is(':checked')) 
                $('#choosePos .required-symbol').remove();
        } else $('#empID .required-symbol').remove();

        if ($('#manager').is(':checked')){
            pos = $('#manager').attr('data-position');
            
            if ($('#empID .required-symbol').length != 0) $('#empID .required-symbol').remove();
        } else $('#choosePos .required-symbol').remove();
        
        if ($('.nofound').length != 0) $('.nofound').remove();
        
        if (pos != '' || dep != ''){
            $.ajax({
                method: "POST",
                url: path + 'Ajax/getManagerAccount',
                data:{'positionTitle' : pos, 'departmentTitle' : dep},
                dataType: "json",
                success: function(data){
                    if (data.length == 0){
                        if ($('.nofound').length == 0){
                            var div = document.createElement('div');
                            div.innerHTML = 'Không tồn tại nhân viên';
                            document.getElementById("typeAccount").after(div);
                            div.setAttribute('class', 'row more wrong nofound');
                            div.setAttribute('style', 'margin-top: 20px; font-size: 120%');
                        }

                        // Hide department, employeeID, employeeName when found no result
                        $('.register-info').addClass('hidden');
                        $('.register-info select').removeAttr('name');
                        return;
                    }
                    
                    $('.register-info').removeClass('hidden');
                    $('#empID select').children().remove();
                    var option = document.createElement('option');
                    option.innerHTML = '';
                    $('#empID select').append(option);
                    $('#empID select').attr('name', 'employeeID');
                    for(var i = 0; i < data.length; i++){
                        var option = document.createElement('option');
                        option.innerHTML = data[i].employeeID;
                        $('#empID select').append(option);
                        option.setAttribute('data-name', data[i].fullName);
                    }

                    if (pos != ''){
                        $('#empID select').attr('readonly', 'readonly');
                        $('#choosePos select').removeAttr('readonly');
                        $('#empID label-form span').remove();

                        if ($('#choosePos .required-symbol').length == 0){
                            var span = document.createElement('span');
                            span.innerHTML = ' *';
                            $('#choosePos .label-form').append(span);
                            span.setAttribute('class', 'required-symbol');
                        }

                        $('#choosePos select').children().remove();
                        var option = document.createElement('option');
                        option.innerHTML = '';
                        $('#choosePos select').append(option);
                        for(var i = 0; i < data.length; i++){
                            var option = document.createElement('option');
                            option.innerHTML = data[i].departmentTitle;
                            $('#choosePos select').append(option);
                            option.setAttribute('data-empID', data[i].employeeID);
                            option.setAttribute('data-name', data[i].fullName);
                        }

                        $('#choosePos select').attr('required', 'required');
                        $('#empID select').removeAttr('required');

                        $('#choosePos').change(function(){
                            var empID = $(this).find(':selected').attr('data-empID'),
                                name = $(this).find(':selected').attr('data-name');

                            $('#empID select').val(empID);
                            $('#empName .form-input').html(name);
                        });
                        
                        return;
                    }

                    if ($('#empID .required-symbol').length == 0){
                        var span = document.createElement('span');

                        span.innerHTML = ' *';
                        $('#empID .label-form').append(span);
                        span.setAttribute('class', 'required-symbol');
                    }

                    $('#choosePos select').attr('readonly', 'readonly');
                    $('#choosePos select').removeAttr('required');
                    $('#empID select').attr('required', 'required');
                    $('#empID select').removeAttr('readonly');

                    $('#empID').change(function(){
                        var name = $(this).find(':selected').attr('data-name');
                        $('#empName .form-input').html(name);
                    })
                }
            });
        }
    });
});