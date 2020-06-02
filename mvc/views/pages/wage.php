<?php 
    $date = isset($_GET['month']) ? $_GET['month'] : 'now';
    $now = new DateTime($date);
    $now->modify('last day of this month');
    $lastDate = $now->format('d');
?>
<!-- Page header -->
<div class="page-header">
    <div class="row">
        <h2 class='header col-1'>Bảng lương</h2>
    </div>
</div>
<div class="page-body">
    <!-- Filter bar -->
    <form action="<?php echo ROOT_LINK?>Wage/show" id='filter-form'>
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
    <!-- Message -->
    <?php if(isset($data['message'])){?>
        <div class="row">
            <div class="col-1 show <?php echo $data['message']['type']?>" id='message'><?php echo $data['message']['mess']?></div>
        </div>
    <?php } ?>
    <!-- Data table -->
    <?php if (sizeof($data['employees']) === 0){?>
        <div class="row" style="font-size: 110%; font-weight:600; color:#6c757d">Chưa có bảng lương</div>
    <?php } else {?>
    <div class="table-responsive row">
        <table class='table-border center'>
            <caption>Tháng <?php echo isset($data['filters']['month']) ? date('m-Y', strtotime($data['filters']['month'])) : date('m-Y')?></caption>
            <thead>
                <tr >
                    <th style="width: 80px">MSNV</th>
                    <th style="width: 200px">Họ tên</th>
                    <th style="width: 200px">Mức lương</th>
                    <th style="width: 150px">Ngày đi làm</th>
                    <th style="width: 150px">Tiền bảo hiểm</th>
                    <th style="width: 150px">Phụ cấp</th>
                    <th style="width: 200px">Thực nhận</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($data['employees'] as $value) {
                ?>
                    <tr>
                        <td style="width: 80px"><?php echo $value['employeeID']?></td>
                        <td style="width: 200px"><?php echo $value['fullName']?></td>
                        <td style="width: 200px"><?php echo number_format($value['wage'])?></td>
                        <td style="width: 150px"><?php echo $value['workDay']?></td>
                        <td style="width: 150px"><?php echo number_format($value['bh'])?></td>
                        <td style="width: 150px"><?php echo number_format($value['phucap'], 2)?></td>
                        <td style="width: 200px"><?php echo number_format($value['income'])?></td>
                    </tr>
                <?php }}?>
            </tbody>
        </table>
    </div>
</div>