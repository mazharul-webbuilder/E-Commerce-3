<?php

if (!isset($_SESSION)) {
    session_start();
}

/* Example */
require './Database.php';
require './GameDataModel.php';

// Initialize
$database       = new Database();
$gameDataModel  = new GameDataModel($database);


/*
$gameDataModel->Select("abcde");        // Room code as parameter

// Update
$gameDataModel->game_type = "3p";
$gameDataModel->Update();

// Print data
echo($gameDataModel->game_type);

// Insert
$gameDataModel->primary_room_code = "cdefg";
$gameDataModel->AddNew();

// Delete
$gameDataModel->Delete();

// Json
$json = $gameDataModel->ToJson();
echo($json);
 */
