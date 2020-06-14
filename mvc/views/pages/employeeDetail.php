<!-- Page header -->
<div class="page-header">
    <div class="row">
        <h2 class='header col-1'>Thông tin</h2>
    </div>
</div>
<div class="page-body">
    <!-- Message for update, add employee -->
    <?php if(isset($data['message'])){?>
        <div class="row">
            <div class="col-1 show <?php echo $data['message']['type']?>" ><?php echo $data['message']['mess']?></div>
        </div>
    <?php } ?>
        <!-- Basic information -->
        <section class="row basic-info card">
            <?php $info = $data['employee']?>
            <div class="container-fluid">
                <div class="card-header row">
                    <div class='left'>Thông tin cơ bản</div>
                    <div class="fa fa-pencil-alt modal-btn edit-employee" data-open='edit-modal' data-active='nav-info'></div>
                </div>
                <div class="card-body">
                    <div class="column col-2 left">
                        <h3 class="half-line employee-name"><?php echo $info['fullName']?></h4>
                        <h4 class="half-line text"><?php echo $info['positionTitle']?></h5>
                        <h5 class="line text"><?php echo $info['departmentTitle']?></h6>
                        <div class="line employee-id small">MSNV: <?php echo $info['employeeID']?></div>
                        <div class="line text small ">Ngày bắt đầu: <?php echo date('d-m-Y', strtotime($info['startDate']))?></div>
                        <?php if ($info['resignDate'] == 'N/A') {?>
                        <div class="line text small ">Mức lương: <?php echo $info['wage']?></div>
                        <?php }?>
                        <div class="line text small ">Ngày nghỉ việc: <?php echo ($info['resignDate'] != 'N/A') ? date('d-m-Y', strtotime($info['resignDate'])) : $info['resignDate']?></div>
                    </div>
                    <ul class="personal-info column col-2 right">
                        <li class='row'>
                            <div class="title col-1-3">Giới tính: </div>
                            <div class="text col-2-3"><?php echo $info['gender']?></div>
                        </li>
                        <li class='row'>
                            <div class="title col-1-3">Số điện thoại: </div>
                            <div class="text col-2-3"><?php echo $info['phone']?></div>
                        </li>
                        <li class='row'>
                            <div class="title col-1-3">Địa chỉ: </div>
                            <div class="text col-2-3"><?php echo $info['address']?></div>
                        </li>
                        <li class='row'>
                            <div class="title col-1-3">Ngày sinh: </div>
                            <div class="text col-2-3"><?php echo date('d-m-Y', strtotime($info['dob']))?></div>
                        </li class='row'>
                        <li class='row'>
                            <div class="title col-1-3">Bằng cấp: </div>
                            <div class="text col-2-3"><?php echo $info['qualification']?></div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Data table -->
        <section class="row jobhis card">
            <div class="container-fluid">
                <div class="card-header row">
                    <div class='left'>Quá trình công tác</div>
                    <div class="fa fa-plus modal-btn edit-employee" data-open='edit-modal' data-active='nav-position'></div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead class='center head-table'>
                            <tr>
                                <th style="width: 200px">Ngày bắt đầu</th>
                                <th style="width: 200px">Chức vụ</th>
                                <th style="width: 250px">Phòng ban</th>
                            </tr>
                        </thead>
                        <tbody class='center'>
                            <?php 
                                $list = $data['jobhis'];
                                foreach ($list as $columns) {
                            ?>
                                <tr class='small'>
                                    <td style="width: 200px"><i><?php echo date('d-m-Y', strtotime($columns['startDate']))?></i></td>
                                    <td style="width: 200px"><?php echo $columns['positionTitle']?></td>
                                    <td style="width: 250px"><?php echo $columns['departmentTitle']?></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- Modal: Edit employee -->
        <?php 
            if ((!empty($role) && $role != 'accountant') || empty($role))
                require_once ROOT .'mvc/views/forms/employee/edit.php';
        ?>