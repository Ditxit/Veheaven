
<?php

    include 'doodle/doodle.php';

    /* Token Debug*/
    Api::get('/token/verify'.API::STRING,function($token){
        Api::send(Token::verify($token));
    });

     /* General Login API */
     Api::post('/login',function(){

        $sql = "SELECT user.id, user.first_name, user.last_name, user.email, user_type.type AS user_type FROM user INNER JOIN user_type ON user.user_type_id = user_type.id WHERE user.email=? AND user.password=?;";

        $data = Database::query($sql, $_POST['email'], $_POST['password']);

        if($data){
            $data = $data[0];
            $data['token'] = Token::create($data);
        }

        Api::send($data);

    });

    /*General Token*/
    Api::get('/visitor/token/create',function(){
        Api::send(Token::create([
            'user_type' => 'visitor'
        ]));
    });

    /*User Email Verify*/
    Api::get('/exist/user/email'.Api::STRING, function($email){
        $data = Database::query("SELECT id FROM user WHERE email = ?;",$email);
        if($data){
            Api::send(TRUE);
        }else{
            Api::send(FALSE);
        }
    });

    Api::get(Api::DEFAULT,function(){
        Api::send([
            'success' => FALSE,
            'message' => 'This API end-point does not exist.'
        ]);
    });

    Api::post(Api::DEFAULT,function(){
        Api::send([
            'success' => FALSE,
            'message' => 'This API end-point does not exist.'
        ]);
    });

?>

