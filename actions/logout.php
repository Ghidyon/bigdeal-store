<?php
    require_once('../app.php');
    // $_SESSION['register data'] = NULL;
    // $_SESSION['login data'] = NULL;
    session_destroy(); // Destroy all user sessions
    redirect('login');
?>
