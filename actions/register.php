<?php
require_once('../app.php');

// When form submit button is clicked, start validation
if (isset($_POST['register'])) {
    $first_name = sanitize($_POST["first_name"]);
    $last_name = sanitize($_POST["last_name"]);
    $email = sanitize($_POST["email"]);
    $password = sanitize($_POST["password"]);

    $user_data = ['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'password' => $password];
    
    // Make a session of values inside input fields
    $_SESSION['register data'] = $user_data;

    // Check empty field and throw error message
    $empty_field_error = empty_field($user_data);

    if (!empty($empty_field_error)) {
        $_SESSION['message'] = msg_alert('danger', '🙏', $empty_field_error); // sets error message into the $_SESSION array
        redirect('register');
    }

    // Check if password exceeds 7 characters and throw error message
    $password_strength_error = password_strength($password);
    
    if (!empty($password_strength_error)) {
        $_SESSION['message'] = msg_alert('danger', '🙏', $password_strength_error);
        redirect('register');
    }
    
    // Check for valid email and throw error message
    $check_email_error = validate_email($user_data['email']);

    if (!empty($check_email_error)) {
        $_SESSION['message'] = msg_alert('danger','🙏', $check_email_error);
        redirect('register');
    }

    $hashed_password = hash_password($password);

    // Check if user data exists already on the database and throw error    
    $user_exist = validate_account('users', $user_data, $conn);

    if ($user_exist) {
        $_SESSION['message'] = msg_alert('danger', '🙄', $user_exist);
        redirect('register');
    }

    // Insert User details into the created database
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";

    if ( $conn->query($sql) ) {
        $conn->close(); // close connection
        redirect('home');
    } else {
        $_SESSION['message'] = msg_alert('danger', '😢', 'Something went wrong, Try again!');
        redirect('register');
    }

} else {
    // take the user back to the home page
    // header('location:'.ROOT.'signup');  used to keep people off some files
    redirect('home');
}