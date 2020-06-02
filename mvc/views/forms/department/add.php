<div class="modal" tabindex='1' id='add-modal'>
    <div class="layer" data-open='add-modal' data-refresh='#add-dep'></div>
    <div class="modal-dialog small-form">
        <!-- Modal header -->
        <div class="modal-header center">Tạo mới phòng ban</div>
        <div class="column modal-body">
            <form action="<?php echo ROOT_LINK?>Department/add" id='add-dep' method='POST'>
                <div class="row">
                    <div class="group-form col-1">
                        <label for='departmentTitle' class='label-form'>Tên phòng ban <span class='required-symbol'>*</span></label>
                        <input type='text' name='departmentTitle' id='departmentTitle' class="form-input" required>
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" class='col-3 btn-primary btn submit-btn save-btn' data-submit='add-modal' value="Thêm">
                </div>
            </form>
        </div>
    </div>
</div>