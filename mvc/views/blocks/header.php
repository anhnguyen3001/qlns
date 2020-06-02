<div class="container">
    <div class="userInfo">
        <div class='username dropdown-btn link' data-toggle='welcome'>
            <?php echo $_SESSION['user'];?>
        </div>
        <ul class='sub-menu small' id='welcome'>
            <div class="dropdown-list">
                <li>
                    <a class="modal-btn edit-user" id='<?php echo $_SESSION['username']?>' data-open='edit-password-modal'>
                        <span>Đổi mật khẩu</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo ROOT_LINK?>Login/logout">Đăng xuất</a>
                </li>
            </div>
        </ul>
    </div>
</div>
    