<?php
    define('DEFAULT_RECORD', 10);
    define('MAX_RECORD', 40);

    // Default Password for Department Account
    define('DEP_PASSWORD', '123');

    // Convert type of Account to Vietnamese
    define('ADMIN', 'admin');
    define('MANAGER', 'Phòng ban');
    define('ACCOUNTANT', 'Nhân viên kế toán');
    define('PERSONNEL', 'Nhân viên nhân sự');

    // Page and action each user can access
    define('MANAGER_ACCESS', [['page' => ['Attendance', 'Login', 'Ajax']]]);
    define('ACCOUNTANT_ACCESS', [['page' => ['Wage', 'Login', 'Ajax']], ['page' => ['Employee'], 'action' => ['show', 'detail']], ['page' => ['Attendance', 'Position', 'Department', 'Education'], 'action' => ['show']]]);
    define('PERSONNEL_ACCESS', [['page' => ['Employee', 'Position', 'Department', 'Education', 'Wage', 'Login', 'Ajax']], ['page' => ['Attendance'], 'action' => ['show']]]);

    // Get path
    $path = str_replace("index.php", "", $_SERVER['PHP_SELF']);
    define('ROOT_CSS', $path .'public/');
    define('ROOT_LINK', $path);
    define('ROOT', str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']));
?>