<?php
class App{
    private $controller = 'Login';
    private $action = 'show';
    private $params = [];

    function __construct()
    {
        $url = $this->UrlProcess();

        $this->redirect($url);

        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    function UrlProcess(){
        if (isset($_GET['url'])){
            $url = $_GET['url'];
            unset($_GET['url']);
            return explode('/', (trim($url,'/')));
        }
    }

    function redirect($url){
        $controller = $this->controller;
        $action = $this->action;

        if ($url != null && $this->isUrlExist($url)){
            if (isset($_SESSION['username'])){
                if (isset($_SESSION['role'])){
                    // Get what page and action users have right to do 
                    $right = strtoupper($_SESSION['role']) .'_ACCESS';
                    $accessPage = constant($right);

                    $pages = [];
                    $actions = [];

                    foreach ($accessPage as $index) {
                        array_push($pages, $index['page']);

                        if (isset($index['action']))
                            $temp = $index['action'];
                        else $temp = ['all'];

                        array_push($actions, array_values($temp));
                    }

                    $haveRight = false;
        
                    for ($i = 0; $i < sizeof($pages); $i++){
                        if (in_array($url[0], $pages[$i])){
                            if (in_array('all', $actions[$i])
                            || (isset($url[1]) && in_array($url[1], $actions[$i]))){
                                $haveRight = true;
                                $i = sizeof($pages);
                                $controller = $url[0];

                                if (isset($url[1]))
                                    $action = $url[1];
                            }
                        }
                    }

                    if (!$haveRight){
                        if (isset($_SERVER['HTTP_REFERER']))
                            $url = $_SERVER['HTTP_REFERER'];
                        else $url = ROOT .$page[0][0];
                        

                        $_SESSION['messType'] = 'fail';
                        $_SESSION['mess'] = 'Bạn không có quyền truy cập vào trang này';
                        
                        header('Location: ' .$url);
                        exit;
                    } 
                } else {
                    $controller = $url[0];
                    unset($url[0]);

                    if (isset($url[1])){
                        $action = $url[1];
                        unset($url[1]);
                    }
                    
                }
                
            } else {
                $controller = $url[0];
                unset($url[0]);

                if (isset($url[1])){
                    $action = $url[1];
                    unset($url[1]);
                }
                
            }
        }
        
        require_once ROOT .'mvc/controllers/' .$controller .'.php';
        $this->controller = new $controller;
        $this->action = $action;

        // Get param
        if (!empty($url))
            $this->params = array_merge($this->params, $url);
            
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