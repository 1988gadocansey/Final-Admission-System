@extends('app')
@inject('sys', 'App\Http\Controllers\SystemController')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">

                @if(Session::has('success1'))
                <div class="card-panel light-green lighten-3">
                    <div style="text-align: center" class=" white-text alert  alert-success"   >
                        {!! Session::get('success1') !!}  
                    </div></div>
                @endif
                @if(Session::has('error1'))
                <div class="card-panel red">
                    <div style=" " class=" white-text alert  alert-danger"  >
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

            <div class="panel panel-default">
                <div class="panel-heading">STEP 2 - BIODATA COLLECTION @if(@\Auth::user()->PHOTO_UPLOAD=="YES")
                    <div style="float: right">
                           <a class="text-success" style="color: red" href="{{url('/upload/photo')}}">Previous Step</a>
                           |
                        @if(@\Auth::user()->STARTED=="1")
                        <a class="text-success" style="color: blue" href="{{url('/form/step3')}}">Next Step</a>
                      @endif 
                    </div>
                   @endif
                </div>
                <div class="panel-body">

                    <form class="form-horizontal" role="form" id="form"   v-form  method="post" accept-charset="utf-8"  name="biodata" action="" >
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 

                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">First Name</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input id="fname" name="fname" type="text" v-model='fname' v-form-ctrl="" value="{{@$data->FIRSTNAME}}" required="" class="form-control">
                                <p class="text-danger text-danger"  v-if="biodata.fname.$error.required" >First Name is required</p>                                 
                            </div>
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Last Name</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input type="text" v-model='lname' name="lname" value="{{@$data->SURNAME}}" v-form-ctrl=""class="form-control" id="lname" required="" >
                                <p class="text-danger text-danger"  v-if="biodata.lname.$error.required" >Surname is required</p>                                 

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Other Names</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input id="oname" name="oname" type="text"   value="{{@$data->OTHERNAME}}"   class="form-control">
                            </div>
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Title</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('title',array("MR"=>"MR","MRS"=>"MRS","MISS"=>"MISS","REV"=>"REV"),old('title'),array('v-model'=>'title','v-form-ctrl'=>'','v-select'=>'title','placeholder'=>'Select Title',"required"=>"required", "tabindex"=>"-1"))  !!}

                                <p class="text-danger text-danger"  v-if="biodata.title.$error.required" >Title is required</p>                                 

                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Marital Status</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('marital_status',array("Single"=>"Single","Married"=>"Married","Divorced"=>"Divorced"),old('marital_status',@$data->MARITAL_STATUS),array('placeholder'=>'Select marital status',"required"=>"required", "tabindex"=>"-1","v-select"=>"marital_status","v-model"=>"marital_status","v-form-ctrl"=>"","id"=>"marital_status"))  !!}
                                <p class="text-danger text-danger"  v-if="biodata.marital_status.$error.required" >Marital Status is required</p>                                 

                            </div>
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Gender</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('gender',array("Male"=>"Male","Female"=>"Female") ,old('gender'),array('placeholder'=>'Select gender',"required"=>"required", "tabindex"=>"-1","v-model"=>"gender","v-form-ctrl"=>"","v-select"=>"gender"))  !!}
                                <p class="text-danger text-danger"  v-if="biodata.gender.$error.required" >Gender is required</p>                                 

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Phone number</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input id="phone" type="text"  name="phone"  v-form-ctrl="" v-model="phone" required=""  value="{{@$data->PHONE}}"   class="form-control">
                                <p class="text-danger text-danger"  v-if="biodata.phone.$error.required" >Applicant's phone number is required</p>                                 


                            </div>
                            @if(@\Auth::user()->COUNTRY=="GHANAIAN")
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Qualification</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('qualification',array("1ST DEGREE"=>"1ST DEGREE","WASSSCE"=>"WASSSCE","SSSCE"=>"SSSCE","TEU/TECHNICAL CERTIFICATES"=>"TEU/TECHNICAL CERTIFICATES" ,"NVTI"=>"NVTI","NAPTEX"=>"NAPTEX","OTHERS"=>"OTHERS") ,old('qualification',@$data->ENTRY_QUALIFICATION),array('placeholder'=>'SELECT FIRST QUALIFICATION'))  !!}

                                                            

                            </div>

                           
                            @else
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Qualification</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input id="qualification" type="text"  name="qualification"   v-form-ctrl="" v-model="qualification" required=""  value="{{@$data->QUALIFICATION}}"  class="form-control">
                                <p class="text-danger text-danger"  v-if="biodata.qualification.$error.required" >Qualification is required</p>                                 


                            </div>
                            @endif

                        </div>
                           @if(@\Auth::user()->COUNTRY=="GHANAIAN")
                         <div class="form-group">
                         <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Qualification 2</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('qualification2',array("1ST DEGREE"=>"1ST DEGREE","WASSSCE"=>"WASSSCE","SSSCE"=>"SSSCE","TEU/TECHNICAL CERTIFICATES"=>"TEU/TECHNICAL CERTIFICATES" ,"NVTI"=>"NVTI","NAPTEX"=>"NAPTEX","OTHERS"=>"OTHERS") ,old('qualification2',@$data->ENTRY_QAULIFICATION2),array('placeholder'=>'SELECT SECOND QUALIFICATION ', "v-form-ctrl"=>"","v-select"=>"qualification2"))  !!}

                              
                            </div>
                         </div>
                           @endif
                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Are you physically challenged?</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('disable',array("Yes"=>"Yes","No"=>"No"), old('disable',@$data->PHYSICALLY_DISABLED),array('placeholder'=>'Select disability',"required"=>"required","tabindex"=>"-1","required"=>"required", "v-form-ctrl"=>"","v-select"=>"disable", "v-model"=>"disable"))  !!}

                                <p class="text-danger text-danger"  v-if="biodata.disable.$error.required" >Disability status is required</p>                                 

                            </div>
                            <div v-if ="disable=='Yes'">
                                <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Name of disability</label>
                                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" id="disabilty" name="disability" class="form-control"   required="required"  value="{{@$data->DISABLED}}"    v-model="disability"  v-form-ctrl>                                                              
                                    <p class="text-danger text-danger"  v-if="biodata.disability.$error.required" >Disability name is required</p>                                 

                                </div></div>
                        </div>
                        
                        
                        
                        
                        
                        
                        <center> <h5 class="text-success">ADDRESS AND LOCATION AND OTHER INFORMATION</h5><hr></center>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Hometown</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">

                                <input type="text" id="hometown" name="hometown"  value="{{@$data->HOMETOWN}}"class="form-control"  required="required"      v-model="hometown"  v-form-ctrl> 
                                <p class="text-danger text-danger"  v-if="biodata.hometown.$error.required" >Hometown is required</p>                                 


                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Residential Address</label>
                                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                    <input id="contact" name="contact" type="text" value="{{@$data->ADDRESS}}" required=""class="form-control"      v-model="contact"  v-form-ctrl>
                                    <p class="text-danger text-danger"  v-if="biodata.contact.$error.required" >Contact address is required</p>                                 


                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            @if(@\Auth::user()->COUNTRY=="GHANAIAN")
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Region</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('region',(['' => 'Select Region'] +$region), 
                                         old('region',@$data->REGION) ,array("required"=>"required", "tabindex"=>"-1","id"=>"region","v-model"=>"region","v-form-ctrl"=>"","v-select"=>"region")   )  !!}    

                                <p class="text-danger text-danger"  v-if="biodata.region.$error.required" >Region is required</p>                                 


                            </div>
                            @else
                             <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Nationality</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('nationality',(['' => 'Select Nationality'] +$country), 
                                         old('nationality',@$data->NATIONALITY) ,array('placeholder'=>'select nationality',"required"=>"required", "tabindex"=>"-1","v-model"=>"nationality","v-form-ctrl"=>"", "v-select"=>"nationality")   )  !!}
                                                             
                                <p class="text-danger text-danger"  v-if="biodata.nationality.$error.required" >Nationality is required</p>                                 


                            </div>
                            @endif
                              <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Hometown Address</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input id="address"  v-model="address"  v-form-ctrl name="address" type="text" value="{{@$data->RESIDENTIAL_ADDRESS}}" required=""class="form-control">

                                <p class="text-danger text-danger"  v-if="biodata.address.$error.required" >Hometown address is required</p>                                 


                            </div></div>

                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Religion</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('religion',$religion,old('religion',''),array("required"=>"required", "tabindex"=>"-1", "v-model"=>"religion","v-form-ctrl"=>"","v-select"=>"religion")   )  !!}

                                <p class="text-danger text-danger"  v-if="biodata.religion.$error.required" >Religion is required</p>                                 


                            </div>
                            <label class="col-md-3 control-label" for="radios">Are you bonded to any organization</label>  
                            <div class="col-md-3"> 
                                <label class="radio-inline" for="radios-0">
                                    <input name="bond" id="radios-0" value="YES" <?php if(@$data->BOND=="YES"){ echo "checked='checked'";}?> type="radio">
                                    Yes
                                </label> 
                                <label class="radio-inline" for="radios-1">
                                    <input name="bond" id="radios-1" value="NO" <?php if(@$data->BOND=="NO"){echo "checked='checked'"; }?> type="radio">
                                    No
                                </label> 
                            </div>  

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Email</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input type="email" id="email" name="email" class="form-control" required=""  value="{{@$data->EMAIL}}"   v-model="email"v-form-ctrl   />

                                <p class="text-danger text-danger"  v-if="biodata.email.$error.required" >Email is required</p>                                 


                            </div>
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Date of Birth(format 12/05/1998)</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input type="text" id="dob" name="dob" class="form-control" required=""  value="{{@$data->DOB}}"  v-model="dob"v-form-ctrl   />

                                <p class="text-danger text-danger"  v-if="biodata.dob.$error.required" >Date of birth is required</p>                                 


                            </div>
                        </div>
                        <center> <h5 class="text-success">PARENT/GUARDIAN INFORMATION</h5><hr></center>
                       <div class="form-group">
                         
                        <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Guardian Name</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">

                                <input type="text" id="gname" name="gname" type="text" value="{{@$data->GURDIAN_NAME}}"class="form-control"  required="required"      v-model="gname"  v-form-ctrl> 
                                <p class="text-danger text-danger"  v-if="biodata.gname.$error.required" >Guardian Name is required</p>                                 


                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Guardian Address</label>
                                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                    <input   id="gaddress" name="gaddress" type="text" value="{{@$data->GURDIAN_ADDRESS}}" required=""class="form-control"      v-model="gaddress"  v-form-ctrl>
                                    <p class="text-danger text-danger"  v-if="biodata.gaddress.$error.required" >Guardian Address is required</p>                                 


                                </div>

                            </div>
                        </div>
                        
                         <div class="form-group">
                         
                        <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Guardian Phone</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">

                                <input type="text" id="gphone" name="gphone" type="text" value="{{@$data->GURDIAN_PHONE}}"class="form-control" name="gphone"  required="required"      v-model="gphone"  v-form-ctrl> 
                                <p class="text-danger text-danger"  v-if="biodata.gphone.$error.required" >Guardian Phone is required</p>                                 


                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Guardian Occupation</label>
                                <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                    <input   id="goccupation" name="goccupation" type="text" value="{{@$data->GURDIAN_ADDRESS}}" required=""class="form-control"      v-model="goccupation"  v-form-ctrl>
                                    <p class="text-danger text-danger"  v-if="biodata.goccupation.$error.required" >Guardian Occupation is required</p>                                 


                                </div>

                            </div>
                        </div>
                         <div class="form-group">
                         
                        <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Guardian Relationship to Applicant</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">

                                <input type="text"id="grelationship" name="grelationship" type="text" value="{{@$data->RELATIONSHIP_TO_APPLICANT}}"class="form-control"    required="required"      v-model="grelationship"  v-form-ctrl> 
                                <p class="text-danger text-danger"  v-if="biodata.grelationship.$error.required" >Guardian Relationship is required</p>                                 


                            </div>
                        
                         <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Source of Finance</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">

                                <input type="text"  id="finance" name="finance"  type="text"  value="{{@$data->SOURCE_OF_FINANCE}}" class="form-control"    required="required"      v-model="finance"  v-form-ctrl> 
                                <p class="text-danger text-danger"  v-if="biodata.finance.$error.required" >Source of finance is required</p>                                 


                            </div>
                         </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <button type="submit"  v-show="biodata.$valid" class="btn btn-primary">Save</button>
                                <button type="button" onclick="return alert('Please fill all required fields')"  v-show="biodata.$invalid" class="btn btn-danger">Save</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div></div>


@endsection

@section('js')
 
<script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
    $(document).ready(function () {
        $('select').select2({width: "resolve"});


    });


</script>   
<script>


//code for ensuring vuejs can work with select2 select boxes
    Vue.directive('select', {
        twoWay: true,
        priority: 1000,
        params: ['options'],
        bind: function () {
            var self = this
            $(this.el)
                    .select2({
                        data: this.params.options,
                        width: "resolve"
                    })
                    .on('change', function () {
                        self.vm.$set(this.name, this.value)
                        Vue.set(self.vm.$data, this.name, this.value)
                    })
        },
        update: function (newValue, oldValue) {
            $(this.el).val(newValue).trigger('change')
        },
        unbind: function () {
            $(this.el).off().select2('destroy')
        }
    })


    var vm = new Vue({
        el: "body",
        ready: function () {
        },
        data: {
         title:"{{@$data->TITLE}}",
          gender:"{{@$data->GENDER}}",
         marital_status:"{{@$data->MARITAL_STATUS}}",
         qualification2:"{{@$data->ENTRY_QAULIFICATION2}}",
         disable:"{{@$data->PHYSICALLY_DISABLED}}",
         region:"{{  @$data->REGION }}",
        nationality : "{{  @$data->NATIONALITY }}",
       religion : "{{  @$data->RELIGION }}",
            options: []

        },
    })

</script>
@endsection    