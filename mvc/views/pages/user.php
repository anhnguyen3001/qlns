<!-- Page header -->
<div class="page-header">
    <div class="row">
        <h2 class='header col-2-3'>Tài khoản</h2>
        <div class="col col-1-3">
            <div class="btn-primary modal-btn add-btn" data-open='add-modal'>
                <div class="fa fa-plus"></div>
                <strong>Thêm mới</strong>
            </div>
        </div>
    </div>
</div>
<!-- Modal: Add user -->
<?php require_once ROOT .'mvc/views/forms/user/add.php';?>
<div class="page-body">
    <!-- Message for update, add user -->
    <?php if(isset($data['message'])){?>
        <div class="row">
            <div class="col-1 show <?php echo $data['message']['type']?>" id='message'><?php echo $data['message']['mess']?></div>
        </div>
    <?php } ?>
    <!-- Message if no result returns-->
    <?php if (sizeof($data['users']) === 0) {?>
        <div class="row" style="font-size: 110%; font-weight:600; color:#6c757d">Không tồn tại tài khoản</div>
    <?php }else {?>
        <!-- Data table -->
        <div class="table-responsive row">
            <table class='center'>
                <thead>
                    <tr>
                        <th style="width: 200px">Người dùng</th>
                        <th style="width: 200px">Tên tài khoản</th>
                        <th style="width: 150px">Mật khẩu</th>
                        <th style="width: 200px">Loại tài khoản</th>
                        <th style="width: 150px">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $list = $data['users'];
                        foreach ($list as $columns) {
                    ?>
                        <tr class='small' id='<?php echo $columns['username']?>'>
                            <td style="width: 200px">
                                <?php if($columns['role'] == 'personnel' || $columns['role'] == 'accountant') {?>
                                    <a class='link' href='<?php echo ROOT_LINK?>Employee/detail?employeeID=<?php echo $columns['user']?>'>
                                <?php }?>
                                <?php echo ($columns['username'] == NULL) ? $columns['loginName'] : $columns['username'];?>
                                <?php if($columns['role'] == 'personnel' || $columns['role'] == 'accountant') {?>
                                    </a>
                                <?php }?>
                            </td>
                            <td style="width: 200px"><?php echo $columns['loginName']?></td>
                            <td style="width: 150px"><?php echo $columns['password']?></td>
                            <td style="width: 200px"><?php echo constant(strtoupper($columns['role']))?></td>
                            <td class='action center' style="width: 150px">
                                <div class="fa fa-ellipsis-v dropdown-btn link" data-toggle='dropdown-<?php echo $columns['user']?>'></div>
                                <div class='sub-menu' id='dropdown-<?php echo $columns['user']?>'>
                                    <ul>
                                        <div class="dropdown-list">
                                            <li>
                                                <a class="row edit modal-btn edit-user" id='<?php echo $columns['user']?>' data-open='edit-password-modal'>
                                                    <span>Chỉnh sửa</span>
                                                    <div class="fa fa-user-cog"></div>
                                                </a>
                                            </li>
                                            <?php if ($columns['role'] != 'admin'){?>
                                            <li>
                                                <a class='row' href='<?php echo ROOT_LINK?>User/delete?username=<?php echo $columns['user']?>' data-open='delete-modal'>
                                                    <span>Xóa</span>
                                                    <div class="fa fa-trash"></div>
                                                </a>
                                            </li>
                                            <?php }?>
                                        </div>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    <?php }?>
</div>