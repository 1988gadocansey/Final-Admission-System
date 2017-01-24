@extends('layouts.app')


@section('style')
  
 <link rel="stylesheet" href="{!! url('public/assets/bootstrap-material-datetimepicker.css') !!}" media="all">  
@endsection
@section('content')
<div class="col s12 m12 l12">
    <div class="card">
       
            @if(Session::has('success1'))
             <div class="card-panel light-green lighten-3">
            <div style="text-align: center" class=" white-text alert  alert-success"   >
                {!! Session::get('success1') !!} <a href="{{url('form/step2')}}">Click to Move to Next Step</a>
            </div></div>
            @endif
             @if(Session::has('error1'))
             <div class="card-panel red">
            <div style=" " class=" white-text alert  alert-success"  >
                {!! Session::get('error1') !!}
            </div></div>
            @endif

            @if (count($errors) > 0)

             <div class="card-content blue-grey">
                <div class=" alert  alert-danger  " style="background-color: red;color: white">

                    <ul>
                        @foreach ($errors->all() as $error)
                        <li> {{  $error  }} </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div> 
</div>
<main class="mn-inner container">
<div class="row">
    <div class="col s12"> 
        <div class="page-title  "> Step 2 - Form Filling  | YOUR APPLICATION NUMBER IS  {{@\Auth::user()->FORM_NO}}</div>
    </div>
    <div class="col s12 m12 l12">
        <div class="card hoverable">
            <div class="card-content">
                 @if(@\Auth::user()->STARTED=="1")
                <div style="float: right"><a class="waves-effect waves-green btn-flat m-b-xs" href="{{url('/form/step3')}}">Next Step</a></div>
                @endif
               <form id="example-form"   v-form  method="post" accept-charset="utf-8"  name="applicationForm"    >
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 

                                    <div>
                                        <h3>Page 1 - Biodata</h3>
                                        <section>
                                            <div class="wizard-content">
                                                <div class="row">
                                                    <div class="col m6">
                                                        <div class="row">
                                                            <div class="input-field col m6 s12">
                                                                <label for="firstName">First name</label>
                                                                <input id="fname" v-model='fname' v-form-ctrl name="fname" type="text" value="{{@$data->FIRSTNAME}}" class="required validate">
                                                                <p class="uk-text-danger uk-text-small"  v-if="biodata.fname.$error.required" >First Name is required</p>
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="lastName">Last name</label>
                                                                <input id="lastName" name="lname" value="{{@$data->SURNAME}}" type="text" class="required validate">
                                                            </div>
                                                            <div class="input-field col s12">
                                                                <label for="email">Othernames</label>
                                                                <input id="oname" name="othernames" value="{{@$data->OTHERNAME}}" type="text" class="">
                                                            </div>
                                                            @if(@\Auth::user()->FORM_TYPE!="BTECH")
                                                            <div class="input-field col s12">
                                                                <div class="input-field col m6 s12">
                                                        {!!   Form::select('qualification',array("WASSCE"=>"WASSCE","SSCE"=>"SSCE","TECHNICAL"=>"TECHNICAL SCHOOL"),old('qualification',''),array('placeholder'=>'SELECT QUALIFICATION',"required"=>"required", "tabindex"=>"-1"))  !!}
                                                            </div>
                                                               
                                                                
                                                            </div>
                                                            @else
                                                            <div class="input-field col s12">
                                                                <div class="input-field col m6 s12">
                                                        {!!   Form::select('qualification',array("CERTIFICATE"=>"CERTIFICATE"),old('qualification',''),array('placeholder'=>'SELECT QUALIFICATION',"required"=>"required", "tabindex"=>"-1"))  !!}
                                                            </div>
                                                               
                                                                
                                                            </div>
                                                            @endif
                                                            
                                                            <div class="input-field col s12">
                                                                <label for="confirm">Application Mode </label>
                                                                <input id="" readonly="" name="entry" type="text" value="{{@\Auth::user()->FORM_TYPE}}" class="required validate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col m6">
                                                        <div class="row">
                                                            <div class="input-field col m6 s12">
                                                        {!!   Form::select('title',array("Mr"=>"Mr","Mrs"=>"Mrs","Miss"=>"Miss"),old(@$data->TITLE,''),array('placeholder'=>'Select title',"required"=>"required", "tabindex"=>"-1","v-model"=>"title","v-form-ctrl"=>"","id"=>"basic"))  !!}
                                                            </div>
                                                             <div class="input-field col m6 s12">
                                                        {!!   Form::select('gender',array("Male"=>"Male","Female"=>"Female"),old('gender',''),array('placeholder'=>'Select gender',"required"=>"required", "tabindex"=>"-1","v-model"=>"gender","v-form-ctrl"=>"","v-select"=>"gender","style"=>"width: 100%"))  !!}
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="birthdate">Date of Birth (Format 12/03/1990)</label>
                                                                <input id="birthdate" name="dob" type="text" placeholder="format 12/03/1990" class=" required">
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                               {!!   Form::select('marital_status',array("Single"=>"Single","Married"=>"Married","Divorced"=>"Divorced"),old('marital_status',''),array('placeholder'=>'Select marital status',"required"=>"required", "tabindex"=>"-1","v-model"=>"tistle","v-form-ctrl"=>"","id"=>"bassic"))  !!}
                                                         
                                                            </div>
                                                            <div class="input-field col s12">
                                                                <label for="phone">Phone number</label>
                                                                <input id="phone" name="phone" minlength="10" pattern='^[0-9]{10}$'  value="{{@$data->PHONE}}"  maxlength="10"type="number" class="required validate">
                                                            </div>
                                                            <div class="input-field col s12">
                                                                @if(@Auth::user()->FORM_TYPE=='BTECH')
                                                            {!!   Form::select('session',array( "Weekend"=>"Weekend"),old('session',''),array('placeholder'=>'Select session preference',"required"=>"required", "tabindex"=>"-1"))  !!}
                                                                @else
                                                                 {!!   Form::select('session',array("Regular"=>"Regular","Evening"=>"Evening"),old('session',''),array('placeholder'=>'Select session preference',"required"=>"required", "tabindex"=>"-1"))  !!}
                                                                 @endif
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <h3>Page 2 - Address and Location</h3>
                                        <section>
                                            <div class="wizard-content">
                                                  <div class="row">
                                                    <div class="col m6">
                                                        <div class="row">
                                                            <div class="input-field col m6 s12">
                                                                <label for="firstName">Hometown</label>
                                                                <input id="s" name="hometown" type="text" value="{{@$data->HOMETOWN}}"class="required validate">
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="lastName">Postal Address</label>
                                                                <input id="contact" name="contact" type="text" value="{{@$data->ADDRESS}}" class="required validate">
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="firstName">Home Address</label>
                                                                <input id="address" name="address" type="text" value="{{@$data->RESIDENTIAL_ADDRESS}}" class="required validate">
                                                            </div>
                                                            <div class="input-field col s12">
                                                               {!!   Form::select('religion',$religion,old('religion',''),array("required"=>"required", "tabindex"=>"-1", "v-model"=>"religion","v-form-ctrl"=>"","style"=>"width: 100%","v-select"=>"religion")   )  !!}
                                                            </div>
                                                            <div class="input-field col s12">
                                                                <div class="switch m-b-md">
                                                                    <label>
                                                                        @if(@$data->BOND!="")
                                                                        <input type="checkbox" name="bond" value="Yes" checked="">
                                                                        @else
                                                                         <input type="checkbox" name="bond" value="Yes" >
                                                                         @endif
                                                                        <span class="lever"></span>
                                                                       Are you bonded to any organization??
                                                                    </label>
                                                                </div>
                                                            </div>
                                                             
                                                        </div>
                                                    </div>
                                                    <div class="col m6">
                                                        <div class="row">
                                                            <div class="input-field col  s12">
                                                          {!!   Form::select('region',$region ,array('placeholder'=>'select region',"required"=>"required", "tabindex"=>"-1","id"=>"region","v-model"=>"region","v-form-ctrl"=>"","v-select"=>"{{old('region')}}")   )  !!}    
                                                            </div>
                                                             <div class="input-field col  s12">
                                                                   {!!   Form::select('nationality',$country ,array('placeholder'=>'select nationality',"required"=>"required", "tabindex"=>"-1","v-model"=>"nationality","v-form-ctrl"=>"","style"=>"width: 100%","v-select"=>"nationality")   )  !!}
                                                             
                                                             </div>
                                                            <div class="input-field col  s12">
                                                                {!!   Form::select('hall',$hall,array('placeholder'=>'select hall of choice',"required"=>"required",  "id"=>"halls","v-model"=>"halls","v-form-ctrl"=>"","v-select"=>"halls")   )  !!}
                                                             
                                                            </div>
                                                            <div class="input-field col m6 s12">
                                                                <label for="city">Email</label>
                                                                <input  id="email" name="email" type="email" value="{{@$data->EMAIL}}" class="required validate">
                                                            </div>
                                                            <div class="input-field col s12">
                                                            {!!   Form::select('disability',array("Yes"=>"Yes","No"=>"No"),old('disability',''),array('placeholder'=>'Select disability',"required"=>"required","tabindex"=>"-1"))  !!}
                                                           
                                                            </div>
                                                             
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <h3>Page 3 - Guardian Info</h3>
                                        <section>
                                            <div class="wizard-content">
                                                  <div class="row">
                                                    <div class="col m6">
                                                        <div class="row">
                                                             <div class="input-field col s12">
                                                                <label for="firstName">Guardian Name</label>
                                                                <input id="gname" name="gname" type="text" value="{{@$data->GURDIAN_NAME}}" class="required validate">
                                                            </div>
                                                             <div class="input-field col s12">
                                                                <label for="firstName">Guardian Address</label>
                                                                <input id="gaddress" name="gaddress" type="text" value="{{@$data->GURDIAN_ADDRESS}}" class="required validate">
                                                            </div>
                                                            
                                                            <div class="input-field col m6 s12">
                                                                <label for="firstName">Source of Finance</label>
                                                                <input id="finance" name="finance" type="text" value="{{@$data->SOURCE_OF_FINANCE}}" class="required validate">
                                                            </div>
                                                             
                                                             
                                                        </div>
                                                    </div>
                                                    <div class="col m6">
                                                        <div class="row">
                                                           <div class="input-field col m6 s12">
                                                                <label for="lastName">Relationship to Guardian</label>
                                                                <input id="grelationship" name="grelationship" type="text" value="{{@$data->RELATIONSHIP_TO_APPLICANT}}" class="required validate">
                                                            </div>
                                                             
                                                           <div class="input-field col m6 s12">
                                                                <label for="firstName">Guardian Occupation</label>
                                                                <input id="goccupation" name="goccupation" type="text" value="{{@$data->GURDIAN_OCCUPATION}}"class="required validate">
                                                            </div>
                                                            
                                                              <div class="input-field col  m6 s12">
                                                                <label for="phone">Guardian Phone</label>
                                                                <input id="gphone" name="gphone" minlength="10" pattern='^[0-9]{10}$' value="{{@$data->GURDIAN_PHONE}}"   maxlength="10"type="number" class="required validate">
                                                            </div>
                                                             
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <h3>Page 4 - Choice of Programme</h3>
                                        <section>
                                            <div class="wizard-content">
                                               <div class="row">
                                                    <div class="col m6">
                                                        <div class="row">
                                                             <div class="input-field col s12">
                                                                 {!!   Form::select('firstChoice',$programme ,array('placeholder'=>'select first choice',"required"=>"required","style"=>"width: 100%","class"=>"js-states browser-default", "tabindex"=>"-1","v-model"=>"programme","v-form-ctrl"=>"","v-select"=>"first")   )  !!}
                                                            </div>
                                                             <div class="input-field col s12">
                                                                 {!!   Form::select('secondChoice',$programme ,array('placeholder'=>'select second choice',"required"=>"required","style"=>"width: 100%","class"=>"js-states browser-default", "tabindex"=>"-1","v-model"=>"programme","v-form-ctrl"=>"","v-select"=>"third")   )  !!}
                                                            </div>
                                                            
                                                            
                                                             
                                                             
                                                        </div>
                                                    </div>
                                                    <div class="col m6">
                                                        <div class="row">
                                                           <div class="input-field col   s12">
                                                                 
                                                                 {!!   Form::select('thirdChoice',$programme ,array('placeholder'=>'select third choice',"required"=>"required","style"=>"width: 100%","class"=>"js-states browser-default", "tabindex"=>"-1","style"=>"width: 100%")   )  !!}
                                                             
                                                           </div>
                                                             
                                                             <div class="input-field col m6 s12">
                                                                <label for="firstName">Programme Study at school</label>
                                                                <input id="programStudy" name="study_program" type="text" value="{{@$data->PROGRAMME_STUDY}}" class="required validate">
                                                            </div>
                                                             <div class="input-field col m6 s12">
                                                                <label for="firstName">Former  School </label>
                                                                <input id="school" name="school" type="text" value="{{@$data->SCHOOL}}" class="required validate">
                                                            </div>
                                                            @if(@Auth::user()->FORM_TYPE=="BTECH")
                                                            <div class="input-field col s12">
                                                            {!!   Form::select('class',array("FIRST CLASS"=>"FIRST CLASS","SECOND CLASS UPPER"=>"SECOND CLASS UPPER","SECOND CLASS LOWER"=>"SECOND CLASS LOWER","THIRD CLASS"=>"THIRD CLASS","PASS"=>"PASS"),old('class',''),array('placeholder'=>'Select class',"tabindex"=>"-1"))  !!}
                                                           
                                                            </div>
                                                           @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
@section('js')
  
<script src="{!! url('public/assets/plugins/jquery-steps/jquery.steps.min.js') !!}"></script>
        <script src="{!! url('public/assets/plugins/jquery-validation/jquery.validate.min.js') !!}"></script>
        <script src="{!! url('public/assets/js/pages/form-wizard.js') !!}"></script>
    
 <script>

//code for ensuring vuejs can work with select2 select boxes
Vue.directive('select', {
  twoWay: true,
  priority: 1000,
  params: [ 'options'],
  bind: function () {
    var self = this
    $(this.el)
      .select2({
        data: this.params.options,
         width: "resolve"
      })
      .on('change', function () {
        self.vm.$set(this.name,this.value)
        Vue.set(self.vm.$datab,this.name,this.value)
      })
  },
  update: function (newValue,oldValue) {
    $(this.el).val(newValue).trigger('change')
  },
  unbind: function () {
    $(this.el).off().select2('destroy')
  }
})


var vm = new Vue({
  el: "body",
  ready : function() {
  },
 data : {
   title:"<?php echo @$data->TITLE ?>",
  firstChoice:"<?php echo @$data->FIRST_CHOICE ?>",
  secondChoice:"<?php echo @$data->SECOND_CHOICE ?>",
   thirdChoice:"<?php echo @$data->THIRD_CHOICE ?>",
  gender:"<?php echo @$data->GENDER?>",
  nationality:"<?php echo @$data->NATIONALITY ?>",
  religion:"<?php echo @$data->RELIGION ?>",
  region:"<?php echo @$data->REGION ?>",
  qualification:"<?php echo @$data->ENTRY_QUALIFICATION ?>",
  
  
    
 options: [      
    ],
     
  },
  methods : {
     
      
     
  }
})

</script>
<!--         <script src="{!! url('public/assets/plugins/select2/js/select2.min.js') !!}"></script>
        <script src="{!! url('public/assets/js/pages/form-select2.js') !!}"></script>
       -->
@endsection