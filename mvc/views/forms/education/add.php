<div class="modal" tabindex='1' id='add-modal'>
    <div class="layer" data-open='add-modal' data-refresh='#add-edu'></div>
    <div class="modal-dialog small-form">
        <!-- Modal header -->
        <div class="modal-header center">Thêm mới bằng cấp</div>
        <div class="column modal-body">
            <form action="<?php echo ROOT_LINK?>Education/add" id='add-edu' method='POST'>
                <div class="row">
                    <div class="group-form col-1">
                        <label for='qualification' class='label-form'>Tên bằng cấp <span class='required-symbol'>*</span></label>
                        <input type='text' name='qualification' id='qualification' class="form-input" required>
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" class='col-3 btn-primary btn submit-btn save-btn' data-submit='add-modal' value="Thêm">
                </div>
            </form>
        </div>
    </div>
</div>