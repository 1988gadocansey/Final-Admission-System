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
                <div class="panel-heading">STEP 3 - ACADEMIC INFORMATION @if(@\Auth::user()->BIODATA_DONE=="1")
                    <div style="float: right">
                           <a class="text-success" style="color: red" href="{{url('/form/step2')}}">Previous Step</a>
                           |
                        
                        <a class="text-success" style="color: blue" href="{{url('/form/step3')}}">Next Step</a>
                        
                        
                      
                    </div>

                   @endif
                </div>
                <div class="panel-body">
                       
                    <form class="form-horizontal" role="form" id="form"   v-form  method="post" accept-charset="utf-8"  name="biodata" action="{{url('form/step3')}}" >
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 

                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">First Choice</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                 {!!   Form::select('firstChoice',$programme ,array('style'=>'width:120px',old('firstChoice',@$data->FIRST_CHOICE),'placeholder'=>'select first choice',"required"=>"required","v-model"=>"firstChoice","v-form-ctrl"=>"","v-select"=>"firstChoice")   )  !!}
                                 <p class="text-danger text-danger"  v-if="biodata.firstChoice.$error.required" >First Choice is required</p>                                 
                            </div>
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label"> </label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                @if(@Auth::user()->FORM_TYPE=="MATURE")
                                    {!!   Form::select('entry',array("MATURE"=>"MATURE"),old('entry',@$data->ENTRY_TYPE),array('placeholder'=>'Select entry type',"required"=>"required", "v-select"=>"entry","v-model"=>"entry","v-form-ctrl"=>"","id"=>"entry"))  !!}

                                @elseif(@Auth::user()->FORM_TYPE=="ACCESS")
                                {!!   Form::select('entry',array("Access"=>"ACCESS"),old('entry',@$data->ENTRY_TYPE),array('placeholder'=>'Select entry type',"required"=>"required", "v-select"=>"entry","v-model"=>"entry","v-form-ctrl"=>"","id"=>"entry"))  !!}
                             @else
                             {!!   Form::select('entry',array("DIRECT"=>"DIRECT"),old('entry',@$data->ENTRY_TYPE),array('placeholder'=>'Select entry type',"required"=>"required", "v-select"=>"entry","v-model"=>"entry","v-form-ctrl"=>"","id"=>"entry"))  !!}
                             @endif
                                <p class="text-danger text-danger"  v-if="biodata.entry.$error.required" >Entry Type is required</p>                                 

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Second Choice</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('secondChoice',$programme ,old('secondChoice',@$data->SECOND_CHOICE),array('placeholder'=>'select second choice',"required"=>"required", "v-model"=>"secondChoice","v-form-ctrl"=>"","v-select"=>"secondChoice")   )  !!}
                                <p class="text-danger text-danger"  v-if="biodata.secondChoice.$error.required" >Second Choice is required</p>                                 

                            
                            </div>
                           @if(@Auth::user()->FORM_TYPE=="BTECH")
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label"> </label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input type="text" id="study_program" name="study_program" class="form-control" required=""placeholder="Programme Studied at School"   value="{{@$data->PROGRAMME_STUDY}}"    v-model="study_program"v-form-ctrl  >                             
                                <p class="text-danger text-danger"  v-if="biodata.study_program.$error.required" >Programme studied is required</p>                                 

                            </div>
                            @endif
                        </div>
                        <div class="form-group">

                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Third Choice</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                {!!   Form::select('thirdChoice',$programme ,old('thirdChoice',@$data->THIRD_CHOICE),array('placeholder'=>'select third choice',"required"=>"required", "v-model"=>"thirdChoice","v-form-ctrl"=>"","v-select"=>"thirdChoice")   )  !!}
                                <p class="text-danger text-danger"  v-if="biodata.secondChoice.$error.required" >Third  Choice is required</p>                                 

                            </div>
                             @if(@Auth::user()->FORM_TYPE=="BTECH" || @Auth::user()->FORM_TYPE=="MTECH" )
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label"> </label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                              {!!   Form::select('class',array("FIRST CLASS"=>"FIRST CLASS","SECOND CLASS UPPER"=>"SECOND CLASS UPPER","SECOND CLASS LOWER"=>"SECOND CLASS LOWER","THIRD CLASS"=>"THIRD CLASS","PASS"=>"PASS"),old('class',@$data->CLASS),array('placeholder'=>'Select Class obtained',"tabindex"=>"-1", "v-model"=>"class","v-form-ctrl"=>"","v-select"=>"class","required"=>""))  !!}
                             <p class="text-danger text-danger"  v-if="biodata.class.$error.required" >Class obtained is required</p>                                 

                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Former School</label>
                            <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                <input id="school" type="text"  name="school"  v-form-ctrl="" v-model="school" required=""  value="{{@$data->SCHOOL}}"   class="form-control">
                                <p class="text-danger text-danger"  v-if="biodata.school.$error.required" >Former School attended is required</p>                                 


                            </div>
                           
                            <label for="inputEmail3" class="col-xs-10 col-sm-2 col-md-2 col-lg-2 control-label">Hall of affiliation</label>
                           <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                                 {!!   Form::select('hall',$hall,old('hall',$data->PREFERED_HALL),array('placeholder'=>'Select hall of choice',"required"=>"required",  "id"=>"hall","v-model"=>"hall","v-form-ctrl"=>"","v-select"=>"hall")   )  !!}
                                                             
                                <p class="text-danger text-danger"  v-if="biodata.hall.$error.required" >Hall of affiliation is required</p>                                 

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
    </div>
</div>
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
              firstChoice:"<?php echo @$data->FIRST_CHOICE ?>",
              secondChoice:"<?php echo @$data->SECOND_CHOICE ?>",
              thirdChoice:"<?php echo @$data->THIRD_CHOICE ?>",
             entry:"<?php echo @@$data->ENTRY_TYPE ?>",
              hall:"<?php echo $data->PREFERED_HALL ?>",
            options: []

        },
    })

</script>
@endsection    