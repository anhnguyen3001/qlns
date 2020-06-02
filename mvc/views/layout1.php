<?php 
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href='<?php echo ROOT_CSS?>css/main_layout1.css'>
        <link rel="stylesheet" href='<?php echo ROOT_CSS?>css/header.css'>
        <link rel="stylesheet" href='<?php echo ROOT_CSS?>css/nav.css'>
        <link rel="stylesheet" href='<?php echo ROOT_CSS?>css/mediaQuery.css'>
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto&display=swap' rel='stylesheet'>
        <!-- Font awsome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
        <title><?php echo $data['title']?></title>
    </head>  
    <body id='body' <?php if(isset($data['edit']) || isset($data['add'])) {?> class='modal-open' <?php }?>>
        <div class = 'hidden' id = 'path'><?php echo ROOT_LINK?></div>
        <div id="page">
            <header>
                <?php require_once ROOT .'mvc/views/blocks/header.php'?>
            </header>
            <nav>
                <?php require_once ROOT .'mvc/views/blocks/nav.php'?>
            </nav>
            <main>
                <div class="container-fluid">
                    <?php require_once ROOT .'mvc/views/pages/' .$data['page'] .'.php';?>
                    <?php require_once ROOT .'mvc/views/forms/user/edit.php';?>
                </div>
            </main>
        </div>
        
        <script type='text/javascript' src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type='text/javascript' src='<?php echo ROOT_CSS?>js/main.js'></script>
        <?php if (file_exists(ROOT .'public/js/' .$data['page'] .'.js')){?>
            <script type='text/javascript' src='<?php echo ROOT_CSS?>js/<?php echo $data['page']?>.js'></script>
        <?php }?>
    </body>
</html>
