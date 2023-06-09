<?php
namespace App\Controllers;
session_start();
use App\Core\View;
use App\Forms\AddUser;
use App\Models\User;
use App\Core\Verificator;

class SecurityController{
    
    function login() {
        $view = new View("User/login", "login");
    }

    function processlogin() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $model = new User();
        $model->setEmail($email);
        
        $check_email = $model->checkEmail();
        if(count($check_email) == 0){
            echo 'Email or Password is incorrect or Account not activated';
            return false;
        }
        
        if (password_verify($password, trim($check_email[0]['password']))) {
            $_SESSION["user"] = [
                'id' => $check_email[0]['id'],
                'firstname' => $check_email[0]['firstname'],
                'lastname' => $check_email[0]['lastname'],
                'email' => $check_email[0]['email'],
                'role' => $check_email[0]['role']
            ];
            echo 'Logged in successfully';
            return true;
        }
    }

    function active(){
        $idUser = $_GET['id'];
        $model = new User();
        $model->setId($idUser);
        $result = (count($model->getDetail()) == 0) ? 'Dữ liệu không tồn tại.' : '';
        $model->setStatus('true');
        $model->status();
    }

    function logout() {
        session_destroy();
        header('Location: '.(empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]".'/login');
        exit();
    }
}