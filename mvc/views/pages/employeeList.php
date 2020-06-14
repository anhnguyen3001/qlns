<?php $role = $_SESSION['role']?>
<!-- Page header -->
<div class="page-header">
    <div class="row">
        <h2 class='header col-2-3'>Nhân viên</h2>
        <!-- Not display if user is accountant -->
        <?php if (Permission::hasPermission('Employee', 'add')){ ?>
            <div class="col col-1-3">
                <div class="btn-primary modal-btn add-btn employee" data-open='add-modal' >
                    <div class="fa fa-plus"></div>
                    <strong>Thêm mới</strong>
                </div>
            </div>
            <?php 
                require_once ROOT .'mvc/views/forms/employee/add.php';
                require_once ROOT .'mvc/views/forms/employee/edit.php';
            ?>
        <?php }?>
    </div>
</div>
<div class="page-body">
    <!-- Filter bar -->
    <form action="<?php echo ROOT_LINK?>Employee/show" id='filter-form'>
        <div class="row">
            <div class="group-form col-5">
                <input type="text" name="employeeID" class="form-control" id='search-employeeID' 
                    value='<?php echo isset($data['filters']['employeeID']) ? $data['filters']['employeeID'] : '' ?>'>
                <label for="search-employeeID" class='focus-label'>Mã nhân viên</label>
                <span class="border"></span>
            </div>
            <div class="group-form col-5">
                <input type="text" name="fullName" class="form-control" id="name"
                    value='<?php echo isset($data['filters']['fullName']) ? $data['filters']['fullName'] : '' ?>'>
                <label for="name" class='focus-label'>Họ tên</label>
                <span class="border"></span>
            </div>
            <div class="group-form col-5">
                <select name="positionID" class="form-control">
                    <?php 
                        if (!empty($data['filters']['positionID']))
                            $posID = $data['filters']['positionID'];
                    ?>
                    <option value="" <?php if (!isset($posID)) echo 'default selected';?>></option>    
                    <?php foreach($data['positions'] as $columns):?>
                        <option value="<?php echo $columns['positionID']?>" 
                                    <?php if (isset($posID) && $posID == $columns['positionID']) echo 'default selected' ?>>
                            <?php echo $columns['positionTitle']?>
                        </option>
                    <?php endforeach;?>
                </select>    
                <label class='focus-label'>Chức vụ</label>
                <span class="border"></span>
            </div>
            <div class="group-form col-5">
                <select name="departmentID" class="form-control" >
                    <?php 
                        if (!empty($data['filters']['departmentID']))
                            $depID= $data['filters']['departmentID'];
                    ?>
                    <option value="" default <?php if (!isset($depID)) echo 'selected';?>></option>
                    <?php foreach($data['departments'] as $columns):?>
                        <option value="<?php echo $columns['departmentID']?>" 
                                        <?php if (isset($depID) && $depID == $columns['departmentID']) echo 'default selected' ?>>
                            <?php echo $columns['departmentTitle']?>
                        </option>
                    <?php endforeach;?>
                </select>      
                <label class='focus-label'>Phòng ban</label>
                <span class="border"></span>
            </div>
            <input type="hidden" name='edit-id' id='editID'>
            <div class="group-form col-5 col-span-1 center"><input type="submit" class='btn-primary' data-submit='filter-form' id="search-btn" value="Tìm kiếm"></div>
        </div>
        <div class="row">
            <div class="col-1 filter">
                <label for='limit'>Hiển thị: </label>
                <select name='limit' id='limit'>
                    <?php echo ($data['filters']['limit'])?>
                    <?php for($i = DEFAULT_RECORD; $i <= MAX_RECORD; $i += 10) {?>
                        <option value="<?php echo $i?>" <?php echo ($i == $data['filters']['limit']) ? 'default selected' : ''?>><?php echo $i?></option>
                    <?php }?>
                </select>
            </div>
        </div>
    </form>
    <!-- Message for update, add employee -->
    <?php if(isset($data['message'])){?>
        <div class="row">
            <div class="message col-1 show <?php echo $data['message']['type']?>" ><?php echo $data['message']['mess']?></div>
        </div>
    <?php } ?>
    <!-- Message if no result returns-->
    <?php if ($data['employees']['totalPage'] === 0) {?>
        <div class="row" style="font-size: 110%; font-weight:600; color:#6c757d">Không có nhân viên</div>
    <?php }else {?>
        <!-- Data table -->
        <div class="table-responsive row">
            <table>
                <thead class='center'>
                    <tr>
                        <th style="width: 70px">MSNV</th>
                        <th style="width: 200px">Họ tên</th>
                        <th style="width: 90px">SĐT</th>
                        <th style="width: 150px; padding-left: 10px">Địa chỉ</th>
                        <th style="width: 120px">Bằng cấp</th>
                        <th style="width: 150px">Chức vụ</th>
                        <th style="width: 200px">Phòng ban</th>
                        <th style="width: 150px">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $list = $data['employees']['employee'];
                        foreach ($list as $columns) {
                    ?>
                        <tr class='small' id='<?php echo $columns['employeeID']?>'>
                            <td class='center' style="width: 60px"><a class='link' href='<?php echo ROOT_LINK?>Employee/detail?employeeID=<?php echo $columns['employeeID']?>'><?php echo $columns['employeeID']?></a></td>
                            <td style="width: 200px"><a class='link' href='<?php echo ROOT_LINK?>Employee/detail?employeeID=<?php echo $columns['employeeID']?>'><?php echo $columns['fullName']?></a></td>
                            <td class='center' style="width: 90px"><?php echo $columns['phone']?></td>
                            <td class='center' style="width: 150px ; padding-left: 10px"><?php echo $columns['address']?></td>
                            <td class='center' style="width: 120px"><?php echo $columns['qualification']?></td>
                            <td class='center' style="width: 150px"><a class='link' href='<?php echo ROOT_LINK?>Employee/show?positionID=<?php echo $columns['positionID']?>'><?php echo $columns['positionTitle']?></a></td>
                            <td class='center' style="width: 200px"><a class='link' href='<?php echo ROOT_LINK?>Employee/show?departmentID=<?php echo $columns['departmentID']?>'><?php echo $columns['departmentTitle']?></a></td>
                            <td class='action center' style="width: 150px">
                                <div class="fa fa-ellipsis-v dropdown-btn link" data-toggle='dropdown-<?php echo $columns['employeeID']?>'></div>
                                <div class='sub-menu' id='dropdown-<?php echo $columns['employeeID']?>'>
                                    <ul>
                                        <div class="dropdown-list">
                                            <li>
                                                <a class='row' href='<?php echo ROOT_LINK?>Employee/detail?employeeID=<?php echo $columns['employeeID']?>'>
                                                    <span>Chi tiết</span>
                                                    <div class="fa fa-info"></div>
                                                </a>
                                            </li>
                                            <!-- Not display if user is accountant -->
                                            <?php if (Permission::hasPermission('Employee', 'edit')){ ?>
                                                <li>
                                                    <a class="row modal-btn edit-employee" id='<?php echo $columns['employeeID']?>' data-open='edit-modal' data-active='nav-info'>
                                                        <span>Chỉnh sửa</span>
                                                        <div class="fa fa-edit"></div>
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
        <!-- Pagination -->
        <div class="row">
            <?php 
                $page = $data['filters']['page'];
            ?>
            <div class="pagination-container">
                <ul class="pagination">
                    <li class="pagination-btn <?php echo ($page > 1) ? 'previous' : 'disabled';?>">
                        <?php echo ($page <= 1) ? '' : '<a href="' .ROOT_LINK .'Employee?page=' .($page - 1) .'">'?>
                            <div class='fa fa-chevron-left'></div>
                        <?php echo ($page <= 1) ? '' : '</a>'?>
                    </li>
                    <?php if ($page > 1) {?>
                        <li class="pagination-btn previous"><a href='<?php echo ROOT_LINK?>Employee?page=<?php echo $page - 1?>'><?php echo $page - 1?></a></li>
                    <?php }?>
                    <li class="pagination-btn active"><?php echo $page?></li>
                    <?php if ($page < $data['employees']['totalPage']) {?>
                        <li class="pagination-btn next">
                            <a href='<?php echo ROOT_LINK?>Employee?page=<?php echo $page + 1?>'><?php echo $page + 1?></a>
                        </li>
                    <?php }?>
                    <li class="pagination-btn <?php echo ($page == $data['employees']['totalPage']) ? 'disabled' : 'next';?>">
                        <?php echo ($page >= $data['employees']['totalPage']) ? '' : '<a href="' .ROOT_LINK .'Employee?page=' .($page + 1) .'">'?>
                            <div class='fa fa-chevron-right'></div>
                        <?php echo ($page >= $data['employees']['totalPage']) ? '' : '</a>'?>
                    </li>
                </ul>
            </div>
            <div class="result">
                Tổng số kết quả <?php echo $data['employees']['totalResult'];?>
            </div>
        </div>
    <?php }?>
</div>