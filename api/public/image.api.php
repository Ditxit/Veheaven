<?php

    /* Upload image file to server and save image name in 'image' table */
    Api::post('/image/save',function(){
        $valid = File::check('jpg','png','jpeg');
        if($valid == TRUE) {
            $name = File::save();
            if($name){
                $data = Database::query("INSERT INTO `image` (`name`) VALUES (?)",$name);
                $data['name'] = $name;
                Api::send($data);
            }else{
                Api::send(File::$error);
            }
        }else {
            Api::send(File::$error);
        }
    });