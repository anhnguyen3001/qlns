<?php
    if (isset($data['employee'])){
        $id = $data['employee']['employeeID'];
        $name = $data['employee']['fullName'];
        $startDate = $data['employee']['startDate'];
        $dob = $data['employee']['dob'];
        $gender = ($data['employee']['gender'] == 'N/A') ? '' : $data['employee']['gender'];
        $phone = $data['employee']['phone'];
        $address = ($data['employee']['address'] == 'N/A') ? '' : $data['employee']['address'];
        $edu = ($data['employee']['educationID'] == 'N/A') ? '' : $data['employee']['educationID'];
        $resignDate = ($data['employee']['resignDate'] == 'N/A') ? '' : $data['employee']['resignDate'];
        $dep = $data['employee']['departmentID'];
        $depName = $data['employee']['departmentTitle'];
        $pos = $data['employee']['positionID'];
        $posName = $data['employee']['positionTitle'];
        $positionDate = $data['employee']['date'];
        
        $wage = $data['employee']['wage'];
        $level = $data['employee']['level'];
        $currentDateWage = date('d-m-Y', strtotime($data['employee']['validDate']));

        
    }
?>
<div class="modal" tabindex='1' id='edit-modal'>
    <div class="layer" data-open='edit-modal' data-refresh='.edit-employee'></div>
    <div class="modal-dialog">
        <!-- Modal header -->
        <div class="modal-header center">Chỉnh sửa thông tin</div>
        <div class="column modal-body">
            <ul class='nav'>
                <li class='nav-items' id='nav-info' data-toggle='#edit-info'>Thông tin cơ bản</li>
                <li class='nav-items' id='nav-position' data-toggle='.edit-position'>Vị trí nhân sự</li>
                <li class='nav-items' id='nav-salary' data-toggle='#edit-salary'>Mức lương</li>
            </ul>
            <form action="<?php echo ROOT_LINK;?>Employee/edit" class='toggle-form edit-employee' id='edit-info' method='POST'>
                
                <div class="row">
                    <div class="group-form col-2">
                        <label for='id' class='label-form'>MSNV <span class='required-symbol'>*</span></label>
                        <input type='text' name='employeeID' id='modal-employeeID' class="form-input disabled" value="<?php echo isset($id) ? $id : ''?>" readonly>
                    </div>
                    <div class="group-form col-2">
                        <label for='modal-dob' class='label-form'>Ngày sinh <span class='required-symbol'>*</span></label>
                        <input type='date' name='dob' id='modal-dob' class="form-input" value="<?php echo isset($dob)? $dob : ''?>"> 
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='modal-fullname' class='label-form'>Họ tên <span class='required-symbol'>*</span></label>
                        <input type='text' name='fullName' id='modal-fullname' class="form-input" value="<?php echo isset($name) ? $name : ''?>" required>
                    </div>
                    <div class="group-form col-2">
                        <label for='modal-gender' class='label-form'>Giới tính</label>
                        <input type='text' name='gender' id='modal-gender' class="form-input" value="<?php echo isset($gender) ? $gender : ''?>">
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='modal-address' class='label-form'>Địa chỉ</label>
                        <input type='text' name='address' id='modal-address' class="form-input" value="<?php echo isset($address) ? $address : ''?>">
                    </div>
                    <div class="group-form col-2">
                        <label for='modal-phone' class='label-form'>Số điện thoại <span class='required-symbol'>*</span></label>
                        <input type='text' name='phone' id='modal-phone' class="form-input" value="<?php echo isset($phone) ? $phone : ''?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-1">
                        <!-- Get qualification -->
                        <label for='modal-education' class='label-form'>Bằng cấp</label>
                        <select name="educationID" id='modal-education-1' class="form-input">
                            <option id="default-edu" <?php if (empty($edu)) echo 'default selected'?>></option>
                            <?php foreach($data['educations'] as $columns):?>
                                <option id='<?php echo $columns['educationID']?>' value="<?php echo $columns['educationID']?>" <?php if (!empty($edu) && $edu == $columns['educationID']) echo 'default selected'?>><?php echo $columns['qualification']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='modal-startDate' class='label-form'>Ngày bắt đầu <span class='required-symbol'>*</span></label>
                        <input type='date' id='modal-startDate' class="form-input disabled" value="<?php echo isset($startDate) ? $startDate : ''?>"readonly>
                    </div>
                    <div class="group-form col-2">
                        <label for='modal-resignDate' class='label-form'>Ngày nghỉ việc <span class='required-symbol'>*</span></label>
                        <input type='date' name ='resignDate' id='modal-resignDate' class="form-input" value="<?php echo isset($resignDate) ? $resignDate : ''?>">
                    </div>
                </div>
                <div class="submit-section center">
                    <input type="submit" name='edit-info' class='col-4 btn-primary submit-btn save-btn' value="Lưu">
                </div>
            </form>
            <form action="<?php echo ROOT_LINK;?>Employee/edit" class='edit-position toggle-form edit-employee' id='edit-position' method='POST'>
                <div class="row header-section">Vị trí hiện tại</div>
                <div class="row">
                    <div class="group-form col-3">
                        <label class='label-form'>Chức vụ <span class='required-symbol'>*</span></label>
                        <select id='current-position' name="positionID" class="form-input" required>
                            <?php foreach($data['positions'] as $columns):?>
                                <option value="<?php echo $columns['positionID']?>" <?php echo (isset($posName) && $posName == $columns['positionTitle']) ? 'selected' : '' ?>>
                                <?php echo $columns['positionTitle']?>
                                </option>
                            <?php endforeach;?>
                        </select>   
                    </div>
                    <div class="group-form col-3">
                        <label for='current-department' class='label-form'>Phòng ban <span class='required-symbol'>*</span></label>
                        <select id='current-department' name="departmentID" class="form-input" required>
                            <?php foreach($data['departments'] as $columns):?>
                                <option value="<?php echo $columns['departmentID']?>" <?php echo (isset($depName) && $depName == $columns['departmentTitle']) ? 'selected' : '' ?>>
                                <?php echo $columns['departmentTitle']?>
                                </option>
                            <?php endforeach;?>
                        </select>      
                    </div>
                    <div class="group-form col-3">
                        <label class='label-form'>Ngày nhận chức <span class='required-symbol'>*</span></label>
                        <input type='date' name='startDate' id='modal-currentDate' value='<?php echo isset($id) ? $positionDate : ''?>' class="form-input" required></input>
                    </div>
                </div>
                <input type='hidden' class='empID-hidden' name='employeeID' value="<?php echo isset($id) ? $id : ''?>">
                <div class="submit-section center">
                    <input type="submit" name='edit-position' class='col-4 btn-primary submit-btn save-btn' value="Lưu">
                </div>
            </form>
            <form action="<?php echo ROOT_LINK;?>Employee/edit" class='edit-position toggle-form edit-employee' id='add-position' method='POST'>
                <input type='hidden' class='empID-hidden' name='employeeID' value="<?php echo isset($id) ? $id : ''?>">
                <input type='hidden' name='currentPos' id='currentPos' value="<?php echo isset($id) ? $pos : ''?>">
                <input type='hidden' name='currentDep' id='currentDep' value="<?php echo isset($id) ? $dep : ''?>">
                <input type='hidden' name='currentPosDate' id='currentPosDate' value="<?php echo isset($id) ? $positionDate : ''?>">
                <div class="row header-section">Vị trí mới</div>
                <div class="row">
                    <div class="group-form col-3">
                        <label for='new-position' class='label-form'>Chức vụ <span class='required-symbol'>*</span></label>
                        <select id='new-position' name="positionID" class="form-input" required>
                            <option value="" default selected></option>
                            <?php foreach($data['positions'] as $columns):?>
                                <option value="<?php echo $columns['positionID']?>"> <?php echo $columns['positionTitle']?>
                                </option>
                            <?php endforeach;?>
                        </select>  
                    </div>
                    <div class="group-form col-3">
                        <label for='new-department' class='label-form'>Phòng ban <span class='required-symbol'>*</span></label>
                        <select id='new-department' name="departmentID" class="form-input" required>
                            <option value="" default selected></option>
                            <?php foreach($data['departments'] as $columns):?>
                                <option value="<?php echo $columns['departmentID']?>">
                                    <?php echo $columns['departmentTitle']?>
                                </option>
                            <?php endforeach;?>
                        </select>      
                    </div>
                    <div class="group-form col-3">
                        <label for='nextDate' class='label-form'>Ngày nhận chức <span class='required-symbol'>*</span></label>
                        <input type='date' name='startDate' id='nextDate' class="form-input" required>
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" name='edit-position' class='col-4 btn-primary submit-btn save-btn' value="Thêm">
                </div>
            </form>
            <form action="<?php echo ROOT_LINK;?>Employee/edit" class='toggle-form edit-employee' id='edit-salary' method='POST'>               
                <div class="row header-section">Mức lương hiện tại</div>
                <div class="row">
                    <div class="group-form col-2">
                        <label class='label-form'>Mức lương</label>
                        <div class="form-input disabled" id='modal-wage'><?php echo isset($id) ? $wage : ''?></div>
                    </div>
                    <div class="group-form col-2">
                        <label class='label-form'>Ngày áp dụng</label>
                        <div class="form-input disabled" id='modal-dateWage'><?php echo isset($id) ? $currentDateWage : ''?></div>
                    </div>
                </div>
                <input type='hidden' class='empID-hidden' name='employeeID' value="<?php echo isset($id) ? $id : ''?>">
                <input type='hidden' name='currentWage' id='currentWage' value="<?php echo isset($id) ? $wage : ''?>">
                <input type='hidden' name='currentDateWage' id='currentDateWage' value="<?php echo isset($id) ? $currentDateWage : ''?>">
                <div class="row header-section">Mức lương mới</div>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='wage' class='label-form'>Mức lương <span class='required-symbol'>*</span></label>
                        <select name='wage' id='wage' class="form-input disabled add" required>
                        </select>
                    </div>
                    <div class="group-form col-2">
                        <label for='newDate-salary' class='label-form'>Ngày áp dụng <span class='required-symbol'>*</span></label>
                        <input type='date' name='validDate' id='newDate-salary' class="form-input" required>
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" name='add-salary' class='col-4 btn-primary submit-btn save-btn' value="Thêm">
                </div>
            </form>
        </div>
    </div>
</div>