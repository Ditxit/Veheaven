<?php

    // Function to get single user details from passed id
    function getUserById($userId){
        $sql = "SELECT
                    id AS id,
                    first_name As firstName,
                    last_name AS lastName,
                    CONCAT(first_name, ' ', last_name) AS fullName,
                    email AS email,
                    phone AS phone
                FROM user
                WHERE status = ? AND id = ?; 
        ";

        $user = Database::query($sql, "verified", $userId);

        $user = $user ? $user[0] : [];

        return $user;
    }