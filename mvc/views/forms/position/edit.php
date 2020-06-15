        <div class="modal" tabindex='1' id='edit-modal'>
            <div class="layer" data-open='edit-modal' data-refresh=".edit-form"></div>
            <div class="modal-dialog small-form">
                <!-- Modal header -->
                <div class="modal-header center">Chỉnh sửa chức vụ</div>
                <div class="column modal-body">
                    <form action="<?php echo ROOT_LINK?>Position/edit" class="edit-form" id='edit-name' method='POST'>
                        <div class="row">
                            <div class="group-form col-2">
                                <label for='currentName' class='label-form'>Chức vụ <span class='required-symbol'>*</span></label>
                                <input type='text' name='positionTitle' id='currentName' class="form-input" required>
                            </div>
                            <div class="group-form col-2">
                                <label for='allowance' class='label-form'>Hệ số phụ cấp <span class='required-symbol'>*</span></label>
                                <input type='text' id='currentAllowance' name='allowance' class="form-input">
                            </div>
                        </div>
                        <input type='hidden' name='positionID' id='currentID' class='positionID'>
                        <div class="row center">
                            <input type="submit" class='btn-primary submit-btn save-btn' value="Lưu">
                        </div>
                    </form>
                </div>
            </div>
        </div>