<?php
session_start();

$errors = [
  'login' => $_SESSION['login_error'] ?? '',
  'register' => $_SESSION['register_error'] ?? ''
];
$activeform = $_SESSION['active_form'] ?? 'login';

session_unset();

function showerror($error){
  return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formname, $activeform){
  return $formname === $activeform ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Leap-Link</title>
    <link rel="icon" href="images/261bd026-1826-4ac1-b9f1-de4882e0c0ae.png">
    <link rel="stylesheet" href="CSS/loginformstyle.css">
</head>
<body>
    <div class="container">
         <div class="formbox <?= isActiveForm('login', $activeform);?>" id="login">
          <form action="login_register.php" method="post">
            <h2>Login</h2>
            <?= showerror($errors['login']); ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btnlogin" name="login">Login</button>
            <p>Don't have an account? <a href="#" onclick="showform('register')">Register</a></p>
          </form>
         </div>

         <div class="formbox <?= isActiveForm('register', $activeform);?>" id="register">
          <form action="login_register.php" method="post">
            <h2>Register</h2>
           <?= showerror($errors['register']); ?>
            <input type="text" name="username" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirmpassword" placeholder="Confirm Password" required>
            <select name="role" id="usertype" placeholder="--Select Role--" required>
              <option value="">select role</option>
              <option value="user">Student</option>
              <option value="companies">Companies</option>
            </select>
            <button type="submit" class="btnregister" name="register">Register</button>
            <p>Already have an account? <a href="#" onclick="showform('loginform')">Login</a></p>
          </form>
         </div>
      </div>
      <script src="JAVASCRIPT/script.js"></script>
</body>
</html>