<?php

    /*
    *   Api to post new enquiry
    */
    Api::post('/enquiry', function(){
        $sql = "INSERT INTO user_enquiry(email,enquiry) VALUES(?,?);";
        $data = Database::query($sql,$_POST['email'],$_POST['enquiry']);
        Api::send($data);
    });

    /*
    *   Api to get all enquiries 
    */
    Api::get('/enquiry/all', function(){
        $sql = "SELECT
                    id AS id,
                    email AS email,
                    enquiry AS enquiry
                FROM user_enquiry
                ORDER BY id DESC; 
                ";
        $enquiries = Database::query($sql);

        if(!$enquiries) Api::send([
            "success" => FALSE,
            "message" => "Unable to fetch enquiries",
        ]);

        Api::send([
            "success" => TRUE,
            "content" => $enquiries,
        ]);
    });

    /*
    *   /enquiry/page/5/items/50
    *   Api to get enquiries by pagination
    */
    Api::get('/enquiry/page'.Api::INTEGER.'/items'.Api::INTEGER, function($page, $items){

        if($page < 1) Api::send([
            "success" => FALSE,
            "message" => "Invalid: page",
        ]);

        if($items < 1) Api::send([
            "success" => FALSE,
            "message" => "Invalid: limit",
        ]);

        $rowCount = Database::query('SELECT count(*) AS "count" FROM user_enquiry;')[0]['count'];
        $maxReach = $page * $items;

        $offSet = ($page - 1) * $items;

        if($page != 1 && $rowCount < $maxReach) Api::send([
            "success" => TRUE,
            "content" => [],
        ]);

        $sql = "SELECT
                    id AS id,
                    email AS email,
                    enquiry AS enquiry
                FROM user_enquiry
                ORDER BY id DESC
                LIMIT ?,?;
                ";

        $enquiries = Database::query($sql, $offSet, $items);

        if(!$enquiries) Api::send([
            "success" => FALSE,
            "message" => "Unable to fetch enquiries",
        ]);

        Api::send([
            "success" => TRUE,
            "content" => $enquiries,
        ]);
    });