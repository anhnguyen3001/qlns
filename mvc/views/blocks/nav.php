<?php $role = $_SESSION['role']?>
<div class="fa fa-bars show-mobile" id="toggle-btn" data-toggle="sidemenu"></div>   
<div class="hide-mobile" id="sidemenu">
    <ul id="menu">
        <li>
            <?php if ($role !== 'manager'){ ?>
                <a href="<?php echo ROOT_LINK?>Employee">
                    <div class="fa fa-address-card"></div>
                    <div>Nhân viên</div>
                </a>
            <?php } ?>
        </li>
        <li>
            <?php if ($role !== 'manager'){ ?>
                <a href="<?php echo ROOT_LINK?>Position">
                    <div class="fa fa-suitcase"></div>
                    <div>Chức vụ</div>
                </a>
            <?php } ?>
        </li>
        <li>
            <?php if ($role !== 'manager'){ ?>
                <a href="<?php echo ROOT_LINK?>Department">
                    <div class="fa fa-building"></div>
                    <div>Phòng ban</div>
                </a>
            <?php } ?>
        </li>
        <li>
            <?php if ($role !== 'manager'){ ?>
                <a href="<?php echo ROOT_LINK?>Education">
                    <div class="fa fa-university"></div>
                    <div>Bằng cấp </div>
                </a>
            <?php } ?>
        </li>
        <li>
            <a href="<?php echo ROOT_LINK?>Attendance">
                <div class="fa fa-calendar-check"></div>
                <div>Chấm công</div>
            </a>
        </li>
        <li>
            <?php if ($role !== 'manager'){ ?>
                <a href="<?php echo ROOT_LINK?>Wage">
                    <div class="fa fa-credit-card"></div>
                    <div>Lương</div>
                </a>
            <?php } ?>
        </li>
        <li>
            <?php if ($role == 'admin'){ ?>
                <a href="<?php echo ROOT_LINK?>User">
                    <div class="fa fa-user"></div>
                    <div>Tài khoản</div>
                </a>
            <?php } ?>
        </li>
    </ul>
</div>