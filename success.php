<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $inpjson = file_get_contents('php://input');
        $input = json_decode($inpjson, true);
        $errors = [];

        $gender = $input["gender"];
        if (empty($gender)) {
            $errors['gender'] = "gender is required";
        } elseif ($gender !== 'Male' || $gender !== 'Female') {
            $errors["gender"] = "Please select Male or Female";
        }

        if (empty($input["fname"])) {
            $errors["fname"] = "fname is required";
        }

        if (empty($input["lname"])) {
            $errors["lname"] = "lname is required";
        }

        $email = $input["email"];
        if (empty($input["email"])) {
            $errors["email"] = "email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email format";
        }

        if (empty($input["phonenumber"])) {
            $errors["phonenumber"] = "phonenumber is required";
        }

        if (count($errors) !== 0) {
            throw new Exception(json_encode($errors), 500);
        } else {
            echo "Validation is success";
        }

    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');

        die(json_encode(array(
            'errors' => $errors,
            'code' => $e->getCode(),
        )));
    }
} else {
    header("HTTP/1.0 405 Method Not Allowed");
    exit();
}

?>
