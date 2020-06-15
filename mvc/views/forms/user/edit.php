        <div class="modal" tabindex='1' id='edit-password-modal'>
            <div class="layer" data-open='edit-password-modal' data-refresh='#updateUser'></div>
            <div class="modal-dialog small-form">
                <!-- Modal header -->
                <div class="modal-header center">Đổi mật khẩu</div>
                <div class="column modal-body">
                    <form action="<?php echo ROOT_LINK?>User/updatePassword" id='updateUser' class='toggle-content' method='POST'>
                        <input type="hidden" id='check-oldPass' value="">
                        <div class="row">
                            <div class="group-form col-1">
                                <label for='oldPass' class='label-form'>Mật khẩu cũ <span class='required-symbol'>*</span></label>
                                <input type='password' name='password' id='oldPass' class="form-input" required>
                            </div>
                        </div>
                        <div class="add"></div>
                        <div class="row">
                            <div class="group-form col-1">
                                <label for='password' class='label-form'>Mật khẩu mới <span class='required-symbol'>*</span></label>
                                <input type='password' name='password' id='newPass' class="form-input" required>
                            </div>
                        </div>
                        <input type='hidden' class='username'  name='loginName'>
                        <div class="row center">
                            <input type="submit" class='btn-primary save-btn' value="Lưu">
                        </div>
                    </form>
                </div>
            </div>
        </div>