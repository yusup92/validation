<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $inpjson = file_get_contents('php://input');
        $input = json_decode($inpjson, true);
        $errors = [];

        $gender = trim($input["gender"]);
        if (empty($gender)) {
            $errors['gender'] = "gender is required";
        } elseif ($gender !== 'Male' && $gender !== 'Female') {
            $errors["gender"] = "Please select Male or Female";
        }


        $fname=trim($input["fname"]);
        if (empty($input["fname"])) {
            $errors["fname"] = "fname is required";
        }elseif (!preg_match("/^[a-zA-Z'-]/", $input['fname'])) {
            $errors["fname"] = "fname is not valid";

        }


        $lname=trim($input["lname"]);
        if (empty($input["lname"])) {
            $errors["lname"] = "lname is required";
        }elseif (!preg_match("/^[a-zA-Z'-]/", $input['lname'])) {
            $errors["lname"] = "lname is not valid";

        }

        $email = trim($input["email"]);
        if (empty($input["email"])) {
            $errors["email"] = "email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email format";
        }

        $phonenumber = trim($input["phonenumber"]);
                if (empty($input["phonenumber"])) {
            $errors["phonenumber"] = "phonenumber is required";
        } 
        elseif(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phonenumber)) {


            $errors["phonenumber"] = "the number format must be 000-0000-0000";

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
