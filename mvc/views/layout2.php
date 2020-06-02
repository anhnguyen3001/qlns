<!-- Page without header and nav -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href='<?php echo ROOT_CSS?>css/<?php echo $data['page']?>.css'>
        <title><?php echo $data['title']?></title>
    </head>  
    <body>
        <main>
            <?php require_once ROOT .'mvc/views/pages/' .$data['page'] .'.php';?>
        </main>
    </body>
</html>