<?php
class App{
    private $controller = 'Login';
    private $action = 'show';
    private $params = [];

    function __construct()
    {
        $url = $this->UrlProcess();

        $this->route($url);

        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    function UrlProcess(){
        if (isset($_GET['url'])){
            $url = $_GET['url'];
            unset($_GET['url']);
            return explode('/', (trim($url,'/')));
        }
    }

    function route($url){
        $controller = $this->controller;
        $action = $this->action;
        
        if ($url != null && $this->isUrlExist($url)){
            if (isset($_SESSION['user'])){
                Permission::hasPermission($controller, $action);
                $controller = $url[0];
                $action = isset($url[1]) ? $url[1] : $action;
                
                if (!Permission::hasPermission($controller, $action)){
                    if (isset($_SERVER['HTTP_REFERER']))
                        $url = $_SERVER['HTTP_REFERER'];
                    else {
                        switch ($_SESSION['role']){
                            case 'manager': $url = ROOT .'Wage'; break;
                            default: $url = ROOT .'Employee'; break;
                        }
                    }
                    
                    $_SESSION['messType'] = 'fail';
                    $_SESSION['mess'] = 'Bạn không có quyền truy cập vào trang này';
                    
                    header('Location: ' .$url);
                    exit;
                }   
            }
        }
        
        require_once ROOT .'mvc/controllers/' .$controller .'.php';
        $this->controller = new $controller;
        $this->action = $action;
    }

    private function isUrlExist($url){
        if (file_exists(ROOT .'mvc/controllers/' .$url[0] .".php")){
            if (isset($url[1])){
                require_once ROOT .'mvc/controllers/' .$url[0] .'.php';
        
                if (!method_exists(new $url[0], $url[1])) 
                    return false;
            }

            return true;
        } 

        return false;
    }
}
?>