<?php
class TournnamentHostClientDataModel
{
    private $_db            = null;    
    private $tableName      = "tournament_host_client";
    
    public  $id             = null;
    public  $user_id        = null;
    public  $tournament_id  = null;
    public  $game_id        = null;
    public  $round_id       = null;
    public  $board_id       = null;
    public  $game_type      = null;
    public  $room_code      = null;
    public  $created_at     = null;
    public  $updated_at     = null;
    
    public function __construct($db)
    {
        $this->_db = $db;
    }
    
    public function Select()
    {
        $sql = "SELECT * FROM $this->tableName WHERE tournament_id=$this->tournament_id AND game_id=$this->game_id AND round_id=$this->round_id AND board_id=$this->board_id AND user_id=$this->user_id;";
        $row = $this->_db->GetQueryResult($sql);
        
        if ($row != null)
        {
            $this->id               = intval($row["id"]);
            $this->user_id          = intval($row["user_id"]);
            $this->tournament_id    = intval($row["tournament_id"]);
            $this->game_id          = intval($row["game_id"]);
            $this->round_id         = intval($row["round_id"]);
            $this->board_id         = intval($row["board_id"]);
            $this->game_type        = $row["game_type"];
            $this->room_code        = $row["room_code"];
            $this->created_at       = $row["created_at"];
            $this->updated_at       = $row["updated_at"];
            
            return true;
        }
        else
        {
            $this->_clear();
            
            return false;
        }
    }
    
    public function Update()
    {
        $sql = "UPDATE $this->tableName SET user_id=$this->user_id, tournament_id=$this->tournament_id, game_id=$this->game_id, round_id=$this->round_id, board_id=$this->board_id, game_type='$this->game_type', room_code='$this->room_code', updated_at=CURRENT_TIMESTAMP WHERE id=$this->id;";
        $this->_db->Update($sql);
        
        $this->Select();
    }
    
    public function Insert()
    {
        $sql = "INSERT INTO $this->tableName(user_id, tournament_id, game_id, round_id, board_id, game_type, room_code) VALUES($this->user_id, $this->tournament_id, $this->game_id, $this->round_id, $this->board_id, '$this->game_type', '$this->room_code');";
        $this->_db->Insert($sql);
        
        $this->Select();
    }
    
    public function Delete()
    {
        $sql = "DELETE FROM $this->tableName WHERE id=$this->id;";
        
        $this->_db->Delete($sql);
        
        $this->_clear();
    }
    
    private function _clear()
    {
        $this->id               = null;
        $this->user_id          = null;
        $this->tournament_id    = null;
        $this->game_id          = null;
        $this->round_id         = null;
        $this->board_id         = null;
        $this->game_type        = null;
        $this->room_code        = null;
        $this->created_at       = null;
        $this->updated_at       = null;
    }
    
    public function ToJson()
    {
        $data = array(
            "id"                => $this->id,
            "user_id"           => $this->user_id,
            "tournament_id"     => $this->tournament_id,
            "game_id"           => $this->game_id,
            "round_id"          => $this->round_id,
            "board_id"          => $this->board_id,
            "game_type"         => $this->game_type,
            "room_code"         => $this->room_code,
            "created_at"        => $this->created_at,
            "updated_at"        => $this->updated_at
        );
        
        return json_encode($data);
    }
    
    public function GetAll($tournament_id, $game_id, $round_id, $board_id)
    {
        $sql    = "SELECT * FROM $this->tableName WHERE tournament_id=$tournament_id AND game_id=$game_id AND round_id=$round_id AND board_id=$board_id ORDER BY created_at ASC;";
        $rows   = $this->_db->GetQueryResults($sql);
        
        if (($rows != null) && (count($rows) > 0))
        {
            $data = array();

            foreach ($rows as $row)
            {
                $item                   = new TournnamentHostClientDataModel($this->_db);
                $item->id               = intval($row["id"]);
                $item->user_id          = intval($row["user_id"]);
                $item->tournament_id    = intval($row["tournament_id"]);
                $item->game_id          = intval($row["game_id"]);
                $item->round_id         = intval($row["round_id"]);
                $item->board_id         = intval($row["board_id"]);
                $item->game_type        = $row["game_type"];
                $item->room_code        = $row["room_code"];
                $item->created_at       = $row["created_at"];
                $item->updated_at       = $row["updated_at"];

                array_push($data, $item);
            }

            return $data;
        }
        else
        {
            return array();
        }
    }
}
