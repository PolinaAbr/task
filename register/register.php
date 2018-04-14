<?php

$xml = simplexml_load_file('c:/wamp/www/task/users.xml');

//если полученны данные
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirm']) && isset($_POST['email']) && isset($_POST['name'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $salt = "";
    $countLogin = 0;
    $countEmail = 0;
    $countUsers = 0;
    //сверка данных с xml
    foreach ($xml->user as $user) {
        $countUsers++;
        if ($login == $user->login) {
            $countLogin++;
        }
        if ($email == $user->email) {
            $countEmail++;
        }
    }
    if ($countLogin > 0) {
        $obj = array('error' => 'Such login has already taken', 'elem' => 'loginReg');
        echo json_encode($obj);
    } else if ($confirm !== $password) {
        $obj = array('error' => 'Passwords doesn\'t coinside', 'elem' => 'confirmReg');
        echo json_encode($obj);
    } else if ($countEmail > 0) {
        $obj = array('error' => 'Such email has already used', 'elem' => 'emailReg');
        echo json_encode($obj);
    } else { 
        setcookie('login', $user->login, time() + 60*60*24);
        $_SESSION['login'] = $user->login;
        $salt = rand(1000, 9999);
        $xml->addChild('user');
        $xml->user[$countUsers - 1]->addChild('login', $login);
        $xml->user[$countUsers - 1]->addChild('password', sha1($salt.$password));
        $xml->user[$countUsers - 1]->addChild('salt', $salt);
        $xml->user[$countUsers - 1]->addChild('email', $email);
        $xml->user[$countUsers - 1]->addChild('name', $name);
        $xml->asXML('c:/wamp/www/task/users.xml');
        $obj = array('user' => $login);
        echo json_encode($obj);
    }
}

?>