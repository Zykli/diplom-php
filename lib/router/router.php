<?php

$pathList = preg_split('/\//', $_SERVER['REQUEST_URI'], -1, PREG_SPLIT_NO_EMPTY);
//убираем лишнее
array_shift($pathList);
array_shift($pathList);
array_shift($pathList);
//--
if (count($pathList) < 2) {
    $controllerText = 'UserController';
    $action = 'list';
    $modelText = 'User';
    $controllerFile = 'controller/' . $controllerText . '.php';
    $modelFile = 'model/' . $modelText . '.php';
}
if (count($pathList) >= 2) {
    array_shift($pathList);
    $controller = array_shift($pathList);
    $action = array_shift($pathList);
    $actiontwo = array_shift($pathList);
    foreach ($pathList as $i => $value) {
        if (isset($pathList[$i+1])) {
            $params[count($params)] = $pathList[$i+1];
        }
    }
    $controllerText = $controller . 'Controller';
    $modelText = ucfirst($controller);
    $controllerFile = 'controller/' . ucfirst($controllerText) . '.php';
    $modelFile = 'model/' . $modelText . '.php';
}
if (is_file($controllerFile) && is_file($modelFile)) {
    include $controllerFile;
    include $modelFile;
    if (class_exists($controllerText) && class_exists($modelText)) {
        $model = new $modelText($db);
        $controller = new $controllerText($model);
        if($actiontwo) {
            $action = ($_SERVER['REQUEST_METHOD'] == 'POST' ? 'post' : 'get').ucfirst($action).ucfirst($actiontwo);
        } else {
            $action = ($_SERVER['REQUEST_METHOD'] == 'POST' ? 'post' : 'get').ucfirst($action);
        }
        if (method_exists($controller, $action)) {
            $controller->$action($params, $_POST);
        }
    }
}