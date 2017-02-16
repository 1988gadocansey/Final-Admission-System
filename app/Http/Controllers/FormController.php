<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\StudentModel;
use App\Models\ProgrammeModel;
use App\Models;
use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Excel;

class FormController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        // $this->getSerialPin();
        if (@\Auth::user()->FINALIZED == 1) {
            return redirect("form/preview");
        }
    }

    public function letter(Request $request, SystemController $sys) {
        $array = $sys->getSemYear();
        $sem = $array[0]->SEMESTER;
        $year = $array[0]->YEAR;
        $applicant = @\Auth::user()->FORM_NO;

        $query = @Models\ApplicantModel::where("APPLICATION_NUMBER", $applicant)->where("ADMITTED", "1")->first();

        return view("applicants.letter")->with("data", $query)->with('year', $year);
    }

    public function index() {

        return view("dashboard");
    }

    public function sms() {
        $sys = new SystemController();
        ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
        $applicant = @\Auth::user()->FORM_NO;
        $query = @Models\ApplicantModel::where("APPLICATION_NUMBER", $applicant)->first();
        $phone = $query->PHONE;
        $firstChoice = $sys->getProgramName($query->FIRST_CHOICE);
        $secondChoice = $sys->getProgramName($query->SECOND_CHOICE);
        $name = $query->FIRSTNAME;
        $message = "Hi $name your application with first choice $firstChoice and second choice $secondChoice has been received by our school. Your Application number is $applicant. Write it on the envelope with the printout and forward it to our university. Congrats";
        if ($sys->firesms($message, $phone, $applicant)) {

            //return redirect('form/preview')->with('success1','Form sent to school successfully');
            //return redirect("/logout");,
            echo "<html><body><a class='uk-text-bold uk-text-large'color='red' href='../logout'>Form submitted successfully click   to logout</a></body></html>";
        } else {
            return redirect('form/preview')->with('error1', 'Form could not be submitted try sgain pls');
        }
    }

    public function createGrades(SystemController $sys) {
        if (@\Auth::user()->FINALIZED == 1) {
            return redirect("form/preview");
        } else {
            if (@\Auth::user()->FORM_TYPE != "BTECH") {
                if (@\Auth::user()->BIODATA_DONE == 1) {
                    $applicant = @\Auth::user()->FORM_NO;
                    $query = @Models\ExamResultsModel::where("APPLICATION_NUMBER", $applicant)->paginate(100);
                    $total = count($query);
                    $subject = $sys->getSubjectList();
                    $grades = $sys->getGradeSystemIDList();
                    $examType = $sys->getExamList();


                    return view('applicants.step4')
                                    ->with('subject', $subject)
                                    ->with('examType', $examType)
                                    ->with('grades', $grades)
                                    ->with('total', $total)
                                    ->with('data', $query);
                } else {
                    return redirect('/form/step2')->with('error1', 'Fill this portion of the form');
                }
            } else {
                return redirect('/form/preview');
            }
        }
    }
    /*
     * @param array of grades
     * count the number of failed subjects
     */
     public function CountFails($array){
        $fail=0;
       
        foreach($array AS $value){
            // echo "value:$value</br>";
            if($value>7){

                 $fail++;
            }


        }
                   return $fail;

    }
    // list the total failed and passed subjects
    public function CheckFails($applicant){
            $subject_array_core=array();
            $subject_array_core_alt=array();
            $subject_array_elect=array();
            $form= $applicant;
            $qualification=array("WASSSCE","SSSCE","NAPTEX","TEU");
       // $query=  mysql_query("SELECT APP_FORM,ENTRY_TYPE,FIRST_CHOICE FROM tbl_applicants WHERE   APP_FORM='$form' ");
      $query=@Models\ApplicantModel::where("APPLICATION_NUMBER", $form)->get();
 
      
        foreach($query as $row){
            if(in_array($row->ENTRY_QUALIFICATION, $qualification)){
                $resultQuery=@Models\ExamResultsModel::where("APPLICATION_NUMBER", $form)->orderBy("GRADE_VALUE","DESC")->get();
            
                foreach($resultQuery as $value){
                     if($value->TYPE=='core'){
                            @$subject_array_core[@$value->subject->NAME]=@$value->GRADE_VALUE;
                        }
                        elseif($value->TYPE=='core_alt'){
                            $subject_array_core_alt[@$value->subject->NAME]=@$value->GRADE_VALUE;
                        }
                        else{
                            $subject_array_elect[@$value->subject->NAME]=@$value->GRADE_VALUE;
                        }
                }
                
               if(count($subject_array_core)<2){$error="Core Subjects not met. minimum pass of two compulsory cores i.e Core Maths and English<br/>"; $qualify="No"; }
		
               if(count($subject_array_core_alt)==0){$error.="Core  Alternative Subject not met. Either pass in Social studies or Integrated Science <br/>"; $qualify="No"; }
		
               if(count($subject_array_core)+count($subject_array_core_alt)+count($subject_array_elect)!=6){$error.="Passes in at least 6 subjects required <br/>"; $qualify="No";}
                
                @sort($subject_array_core_alt);  @sort($subject_array_core);   @sort($subject_array_elect);
        
              $elective_slice=  @array_slice($subject_array_elect, 0,3);
              $core_alt_slice=  @array_slice($subject_array_core_alt, 0,1);

            $grade=  (  array_sum($subject_array_core) +  array_sum($elective_slice)+ array_sum($core_alt_slice));
           
            $total=  $this->CountFails($subject_array_core)+ $this->CountFails($elective_slice) + $this->CountFails($core_alt_slice);   
               
            if ($qualify == "Yes") {
                    $status = "Qualify?" . $qualify . " - " . " Total Failed: " . $total;
                } else {
                    $status = "Qualify?" . $qualify . " - " . $error . " - " . " Total Failed: " . $total;
                }
                
             return    mysql_query("UPDATE tbl_applicants SET STATUS='$status' , GRADE='$grade' WHERE APP_FORM='$form'");
            
             @Models\ApplicantModel::where("APPLICATION_NUMBER", $form)->update(array("ELIGIBILTY"=>$status,"QUALIFY"=>$qualify,"GRADE"=>$grade));   
                
            } else{
                $qualify="Yes";
            }
        }
   
    }

    public function step4(Request $request, SystemController $sys) {
        if (@\Auth::user()->STARTED == 1 && @\Auth::user()->PHOTO_UPLOAD == "YES") {

            

//            $this->validate($request, [
//                'grade' => 'required',
//                'subject' => 'required',
//                'type' => 'required',
//                'center' => 'required',
//                'indexno' => 'required',
//                'month' => 'required',
//                'sitting' => 'required',
//            ]);



                $applicantForm = @\Auth::user()->FORM_NO;
                $total = count($request->input('grade'));
                $grade = $request->input('grade');
                $subject = $request->input('subject');
                $center = $request->input('center');
                $type = $request->input('type');
                $indexno = $request->input('indexno');
                $month = $request->input('month');
                $sitting = $request->input('sitting');

              if(@\Auth::user()->COUNTRY=="GHANAIAN"){
                if($sys->getEntryName()=="WASSSCE" || @$sys->getEntryName()=="SSSCE"){
                for ($i = 0; $i < $total; $i++) {
                    $result = new Models\ExamResultsModel();
                    $result->APPLICATION_NUMBER = $applicantForm;
                    $result->SUBJECT = $subject[$i];
                    $result->SITTING = $sitting[$i];
                    $result->EXAM_TYPE = $type[$i];
                    $result->INDEX_NO = $indexno[$i];
                    $result->CENTER = $center[$i];
                 
                    $result->TYPE =@$sys->getSubjectType($subject[$i]);
                    $result->GRADE_VALUE =@$sys->getGradeValue($grade[$i]);
                    
                    $result->MONTH = $month[$i];
                    $result->GRADE = $grade[$i];
                    $result->save();
                    \DB::commit();
                }
                    }
                    else{
                              for ($i = 0; $i < $total; $i++) {
                    $result = new Models\ExamResultsModel();
                    $result->APPLICATION_NUMBER = $applicantForm;
                    $result->SUBJECT = $subject[$i];
                    $result->SITTING = $sitting[$i];
                    $result->EXAM_TYPE = $type[$i];
                    $result->INDEX_NO = $indexno[$i];
                    $result->CENTER = $center[$i];
                 
                    $result->TYPE =@$subject[$i];
                    $result->GRADE_VALUE =@$grade[$i];
                    
                    $result->MONTH = $month[$i];
                    $result->GRADE = $grade[$i];
                    $result->save();
                    \DB::commit();
                
                }
                   }
               }
                else{
                            for ($i = 0; $i < $total; $i++) {
                    $result = new Models\ExamResultsModel();
                    $result->APPLICATION_NUMBER = $applicantForm;
                    $result->SUBJECT = $subject[$i];
                    $result->SITTING = $sitting[$i];
                    $result->EXAM_TYPE = $type[$i];
                    $result->INDEX_NO = $indexno[$i];
                    $result->CENTER = $center[$i];
                 
                    $result->TYPE =@$subject[$i];
                    $result->GRADE_VALUE =@$grade[$i];
                    
                    $result->MONTH = $month[$i];
                    $result->GRADE = $grade[$i];
                    $result->save();
                    \DB::commit();
                
                }
                   }
                return redirect("/form/academic/grades")->with("success1", " <span style='font-weight:bold;font-size:13px;'> Ayekoo  grades successfully Recieved!!. </span> ");
             
        } else {
            return redirect("/form/step3")->with("error1", " <span style='font-weight:bold;font-size:13px;'>Whoops  fill this portion of the form</span> ");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function step2(SystemController $sys) {
        if (@\Auth::user()->FINALIZED == 1) {
            return redirect("form/preview");
        } else {
            if (@\Auth::user()->PHOTO_UPLOAD == "YES") {

                $applicant = @\Auth::user()->FORM_NO;

                $query = @Models\ApplicantModel::where("APPLICATION_NUMBER", $applicant)->first();
                $region = $sys->getRegions();
                $programme = $sys->getProgramList();

                $hall = $sys->getHalls();
                $religion = $sys->getReligion();
                return view('applicants.step2')
                                ->with('programme', $programme)
                                ->with('country', $sys->getCountry())
                                ->with('region', $region)
                                ->with('hall', $hall)
                                ->with('religion', $religion)
                                ->with("data", $query);
            } else {
                return redirect("upload/photo")->with("error", " <span style='font-weight:bold;font-size:13px;'>Whoops  upload your photo</span> ");
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SystemController $sys) {


        /* transaction is used here so that any errror rolls
         *  back the whole process and prevents any inserts or updates
         */
        \DB::beginTransaction();
        try {



            $this->validate($request, [
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required',
                'gender' => 'required',
                'qualification' => 'required',
                'gname' => 'required',
                'gphone' => 'required',
                'dob' => 'required|date_format:"d/m/Y"',
                'gphone' => 'required',
                'address' => 'required',
                'email' => 'required|email',
                'hometown' => 'required',
                'gender' => 'required'
            ]);

            $applicantForm = @\Auth::user()->FORM_NO;

//            $firstChoice = strtoupper($request->input('firstChoice'));
//            $secondChoice = strtoupper($request->input('secondChoice'));
//            $thirdChoice = strtoupper($request->input('thirdChoice'));
            $gender =  $request->input('gender') ;

            $hall = $request->input('hall');
            $dob = strtoupper($request->input('dob'));
            $gname = strtoupper($request->input('gname'));
            $gphone = strtoupper($request->input('gphone'));
            $goccupation = strtoupper($request->input('goccupation'));
            $gaddress = strtoupper($request->input('gaddress'));
            $email = strtoupper($request->input('email'));
            $phone = strtoupper($request->input('phone'));
            $marital_status =  $request->input('marital_status') ;
            $region =  $request->input('region') ;
            if (@\Auth::user()->COUNTRY == "GHANAIAN") {
                $country = "Ghana";
            } else {
                $country =  $request->input('nationality');
            }
            $religion =  $request->input('religion') ;
            $residentAddress = strtoupper($request->input('contact'));
            $address = strtoupper($request->input('address'));
            $hometown = strtoupper($request->input('hometown'));
            $grelationship = strtoupper($request->input('grelationship'));

            $disability = strtoupper($request->input('disability'));
            $disability_question =  $request->input('disable') ;
            $title = strtoupper($request->input('title'));

            $qualification = strtoupper($request->input('qualification'));
             $qualification2 = strtoupper($request->input('qualification2'));
            $age = @$sys->age($dob, "eu");
            $bond = strtoupper($request->input('bond'));
            // $class =strtoupper( $request->input('class'));
            $fname = strtoupper($request->input('fname'));
            $lname = strtoupper($request->input('lname'));
            $finance = strtoupper($request->input('finance'));
            $othername = strtoupper($request->input('oname'));

            $name = $lname . ' ' . $othername . ' ' . $fname;
            $test = Models\ApplicantModel::where("APPLICATION_NUMBER", $applicantForm)->get()->toArray();
            if (empty($test)) {
                $query = new Models\ApplicantModel();
                $query->APPLICATION_NUMBER = $applicantForm;
                $query->NAME = $name;
                $query->RELATIONSHIP_TO_APPLICANT = $grelationship;
                $query->FIRSTNAME = $fname;
                $query->SURNAME = $lname;
                $query->OTHERNAME = $othername;
                $query->TITLE = $title;
                $query->GENDER = $gender;
                $query->DOB = $dob;
                $query->NAME = $name;
                $query->AGE = $age;
                $query->SOURCE_OF_FINANCE = $finance;
                $query->MARITAL_STATUS = $marital_status;

                $query->ADDRESS = $address;
                $query->RESIDENTIAL_ADDRESS = $residentAddress;
                $query->EMAIL = $email;
                 $query->PREFERED_HALL = $hall;
                $query->PHONE = $phone;
                $query->NATIONALITY = $country;
                $query->REGION = $region;
                $query->RELIGION = $religion;
                $query->HOMETOWN = $hometown;
                $query->GURDIAN_NAME = $gname;
                $query->GURDIAN_ADDRESS = $gaddress;
                $query->GURDIAN_PHONE = $gphone;
                $query->GURDIAN_OCCUPATION = $goccupation;
                $query->PHYSICALLY_DISABLED = $disability_question;
                $query->DISABLED = $disability;
                $query->ENTRY_QAULIFICATION2 = $qualification2;
                $query->STATUS = "APPLICANT";

                $query->YEAR_ADMISION = date("Y") . "/" . (date("Y") + 1);

                $query->BOND = $bond;

                $query->FORM_TYPE = @\Auth::user()->FORM_TYPE;

                $query->ENTRY_QUALIFICATION = $qualification;


                if ($query->save()) {
                    Models\FormModel::where("FORM_NO", $applicantForm)->update(array("STARTED" => "1"));
                    \DB::commit();

                    return redirect("/form/step3")->with("success1", " <span style='font-weight:bold;font-size:13px;'> Ayekoo $name form successfully saved!!</span> ");
                } else {

                    return redirect("/form/step2")->with("error1", "<span style='font-weight:bold;font-size:13px;'> $name form could not be save try again </span>");
                }
            } else {
                $query = Models\ApplicantModel::where("APPLICATION_NUMBER", $applicantForm)
                        ->update(array(
                    "NAME" => $name,
                    "RELATIONSHIP_TO_APPLICANT" => $grelationship,
                    "FIRSTNAME" => $fname,
                    "SURNAME" => $lname,
                    "OTHERNAME" => $othername,
                    "TITLE" => $title,
                    "GENDER" => $gender,
                    "DOB" => $dob,
                    "NAME" => $name,
                    "AGE" => $age,
                    "SOURCE_OF_FINANCE" => $finance,
                    "MARITAL_STATUS" => $marital_status,
                    "ADDRESS" => $address,
                    "RESIDENTIAL_ADDRESS" => $residentAddress,
                    "EMAIL" => $email,
                    "PHONE" => $phone,
                    "PREFERED_HALL" => $hall,
                    "NATIONALITY" => $country,
                    "REGION" => $region,
                    "RELIGION" => $religion,
                    "HOMETOWN" => $hometown,
                    "GURDIAN_NAME" => $gname,
                    "GURDIAN_ADDRESS" => $gaddress,
                    "GURDIAN_PHONE" => $gphone,
                    "GURDIAN_OCCUPATION" => $goccupation,
                    "PHYSICALLY_DISABLED" => $disability_question,
                    "DISABLED" => $disability,
                    "STATUS" => "APPLICANT",
                    "DISABLED" => $disability,
                    "BOND" => $bond,
                    "FORM_TYPE" => @\Auth::user()->FORM_TYPE,
                    "ENTRY_QUALIFICATION" => $qualification,
                    "ENTRY_QAULIFICATION2" => $qualification2,
                    "UPDATED" => "1"
                ));
                Models\FormModel::where("FORM_NO", $applicantForm)
                            ->update(array("BIODATA_DONE" => "1"));
                    \DB::commit();
                if ($query) {
                   
                    return redirect("/form/step3")->with("success1", " <span style='font-weight:bold;font-size:13px;'> Ayekoo $name Form A successfully saved! ");
                } else {

                    return redirect("/form/step2")->with("error1", "<span style='font-weight:bold;font-size:13px;'> $name form could not be save try again </span>");
                }
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    // academic section of page
    public function step3(SystemController $sys, Request $request) {
        if(@\Auth::user()->FINALIZED==1)
        {
               return redirect("form/preview");
        }
        else{
        if ($request->isMethod("get")) {
            $programme = $sys->getProgramList();
            $hall = $sys->getHalls();
            $query = Models\ApplicantModel::where("APPLICATION_NUMBER", @\Auth::user()->FORM_NO)->first();
            return view('applicants.step3')->with("data", $query)->with('programme', $programme)
                            ->with('hall', $hall);
        } else {
//         \DB::beginTransaction();
//        try {



            $this->validate($request, [
                'thirdChoice' => 'required',
                'firstChoice' => 'required',
                'secondChoice' => 'required',
                'hall' => 'required',
                
                'school' => 'required',
                'entry' => 'required',
                 
            ]);
            $applicantForm = @\Auth::user()->FORM_NO;

            $firstChoice = strtoupper($request->input('firstChoice'));
            $secondChoice = strtoupper($request->input('secondChoice'));
            $thirdChoice = strtoupper($request->input('thirdChoice'));
            $hall =  $request->input('hall') ;
            $programStudy = strtoupper($request->input('study_program'));
            $entry = strtoupper($request->input('entry'));
             \Session::put('entry', $entry);
            $class = strtoupper($request->input('class'));
            $school = strtoupper($request->input('school'));
           
                 if(@\Auth::user()->FORM_TYPE=="BTECH"){
                     $query = Models\ApplicantModel::where("APPLICATION_NUMBER", $applicantForm)
                    ->update(array(
                 
                "FIRST_CHOICE" => $firstChoice,
                "SECOND_CHOICE" => $secondChoice,
                "THIRD_CHOICE" => $thirdChoice,
                "CLASS" => $class,
                       
                "PROGRAMME_STUDY" => $programStudy,
                "PREFERED_HALL" =>$hall,
                "SCHOOL" => $school,
                "ENTRY_TYPE" => $entry,
                "UPDATED" => "1"
            ));
                 }
                 else{
                      $query = Models\ApplicantModel::where("APPLICATION_NUMBER", $applicantForm)
                    ->update(array(
                 
                "FIRST_CHOICE" => $firstChoice,
                "SECOND_CHOICE" => $secondChoice,
                "THIRD_CHOICE" => $thirdChoice,
                      "PREFERED_HALL" =>$hall,
                "SCHOOL" => $school,
                "ENTRY_TYPE" => $entry,
                "UPDATED" => "1"
            ));
                 }
            \DB::commit();
            if ($query) {

                if (@\Auth::user()->FORM_TYPE == "BTECH") {
                    return redirect("/form/academic/grades")->with("success1", " <span style='font-weight:bold;font-size:13px;'>  Form successfully Recieved!!</span> ");
                } else {
                    return redirect("/form/academic/grades")->with("success1", " <span style='font-weight:bold;font-size:13px;'>  Form   successfully Recieved!!. </span> ")
                     ;
                }
            } else {

                return redirect("/form/step3")->with("error1", "<span style='font-weight:bold;font-size:13px;'> Form could not be save try again </span>");
            }


//       } catch (\Exception $e) {
//          \DB::rollback();
//        }
        }
    }}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, SystemController $sys, Request $request) {

        $region = $sys->getRegions();


        // make sure only students who are currently in school can update their data
        $query = StudentModel::where('ID', $id)->first();
        $programme = $sys->getProgramList();
        $hall = $sys->getHalls();
        $religion = $sys->getReligion();
        return view('students.show')->with('student', $query)
                        ->with('programme', $programme)
                        ->with('country', $sys->getCountry())
                        ->with('region', $region)
                        ->with('hall', $hall)
                        ->with('religion', $religion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPictureUpload() {
        if (@\Auth::user()->FINALIZED == 1) {
            return redirect("form/preview");
        } else {
            return view("applicants.upload");
        }
    }

    public function uploadPicture(Request $request, SystemController $sys) {
         $this->validate($request, [
               //'picture' => 'required|image|image_size:240,180|image_aspect:1',
               //'picture' => 'required|image|image_size:240,180',
               
            ]);
        $valid_exts = array('jpeg', 'jpg'); // valid extensions
        $max_size = 400000; // max file size
        $file = $request->file('picture');
        $ext = strtolower($request->file('picture')->getClientOriginalExtension());
        $applicantID = @\Auth::user()->ID;
        $applicantNO = @\Auth::user()->FORM_NO;
        if (in_array($ext, $valid_exts)) {
            if (!empty($file)) {

                if ($_FILES['picture']['size'] <= $max_size) {

                    $savepath = 'public/uploads/photos/';
                    
                    if (empty($applicantNO)) {
                        $sql = \DB::table('tbl_form_number')->get();
                        $new_formNo = $sql[0]->FORM_NO;
                        $formNo = date("Y") . $new_formNo;
                        User::where("ID", $applicantID)->update(
                                array(
                                    "FORM_NO" => $formNo,
                                    "PHOTO_UPLOAD" => 'YES'
                        ));
                        $path = $savepath . $formNo . '.' . $ext;
                        \DB::table('tbl_form_number')->increment('FORM_NO');
                    } else {
                        $path = $savepath . $applicantNO . '.' . $ext;
                    }

                    if ($request->file('picture')->move($savepath, $path)) {
                        $applicantPhoto=@\Auth::user()->FORM_NO;
                        // open file a image resource
                        if($applicantPhoto>0){
                                $img = \Image::make('public/uploads/photos/'.$applicantPhoto.'.jpg');


                                // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
                                $img->fit(240, 180);

                                // crop the best fitting 1:1 ratio (200x200) and resize to 200x200 pixel
                                $img->fit(200);

                                // add callback functionality to retain maximal original image size
                                $img->fit(800, 600, function ($constraint) {
                                    $constraint->upsize();
                                });

                         }

                        return redirect('form/step2')->with("success", " <span style='font-weight:bold;font-size:13px;'>Ayekoo photo uploaded succesfully</span> ");
                    }
                } else {
                    return redirect('/upload/photo')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload only photos with size less than or equal to 500kb!!!!</span> ");
                }
            } else {
                return redirect('/upload/photo')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please select photo to upload!!!!</span> ");
            }
        } else {
            return redirect('/upload/photo')->with("error", " <span style='font-weight:bold;font-size:13px;'>Only .jpg or .jpeg photo format is allowed  !</span> ");
        }
    }

    public function finanlize(SystemController $sys) {
        $applicant = @\Auth::user()->FORM_NO;
        $biodata = @Models\ApplicantModel::where("APPLICATION_NUMBER", $applicant)->first();
        $firstChoice = $biodata->FIRST_CHOICE;
        $secondChoice = $biodata->SECOND_CHOICE;
        $thirdChoice = $biodata->THIRD_CHOICE;
        $name = $biodata->NAME;
        $phone = $biodata->PHONE;
        $grades = @Models\ExamResultsModel::where("APPLICATION_NUMBER", $applicant)->get();
        if (@\Auth::user()->BIODATA_DONE == "1") {
            if (@\Auth::user()->FORM_TYPE != "BTECH" && !$grades->isEmpty()) {

                @Models\ApplicantModel::where("APPLICATION_NUMBER", $applicant)
                                ->update(array("COMPLETED" => "1"));
                @Models\FormModel::where("FORM_NO", $applicant)
                                ->update(array("FINALIZED" => "1"));
                $this->sms();
            } else {
                @Models\ApplicantModel::where("APPLICATION_NUMBER", $applicant)
                                ->update(array("COMPLETED" => "1"));
                @Models\FormModel::where("FORM_NO", $applicant)
                                ->update(array("FINALIZED" => "1"));

                if (@\Auth::user()->COUNTRY == "GHANAIAN") {
                    @$this->sms();
                    $pin=@\Auth::user()->PIN;
                    $serial=@\Auth::user()->serial;
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $email_message = "
           <p>akoradi Technical University Online Admission System</p>

           <p>Hello $name</p>
            
          <p> <ol>
                <li>Takoradi Technical University  has received your form you filled at the Admissions Portal \n.</br>  
               
            </ol></p>
            <p>  Your PIN code=$pin and SERIAL NO.=$serial </br> </p>
            <p> Thank you for applying to study at Takoradi Technical University.</p>
            <p>Your First Choice is $firstChoice</p>
            <p>Your Second Choice is $secondChoice</p>
            <p>Your Third Choice is $thirdChoice</p>
 
            <p>This is an automatically generated email message. Please do not reply
                to this mail directly.</p>
                <p>If further assistance is required, please send an email to
            registrar@ttu.edu.gh</p>";
                    "<p>Best regards</p>";

                  // @mail($email, "Takoradi Technical University Admissions", $email_message, $headers) ;
                     return @redirect("/form/preview");

               // return @redirect()->route('/form/preview');

                   
                
            } else {
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $email_message = "
           <p>akoradi Technical University Online Admission System</p>

           <p>Hello $name</p>
            
          <p> <ol>
                <li>Takoradi Technical University  has received your form you filled at the Admissions Portal \n.</br>  
               
            </ol></p>
            <p>  Your PIN code=$pin and SERIAL NO.=$serial </br> </p>
            <p> Thank you for applying to study at Takoradi Technical University.</p>
            <p>Your First Choice is $firstChoice</p>
            <p>Your Second Choice is $secondChoice</p>
            <p>Your Third Choice is $thirdChoice</p>
 
            <p>This is an automatically generated email message. Please do not reply
                to this mail directly.</p>
                <p>If further assistance is required, please send an email to
            registrar@ttu.edu.gh</p>";
                "<p>Best regards</p>";

                @mail($email, "Takoradi Technical University Admissions", $email_message, $headers);
                     return @redirect("/form/preview");
      
                 
      
                
            }
        }

        } else {
            return redirect("/form/step2")->with("error1", "Please fill this page before submiting your form");
        }
    }

    public function preview(SystemController $sys) {
        $applicant = @\Auth::user()->FORM_NO;
        $biodata = @Models\ApplicantModel::where("APPLICATION_NUMBER", $applicant)->first();

        $grades = @Models\ExamResultsModel::where("APPLICATION_NUMBER", $applicant)->get();


        return view('applicants.preview')
                        ->with('student', $biodata)
                        ->with('data', $grades);
    }

    public function destroyGrade(Request $request) {
        \DB::beginTransaction();
        try {
            $applicantForm = @\Auth::user()->FORM_NO;
            $query = Models\ExamResultsModel::where("APPLICATION_NUMBER", $applicantForm)->where('ID', $request->input("id"))->delete();

            if ($query) {
                \DB::commit();

                return redirect()->back()->with("success", " <span style='font-weight:bold;font-size:13px;'>  Grade successfully delete!</span> ");
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }
    
    public function generateAccounts() {
        ini_set('max_execution_time', 30000); //300 seconds = 5 minutes
         $form=  Models\ExcelForm::where("SOLD_BY","CAMPUS")->get();
         foreach($form as $users=>$row){
             
             
             $FormTable=new  Models\FormModel();
              $FormTable->serial=$row->serial;
            $FormTable->PIN=$row->PIN;
           $FormTable->password=bcrypt($row->PIN);
           $FormTable->SOLD_BY=$row->SOLD_BY;
           $FormTable->FORM_TYPE=$row->FORM_TYPE;
              $FormTable->save();
         } 
         
    }

}
