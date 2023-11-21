<?php
/*
 * URI:             localhost/ludogamedata/api-tournament-host-management-all.php
 * 
 * Method:          POST
 * 
 * Form Data Example:
 * 
 * tournament_id:   2,
 * game_id:         3,
 * round_id:        4,
 * board_id:        5
 * 
 Response:
{
    "data": [
        {
            "id": 4,
            "user_id": 1,
            "tournament_id": 2,
            "game_id": 3,
            "round_id": 4,
            "board_id": 5
            "game_type": "2p",
            "room_code": null,
            "created_at": "2023-11-18 20:20:51",
            "updated_at": "2023-11-18 20:20:51"
        }
    ],
    "message": "1 data found",
    "type": "success"
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
if (isset($_POST["tournament_id"])  &&
    isset($_POST["game_id"])        &&
    isset($_POST["round_id"])       &&
    isset($_POST["board_id"]))
{
    // Gather Data
    $tournament_id   = intval($_POST["tournament_id"]);
    $game_id         = intval($_POST["game_id"]);
    $round_id        = intval($_POST["round_id"]);
    $board_id        = intval($_POST["board_id"]);

    $data            = $tournnamentHostClientData->GetAll($tournament_id, $game_id, $round_id, $board_id);

    // Return response
    $response = array(
        "data"      => $data,
        "message"   => count($data) . " data found",
        "type"      => "success"
    );
    
    header("Content-type: application/json; charset=utf-8");
    print(json_encode($response));
}
// Failure
else
{
    onFailure("Tournament ID, Game ID, Round ID and Board ID are required");
}

function onFailure($message)
{
    $failureResponse = json_encode(array("error" => $message, "type" => "error"));
    
    header("Content-type: application/json; charset=utf-8");
    print($failureResponse);
}