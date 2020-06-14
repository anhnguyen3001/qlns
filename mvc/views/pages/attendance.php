<?php 
    $date = isset($_GET['month']) ? $_GET['month'] : 'now';
    $now = new DateTime($date);
    $now->modify('last day of this month');
    $daysOfMonth = $now->format('d');
    $role = $_SESSION['role'];
?>
<!-- Page header -->
<div class="page-header">
    <div class="row">
        <h2 class='header col-2-3'>Chấm công</h2>
        <?php if (Permission::hasPermission('attendance', 'add')){ ?>
        <div class="col col-1-3">
            <div class="btn-primary modal-btn add-btn" data-open='add-modal'>
                <div class="fa fa-plus"></div>
                <strong>Thêm mới</strong>
            </div>
        </div>
        <?php require_once ROOT .'mvc/views/forms/attendance/add.php';}?>
    </div>
</div>
<div class="page-body">
    <!-- Filter bar -->
    <?php if ($role != 'manager'){?>
    <form action="<?php echo ROOT_LINK?>Attendance/show" id='filter-form'>
        <div class="row">
            <div class="group-form col-5">
                <select id='department' name="departmentID" class="form-control" >
                    <?php 
                        if (!empty($data['filters']['departmentID']))
                            $depID= $data['filters']['departmentID'];
                    ?>
                    <?php foreach($data['departments'] as $columns):?>
                        <option value="<?php echo $columns['departmentID']?>" 
                                        <?php if (isset($depID) && $depID == $columns['departmentID']) echo 'default selected'?>>
                            <?php echo $columns['departmentTitle']?>
                        </option>
                    <?php endforeach;?>
                </select>      
                <label for="department" class='focus-label'>Phòng ban</label>
                <span class="border"></span>
            </div>
            <div class="group-form col-5">
                <input type="text" name="month" class="form-control" id="month"
                    value='<?php echo isset($data['filters']['month']) ? $data['filters']['month'] : '' ?>'>
                <label for="month" class='focus-label'>Tháng</label>
                <span class="border"></span>
            </div>
            <div class="group-form col-5"><input type="submit" class='btn-primary' data-submit='filter-form' id="search-btn" value="Tìm kiếm"></div>
        </div>
    </form>
    <?php }?>
    <!-- Message for add -->
    <?php if(isset($data['message'])){?>
        <div class="row">
            <div class="message col-1 show <?php echo $data['message']['type']?>" ><?php echo $data['message']['mess']?></div>
        </div>
    <?php } ?>
    <!-- Data table -->
    <?php if (sizeof($data['attendances']) === 0){?>
        <div class="row" style="font-size: 110%; font-weight:600; color:#6c757d">Không có chấm công</div>
    <?php } else {?>
    <div class="table-responsive row">
        <table class='table-border center'>
            <caption>Tháng <?php echo isset($data['filters']['month']) ? date('m-Y', strtotime($data['filters']['month'])) : date('m-Y')?></caption>
            <thead>
                <tr >
                    <th style="width: 80px">MSNV</th>
                    <th style="width: 200px">Họ tên</th>
                    <?php for ($i = 1; $i <= $daysOfMonth; $i++):?>
                        <th style='width:30px; padding: 0 3px'><?php echo $i?></th>
                    <?php endfor?>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($data['attendances'] as $value) {
                        foreach ($value as $col => $status) {
                ?>
                    <tr>
                        <td style="width: 80px"><?php echo $col?></td>
                        <td style="width: 200px"><?php echo $status['fullName']?></td>
                        <?php for ($i = 1; $i <= $daysOfMonth; $i++):?>
                            <td style='width:30px; padding: 0 3px' class="<?php 
                                $index = array_search($i,$status['date']); 
                                if ($index !== false) echo $status['status'][$index];?>">
                            </td>
                        <?php endfor?>
                    </tr>
                <?php }}}?>
            </tbody>
        </table>
    </div>
</div>