<?php
global $conn; // to be able to be accessed in any scope

function dump_and_die($element) {
    echo "<pre>";
    var_dump($element);
    echo "</pre>";
    die;
}

// Redirect to another page
function redirect($location) {
    $redirect = die(header('location:'.ROOT.$location)); // used to move to the specified location page
    return $redirect;
}


######## Form Validation and Processing ##########

// Check input and remove unwanted spaces and filtering
function sanitize($data) {
    $sanitize = trim($data, ' ');
    return $sanitize;
}

// Check for empty fields
function empty_field($data) {
    if(is_array($data)) {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $error = 'Please fill in ' . $key . ' field! 🙏';
                return $error;
            }
        } 
    } elseif (empty($data)) {
        $error = 'Please fill the empty fields! 🙏';
        return $error;
    }
}

// Check and return error when two passwords do not match
function password_match($password_field, $confirm_password_field) {
    if ($password_field !== $confirm_password_field) {
        $error = '🙄 Passwords do not match!';
        return $error;
    }
}

// Check and return error when a password is less than 8 characters
function password_strength($password) {
    if (strlen($password) > 1 && strlen($password) < 8) {
        $error = 'Password must be 8 characters long! 🙏';
        return $error;
    }
}

// Toast error message with color and time duration
function toast($message, $color, $duration) {
    $toast =    "<script>
                    M.toast({
                        html: " . "'" . $message . "'" . ",
                        classes: 'rounded $color',
                        displayLength: $duration
                    });
                </script>";
    echo $toast;
}

// Check and return error when phone number is less than 8 and more than 15 characters 
function check_phone($tel) {
    if(!(strlen(intval($tel)) > 7 && strlen(intval($tel)) < 16)) {
        $error = 'Enter a valid phone number! 🙏';
        return $error;
    }
}

// Check and return error if an email is invalid 
function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {// for validating the email to check if it has the ".com"
        $error = 'Enter a valid email! 🙏';
        return $error;
    }
}

// Check if two passwords are the same and return the hashed password
function hash_password($password_field, $confirm_password_field) {
    if ($password_field === $confirm_password_field) {
        $password = password_hash($password_field, PASSWORD_DEFAULT);
        return $password;
    }
}

// Check if there is any input value, then retain value and display it as default henceforth
/* function retain_input_value($execute, $value) {
    if (isset($execute)) {
        $retained_value = $execute[$value];
        return $retained_value;
    }
} */

function validate_account($table_name, $user_array, $database) {
    // for every item in the user array, check for error
    foreach ($user_array as $table_field => $input) {
        // extract every input match
        $sql = "SELECT * FROM $table_name WHERE $table_field = '$input'";
        // result gotten from the database;
        $result = $database->query($sql);

        // Once number of rows fetched is 1 or more, it carries result
        // Once selected value from database is one or more, throw error message
        if ($result->num_rows > 0) {
            $database->close(); // close opened connection
            $error = '🙄 ' . ucfirst($table_field) . ' already exists!';
            return $error;
        }
    }
    return false;
}

function get_user_details($table_name, $user_array, $database) {
    // for every item in the user array, check for error
    foreach ( $user_array as $table_field => $user_input) {
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

function pass_match($login_password, $hashed_password) {
    if ( password_verify($login_password, $hashed_password) ) { // returns true if match is correct
        return true;
    }
    return false;
}