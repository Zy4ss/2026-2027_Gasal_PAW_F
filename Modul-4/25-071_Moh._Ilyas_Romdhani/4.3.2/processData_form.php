<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<style>
    .field {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .field label {
        width: 130px;
        text-align: right;
        margin-right: 20px;
    }

    fieldset {
        background-color: #e0e0ff;
    }

    input[type="text"],
    input[type="password"],
    textarea,
    select {
        box-sizing: border-box;
    }

    .error {
        color: #b00020;
        margin-left: 10px;
    }
</style>

<body>
    <h1>Register</h1>

    <?php
    $errors = array();

    if (isset($_POST['surname'])) {
        require 'validate.inc';

        validateName($errors, $_POST, 'surname');
        validateEmail($errors, $_POST, 'email');
        validatePassword($errors, $_POST, 'password');
        validateAddress($errors, $_POST, 'address');
        validateState($errors, $_POST, 'state');
        validateSex($errors, $_POST, 'sex');

        if ($errors) {
            echo '<h1>Invalid, correct the following errors:</h1>';
            foreach ($errors as $field => $error)
                echo "$field $error<br/>";
            include 'form.inc';
        } else {
            echo 'Form submitted successfully with no errors';
        }
    } else
        include 'form.inc';
    ?>
</body>

</html>
