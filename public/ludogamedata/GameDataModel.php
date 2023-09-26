<?php
class GameDataModel {
    private $_db = null;    
    private $tableName = "gamedata";
    
    public $id = null;
    public $primary_room_code = null;
    public $game_type = "4p";
    public $reconnection_room_code = null;
    public $room_host = null;
    public $player_1_id = null;
    public $player_1_token_1_state = 0;
    public $player_1_token_1_value = 0;
    public $player_1_token_2_state = 0;
    public $player_1_token_2_value = 0;
    public $player_1_token_3_state = 0;
    public $player_1_token_3_value = 0;
    public $player_1_token_4_state = 0;
    public $player_1_token_4_value = 0;
    public $player_1_classic_game_end = 0;
    public $player_2_id = null;
    public $player_2_token_1_state = 0;
    public $player_2_token_1_value = 0;
    public $player_2_token_2_state = 0;
    public $player_2_token_2_value = 0;
    public $player_2_token_3_state = 0;
    public $player_2_token_3_value = 0;
    public $player_2_token_4_state = 0;
    public $player_2_token_4_value = 0;
    public $player_2_classic_game_end = 0;
    public $player_3_id = null;
    public $player_3_token_1_state = 0;
    public $player_3_token_1_value = 0;
    public $player_3_token_2_state = 0;
    public $player_3_token_2_value = 0;
    public $player_3_token_3_state = 0;
    public $player_3_token_3_value = 0;
    public $player_3_token_4_state = 0;
    public $player_3_token_4_value = 0;
    public $player_3_classic_game_end = 0;
    public $player_4_id = null;
    public $player_4_token_1_state = 0;
    public $player_4_token_1_value = 0;
    public $player_4_token_2_state = 0;
    public $player_4_token_2_value = 0;
    public $player_4_token_3_state = 0;
    public $player_4_token_3_value = 0;
    public $player_4_token_4_state = 0;
    public $player_4_token_4_value = 0;
    public $player_4_classic_game_end = 0;
    public $host_attempt = null;
    public $is_player_1_left = false;
    public $is_player_2_left = false;
    public $is_player_3_left = false;
    public $is_player_4_left = false;
    public $game_state = 0;
    public $winner_1 = null;
    public $winner_2 = null;
    public $winner_3 = null;
    public $winner_4 = null;
    public $player_1_name = null;
    public $player_2_name = null;
    public $player_3_name = null;
    public $player_4_name = null;

    public function __construct($db) {
        $this->_db = $db;
    }
    
    public function Select($roomCode) {
        $sql = "SELECT * FROM $this->tableName WHERE primary_room_code='$roomCode';";
        $row = $this->_db->GetQueryResult($sql);
        
        if ($row != null)
        {
            $this->id = $row["id"];
            
            $this->primary_room_code = $row["primary_room_code"];
            $this->game_type = $row["game_type"];
            $this->reconnection_room_code = $row["reconnection_room_code"];
            $this->room_host = $row["room_host"];
            
            $this->player_1_id = $row["player_1_id"];
            $this->player_1_token_1_state = $row["player_1_token_1_state"];
            $this->player_1_token_1_value = $row["player_1_token_1_value"];
            $this->player_1_token_2_state = $row["player_1_token_2_state"];
            $this->player_1_token_2_value = $row["player_1_token_2_value"];
            $this->player_1_token_3_state = $row["player_1_token_3_state"];
            $this->player_1_token_3_value = $row["player_1_token_3_value"];
            $this->player_1_token_4_state = $row["player_1_token_4_state"];
            $this->player_1_token_4_value = $row["player_1_token_4_value"];
            $this->player_1_classic_game_end = $row["player_1_classic_game_end"];
            
            $this->player_2_id = $row["player_2_id"];
            $this->player_2_token_1_state = $row["player_2_token_1_state"];
            $this->player_2_token_1_value = $row["player_2_token_1_value"];
            $this->player_2_token_2_state = $row["player_2_token_2_state"];
            $this->player_2_token_2_value = $row["player_2_token_2_value"];
            $this->player_2_token_3_state = $row["player_2_token_3_state"];
            $this->player_2_token_3_value = $row["player_2_token_3_value"];
            $this->player_2_token_4_state = $row["player_2_token_4_state"];
            $this->player_2_token_4_value = $row["player_2_token_4_value"];
            $this->player_2_classic_game_end = $row["player_2_classic_game_end"];
            
            $this->player_3_id = $row["player_3_id"];
            $this->player_3_token_1_state = $row["player_3_token_1_state"];
            $this->player_3_token_1_value = $row["player_3_token_1_value"];
            $this->player_3_token_2_state = $row["player_3_token_2_state"];
            $this->player_3_token_2_value = $row["player_3_token_2_value"];
            $this->player_3_token_3_state = $row["player_3_token_3_state"];
            $this->player_3_token_3_value = $row["player_3_token_3_value"];
            $this->player_3_token_4_state = $row["player_3_token_4_state"];
            $this->player_3_token_4_value = $row["player_3_token_4_value"];
            $this->player_3_classic_game_end = $row["player_3_classic_game_end"];
            
            $this->player_4_id = $row["player_4_id"];
            $this->player_4_token_1_state = $row["player_4_token_1_state"];
            $this->player_4_token_1_value = $row["player_4_token_1_value"];
            $this->player_4_token_2_state = $row["player_4_token_2_state"];
            $this->player_4_token_2_value = $row["player_4_token_2_value"];
            $this->player_4_token_3_state = $row["player_4_token_3_state"];
            $this->player_4_token_3_value = $row["player_4_token_3_value"];
            $this->player_4_token_4_state = $row["player_4_token_4_state"];
            $this->player_4_token_4_value = $row["player_4_token_4_value"];
            $this->player_4_classic_game_end = $row["player_4_classic_game_end"];
            
            $this->host_attempt = $row["host_attempt"];
            $this->is_player_1_left = boolval($row["is_player_1_left"]);
            $this->is_player_2_left = boolval($row["is_player_2_left"]);
            $this->is_player_3_left = boolval($row["is_player_3_left"]);
            $this->is_player_4_left = boolval($row["is_player_4_left"]);
            
            $this->game_state = intval($row["game_state"]);
            $this->winner_1 = $row["winner_1"];
            $this->winner_2 = $row["winner_2"];
            $this->winner_3 = $row["winner_3"];
            $this->winner_4 = $row["winner_4"];
            
            $this->player_1_name = $row["player_1_name"];
            $this->player_2_name = $row["player_2_name"];
            $this->player_3_name = $row["player_3_name"];
            $this->player_4_name = $row["player_4_name"];
        }
    }
    
    public function Update()
    {
        $this->_update(
                $this->primary_room_code,
                $this->game_type,
                $this->reconnection_room_code,
                $this->room_host,
                $this->player_1_id,
                $this->player_1_token_1_state,
                $this->player_1_token_1_value,
                $this->player_1_token_2_state,
                $this->player_1_token_2_value,
                $this->player_1_token_3_state,
                $this->player_1_token_3_value,
                $this->player_1_token_4_state,
                $this->player_1_token_4_value,
                $this->player_2_id,
                $this->player_2_token_1_state,
                $this->player_2_token_1_value,
                $this->player_2_token_2_state,
                $this->player_2_token_2_value,
                $this->player_2_token_3_state,
                $this->player_2_token_3_value,
                $this->player_2_token_4_state,
                $this->player_2_token_4_value,
                $this->player_3_id,
                $this->player_3_token_1_state,
                $this->player_3_token_1_value,
                $this->player_3_token_2_state,
                $this->player_3_token_2_value,
                $this->player_3_token_3_state,
                $this->player_3_token_3_value,
                $this->player_3_token_4_state,
                $this->player_3_token_4_value,
                $this->player_4_id,
                $this->player_4_token_1_state,
                $this->player_4_token_1_value,
                $this->player_4_token_2_state,
                $this->player_4_token_2_value,
                $this->player_4_token_3_state,
                $this->player_4_token_3_value,
                $this->player_4_token_4_state,
                $this->player_4_token_4_value,
                $this->host_attempt,
                $this->is_player_1_left,
                $this->is_player_2_left,
                $this->is_player_3_left,
                $this->is_player_4_left,
                $this->game_state,
                $this->winner_1,
                $this->winner_2,
                $this->winner_3,
                $this->winner_4,
                $this->player_1_name,
                $this->player_2_name,
                $this->player_3_name,
                $this->player_4_name,
                $this->player_1_classic_game_end,
                $this->player_2_classic_game_end,
                $this->player_3_classic_game_end,
                $this->player_4_classic_game_end
        );
        
        $this->Select($this->primary_room_code);
    }


    public function _update($primary_room_code,
                            $game_type,
                            $reconnection_room_code,
                            $room_host,
            
                            $player_1_id,
                            $player_1_token_1_state,
                            $player_1_token_1_value,
                            $player_1_token_2_state,
                            $player_1_token_2_value,
                            $player_1_token_3_state,
                            $player_1_token_3_value,
                            $player_1_token_4_state,
                            $player_1_token_4_value,
            
                            $player_2_id,
                            $player_2_token_1_state,
                            $player_2_token_1_value,
                            $player_2_token_2_state,
                            $player_2_token_2_value,
                            $player_2_token_3_state,
                            $player_2_token_3_value,
                            $player_2_token_4_state,
                            $player_2_token_4_value,
            
                            $player_3_id,
                            $player_3_token_1_state,
                            $player_3_token_1_value,
                            $player_3_token_2_state,
                            $player_3_token_2_value,
                            $player_3_token_3_state,
                            $player_3_token_3_value,
                            $player_3_token_4_state,
                            $player_3_token_4_value,
            
                            $player_4_id,
                            $player_4_token_1_state,
                            $player_4_token_1_value,
                            $player_4_token_2_state,
                            $player_4_token_2_value,
                            $player_4_token_3_state,
                            $player_4_token_3_value,
                            $player_4_token_4_state,
                            $player_4_token_4_value,
            
                            $host_attempt,
                            $is_player_1_left,
                            $is_player_2_left,
                            $is_player_3_left,
                            $is_player_4_left,
            
                            $game_state,
                            $winner_1,
                            $winner_2,
                            $winner_3,
                            $winner_4,
            
                            $player_1_name,
                            $player_2_name,
                            $player_3_name,
                            $player_4_name,
            
                            $player_1_classic_game_end,
                            $player_2_classic_game_end,
                            $player_3_classic_game_end,
                            $player_4_classic_game_end) {
        
        $is_player_1_left = $is_player_1_left ? 1 : 0;
        $is_player_2_left = $is_player_2_left ? 1 : 0;
        $is_player_3_left = $is_player_3_left ? 1 : 0;
        $is_player_4_left = $is_player_4_left ? 1 : 0;
        
        $player_1_classic_game_end = $player_1_classic_game_end ? 1 : 0;
        $player_2_classic_game_end = $player_2_classic_game_end ? 1 : 0;
        $player_3_classic_game_end = $player_3_classic_game_end ? 1 : 0;
        $player_4_classic_game_end = $player_4_classic_game_end ? 1 : 0;
        
        $sql = "UPDATE $this->tableName SET game_type='$game_type', reconnection_room_code='$reconnection_room_code', room_host='$room_host', player_1_id='$player_1_id', player_1_token_1_state=$player_1_token_1_state, player_1_token_1_value=$player_1_token_1_value, player_1_token_2_state=$player_1_token_2_state, player_1_token_2_value=$player_1_token_2_value, player_1_token_3_state=$player_1_token_3_state, player_1_token_3_value=$player_1_token_3_value, player_1_token_4_state=$player_1_token_4_state, player_1_token_4_value=$player_1_token_4_value, player_2_id='$player_2_id', player_2_token_1_state=$player_2_token_1_state, player_2_token_1_value=$player_2_token_1_value, player_2_token_2_state=$player_2_token_2_state, player_2_token_2_value=$player_2_token_2_value, player_2_token_3_state=$player_2_token_3_state, player_2_token_3_value=$player_2_token_3_value, player_2_token_4_state=$player_2_token_4_state, player_2_token_4_value=$player_2_token_4_value, player_3_id='$player_3_id', player_3_token_1_state=$player_3_token_1_state, player_3_token_1_value=$player_3_token_1_value, player_3_token_2_state=$player_3_token_2_state, player_3_token_2_value=$player_3_token_2_value, player_3_token_3_state=$player_3_token_3_state, player_3_token_3_value=$player_3_token_3_value, player_3_token_4_state=$player_3_token_4_state, player_3_token_4_value=$player_3_token_4_value, player_4_id='$player_4_id', player_4_token_1_state=$player_4_token_1_state, player_4_token_1_value=$player_4_token_1_value, player_4_token_2_state=$player_4_token_2_state, player_4_token_2_value=$player_4_token_2_value, player_4_token_3_state=$player_4_token_3_state, player_4_token_3_value=$player_4_token_3_value, player_4_token_4_state=$player_4_token_4_state, player_4_token_4_value=$player_4_token_4_value, host_attempt='$host_attempt', is_player_1_left=$is_player_1_left, is_player_2_left=$is_player_2_left, is_player_3_left=$is_player_3_left, is_player_4_left=$is_player_4_left, game_state=$game_state, winner_1='$winner_1', winner_2='$winner_2', winner_3='$winner_3', winner_4='$winner_4', player_1_name='$player_1_name', player_2_name='$player_2_name', player_3_name='$player_3_name', player_4_name='$player_4_name', player_1_classic_game_end=$player_1_classic_game_end, player_2_classic_game_end=$player_2_classic_game_end, player_3_classic_game_end=$player_3_classic_game_end, player_4_classic_game_end=$player_4_classic_game_end WHERE primary_room_code='$primary_room_code';";
        
        $this->_db->Update($sql);
    }
    
    public function AddNew() {
        $this->_insert($this->primary_room_code, $this->game_type, $this->reconnection_room_code, $this->room_host, $this->player_1_id, $this->player_1_token_1_state, $this->player_1_token_1_value, $this->player_1_token_2_state, $this->player_1_token_2_value, $this->player_1_token_3_state, $this->player_1_token_3_value, $this->player_1_token_4_state, $this->player_1_token_4_value, $this->player_2_id, $this->player_2_token_1_state, $this->player_2_token_1_value, $this->player_2_token_2_state, $this->player_2_token_2_value, $this->player_2_token_3_state, $this->player_2_token_3_value, $this->player_2_token_4_state, $this->player_2_token_4_value, $this->player_3_id, $this->player_3_token_1_state, $this->player_3_token_1_value, $this->player_3_token_2_state, $this->player_3_token_2_value, $this->player_3_token_3_state, $this->player_3_token_3_value, $this->player_3_token_4_state, $this->player_3_token_4_value, $this->player_4_id, $this->player_4_token_1_state, $this->player_4_token_1_value, $this->player_4_token_2_state, $this->player_4_token_2_value, $this->player_4_token_3_state, $this->player_4_token_3_value, $this->player_4_token_4_state, $this->player_4_token_4_value);
        
        $this->Select($this->primary_room_code);
    }


    public function _insert(
            $primary_room_code,
            $game_type,
            $reconnection_room_code,
            $room_host,

            $player_1_id,
            $player_1_token_1_state,
            $player_1_token_1_value,
            $player_1_token_2_state,
            $player_1_token_2_value,
            $player_1_token_3_state,
            $player_1_token_3_value,
            $player_1_token_4_state,
            $player_1_token_4_value,

            $player_2_id,
            $player_2_token_1_state,
            $player_2_token_1_value,
            $player_2_token_2_state,
            $player_2_token_2_value,
            $player_2_token_3_state,
            $player_2_token_3_value,
            $player_2_token_4_state,
            $player_2_token_4_value,

            $player_3_id,
            $player_3_token_1_state,
            $player_3_token_1_value,
            $player_3_token_2_state,
            $player_3_token_2_value,
            $player_3_token_3_state,
            $player_3_token_3_value,
            $player_3_token_4_state,
            $player_3_token_4_value,

            $player_4_id,
            $player_4_token_1_state,
            $player_4_token_1_value,
            $player_4_token_2_state,
            $player_4_token_2_value,
            $player_4_token_3_state,
            $player_4_token_3_value,
            $player_4_token_4_state,
            $player_4_token_4_value
    ) {
        $sql = "INSERT INTO $this->tableName(primary_room_code, game_type, reconnection_room_code, room_host, player_1_id, player_1_token_1_state, player_1_token_1_value, player_1_token_2_state, player_1_token_2_value, player_1_token_3_state, player_1_token_3_value, player_1_token_4_state, player_1_token_4_value, player_2_id, player_2_token_1_state, player_2_token_1_value, player_2_token_2_state, player_2_token_2_value, player_2_token_3_state, player_2_token_3_value, player_2_token_4_state, player_2_token_4_value, player_3_id, player_3_token_1_state, player_3_token_1_value, player_3_token_2_state, player_3_token_2_value, player_3_token_3_state, player_3_token_3_value, player_3_token_4_state, player_3_token_4_value, player_4_id, player_4_token_1_state, player_4_token_1_value, player_4_token_2_state, player_4_token_2_value, player_4_token_3_state, player_4_token_3_value, player_4_token_4_state, player_4_token_4_value) VALUES('$primary_room_code', '$game_type', '$reconnection_room_code', '$room_host', '$player_1_id', $player_1_token_1_state, $player_1_token_1_value, $player_1_token_2_state, $player_1_token_2_value, $player_1_token_3_state, $player_1_token_3_value, $player_1_token_4_state, $player_1_token_4_value, '$player_2_id', $player_2_token_1_state, $player_2_token_1_value, $player_2_token_2_state, $player_2_token_2_value, $player_2_token_3_state, $player_2_token_3_value, $player_2_token_4_state, $player_2_token_4_value, '$player_3_id', $player_3_token_1_state, $player_3_token_1_value, $player_3_token_2_state, $player_3_token_2_value, $player_3_token_3_state, $player_3_token_3_value, $player_3_token_4_state, $player_3_token_4_value, '$player_4_id', $player_4_token_1_state, $player_4_token_1_value, $player_4_token_2_state, $player_4_token_2_value, $player_4_token_3_state, $player_4_token_3_value, $player_4_token_4_state, $player_4_token_4_value);";

        $this->_db->Insert($sql);
    }
    
    public function Delete() {
        $sql = "DELETE FROM $this->tableName WHERE primary_room_code='$this->primary_room_code';";
        
        $this->_db->Delete($sql);
    }
    
    public function ToJson() {
        $data = array(
            "id" => intval($this->id),
            "primary_room_code" => $this->primary_room_code,
            "game_type" => $this->game_type,
            "reconnection_room_code" => $this->reconnection_room_code,
            "room_host" => $this->room_host,
            
            "player_1_id" => $this->player_1_id,
            "player_1_name" => $this->player_1_name,
            "player_1_token_1_state" => intval($this->player_1_token_1_state),
            "player_1_token_1_value" => intval($this->player_1_token_1_value),
            "player_1_token_2_state" => intval($this->player_1_token_2_state),
            "player_1_token_2_value" => intval($this->player_1_token_2_value),
            "player_1_token_3_state" => intval($this->player_1_token_3_state),
            "player_1_token_3_value" => intval($this->player_1_token_3_value),
            "player_1_token_4_state" => intval($this->player_1_token_4_state),
            "player_1_token_4_value" => intval($this->player_1_token_4_value),
            
            "player_2_id" => $this->player_2_id,
            "player_2_name" => $this->player_2_name,
            "player_2_token_1_state" => intval($this->player_2_token_1_state),
            "player_2_token_1_value" => intval($this->player_2_token_1_value),
            "player_2_token_2_state" => intval($this->player_2_token_2_state),
            "player_2_token_2_value" => intval($this->player_2_token_2_value),
            "player_2_token_3_state" => intval($this->player_2_token_3_state),
            "player_2_token_3_value" => intval($this->player_2_token_3_value),
            "player_2_token_4_state" => intval($this->player_2_token_4_state),
            "player_2_token_4_value" => intval($this->player_2_token_4_value),
            
            "player_3_id" => $this->player_3_id,
            "player_3_name" => $this->player_3_name,
            "player_3_token_1_state" => intval($this->player_3_token_1_state),
            "player_3_token_1_value" => intval($this->player_3_token_1_value),
            "player_3_token_2_state" => intval($this->player_3_token_2_state),
            "player_3_token_2_value" => intval($this->player_3_token_2_value),
            "player_3_token_3_state" => intval($this->player_3_token_3_state),
            "player_3_token_3_value" => intval($this->player_3_token_3_value),
            "player_3_token_4_state" => intval($this->player_3_token_4_state),
            "player_3_token_4_value" => intval($this->player_3_token_4_value),
            
            "player_4_id" => $this->player_4_id,
            "player_4_name" => $this->player_4_name,
            "player_4_token_1_state" => intval($this->player_4_token_1_state),
            "player_4_token_1_value" => intval($this->player_4_token_1_value),
            "player_4_token_2_state" => intval($this->player_4_token_2_state),
            "player_4_token_2_value" => intval($this->player_4_token_2_value),
            "player_4_token_3_state" => intval($this->player_4_token_3_state),
            "player_4_token_3_value" => intval($this->player_4_token_3_value),
            "player_4_token_4_state" => intval($this->player_4_token_4_state),
            "player_4_token_4_value" => intval($this->player_4_token_4_value),
            
            "host_attempt" => $this->host_attempt,
            "is_player_1_left" => boolval($this->is_player_1_left),
            "is_player_2_left" => boolval($this->is_player_2_left),
            "is_player_3_left" => boolval($this->is_player_3_left),
            "is_player_4_left" => boolval($this->is_player_4_left),
            
            "game_state" => $this->game_state,
            "winner_1" => $this->winner_1,
            "winner_2" => $this->winner_2,
            "winner_3" => $this->winner_3,
            "winner_4" => $this->winner_4,
            
            "player_1_classic_game_end" => $this->player_1_classic_game_end,
            "player_2_classic_game_end" => $this->player_2_classic_game_end,
            "player_3_classic_game_end" => $this->player_3_classic_game_end,
            "player_4_classic_game_end" => $this->player_4_classic_game_end
        );
        
        return json_encode($data);
    }
}