<div class="modal" tabindex='1' id='add-modal'>
    <div class="layer" data-open='add-modal' data-refresh='#add-attendance'></div>
    <div class="modal-dialog small-form">
        <!-- Modal header -->
        <div class="modal-header center">Chấm công</div>
        <div class="column modal-body">
            <ul class='column group-form'>
                <li class='row group-form'>
                    <div class="title label-form col-1-3">Phòng ban: </div>
                    <div class="text col-2-3"><?php echo $_SESSION['user'];?></div>
                </li>
                <li class='row group-form'>
                    <div class="title label-form col-1-3">Trưởng phòng: </div>
                    <div class="text col-2-3"><?php echo $data['department']['fullName'];?></div>
                </li>
                <li class='row group-form'>
                    <div class="title label-form col-1-3">Ngày: </div>
                    <div class="text col-2-3"><?php echo date('d-m-Y');?></div>
                </li>
            </ul>
            <form action="<?php echo ROOT_LINK?>Attendance/add" id="add-attendance" method='POST'>
                <input type="hidden" name='date' value='<?php echo date('d-m-Y')?>'>
                <div class="row header-section"><i>Danh sách nhân viên:</i></div>
                <div class="table-responsive row">
                    <table class='center'>
                        <thead>
                            <th class='id' style='width:80px'>Mã NV</th>
                            <th class='name' style='width:190px'>Họ tên</th>
                            <th class="status" style='width:70px'>Có</th>
                            <th class='status' style='width:70px'>Vắng</th>
                        </thead>
                        <tbody>
                            <?php 
                                $employees = $data['employees'];
                                foreach ($employees as $value):
                            ?>
                                <tr>
                                    <td class='id' style='width:80px'>
                                        <?php echo $value['employeeID'];?>
                                    </td>    
                                    <td class="name" style='width:190px'><?php echo $value['fullName'];?></td>
                                    <td class="status" style='width:70px'><input type='radio' name='<?php echo $value['employeeID'];?>' value="present" checked></td>    
                                    <td class="status" style='width:70px'><input type='radio' name='<?php echo $value['employeeID'];?>' value="absent"></td>  
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
                <div class="row center">
                    <input type="submit" class='col-3 btn-primary save-btn' data-submit='add-modal' id="save-btn" value="Lưu">
                </div>
            </form>
        </div>
    </div>
</div>