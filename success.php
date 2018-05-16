<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $inpjson = file_get_contents('php://input');
        $input = json_decode($inpjson, true);
        $errors = [];

        if (isset($input['gender'])) {
            if ($input['gender'] == 'NULL') {
                $errors[] = "gender is requeired";
            }
        }

        if (empty($input["fname"])) {
            $errors[] = "firstname is required";
        }

        if (empty($input["lname"])) {
            $errors[] = "lastname is required";
        }

        if (empty($input["email"])) {
            $errors[] = "email is required";
        } else {
            // regex match happen here
        }

        if (empty($input["phonenumber"])) {
            $errors[] = "phonenumber is required";
        }

        if (count($errors) !== 0) {
            throw new Exception(json_encode($errors), 500);
        } else {
            return "Validation is success";
        }

    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');

        die(json_encode(array(
            'error' => array(
                'msg' => json_decode($e->getMessage()),
                'code' => $e->getCode(),
            ),
        )));
    }
}

/*  header('Content-Type: application/json; charset=UTF-8');
echo json_encode([
"kidfsdf" => "hello world"]); */
?>