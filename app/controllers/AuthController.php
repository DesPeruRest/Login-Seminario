<?php

require_once "../app/core/Controller.php";
require_once "../app/models/User.php";

class AuthController extends Controller
{
    public function login()
    {
        $this->view("auth/login");
    }

    public function register()
    {
        $this->view("auth/register");
    }

    public function loginPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user['email'];
                echo "Login exitoso";
            } else {
                echo "Credenciales incorrectas";
            }
        }
    }

    public function registerPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $company = $_POST['company'];
            $role = $_POST['role'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $userModel = new User();
            $userModel->create($name, $lastname, $email, $company, $role, $password);

            echo "Usuario registrado";
        }
    }
}