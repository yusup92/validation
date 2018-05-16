<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $inpjson = file_get_contents('php://input');
        $input = json_decode($inpjson, true);
        $errors = [];

        if (empty($input["gender"])) {
        $errors['error'] = "gender is required";
        }
        elseif ($input["gender"] !=='Male' && $input["gender"] !=='Female') {
            $errors['error'] = "Please select Male or Female";
        }
      

        if (empty($input["fname"])) {
            $errors['error'] = "fname is required";
        }

        if (empty($input["lname"])) {
            $errors['error'] = "lname is required";
        }

        if (empty($input["email"])) {
            $errors['error'] = "email is required";
        } else {

            $email = $input["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $errors['error'] = "Invalid email format"; 
                }
            
        }

        if (empty($input["phonenumber"])) {
            $errors['error'] = "phonenumber is required";
        }

       
        if (count($errors) !== 0) {
            throw new Exception(json_encode($errors), 500); //throw new Exception(#code, 500)
        } else {
            echo "Validation is success";
        }

    } catch (Exception $e) {                                        //
        header('HTTP/1.1 500 Internal Server Booboo');              //
        header('Content-Type: application/json; charset=UTF-8');    //

        die(json_encode(array(                                      //
            'error' => array(                                       //
                'msg' => json_decode($e->getMessage()),             //
                'code' => $e->getCode(),                            //
            ),
        )));
    }
}

?>
