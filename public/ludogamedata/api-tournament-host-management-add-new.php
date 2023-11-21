<?php
/*
 * URI:             localhost/ludogamedata/api-tournament-host-management-add-new.php
 * 
 * Method:          POST
 * 
 * Form Data Example:
 * 
 * user_id:         1
 * tournament_id:   2,
 * game_id:         3,
 * round_id:        4,
 * board_id:        5,
 * game_type:       "2p"
 * 
 * Response:
 {
    "id": 4,
    "user_id": 1,
    "tournament_id": 2,
    "game_id": 3,
    "round_id": 4,
    "board_id": 5,
    "game_type": "2p",
    "room_code": null,
    "created_at": "2023-11-18 20:20:51",
    "updated_at": "2023-11-18 20:20:51"
}
 * 
 */

if (!isset($_SESSION)) {
    session_start();
}

require './Database.php';
require './TournnamentHostClientDataModel.php';

// Initialize
$database                   = new Database();
$tournnamentHostClientData  = new TournnamentHostClientDataModel($database);

// Validate
if (isset($_POST["user_id"])        &&
    isset($_POST["tournament_id"])  &&
    isset($_POST["game_id"])        &&
    isset($_POST["round_id"])       &&
    isset($_POST["board_id"])       &&
    isset($_POST["game_type"]))
{
    $tournament_id                              = intval($_POST["tournament_id"]);
    $game_id                                    = intval($_POST["game_id"]);
    $round_id                                   = intval($_POST["round_id"]);
    $board_id                                   = intval($_POST["board_id"]);
    
    // Gather Data
    $tournnamentHostClientData->user_id         = intval($_POST["user_id"]);
    $tournnamentHostClientData->tournament_id   = $tournament_id;
    $tournnamentHostClientData->game_id         = $game_id;
    $tournnamentHostClientData->round_id        = $round_id;
    $tournnamentHostClientData->board_id        = $board_id;
    $tournnamentHostClientData->game_type       = $_POST["game_type"];
    
    // Check if the data still exists
    $isDataExists = $tournnamentHostClientData->Select();
    
    // Add new
    if (!$isDataExists)
    {
        $data = $tournnamentHostClientData->GetAll($tournament_id, $game_id, $round_id, $board_id);
        $roomCode = null;
        
        if (($data != null) && (count($data) > 0))
        {
            $roomCode = $data[0]->room_code;
        }
        
        $tournnamentHostClientData->user_id         = intval($_POST["user_id"]);
        $tournnamentHostClientData->tournament_id   = $tournament_id;
        $tournnamentHostClientData->game_id         = $game_id;
        $tournnamentHostClientData->round_id        = $round_id;
        $tournnamentHostClientData->board_id        = $board_id;
        $tournnamentHostClientData->game_type       = $_POST["game_type"];
        $tournnamentHostClientData->room_code       = $roomCode;
        
        $tournnamentHostClientData->Insert();
    }
    
    // Return response
    header("Content-type: application/json; charset=utf-8");
    print($tournnamentHostClientData->ToJson());
}
// Failure
else
{
    onFailure("Tournament ID, Game ID, Round ID, Board ID, User Id and Game Type are required");
}

function onFailure($message)
{
    $failureResponse = json_encode(array("error" => $message, "type" => "error"));
    
    header("Content-type: application/json; charset=utf-8");
    print($failureResponse);
}