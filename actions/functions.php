<?php
global $conn; // to be able to be accessed in any scope

function dump_and_die($element)
{
    echo "<pre>";
    var_dump($element);
    echo "</pre>";
    die;
}

// Redirect to another page
function redirect($location)
{
    $redirect = die(header('location:' . ROOT . $location)); // used to move to the specified location page
    return $redirect;
}

// processing alert message using bootstrap alert
function msg_alert($alert_type, $expression, $text)
{
    $msg = "<div class='alert alert-$alert_type alert-dismissible fade show' role='alert' style='border-radius:70px; overflow:hidden'>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    <strong>$expression</strong> $text
    </div>";

    return $msg;
}

######## Form Validation and Processing ##########

// Check input and remove unwanted spaces and filtering
function sanitize($data)
{
    $sanitize = filter_var(trim($data));
    return $sanitize;
}

// Check for empty fields
function empty_field($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $error = 'Please fill in ' . $key . ' field.';
                return $error;
            }
        }
    } elseif (empty($data)) {
        $error = 'Please fill in empty field.';
        return $error;
    }
}

// Check and return error when a password is less than 8 characters
function password_strength($password)
{
    if (strlen($password) > 1 && strlen($password) < 8) {
        $error = 'Password must be 8 characters long!';
        return $error;
    }
}

// Check and return error if an email is invalid 
function validate_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // for validating the email to check if it has the ".com"
        $error = 'Enter a valid email!';
        return $error;
    }
}

// Check for password and return the hashed password
function hash_password($password_field)
{
    $password = password_hash($password_field, PASSWORD_DEFAULT);
    return $password;
}

// Check if user is already resgistered before
function validate_account($table_name, $user_array, $database)
{
    // for every item in the user array, check for error
    foreach ($user_array as $table_field => $input) {
        // extract every input match
        $sql = "SELECT * FROM $table_name WHERE $table_field = '$input'";
        // result gotten from the database;
        $result = $database->query($sql);

        // Once number of rows fetched is 1 or more, it carries result
        // Once selected value(number of rows) from database is one or more, throw error message
        if ($result->num_rows > 0) {
            $database->close(); // close opened connection
            $error = ucfirst($table_field) . ' already exists!';
            return $error;
        }
    }
    return false;
}

function get_user_details($table_name, $user_array, $database)
{
    // for every item in the user array, check for error
    foreach ($user_array as $table_field => $user_input) {
        // extract every input match
        $sql = "SELECT * FROM users $table_name WHERE $table_field = '$user_input'";
        // result gotten from the database;
        $result = $database->query($sql);

        // Once selected value from database is one or more, return result
        if ($result->num_rows > 0) {
            return $result;
        }
    }
}

function pass_match($login_password, $hashed_password)
{
    if (password_verify($login_password, $hashed_password)) { // returns true if match is correct
        return true;
    }
    return false;
}
