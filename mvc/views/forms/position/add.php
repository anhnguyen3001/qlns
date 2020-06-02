<div class="modal" tabindex='1' id='add-modal'>
    <div class="layer" data-open='add-modal' data-delete='add-salary' data-refresh='#add-form'></div>
    <div class="modal-dialog small-form">
        <!-- Modal header -->
        <div class="modal-header center">Tạo mới chức vụ</div>
        <div class="column modal-body">
            <form action="<?php echo ROOT_LINK?>Position/add" id='add-form' method='POST'>
                <div class="row">
                    <div class="group-form col-2">
                        <label for='newPosName' class='label-form'>Tên chức vụ <span class='required-symbol'>*</span></label>
                        <input type='text' name='positionTitle' id='newPosName' class="form-input" required>
                    </div>
                    <div class="group-form col-2">
                        <label for='allowance' class='label-form'>Hệ số phụ cấp <span class='required-symbol'>*</span></label>
                        <input type='text' name='allowance' id='allowance' class="form-input" required>
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" class='col-4 btn-primary btn submit-btn save-btn' data-submit='add-modal' value="Thêm">
                </div>
            </form>
        </div>
    </div>
</div>