<?php
session_start();
require_once 'config.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirmPassword = password_hash($_POST['confirmpassword'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkemail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if($checkemail->num_rows > 0){
        $_SESSION['register_error'] = 'Email is already registered';
        $_SESSION['active_form'] = 'register';
    }else{
        $conn->query("INSERT INTO users (username, email, password, confirmpassword, role) VALUES ('$username', '$email', '$password', '$confirmpassword', '$role')");
    }
    header("Location: loginform.php");
    exit();
}
if(isset($_POST['login'])){
     $email = $_POST['email'];
     $password = $_POST['password'];
    
     $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
     if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user["password"])){
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if($user['role'] === 'user'){
                header("Location: Studentdemo.html");
            }
            else{
                header("Location: Companiesdemo.html");
            }
            exit();
        }
     }
    $_SESSION['login_error'] = 'Incorrect Email or Password';
    $_SESSION['active_form'] = 'login';
    header("Location: loginform.php");
    exit();
}
?>