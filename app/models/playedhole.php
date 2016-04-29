<?php

  class PlayedHole extends BaseModel {
  	
  	public $id, $playedcourse_id, $golfer_id, $result, $holenumber;

    public function __construct($attributes){
      parent::__construct($attributes);
      $this->validators = array('validatePlayedHoles');
    }

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO PlayedHole (playedcourse_id, golfer_id, result, holenumber) VALUES (:playedcourse_id, :golfer_id, :result, :holenumber) RETURNING id');
      $query->execute(array('playedcourse_id' => $this->playedcourse_id, 'golfer_id' => $this->golfer_id, 'result' => $this->result, 'holenumber' => $this->holenumber));
      $row = $query->fetch();
      $this->id = $row['id'];
    }


  }