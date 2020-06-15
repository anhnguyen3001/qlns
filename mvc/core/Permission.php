<?php
    define('EMPLOYEE', 0);
    define('DEPARTMENT', 1);
    define('POSITION', 2);
    define('EDUCATION', 3);
    define('ATTENDANCE', 4);
    define('WAGE', 5);
    define('USER', 6);

    define('SHOW', 1);
    define('DETAIL', 2);
    define('EDIT', 3);
    define('ADD', 4);
    define('DELETE', 5);
    define('UPDATEPASSWORD', 6);

    class Permission{
        public static function hasPermission($controller, $action){
            $defaultAccess = ['login', 'ajax'];

            if (in_array(strtolower($controller), $defaultAccess))
                return true;
            
            $controller = constant(strtoupper($controller));
            $action = constant(strtoupper($action));

            $role = $_SESSION['role'];
            $accessPages = [];

            if ($role == 'admin') $accessPages = [111 => 1, 16 => 2];
            else {
                if (preg_match('/manager/', $role)) $accessPages = [16 => 18];

                if (preg_match('/personnel/', $role)) {
                    if (isset($accessPages)) $accessPages = Permission::mergeAction($accessPages, [47 => 1, 16 => 2]);
                    else $accessPages = [47 => 1, 16 => 2];
                } else if (preg_match('/accountant/', $role)) {
                    if (isset($accessPages)) $accessPages = Permission::mergeAction($accessPages, [62 => 2, 1 => 6]);
                    else $accessPages = [62 => 2, 1 => 6];
                }

                $accessPages[64] = 64;
            }

            foreach ($accessPages as $key => $value) {
                if (((1 << $controller & $key) == (1 << $controller))
                && (((1 << $action & $value) == (1 << $action)) || $value == 1))
                    return true;
            }

            return false;
        }  

        public static function mergeAction($original, $merge){
            foreach ($merge as $key => $value) {
                if (array_key_exists($key, $original))
                    $original[$key] += $value;
                else $original[$key] = $value;
            }

            return $original;
        }
    }
?>