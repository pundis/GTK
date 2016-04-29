  <?php

  class PlayedCourseController extends BaseController {

    public static function create() {
      self::check_logged_in();
      $courses = Course::all();

      View::make('playedcourse/new.html', array('courses' => $courses));
    }

    public static function index() {
      self::check_logged_in();

      View::make('playedcourse/index.html');
    }

    public static function create2() {
      self::check_logged_in();

      $params = $_POST;
      $course_id = $params['course_id'];
      $holes = Hole::findByCourseId($course_id);
      $course = Course::find($course_id);

      View::make('playedcourse/new2.html', array('holes' => $holes, 'course' => $course));
    }

    public static function store() {

      if (sizeof($_POST) == 19) {
        $tresult = ($_POST['1'] + $_POST['2'] + $_POST['3'] + $_POST['4'] + $_POST['5'] + $_POST['6'] + 
                  $_POST['7'] + $_POST['8'] + $_POST['9'] + $_POST['10'] + $_POST['11'] + $_POST['12'] + $_POST['13'] + $_POST['14'] + $_POST['15'] + $_POST['16'] + $_POST['17'] + $_POST['18']);
      } elseif (sizeof($_POST) == 10) {
      $tresult = ($_POST['1'] + $_POST['2'] + $_POST['3'] + $_POST['4'] + $_POST['5'] + $_POST['6'] + 
                  $_POST['7'] + $_POST['8'] + $_POST['9']);
      }
      $user = self::get_user_logged_in();
      $attr = array('golfer_id' => $user->id, 'course_id' => $_POST['course_id'], 'result' => $tresult);

      $pcourse = new PlayedCourse($attr);
      // tarvittavat validaatiot ovat tapahtuneet näkymissä
      $pcourse->save();

      for ($i=1; $i < sizeof($_POST) ; $i++) { 
        $attr = array('playedcourse_id' => $pcourse->id, 'golfer_id' => $user->id, 'result' => $_POST[$i], 'holenumber' => $i);
        $phole = new PlayedHole($attr);
        //näkymä validoinut tarvittavat
        $phole->save();
      }

      Redirect::to('/playedcourses', array('message' => 'Pelatut kentät ja reiät on lisätty tietokantaan!'));
    }

  }