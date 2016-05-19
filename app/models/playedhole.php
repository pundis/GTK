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

    public function destroy() {
      $query = DB::connection()->prepare('DELETE From PlayedHole Where id = :id');
      $query->execute(array('id' => $this->id));
      $row = $query->fetch();
    }

    public function findByPlayedCourseId($id) {
      $query = DB::connection()->prepare('SELECT * FROM PlayedHole WHERE playedcourse_id = :id ORDER BY holenumber');
      $query->execute(array('id' => $id));
      $rows = $query->fetchAll();

      $holes = array();

      foreach($rows as $row){
          $holes[] = new PlayedHole(array(
          'id' => $row['id'],
          'playedcourse_id' => $row['playedcourse_id'],
          'golfer_id' => $row['golfer_id'],
          'result' => $row['result'],
          'holenumber' => $row['holenumber']
          ));
      }

      return $holes;
    }


  }