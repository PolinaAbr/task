<?php

//загрузка данных их xml
$xml = simplexml_load_file('c:/wamp/www/task/users.xml');

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $count = 0;
    //сверка данных с xml
    foreach ($xml->user as $user) {
        if ($login == $user->login) {
            $count++;
            $salt = $user->salt;
            if (sha1($salt.$password) == $user->password) {
                //запись данных в сессию
                setcookie('login', $user->login, time() + 60*60*24);
                $_SESSION['login'] = $user->login;
                $obj = array('user' => $login);
                //преобразование в json
                echo json_encode($obj);
            } else {
                $obj = array('error' => 'Incorrect password', 'elem' => 'passwordLog');
                echo json_encode($obj);
            }
        }
    }
    if ($count == 0) {
        $obj = array('error' => 'Incorrect login', 'elem' => 'loginLog');
        echo json_encode($obj);
    }
}

function login() {     
    if (isset($_SESSION['login'])) { //если сесcия есть   
        if (isset($_COOKIE['login'])) { //если cookie есть
            setcookie("login", "", time() - 1); //обновляем cookie          
            setcookie ("login", $_COOKIE['login'], time() + 60*60*24); 
            var_dump($_COOKIE['login']);           
            var_dump($_SESSION['login']);           
            return true;        
        } else { //иначе добавляем cookie
            setcookie ("login", $_SESSION['login'], time() + 60*60*24);
            var_dump($_COOKIE['login']);           
            var_dump($_SESSION['login']);              
            return true;            
        }   
    } else { //если сессии нет
        if(isset($_COOKIE['login'])) { //проверяем существование cookie         
            $_SESSION['login'] = $_COOKIE['login']; //записываем в сесиию login  
            var_dump($_COOKIE['login']);           
            var_dump($_SESSION['login']);            
            return true;            
        } else { //если cookie не существуют      
            return false;       
        }   
    } 
}

function logout() {   
    unset($_SESSION['login']); //удаляем переменную сессии   
    setcookie("login", ""); //удаляем cookie с логином  
    echo "<script>location.href='index.php'</script>";
}

?>