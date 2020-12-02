
<?php

    include 'doodle/doodle.php';

    // https://localhost/Veheaven/api/user/sudin
    Api::get('/user'.Api::STRING,function($username){

        $sql = "SELECT * FROM test WHERE username = ?";
        $data = Database::query($sql,$username);

        Api::send($data);
    });

    Api::get('/user/create'.Api::STRING.Api::STRING,function($username,$password){

        $sql = "INSERT INTO test (username,password) VALUES(?,?)";
        $response = Database::query($sql,$username,$password);

        Api::send($response);
    });

    Api::get('/user/delete'.Api::STRING, function($username){

        $sql = "DELETE FROM test WHERE username = ?";
        $response = Database::query($sql,$username);

        Api::send($response);

    });


?>

