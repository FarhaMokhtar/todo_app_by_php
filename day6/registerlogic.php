<?php
session_start();
if (isset($_SESSION['name'])) {
    header('Location: index.php');
    exit();
}

$error=[];
$email=trim(htmlspecialchars($_REQUEST['email'], ENT_QUOTES));
$name=trim(htmlspecialchars($_REQUEST['name'], ENT_QUOTES));
$password=$_REQUEST['password'];
$department = $_REQUEST['department'];
$password_pattern = '/^[a-zA-Z0-9]{5,10}$/';

//validation email
if(empty($email)){
    $error['email']='email is required';
}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error['email'] = 'email is not valid email';
}
$filename = './users.json';
$users = json_decode(file_get_contents('users.json'), true);
if (isset($users[$email])) {
    $error['email']='this email already exist';
}
//validation password
if(empty($password)){
    $error['password']='password is required';
}//elseif (!preg_match($password , $password_pattern)) {
//     $error['password']='password is not valid';
// }
//validation name
if(empty($name)){
    $error['name']='name is required';
}
//validation department
if(empty($department)){
    $error['department']='department is required';
}

//if no error in input 
if(empty($error)){
    $users[] = [
        'id' => empty($users) ? 1 :  ++end($users)['id'],
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'department' => $department,
    ];
    file_put_contents('users.json', json_encode($users));

    header("Location:login.php");

}else{
    $error = http_build_query($error);
    header("Location:register.php?$error");
}






