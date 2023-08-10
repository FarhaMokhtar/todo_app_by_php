<?php
session_start();
// Check if the user is already logged in, redirect to index page if yes
// if (isset($_SESSION['email'])) {
//     header('Location: index.php');
//     exit();
// }
$error=[];
$email=trim(htmlspecialchars($_REQUEST['email'], ENT_QUOTES));
$password=$_REQUEST['password'];


//validation on email and password feilds
if(empty($email)){
    $error['email']='email is required';
}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error['email'] = 'email is not valid email';
}
if(empty($password)){
    $error['password']='password is required';
}//elseif (!preg_match($password , $password_pattern)) {
//     $error['password']='password is not valid';
// }
if(empty($error)){
    $users = json_decode(file_get_contents('users.json'), true);
    $loggedIn = false;
    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            $loggedIn = true;
            break;
        }
    }
    if ($loggedIn) {
        $_SESSION['email'] = $email;
        header('Location: goON.php');
        exit();
    } else {
        $errors = 'Invalid username or password.';
    }
}else{
    $error = http_build_query($error);
    header("Location:login.php?$error");
}
