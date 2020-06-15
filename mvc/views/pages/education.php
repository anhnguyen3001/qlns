<?php $role = $_SESSION['role']?>
<!-- Page header -->
<div class="page-header">
    <div class="row">
        <h2 class='header col-2-3'>Bằng cấp</h2>
        <?php if (Permission::hasPermission('education', 'add')){ ?>
            <div class="col col-1-3">
                <div class="btn-primary modal-btn add-btn" data-open='add-modal' id="add-education">
                    <div class="fa fa-plus"></div>
                    <strong>Thêm mới</strong>
                </div>
            </div>
            <?php 
                require_once ROOT .'mvc/views/forms/education/add.php';
                require_once ROOT .'mvc/views/forms/education/edit.php';   
            ?>
        <?php }?>
    </div>
</div>
<div class="page-body">
    <!-- Message for update, add -->
    <?php if(isset($data['message'])){?>
        <div class="row">
            <div class="message col-1 show <?php echo $data['message']['type']?>" ><?php echo $data['message']['mess']?></div>
        </div>
    <?php } ?>
    <!-- Message if no result returns-->
    <?php if (sizeof($data['educations']) === 0) {?>
        <div class="row" style="font-size: 110%; font-weight:600; color:#6c757d">Chưa tồn tại bằng cấp</div>
    <?php }else {?>
        <!-- Data table -->
        <div class="area-table row">
            <table class='center'>
                <thead>
                    <tr>
                        <th>Bằng cấp</th>
                        <?php if (Permission::hasPermission('education', 'edit')){ ?>
                            <th>Chức năng</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $list = $data['educations'];
                        foreach ($list as $columns) {
                    ?>
                        <tr id='<?php echo $columns['educationID']?>'>
                            <td id='name-<?php echo $columns['educationID']?>'>
                                <a class='link' href="<?php echo ROOT_LINK?>Employee/show?educationID=<?php echo $columns['educationID']?>"><?php echo $columns['qualification']?></a>
                            </td>
                            <?php if (Permission::hasPermission('education', 'edit')){ ?>
                                <td class='action'>
                                    <div class="fa fa-ellipsis-v dropdown-btn link" data-toggle='dropdown-<?php echo $columns['educationID']?>'></div>
                                    <div class='sub-menu' id='dropdown-<?php echo $columns['educationID']?>'>
                                        <ul>
                                            <div class="dropdown-list">
                                                <li>
                                                    <a class="row edit modal-btn edit-education" id = '<?php echo $columns['educationID']?>' data-open='edit-modal' data-name='name-<?php echo $columns['educationID']?>'>
                                                        <span>Chỉnh sửa</span>
                                                        <div class="fa fa-edit"></div>
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </div>
                                </td>
                            <?php }?>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    <?php }?>
</div>