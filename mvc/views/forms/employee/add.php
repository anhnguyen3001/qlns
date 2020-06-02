<div class="modal" tabindex='1' id='add-modal'>
    <div class="layer" data-open='add-modal' data-refresh='#add-employee'></div>
    <div class="modal-dialog">
        <!-- Modal header -->
        <div class="modal-header center">Tạo mới nhân viên</div>
        <div class="column modal-body">
            <form action="<?php echo ROOT_LINK?>Employee/add" id="add-employee" method='POST'>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='newEmpID' class='label-form'>MSNV <span class='required-symbol'>*</span></label>
                        <input type='text' name='employeeID' id='newEmpID' class="form-input disabled" readonly>
                    </div>
                    <div class="group-form col-2">
                        <label for='startDate' class='label-form'>Ngày bắt đầu <span class='required-symbol'>*</span></label>
                        <input type='date' name='startDate' id='startDate' class="form-input" required>
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='fullName' class='label-form'>Họ tên <span class='required-symbol'>*</span></label>
                        <input type='text' name='fullName' id='fullName' class="form-input" required>
                    </div>
                    <div class="group-form col-2">
                        <label for='dob' class='label-form'>Ngày sinh <span class='required-symbol'>*</span></label>
                        <input type='date' name='dob' id='dob' class="form-input" required>
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='address' class='label-form'>Địa chỉ</label>
                        <input type='text' name='address' id='address' class="form-input">
                    </div>
                    <div class="group-form col-2">
                        <label for='phone' class='label-form'>Số điện thoại <span class='required-symbol'>*</span></label>
                        <input type='text' name='phone' id='phone' class="form-input" required>
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='gender' class='label-form'>Giới tính</label>
                        <input type='text' name='gender' id='gender' class="form-input">
                    </div>
                    <div class="group-form col-2">
                        <label for='education' class='label-form'>Bằng cấp</label>
                        <select id='education' name="educationID" class="form-input">
                            <option value="" default selected></option>
                            <?php foreach($data['educations'] as $columns):?>
                                <option value="<?php echo $columns['educationID']?>">
                                    <?php echo $columns['qualification']?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='position' class='label-form'>Chức vụ <span class='required-symbol'>*</span></label>
                        <select id='position' name="positionID" class="form-input" required>
                            <option value="" default selected></option>
                            <?php foreach($data['positions'] as $columns):?>
                                <option value="<?php echo $columns['positionID']?>">
                                    <?php echo $columns['positionTitle']?>
                                </option>
                            <?php endforeach;?>
                        </select>  
                    </div>
                    <div class="group-form col-2">
                        <label for='department' class='label-form'>Phòng ban <span class='required-symbol'>*</span></label>
                        <select id='department' name="departmentID" class="form-input" required>
                            <option value="" default selected></option>
                            <?php foreach($data['departments'] as $columns):?>
                                <option value="<?php echo $columns['departmentID']?>">
                                    <?php echo $columns['departmentTitle']?>
                                </option>
                            <?php endforeach;?>
                        </select>      
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-1">
                        <label for='wage' class='label-form'>Mức lương <span class='required-symbol'>*</span></label>
                        <input type='text' pattern='[0-9]+' id='wage' name="wage" class="form-input" required></input>  
                    </div>
                </div>
                <fieldset class='row'>
                    <legend class='subheader'>Tạo tài khoản: </legend>
                    <div class="row center">
                        <div class="col-3">
                            <input type='radio' id='manager' name='role' value="manager">
                            <label for='manager'>Trưởng phòng</label>
                        </div>
                        <div class="col-3">
                            <input type='radio' id='accounting' name='role' value="accountant">
                            <label for='accounting'>Nhân viên kế toán</label>
                        </div>
                        <div class="col-3">
                            <input type='radio' id='hr' name='role' value="personnel">
                            <label for='hr'>Nhân viên nhân sự</label>
                        </div>
                    </div>
                </fieldset>
                <div class="row center">
                    <input type="submit" class='col-4 btn-primary btn submit-btn save-btn' data-submit='add-modal' value="Thêm">
                </div>
            </form>
        </div>
    </div>
</div>