$(document).ready(function(){
    var path = $('#path').html();
    $('#add-user').change(function(){
        var
            role = $("input[name='role']:checked", '#add-user').attr('data-account'),
            username = $('#' +role).val();

        if (username !== '' && username !== undefined){
            $.ajax({
                method: "POST",
                url: path + 'Ajax/getUser',
                data:{'username' : username},
                dataType: "json",
                success: function(data){
                    if (data == null || data == undefined){
                        $('#' + role).addClass('true');
                        $('#' + role).removeClass('wrong');
                    } else {
                        $('#' + role).addClass('wrong');
                        $('#' + role).removeClass('true');
                    }
                }
            });

            if (role == 'employeeID'){
                $.ajax({
                    method: "POST",
                    url: path + 'Ajax/getEmployee',
                    data:{'id' : username},
                    dataType: "json",
                    success: function(data){
                        if (data != null){
                            $('#' + role).addClass('true');
                            $('#' + role).removeClass('wrong');
                        } else {
                            $('#' + role).addClass('wrong');
                            $('#' + role).removeClass('true');
                        }
                    }
                });
            }
        }
    });

    $('#add-user').submit(function(e){
        var role = $("input[name='role']:checked", '#add-user').attr('data-account');
    
        if ($('#' + role).val() == '' ){
            $('#' + role).addClass('wrong');
            $('#' + role).removeClass('true');
            return false;
        }
        
        if (role != 'employeeID'){
            $('#departmentTitle').val($('#' + role + " option:selected").html().trim());
        } 

        if ($('#' + role).attr('class').match(/wrong/) !== null){
            return false;
        }
    });

    // Create account
    // Manager account
    $("input[name='role']").change(function(){
        var role = $("input[name='role']:checked", '#add-user').attr('data-account');
        
        if (role == 'employeeID'){
            $('#area-user').remove();
            $('#typeAccount').after(
                '<div class="row" id="area-user">'
                + '<div class="group-form col-1">'
                + '<label for="employeeID" class="label-form">MSNV <span class="required-symbol">*</span></label>'
                + '<input type="text" name="employeeID" id="employeeID" class="form-input disabled"></div></div>');
        } else {
            $('#area-user').remove();
            $.ajax({
                method: "POST",
                url: path + 'Ajax/getDepartment',
                data:{'getDep' : true},
                dataType: "json",
                success: function(data){
                    var option = '';
                    for (var i = 0; i< data.length; i++){
                        option += "<option value='" + data[i].departmentID + "'>" + data[i].departmentTitle + "</option>";
                    }

                    $('#area-user').remove();
                    $('#typeAccount').after(
                    '<div class="row" id="area-user">'
                    + '<div class="group-form col-1">'
                    + '<label for="departmentID" class="label-form">Phòng ban <span class="required-symbol">*</span></label>'
                    + '<select id="departmentID" name="departmentID" class="form-input">'
                    + '<option></option>'
                    + option
                    + '</select></div>'
                    + "<input type='hidden' id='departmentTitle' name='departmentTitle'></div>");
                }
            });
        }
    });
});