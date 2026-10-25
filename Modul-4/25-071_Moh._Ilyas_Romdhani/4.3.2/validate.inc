<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";

    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'is required.';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'must contain only letters, apostrophes, and hyphens.';
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'is required.';
    else if (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL))
        $errors[$field_name] = 'must be a valid email address.';
}

function validatePassword(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || $field_list[$field_name] === '')
        $errors[$field_name] = 'is required.';
    else if (strlen($field_list[$field_name]) < 8)
        $errors[$field_name] = 'must be at least 8 characters long.';
}

function validateAddress(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'is required.';
}

function validateState(&$errors, $field_list, $field_name)
{
    $states = array('1', '2', '3', '4', '5', '6', '7', '8');

    if (!isset($field_list[$field_name]) || !in_array($field_list[$field_name], $states, true))
        $errors[$field_name] = 'must be selected.';
}

function validateSex(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || !in_array($field_list[$field_name], array('Male', 'Female'), true))
        $errors[$field_name] = 'must be selected.';
}
?>
