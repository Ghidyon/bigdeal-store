<?php

require_once('../app.php');

// When the form submit button is clicked, start validation
if (isset($_POST['login'])) {
    $email = sanitize($_POST['email']);
    $user_password = sanitize($_POST['password']);

    $login_data = ["email" => $email, "password" => $user_password];

    // Make a session of values inside input fields
    // $_SESSION['login data'] = $login_data; 

    // Check empty field and throw error message
    $empty_field_error = empty_field($login_data);
    
    if (!empty($empty_field_error)) {
        $_SESSION['message'] = msg_alert('danger', '🙄', $empty_field_error);
        redirect('login');
    }

    // Get user details from the database 
    $result = get_user_details('users', $login_data, $conn);

    if ($result->num_rows > 0) {
        // Fetch results from database and display in an array
        $fetched_user_data = $result->fetch_assoc();

        // Extract every item in the array to stand individually as a declared variable
        // Extract to get hashed password in the database as a variable
        extract($fetched_user_data); // makes each key of the array a variable and assigns the key's value to it
        
        // Compare password entered by user and hashed password gotten from database
        if (pass_match($user_password, $password)) {
            $_SESSION['user'] = $fetched_user_data; // if passwords match, create a user session containing user details
            redirect('home');
        } else {
            $_SESSION['message'] = msg_alert('danger', '🙄', 'Incorrect password');
            redirect('login');
        }
        
    } else {
        $_SESSION['message'] = "🙄 Invalid email or phone number";
        redirect('login');
    }

} else {
    redirect('home');
}
