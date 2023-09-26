<?php
if (!isset($_SESSION)) {
    session_start();
}

require './Database.php';
require './GameDataModel.php';

// Initialize
$database       = new Database();
$gameDataModel  = new GameDataModel($database);

function onFailure($message)
{
    $failureResponse = json_encode(array("error" => $message, "type" => "error"));
    
    print($failureResponse);
}

// http://localhost/ludogamedata/api.php?gameinfo=abcde
if (isset($_GET["gameinfo"]))
{
    $roomCode = trim($_GET["gameinfo"]);
    
    $gameDataModel->Select($roomCode);
    
    if ($gameDataModel->id != null)
    {
        $data = $gameDataModel->ToJson();
        
        print($data);
    }
    else
    {
        onFailure("Room code needed");
    }
}
// http://localhost/ludogamedata/api.php
else if (isset($_POST["context"]))
{
    $context    = trim($_POST["context"]);
    $room_code  = trim($_POST["room_code"]);
    
    if (($context != null) && ($room_code != null) && (strlen($context) > 0) && (strlen($room_code) > 0))
    {
        /*
        {
            "context": "add_new",
            "room_code": "ABC12",
            "game_type": "4p",
            "player_id": "12345"
        }
        */ 
        
        if ($context == "add_new")
        {
            $game_type = trim($_POST["game_type"]);
            $playerId  = trim($_POST["player_id"]);
            
            $gameDataModel->primary_room_code           = $room_code;
            $gameDataModel->reconnection_room_code      = $room_code;
            $gameDataModel->game_type                   = $game_type;
            $gameDataModel->player_1_id                 = $playerId;
            $gameDataModel->room_host                   = $playerId;
            $gameDataModel->AddNew();

            $data = $gameDataModel->ToJson();
            print($data);
        }
        /*
        {
            "context": "update_game_state",
            "room_code": "ABC12",
            "game_state": 1
        }
        */
        else if ($context == "update_game_state")
        {
            $gameDataModel->Select($room_code);
            
            $gameDataModel->game_state = intval($_POST["game_state"]);
            
            $gameDataModel->Update();
            
            $gameDataModel->Select($room_code);
            
            $data = $gameDataModel->ToJson();
            
            print($data);
        }
        /*
        {
            "context": "update_winners",
            "room_code": "ABC12",
            "winner_1": "12345",
            "winner_2": "34567",
            "winner_3": "89101",
            "winner_4": "45677",
        }
        */
        else if ($context == "update_winners")
        {
            $gameDataModel->Select($room_code);
            
            $gameDataModel->winner_1 = $_POST["winner_1"];
            $gameDataModel->winner_2 = $_POST["winner_2"];
            $gameDataModel->winner_3 = $_POST["winner_3"];
            $gameDataModel->winner_4 = $_POST["winner_4"];
            
            $gameDataModel->Update();
            
            $gameDataModel->Select($room_code);
            
            $data = $gameDataModel->ToJson();
            
            print($data);
        }
        /*
        {
            "context": "update_player_name",
            "room_code": "ABC12",
            "player_type": 0,
            "player_name": "John Doe"
        }
        */
        else if ($context == "update_player_name")
        {
            $gameDataModel->Select($room_code);
            
            $playerType = intval($_POST["player_type"]);
            $playerName = $_POST["player_name"];
            
            if ($playerType == 0)
            {
                $gameDataModel->player_1_name = $playerName;
            }
            else if ($playerType == 1)
            {
                $gameDataModel->player_2_name = $playerName;
            }
            else if ($playerType == 2)
            {
                $gameDataModel->player_3_name = $playerName;
            }
            else if ($playerType == 3)
            {
                $gameDataModel->player_4_name = $playerName;
            }
            
            $gameDataModel->Update();
            
            $gameDataModel->Select($room_code);
            
            $data = $gameDataModel->ToJson();
            
            print($data);
        }
        /*
        {
            "context": "update_reconnection_code",
            "room_code": "ABC12",
            "reconnection_room_code": "CDEF1",
            "room_host": "12345"
        }
        */
        else if ($context == "update_reconnection_code")
        {
            $gameDataModel->Select($room_code);
            
            $gameDataModel->reconnection_room_code = $_POST["reconnection_room_code"];
            $gameDataModel->room_host = $_POST["room_host"];
            
            $gameDataModel->Update();
            
            $gameDataModel->Select($room_code);
            
            $data = $gameDataModel->ToJson();
            
            print($data);
        }
        /*
        {
            "context": "update_host_attempt",
            "room_code": "ABC12",
            "host_attempt": "12345"
        }
        */
        else if ($context == "update_host_attempt")
        {
            $gameDataModel->Select($room_code);
            
            $gameDataModel->host_attempt = $_POST["host_attempt"];
            
            $gameDataModel->Update();
            
            $gameDataModel->Select($room_code);
            
            $data = $gameDataModel->ToJson();
            
            print($data);
        }
        /*
        {
            "context": "update_player_data",
            "room_code": "ABC12",
            "player_type": 0,           // 0 - 3
            "player_id": "12345",
            "player_name": "John Doe",
            "player_token_1_state": 0,
            "player_token_1_value": 0,
            "player_token_2_state": 0,
            "player_token_2_value": 0,
            "player_token_3_state": 0,
            "player_token_3_value": 0,
            "player_token_4_state": 0,
            "player_token_4_value": 0,
            "is_host": true,
            "player_classic_game_end": player_classic_game_end
        }
        */
        else if ($context == "update_player_data")
        {
            $gameDataModel->Select($room_code);
            
            $playerType = intval(trim($_POST["player_type"]));
            $is_host = boolval(trim($_POST["is_host"]));
            
            if ($is_host)
            {
                $gameDataModel->room_host = $_POST["player_id"];
            }
            
            if ($playerType == 0)
            {
                $gameDataModel->player_1_id            = $_POST["player_id"];
                $gameDataModel->player_1_name          = $_POST["player_name"];
                $gameDataModel->player_1_token_1_state = $_POST["player_token_1_state"];
                $gameDataModel->player_1_token_1_value = $_POST["player_token_1_value"];
                $gameDataModel->player_1_token_2_state = $_POST["player_token_2_state"];
                $gameDataModel->player_1_token_2_value = $_POST["player_token_2_value"];
                $gameDataModel->player_1_token_3_state = $_POST["player_token_3_state"];
                $gameDataModel->player_1_token_3_value = $_POST["player_token_3_value"];
                $gameDataModel->player_1_token_4_state = $_POST["player_token_4_state"];
                $gameDataModel->player_1_token_4_value = $_POST["player_token_4_value"];
                $gameDataModel->player_1_classic_game_end = $_POST["player_classic_game_end"];
            }
            else if ($playerType == 1)
            {
                $gameDataModel->player_2_id            = $_POST["player_id"];
                $gameDataModel->player_2_name          = $_POST["player_name"];
                $gameDataModel->player_2_token_1_state = $_POST["player_token_1_state"];
                $gameDataModel->player_2_token_1_value = $_POST["player_token_1_value"];
                $gameDataModel->player_2_token_2_state = $_POST["player_token_2_state"];
                $gameDataModel->player_2_token_2_value = $_POST["player_token_2_value"];
                $gameDataModel->player_2_token_3_state = $_POST["player_token_3_state"];
                $gameDataModel->player_2_token_3_value = $_POST["player_token_3_value"];
                $gameDataModel->player_2_token_4_state = $_POST["player_token_4_state"];
                $gameDataModel->player_2_token_4_value = $_POST["player_token_4_value"];
                $gameDataModel->player_2_classic_game_end = $_POST["player_classic_game_end"];
            }
            else if ($playerType == 2)
            {
                $gameDataModel->player_3_id            = $_POST["player_id"];
                $gameDataModel->player_3_name          = $_POST["player_name"];
                $gameDataModel->player_3_token_1_state = $_POST["player_token_1_state"];
                $gameDataModel->player_3_token_1_value = $_POST["player_token_1_value"];
                $gameDataModel->player_3_token_2_state = $_POST["player_token_2_state"];
                $gameDataModel->player_3_token_2_value = $_POST["player_token_2_value"];
                $gameDataModel->player_3_token_3_state = $_POST["player_token_3_state"];
                $gameDataModel->player_3_token_3_value = $_POST["player_token_3_value"];
                $gameDataModel->player_3_token_4_state = $_POST["player_token_4_state"];
                $gameDataModel->player_3_token_4_value = $_POST["player_token_4_value"];
                $gameDataModel->player_3_classic_game_end = $_POST["player_classic_game_end"];
            }
            else if ($playerType == 3)
            {
                $gameDataModel->player_4_id            = $_POST["player_id"];
                $gameDataModel->player_4_name          = $_POST["player_name"];
                $gameDataModel->player_4_token_1_state = $_POST["player_token_1_state"];
                $gameDataModel->player_4_token_1_value = $_POST["player_token_1_value"];
                $gameDataModel->player_4_token_2_state = $_POST["player_token_2_state"];
                $gameDataModel->player_4_token_2_value = $_POST["player_token_2_value"];
                $gameDataModel->player_4_token_3_state = $_POST["player_token_3_state"];
                $gameDataModel->player_4_token_3_value = $_POST["player_token_3_value"];
                $gameDataModel->player_4_token_4_state = $_POST["player_token_4_state"];
                $gameDataModel->player_4_token_4_value = $_POST["player_token_4_value"];
                $gameDataModel->player_4_classic_game_end = $_POST["player_classic_game_end"];
            }
            
            
            $gameDataModel->Update();
            
            $gameDataModel->Select($room_code);
            
            $data = $gameDataModel->ToJson();
            
            print($data);
        }
        else if ($context == "update_player_left")
        {
            $gameDataModel->Select($room_code);
            
            $playerType = intval(trim($_POST["player_type"]));
            $value = boolval(trim($_POST["value"]));
            
            if ($playerType == 0)
            {
                $gameDataModel->is_player_1_left = $value;
            }
            else if ($playerType == 1)
            {
                $gameDataModel->is_player_2_left = $value;
            }
            else if ($playerType == 2)
            {
                $gameDataModel->is_player_3_left = $value;
            }
            else if ($playerType == 3)
            {
                $gameDataModel->is_player_4_left = $value;
            }
            
            $gameDataModel->Update();
            
            $gameDataModel->Select($room_code);
            
            $data = $gameDataModel->ToJson();
            
            print($data);
        }
        else if ($context == "update")
        {
            $gameDataModel->Select($room_code);
            
            $gameDataModel->reconnection_room_code = $_POST["reconnection_room_code"];
            $gameDataModel->room_host              = $_POST["room_host"];
            
            $gameDataModel->player_1_id            = $_POST["player_1_id"];
            $gameDataModel->player_1_name          = $_POST["player_1_name"];
            $gameDataModel->player_1_token_1_state = $_POST["player_1_token_1_state"];
            $gameDataModel->player_1_token_1_value = $_POST["player_1_token_1_value"];
            $gameDataModel->player_1_token_2_state = $_POST["player_1_token_2_state"];
            $gameDataModel->player_1_token_2_value = $_POST["player_1_token_2_value"];
            $gameDataModel->player_1_token_3_state = $_POST["player_1_token_3_state"];
            $gameDataModel->player_1_token_3_value = $_POST["player_1_token_3_value"];
            $gameDataModel->player_1_token_4_state = $_POST["player_1_token_4_state"];
            $gameDataModel->player_1_token_4_value = $_POST["player_1_token_4_value"];
            
            $gameDataModel->player_2_id            = $_POST["player_2_id"];
            $gameDataModel->player_2_name          = $_POST["player_2_name"];
            $gameDataModel->player_2_token_1_state = $_POST["player_2_token_1_state"];
            $gameDataModel->player_2_token_1_value = $_POST["player_2_token_1_value"];
            $gameDataModel->player_2_token_2_state = $_POST["player_2_token_2_state"];
            $gameDataModel->player_2_token_2_value = $_POST["player_2_token_2_value"];
            $gameDataModel->player_2_token_3_state = $_POST["player_2_token_3_state"];
            $gameDataModel->player_2_token_3_value = $_POST["player_2_token_3_value"];
            $gameDataModel->player_2_token_4_state = $_POST["player_2_token_4_state"];
            $gameDataModel->player_2_token_4_value = $_POST["player_2_token_4_value"];
            
            $gameDataModel->player_3_id            = $_POST["player_3_id"];
            $gameDataModel->player_3_name          = $_POST["player_3_name"];
            $gameDataModel->player_3_token_1_state = $_POST["player_3_token_1_state"];
            $gameDataModel->player_3_token_1_value = $_POST["player_3_token_1_value"];
            $gameDataModel->player_3_token_2_state = $_POST["player_3_token_2_state"];
            $gameDataModel->player_3_token_2_value = $_POST["player_3_token_2_value"];
            $gameDataModel->player_3_token_3_state = $_POST["player_3_token_3_state"];
            $gameDataModel->player_3_token_3_value = $_POST["player_3_token_3_value"];
            $gameDataModel->player_3_token_4_state = $_POST["player_3_token_4_state"];
            $gameDataModel->player_3_token_4_value = $_POST["player_3_token_4_value"];
            
            $gameDataModel->player_4_id            = $_POST["player_4_id"];
            $gameDataModel->player_4_name          = $_POST["player_4_name"];
            $gameDataModel->player_4_token_1_state = $_POST["player_4_token_1_state"];
            $gameDataModel->player_4_token_1_value = $_POST["player_4_token_1_value"];
            $gameDataModel->player_4_token_2_state = $_POST["player_4_token_2_state"];
            $gameDataModel->player_4_token_2_value = $_POST["player_4_token_2_value"];
            $gameDataModel->player_4_token_3_state = $_POST["player_4_token_3_state"];
            $gameDataModel->player_4_token_3_value = $_POST["player_4_token_3_value"];
            $gameDataModel->player_4_token_4_state = $_POST["player_4_token_4_state"];
            $gameDataModel->player_4_token_4_value = $_POST["player_4_token_4_value"];
            
            $gameDataModel->Update();
            
            $gameDataModel->Select($room_code);
            
            $data = $gameDataModel->ToJson();
            
            print($data);
        }
        /*
        {
            "context": "delete",
            "room_code": "ABC12",
        }
        */
        else if ($context == "delete")
        {
            $gameDataModel->Select($room_code);
            $data = $gameDataModel->ToJson();
            
            $gameDataModel->Delete();
            
            print($data);
        }
        else
        {
            onFailure("Wrong request");
        }
    }
    else
    {
        onFailure("Input data not found");
    }
}
else
{
    header("HTTP/1.0 404 Not Found");
}