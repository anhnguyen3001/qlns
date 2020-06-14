<div class="modal" tabindex='1' id='add-modal'>
    <div class="layer" data-open='add-modal' data-refresh='#add-user'></div>
    <div class="modal-dialog small-form">
        <!-- Modal header -->
        <div class="modal-header center">Thêm tài khoản</div>
        <div class="column modal-body">
            <div class="row wrong message" id='add-message'></div>
            <form action='<?php echo ROOT_LINK?>User/add' id="add-user" method='POST'>
                <div class="row header-section">Tài khoản cho: </div>
                <div class="row center" id='typeAccount'>
                    <div class="col-3" style='text-align:left'>
                        <input type='checkbox' class='typeAccount' id='manager' name='role[]' value="manager" data-toggle='depChoose' data-position ="Trưởng phòng">
                        <label for='manager'>Trưởng phòng</label>
                    </div>
                    <div class="col-3">
                        <input type='checkbox' class='typeAccount employee' id='accountant' name='role[]' value="accountant" data-toggle='employeeChoose' data-department = 'Kế toán'>
                        <label for='accountant'>Nhân viên kế toán</label>
                    </div>
                    <div class="col-3">
                        <input type='checkbox' class=' typeAccount employee' id='hr' name='role[]' value="personnel" data-toggle='employeeChoose' data-department = 'Nhân sự'>
                        <label for='hr'>Nhân viên nhân sự</label>
                    </div>
                </div>
                <div class="row register-info" id='choosePos'>
                    <div class="group-form col-1">
                        <label class='label-form'>Phòng ban</label>
                        <select class="form-input more">
                        </select>
                    </div>
                </div>
                <div class="row register-info" id='empID'>
                    <div class="group-form col-1">
                        <label class='label-form'>MSNV</label>
                        <select class="form-input more" name='employeeID'>
                        </select>
                    </div>
                </div>
                <div class="row register-info" id='empName'>
                    <div class="group-form col-1">
                        <label class='label-form'>Tên nhân viên</label>
                        <div class="form-input"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-1">
                        <label for='password' class='label-form'>Mật khẩu <span class='required-symbol'>*</span></label>
                        <input type='password' name='password' id='password' class="form-input disabled" required>
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" class='col-4 btn-primary save-btn' id='add-user-btn' data-submit='add-modal' value="Thêm">
                </div>
            </form>
        </div>
    </div>
</div>