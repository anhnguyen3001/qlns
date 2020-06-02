<div class="signin">
    <form action="<?php echo ROOT_LINK;?>Login/userLogin" method="POST">
        <h2>Đăng Nhập</h2>
        <?php if(isset($data['message'])){?>
            <div class="row">
                <div class="message"><?php echo $data['message']['mess']?></div>
            </div>
        <?php } ?>
        <input type="text" name="loginName" placeholder="Tên Đăng Nhập">
        <input type="Password" name="password" placeholder="Mật Khẩu">
        <button class="btn" type="submit">Đăng Nhập</button>
    </form>
</div>