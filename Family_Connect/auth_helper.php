<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function protect_page(array $allowed_roles) {
    
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: login.php');
        exit();
    }

  
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        
        header('Location: index.php'); 
        exit();
    }
}


function user_has_role($roles): bool {
    if (!isset($_SESSION['role'])) {
        return false;
    }

    $user_role = $_SESSION['role'];

    return is_array($roles) ? in_array($user_role, $roles) : $user_role === $roles;
}