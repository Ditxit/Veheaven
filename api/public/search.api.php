<?php

    // function to get all possible typo in the word
    function get_word_typos($str) {
  
        $typosArr = array();
          
        $strArr = str_split($str);
                
        //Proximity of keys on keyboard
        $arr_prox = array();
        $arr_prox['a'] = array('q', 'w', 'z', 'x');
        $arr_prox['b'] = array('v', 'f', 'g', 'h', 'n');
        $arr_prox['c'] = array('x', 's', 'd', 'f', 'v');
        $arr_prox['d'] = array('x', 's', 'w', 'e', 'r', 'f', 'v', 'c');
        $arr_prox['e'] = array('w', 's', 'd', 'f', 'r');
        $arr_prox['f'] = array('c', 'd', 'e', 'r', 't', 'g', 'b', 'v');
        $arr_prox['g'] = array('r', 'f', 'v', 't', 'b', 'y', 'h', 'n');
        $arr_prox['h'] = array('b', 'g', 't', 'y', 'u', 'j', 'm', 'n');
        $arr_prox['i'] = array('u', 'j', 'k', 'l', 'o');
        $arr_prox['j'] = array('n', 'h', 'y', 'u', 'i', 'k', 'm');
        $arr_prox['k'] = array('u', 'j', 'm', 'l', 'o');
        $arr_prox['l'] = array('p', 'o', 'i', 'k', 'm');
        $arr_prox['m'] = array('n', 'h', 'j', 'k', 'l');
        $arr_prox['n'] = array('b', 'g', 'h', 'j', 'm');
        $arr_prox['o'] = array('i', 'k', 'l', 'p');
        $arr_prox['p'] = array('o', 'l');
        $arr_prox['q'] = array('w', 'a','s');
        $arr_prox['r'] = array('e', 'd', 'f', 'g', 't');
        $arr_prox['s'] = array('q', 'w', 'e', 'z', 'x', 'c');
        $arr_prox['t'] = array('r', 'f', 'g', 'h', 'y');
        $arr_prox['u'] = array('y', 'h', 'j', 'k', 'i');
        $arr_prox['v'] = array('', 'c', 'd', 'f', 'g', 'b');    
        $arr_prox['w'] = array('q', 'a', 's', 'd', 'e');
        $arr_prox['x'] = array('z', 'a', 's', 'd', 'c');
        $arr_prox['y'] = array('t', 'g', 'h', 'j', 'u');
        $arr_prox['z'] = array('x', 's', 'a');
        $arr_prox['1'] = array('2','q', 'w');
        $arr_prox['2'] = array('1','3','q', 'w', 'e');
        $arr_prox['3'] = array('2','4','w', 'e', 'r');
        $arr_prox['4'] = array('3','5','e', 'r', 't');
        $arr_prox['5'] = array('4','6','r', 't', 'y');
        $arr_prox['6'] = array('5','7','t', 'y', 'u');
        $arr_prox['7'] = array('6','8','y', 'u', 'i');
        $arr_prox['8'] = array('7','9','u', 'i', 'o');
        $arr_prox['9'] = array('8','0','i', 'o', 'p');
        $arr_prox['0'] = array('9','o', 'p');
                                                
        foreach($strArr as $key=>$value){
            $temp = $strArr;
            foreach ($arr_prox[$value] as $proximity){
                $temp[$key] = $proximity;
                $typosArr[] = join("", $temp);
            }
        }   

        return $typosArr;
    }

    /*
    * Returns vehicles,users with matching keywords
    */
    // NOTE: search by features, colors and provience is missing
    Api::get('/search'.Api::INTEGER.Api::STRING, function($limit, $search_term){

        // Preparing Keywords
        $keywords = explode("-", $search_term);

        $keyword_typos = [];
        foreach($keywords as $keyword){
            $keyword_typos += get_word_typos($keyword);
        }
        $keywords += $keyword_typos;

        // Preparing SQLs
        $sql = "SELECT 
                vehicle.id AS id,
                CONCAT(
                        user.first_name,' ',
                        user.last_name,' ',
                        user.email,' ',
                        vehicle.name,' ',
                        vehicle.price,' ',
                        vehicle_condition.condition,' ',
                        vehicle_type.type,' ',
                        vehicle_body.body,' ',
                        vehicle_transmission.transmission,' ',
                        front_vehicle_tyre.tyre,' ',
                        rear_vehicle_tyre.tyre,' ',
                        vehicle_fuel.fuel,' ',
                        front_vehicle_break.break,' ',
                        rear_vehicle_break.break,' ',
                        vehicle_model.model,' ',
                        vehicle_brand.brand
                    ) AS full_text
            FROM vehicle 
                INNER JOIN user_vehicle 
                    ON user_vehicle.vehicle_id = vehicle.id 
                INNER JOIN user
                    ON user_vehicle.user_id = user.id
                INNER JOIN vehicle_condition
                    ON vehicle.vehicle_condition_id = vehicle_condition.id
                INNER JOIN vehicle_type
                    ON vehicle.vehicle_type_id = vehicle_type.id
                INNER JOIN vehicle_body
                    ON vehicle.vehicle_body_id = vehicle_body.id
                INNER JOIN vehicle_transmission
                    ON vehicle.vehicle_transmission_id = vehicle_transmission.id
                INNER JOIN vehicle_tyre front_vehicle_tyre
                    ON vehicle.front_vehicle_tyre_id = front_vehicle_tyre.id
                INNER JOIN vehicle_tyre rear_vehicle_tyre
                    ON vehicle.rear_vehicle_tyre_id = rear_vehicle_tyre.id 
                INNER JOIN vehicle_fuel
                    ON vehicle.vehicle_fuel_id = vehicle_fuel.id 
                INNER JOIN vehicle_break front_vehicle_break
                    ON vehicle.front_vehicle_break_id = front_vehicle_break.id 
                INNER JOIN vehicle_break rear_vehicle_break
                    ON vehicle.rear_vehicle_break_id = rear_vehicle_break.id 
                INNER JOIN vehicle_model
                    ON vehicle.vehicle_model_id = vehicle_model.id
                INNER JOIN vehicle_brand
                    ON vehicle_model.vehicle_brand_id = vehicle_brand.id 
            WHERE user_vehicle.status=? AND (
        ";

        foreach($keywords as $index => $keyword){
            $sql .= "CONCAT(
                        user.first_name,' ',
                        user.last_name,' ',
                        user.email,' ',
                        vehicle.name,' ',
                        vehicle.price,' ',
                        vehicle_condition.condition,' ',
                        vehicle_type.type,' ',
                        vehicle_body.body,' ',
                        vehicle_transmission.transmission,' ',
                        front_vehicle_tyre.tyre,' ',
                        rear_vehicle_tyre.tyre,' ',
                        vehicle_fuel.fuel,' ',
                        front_vehicle_break.break,' ',
                        rear_vehicle_break.break,' ',
                        vehicle_model.model,' ',
                        vehicle_brand.brand
                    ) 
                    LIKE '%".$keyword."%'";

            $sql .= ($index != count($keywords) - 1) ? " OR " : ")";
        }

        $sql .= " LIMIT ?;";

        /* @return
            [
                [
                    "id" => "...",
                    "full_text" => "..."
                ]
                ...
            ]
        */
        $vehicle_datas = Database::query($sql,"public",$limit*5);

        // Order the result by similarity percentage
        $sorted_vehicle_datas = [];
        foreach($vehicle_datas as $vehicle_data){
            similar_text(
                strtolower($vehicle_data['full_text']),
                str_replace("-", " ", $search_term),
                $score
            );
            $sorted_vehicle_datas[] = ['id'=>$vehicle_data['id'], 'score'=>$score];
        }

        usort($sorted_vehicle_datas, function ($one, $two) {
            return $two['score'] <=> $one['score'];
        });

        // Only selecting the first {$limit} ids
        $sorted_vehicle_datas = array_slice($sorted_vehicle_datas, 0, $limit); //array, from_index, to_index

        // Preparing return data
        $vehicles = [];
        foreach($sorted_vehicle_datas as $vehicle_data){
            $vehicles[] = getVehicleById($vehicle_data['id']);
        }

        // For Searching Users
        $sql = "SELECT
                    user.id AS id,
                    CONCAT(
                        user.id,' ',
                        user.first_name,' ',
                        user.last_name,' ',
                        user.email,' ',
                        user.phone
                    ) AS full_text
                FROM user
                WHERE user.status=? AND (
                ";
        
        foreach($keywords as $index => $keyword){
            $sql .= "CONCAT(
                        user.id,' ',
                        user.first_name,' ',
                        user.last_name,' ',
                        user.email,' ',
                        user.phone
                    ) 
                    LIKE '%".$keyword."%'";

            $sql .= ($index != count($keywords) - 1) ? " OR " : ")";
        }

        $sql .= " LIMIT ?;";

        $user_datas = Database::query($sql, "verified", $limit*5);

        // Order user data result by similarity percentage
        $sorted_user_datas = [];
        foreach($user_datas as $user_data){
            similar_text(
                strtolower($user_data['full_text']),
                str_replace("-", " ", $search_term),
                $score
            );
            $sorted_user_datas[] = ['id'=>$user_data['id'], 'score'=>$score];
        }

        usort($sorted_user_datas, function ($one, $two) {
            return $two['score'] <=> $one['score'];
        });

        // Only selecting the first {$limit} ids
        $sorted_user_datas = array_slice($sorted_user_datas, 0, $limit); //array, from_index, to_index

        // Preparing return data
        $users = [];
        foreach($sorted_user_datas as $user_data){
            $users[] = getUserById($user_data['id']);
        }

        $content = [];
        $content['vehicles'] = $vehicles;
        $content['users'] = $users;

        Api::send([
            "success" => TRUE,
            "content" => $content
        ]);
    });