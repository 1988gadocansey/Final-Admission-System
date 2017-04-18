<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessagesModel;
use App\Models;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SystemController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }
      public function getEntryName() {
         
         
         $applicant = \DB::table('tpoly_applicants')
                ->where('APPLICATION_NUMBER', @\Auth::user()->FORM_NO)->first();
         return $applicant->ENTRY_QUALIFICATION;
       
         
    }
    public function age($birthdate, $pattern = 'eu') {
        $patterns = array(
            'eu' => 'd/m/Y',
            'mysql' => 'Y-m-d',
            'us' => 'm/d/Y',
            'gh' => 'd-m-Y',
        );

        $now = new \DateTime();
        $in = \DateTime::createFromFormat($patterns[$pattern], $birthdate);
        $interval = $now->diff($in);
        return $interval->y;
    }

    public function getReligion() {
        $religion = \DB::table('tbl_religion')
                ->lists('religion', 'religion');
        return $religion;
    }

    public function getCountry() {
        $country = \DB::table('tbl_country')
                ->lists('Name', 'Name');
        return $country;
    }

    public function getHalls() {
        $hall = \DB::table('tpoly_hall')
                ->lists('HALL_NAME', 'HALL_NAME');
        return $hall;
    }

    public function getRegions() {
        $region = \DB::table('tbl_regions')
                ->lists('Name', 'Name');
        return $region;
    }

    public function getExamList() {


        $type = Models\ExamTypeModel::
                lists('EXAM_TYPE', 'EXAM_TYPE');
        return $type;
    }

    public function getSubjectList() {


        $subject = Models\SubjectModel::
                lists('NAME', 'ID');
        return $subject;
    }

    public function getGradeSystemIDList() {


        $grade = Models\GradeSystemModel::where("value","!=","")->orderBy("grade")->lists('grade', 'grade');
              
        return $grade;
    }

    public function getGradeS() {


        $grade = \DB::table('tpoly_grade_system')
                ->lists('type', 'type');
        return $grade;
    }

    public function getWaecList() {


        $school = \DB::table('tpoly_faculty')
                ->lists('FACULTY', 'FACCODE');
        return $school;
    }

    public function getGradeValue($grade) {

        $value = Models\GradeSystemModel::where("grade", $grade)->get();

        return @$value[0]->value;
    }
    public function getSubjectType($subject) {

        $value = Models\SubjectModel::where("ID", $subject)->get();

        return @$value[0]->TYPE;
    }
    public function programmeSearchByCode() {

        $program = \DB::table('tpoly_programme')->get();

        foreach ($program as $p => $value) {
            $programs[] = $value->PROGRAMMECODE;
        }
        return $programs;
    }

    public function getProgramName($code) {

        $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE', $code)->get();

        return @$programme[0]->PROGRAMME;
    }
    public function getProgramDuration($code) {

        $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE', $code)->get();

        return @$programme[0]->DURATION;
    }

    // this is purposely for select box 
    public function getProgramList() {
        $formType = @\Auth::user()->FORM_TYPE;
        if ($formType == "HND" || $formType=="MATURE") {
            $program = \DB::table('tpoly_programme')->where("TYPE",   "HND")->where("RUNNING","1")->orderby("PROGRAMME")
                    ->lists('PROGRAMME', 'PROGRAMMECODE');
            return $program;
        }
        elseif($formType == "DIPLOMA"){
             $program = \DB::table('tpoly_programme')->where("TYPE", "LIKE", "DIPLOMA%")->where("RUNNING","1")->orderby("PROGRAMME")
                    ->lists('PROGRAMME', 'PROGRAMMECODE');
            return $program;
        }
        
       elseif($formType == "BTECH"){
            $program = \DB::table('tpoly_programme')->where("TYPE",   "BTECH")->where("RUNNING","1")->orderby("PROGRAMME")
                    ->lists('PROGRAMME', 'PROGRAMMECODE');
            return $program;
        }
         elseif($formType == "CERTIFICATES"){
            $program = \DB::table('tpoly_programme')->where("TYPE",    "CERTIFICATE")->where("RUNNING","1")->orderby("PROGRAMME")
                    ->lists('PROGRAMME', 'PROGRAMMECODE');
            return $program;

        }
        elseif($formType == "ACCESS COURSE"){
            $program = \DB::table('tpoly_programme')->where("TYPE", "LIKE",  "%ACCESS%")->where("RUNNING","1")->orderby("PROGRAMME")
                    ->lists('PROGRAMME', 'PROGRAMMECODE');
            return $program;
        }
        else{
            $program = \DB::table('tpoly_programme')->where("RUNNING","1")->orderby("PROGRAMME")
                    ->lists('PROGRAMME', 'PROGRAMMECODE');
            return $program;
        }
    }

    public function years() {

        for ($i = 2008; $i <= 2030; $i++) {
            $year = $i - 1 . "/" . $i;
            $years[$year] = $year;
        }
        return $years;
    }

    public function WASSCE_Grades() {
        $grade = \DB::table('tbl_waec_grades_system')
                ->lists('grade', 'grade');
        return $grade;
    }

    /**
     * Get current sem and year
     *
     * @param  Request  $request
     * @return Response
     */
    public function getSemYear() {
        $sql = \DB::table('tpoly_academic_settings')->where('ID', \DB::raw("(select max(`ID`) from tpoly_academic_settings)"))->get();
        return $sql;
    }

    public function getProgram($code) {

        $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE', $code)->get();

        return @$programme[0]->PROGRAMME;
    }

    public function getProgramArray($code) {

        $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE', $code)->get();

        return @$programme;
    }

    public function picture($path, $target) {
        if (file_exists($path)) {
            $mypic = getimagesize($path);

            $width = $mypic[0];
            $height = $mypic[1];

            if ($width > $height) {
                $percentage = ($target / $width);
            } else {
                $percentage = ($target / $height);
            }

            //gets the new value and applies the percentage, then rounds the value
            $width = round($width * $percentage);
            $height = round($height * $percentage);

            return "width=\"$width\" height=\"$height\"";
        } else {
            
        }
    }

    public function pictureid($stuid) {

        return str_replace('/', '', $stuid);
    }
 public function firesms($message,$phone,$receipient){
          
         
           if (!empty($phone)&& !empty($message)&& !empty($receipient)) {
             \DB::beginTransaction();
            try {

                 
                $phone="+233".\substr($phone,1,9);
            $phone = str_replace(' ', '', $phone);
                 $phone = str_replace('-', '', $phone);
                 if (!empty($message) && !empty($phone)) {
           $key = "bcb86ecbc1a058663a07"; //your unique API key;
          $message=urlencode($message); //encode url;
        $sender_id="TTU";

        $url = "http://sms.gadeksystems.com/smsapi?key=$key&to=$phone&msg=$message&sender_id=$sender_id";
        //print_r($url);
        $result = file_get_contents($url); //call url and store result;

                   if ($result = 1000) {

                   $result="Message was successfully sent"; 
                   
                    }else{ 
                    $result="Message failed to send. Error: " .  $result; 
                     
                    } 
                    $array=  $this->getSemYear();
        $sem=$array[0]->SEMESTER;
               $year=$array[0]->YEAR;
                  $user = \Auth::user()->serial; 
                
                 
                  $user = \Auth::user()->fund;
                  $sms=new MessagesModel();
                    $sms->dates=\DB::raw("NOW()");
                    $sms->message=$message;
                    $sms->phone=$phone;
                    $sms->status=$result;
                    $sms->type="Admission Notifications";
                    
                    $sms->sender=$user;
              $sms->term=$sem;
                   $sms->year=$year;
                    $sms->receipient=$receipient;
                     
                   $sms->save();
                   \DB::commit();
            }
            
                    }
            catch (\Exception $e) {
                \DB::rollback();
            }
        }
     
       
        
    }
}
