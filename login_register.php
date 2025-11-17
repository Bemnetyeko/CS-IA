<?php 
session_start(); 
require_once 'config.php';

// SIGN UP 
if (isset($_POST['signup'])) { 
    $name = $_POST['name']; 
    $email = $_POST['email']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = $_POST['role'];

// Check if email already exists 
    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'"); 
    if ($checkEmail->num_rows > 0) {
        $_SESSION['signup_error'] = 'Email is already registered!'; 
        $_SESSION['active_form'] = 'signup'; 
    } else { 
        $conn->query("INSERT INTO users (name, email, password, role) 
            VALUES ('$name', '$email', '$password', '$role')"); 
            } 
        header("Location: login.php"); 
        exit(); 
    }

// LOGIN
if (isset($_POST['login'])) { 
    $email = $_POST['email']; 
    $password = $_POST['password']; 
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'"); 
    if ($result->num_rows > 0) { $user = $result->fetch_assoc(); 
        if (password_verify($password, $user["password"])) {
            // Store session variables
            $_SESSION['name'] = $user['name']; 
            $_SESSION['email'] = $user['email']; 
            $_SESSION['role'] = $user['role'];

            //Redirect based on role
            if ($user['role'] == 'admin') { 
                header("Location: admin_dashboard.php"); 
                exit(); 
            } else { 
                header("Location: user_dashboard.php"); 
                exit(); 
            } 
        } else {
            //wrong password
            $_SESSION['login_error'] = "Incorrect email or password"; 
            $_SESSION['active_form'] = "login"; 
            header("Location: login.php"); 
            exit(); 
        } 
    } else {
        //no such email
        $_SESSION['login_error'] = "Incorrect email or password"; 
        $_SESSION['active_form'] = "login"; 
        header("Location: login.php"); 
        exit(); 
        } 
        } 
        ?>