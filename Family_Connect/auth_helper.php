<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica si un usuario ha iniciado sesión y tiene un rol permitido.
 * Si no cumple, lo redirige a la página de login.
 *
 * @param array $allowed_roles Array con los roles permitidos. Ej: ['admin', 'doctor']
 */
function protect_page(array $allowed_roles) {
    // 1. Si no hay usuario en la sesión, redirigir a login.
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: login.php');
        exit();
    }

    // 2. Si el rol del usuario no está en la lista de roles permitidos, redirigir.
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        
        header('Location: index.php'); 
        exit();
    }
}

/**
 * Comprueba si el usuario actual tiene un rol específico (o uno de varios).
 
 
 * @param string|array 
 * @return bool True si el usuario tiene el rol, false en caso contrario.
 */
function user_has_role($roles): bool {
    if (!isset($_SESSION['role'])) {
        return false;
    }

    $user_role = $_SESSION['role'];

    return is_array($roles) ? in_array($user_role, $roles) : $user_role === $roles;
}