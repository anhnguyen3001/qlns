<?php $role = $_SESSION['role']?>
<!-- Page header -->
<div class="page-header">
    <div class="row">
        <h2 class='header col-2-3'>Phòng ban</h2>
        <?php if (Permission::hasPermission('department', 'add')){ ?>
            <div class="col col-1-3">
                <div class="btn-primary modal-btn add-btn" data-open='add-modal' id="add-department">
                    <div class="fa fa-plus"></div>
                    <strong>Thêm mới</strong>
                </div>
            </div>
            <?php 
                require_once ROOT .'mvc/views/forms/department/add.php';
                require_once ROOT .'mvc/views/forms/department/edit.php';   
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
    <?php if (sizeof($data['departments']) === 0) {?>
        <div class="row" style="font-size: 110%; font-weight:600; color:#6c757d">Chưa có phòng ban</div>
    <?php }else {?>
        <!-- Data table -->
        <div class="table-responsive row">
            <table class='center'>
                <thead>
                    <tr>
                        <th style="width: 200px">Phòng ban</th>
                        <th style="width: 200px">Trưởng phòng</th>
                        <?php if (Permission::hasPermission('department', 'edit')){ ?>
                            <th style="width: 150px">Chức năng</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $list = $data['departments'];
                        foreach ($list as $columns) {
                    ?>
                        <tr id='<?php echo $columns['departmentID']?>'>
                            <td style="width: 200px">
                                <a class='link' id='name-<?php echo $columns['departmentID']?>' href="<?php echo ROOT_LINK?>Employee/show?departmentID=<?php echo $columns['departmentID']?>"><?php echo $columns['departmentTitle']?></a>
                            </td>
                            <td id='name' style="width: 200px">
                                <?php if ($columns['fullName'] !== 'N/A'){?>
                                    <a class='link' href="<?php echo ROOT_LINK?>Employee/detail?employeeID=<?php echo  $columns['employeeID']?>">
                                <?php }?>
                                    <?php echo $columns['fullName']?>
                                <?php if ($columns['fullName'] !== 'N/A'){?>
                                    </a>
                                <?php }?>
                            </td>
                            <?php if (Permission::hasPermission('department', 'edit')){ ?>
                                <td class='action' style="width: 150px">
                                    <div class="fa fa-ellipsis-v dropdown-btn link" data-toggle='dropdown-<?php echo $columns['departmentID']?>'></div>
                                    <div class='sub-menu' id='dropdown-<?php echo $columns['departmentID']?>'>
                                        <ul>
                                            <div class="dropdown-list">
                                                <li>
                                                    <a class="row edit modal-btn edit-department" id = '<?php echo $columns['departmentID']?>' data-open='edit-modal' data-name='name-<?php echo $columns['departmentID']?>'>
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