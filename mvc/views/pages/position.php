<?php $role = $_SESSION['role']?>
<!-- Page header -->
<div class="page-header">
    <div class="row">
        <h2 class='header col-2-3'>Chức vụ</h2>
        <!-- Not display if user is accountant -->
        <?php if (Permission::hasPermission('position', 'add')){ ?>
        <div class="col col-1-3">
            <div class="btn-primary modal-btn add-btn" data-open='add-modal' id="add-position">
                <div class="fa fa-plus"></div>
                <strong>Thêm mới</strong>
            </div>
        </div>
        <!-- Modal: Add, edit position -->
        <?php 
            require_once ROOT .'mvc/views/forms/position/add.php';
            require_once ROOT .'mvc/views/forms/position/edit.php';
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
    <?php if (sizeof($data['positions']) === 0) {?>
        <div class="row" style="font-size: 110%; font-weight:600; color:#6c757d">Không tồn tại chức vụ</div>
    <?php }else {?>
        <!-- Data table -->
        <div class="area-table row">
            <table class='center'>
                <thead>
                    <tr>
                        <th style="min-width:150px">Chức vụ</th>
                        <th style="max-width:80px">Hệ số phụ cấp</th>
                        <?php if (Permission::hasPermission('position', 'edit')){ ?>
                            <th >Chức năng</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $list = $data['positions'];
                        foreach ($list as $columns) {
                    ?>
                        <tr class='small' id='<?php echo $columns['positionID']?>'>
                            <td style="min-width:150px">
                                <a class='link' id='name-<?php echo $columns['positionID']?>' href='<?php echo ROOT_LINK?>Employee/show?positionID=<?php echo $columns['positionID']?>'><?php echo $columns['positionTitle']?></a>
                            </td>
                            <td style="max-width:80px" id='allowance-<?php echo $columns['positionID']?>' style="width: 200px"><?php echo $columns['allowance'] ?></td>
                            <?php if (Permission::hasPermission('position', 'edit')){ ?>
                                <td class='action' >
                                    <div class="fa fa-ellipsis-v dropdown-btn link" data-toggle='dropdown-<?php echo $columns['positionID']?>'></div>
                                    <div class='sub-menu' id='dropdown-<?php echo $columns['positionID']?>'>
                                        <ul>
                                            <div class="dropdown-list">
                                                <li>
                                                    <a class="row edit modal-btn edit-position" id='<?php echo $columns['positionID']?>' data-open='edit-modal' data-name='name-<?php echo $columns['positionID']?>'>
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