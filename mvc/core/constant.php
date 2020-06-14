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

    // Get path
    $path = str_replace("index.php", "", $_SERVER['PHP_SELF']);
    define('ROOT_CSS', $path .'public/');
    define('ROOT_LINK', $path);
    define('ROOT', str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']));
?>