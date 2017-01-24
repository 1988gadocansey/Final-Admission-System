@extends('layouts.app')


@section('style')
<script src="{!! url('public/assets/js/jquery.min.js') !!}"></script>

<script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>

@endsection
@section('content')
<div class="col s12 m12 l12">
    <div class="card">
       
            @if(Session::has('success'))
             <div class="card-panel light-green lighten-3">
            <div style="text-align: center" class=" white-text alert  alert-success"   >
                {!! Session::get('success') !!}  
            </div></div>
            @endif
             @if(Session::has('error'))
             <div class="card-panel red">
            <div style=" " class=" white-text alert  alert-success"  >
                {!! Session::get('error') !!}
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
@inject('sys', 'App\Http\Controllers\SystemController')
<main class="mn-inner ">
    <div class="row">
         @if($total!="")
                <div style="float: right"><a class="waves-effect waves-light btn blue m-b-xs" href="{{url('/form/preview')}}">Preview Form and Submit</a></div>
                @endif
        <div class="col s12">
            <div class="page-title  text-success"><small class="">Upload Exams Results here</small></div>
        </div>
        <form    id="form" accept-charset="utf-8" method="POST" name="applicationForm" >
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
            <div class="col s12 m12 l12">
                <div class="card hoverable">
                    <table id="paymentTable" class="uk-table"border="0" style="font-weight:bold">
                        <tr id="paymentRow" payment_row="payment_row"> 

                            <td valign="top">Index Number &nbsp;<input type="text"  id="indexno"  class="required validate"  name="indexno[]" style="width:auto;"></td>

	  <td valign="top">Exam Type &nbsp;
            {!!   Form::select('type[]',$examType ,array('placeholder'=>'select exam type' ,"id"=>"dd", "class"=>"browser-default")   )  !!}

          </td>

    
          <td valign="top">Subject &nbsp;
              {!!   Form::select('subject[]',$subject ,array('placeholder'=>'select subject' ,"required"=>"required", "id"=>"-1")   )  !!}</td>

          <td valign="top">Grades &nbsp;
              
             {!!   Form::select('grade[]',$grades , null,array('placeholder'=>'select grade' , "required"=>"required", "id"=>"-1")   )  !!}

          </td>

          
          <td valign="top">Exam Sitting &nbsp;
              
                                    {!!   Form::select('sitting[]',array("FIRST SITTING"=>"FIRST SITTING","SECOND SITTING"=>"SECOND SITTING","THIRD SITTING"=>"THIRD SITTING"),old('sitting',''),array(  'placeholder'=>'Select sitting',"required"=>"required","id"=>"-1","class"=>"browser-default"))  !!}

                             
          </td>
              
          <td>Month of Exam &nbsp;
               {!!   Form::select('month[]',array("MAY/JUNE"=>"MAY/JUNE","NOV/DEC"=>"NOV/DEC"),old('month',''),array('placeholder'=>'Select month', "style"=>"margin-top:-22px",  "id"=>"s","class"=>" "))  !!}

          </td>
          <td>Exam Center &nbsp;
              <input required="" id="center" name="center[]" type="text"   required=''>
                              
          </td>
	  <td valign="top" id="insertPaymentCell"><button  type="button" id="insertPaymentRow" class="waves-effect waves-light btn blue m-b-xs btn-sm" title="click to add more grades" ><i class="sidebar-menu-icon material-icons">add</i></button></td> 
	   
                        </tr>
                    </table>
                </div>
            </div>

            <div style="margin-left: 500px">
                <table>

                    <tr><td><input type="submit" value="Save" id='save'v-show="applicationForm.$valid"  class="waves-effect waves-light btn green m-b-xs">
                            <input type="reset" value="Cancel" class="waves-effect waves-light btn red m-b-xs">
                        </td></tr></table></div>

        </form>
    </div>
     <div class="row">
        <div class="col s12">
            <div class="page-title  text-success"><small class="">Uploaded Results</small></div>
        </div>
          <div class="col s12 m12 l12">
                <div class="card hoverable">
                     <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                 <table class="responsive-table table-striped table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th data-field="id">NO</th>
                                            <th data-field="price">INDEXNO</th>
                                            <th data-field="name">SUBJECT</th>
                                            <th data-field="price">GRADE</th>
                                            <th data-field="price">VALUE</th>
                                            <th data-field="price">EXAM TYPE</th>
                                            <th data-field="price">SITTING</th>
                                            <th data-field="price">MONTH OF EXAM</th>
                                            <th data-field="price">CENTER</th>
                                            <th style="text-align: center">ACTION</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        
                                         @foreach($data as $index=> $row) 
                                         
                                         
                                        <tr align="">
                                            <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                                            <td> {{ @$row->INDEX_NO }}</td>
                                            <td> {{ @$row->subject->NAME	 }}</td>
                                            <td> {{ @$row->GRADE	 }}</td>
                                            <td> {{ @$row->GRADE_VALUE	 }}</td>
                                            <td> {{ @$row->EXAM_TYPE }}</td>
                                           <td> {{ @$row->SITTING }}</td>
                                            <td> {{ @$row->MONTH }}</td>
                                            <td> {{ @$row->CENTER }}</td>
                                            <td style="text-align: center">
                                                
                                                 {!!Form::open(['action' =>['FormController@destroyGrade', 'id'=>$row->ID], 'method' => 'DELETE','name'=>'c' ,'style' => 'display: inline;'])  !!}

                                                      <button type="submit" title="click to delete subject" onclick="return confirm('Are you sure you want to delete   {{@$row->subject->NAME}}  ?')" class="waves-effect waves-red btn-flat m-b-xs" ><i  class="material-icons md-18">delete</i></button>
                                                        
                                                     {!! Form::close() !!}
                                            </td>
                                          </tr> 
                                           @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
          
    </div>
 
</main>
    
 
@endsection
@section('js')

<script>


        $(document).ready(function(){
$("select").addClass('browser-default'),
        function checkFormElements(){}



        $("#insertPaymentRow").bind('click', function(){

        var numOrgs = $(" table#paymentTable tr[payment_row]").length + 1;
                var newOrg = $("table#paymentTable tr:first ").clone(true);
                $(newOrg).children(' td#insertPaymentCell ').html('<button  type="button" id="removePaymentRow_' + numOrgs + '"  title="click to delete grade" class="waves-effect waves-light btn orange m-b-xs btn-sm" ><i class="material-icons">remove</i></button>');
                var amountLine = $(newOrg).children('td')[2];
                $(amountLine).children(':last-child').prop('value', '');
                var amountInput = $(amountLine).children(':last-child');
                $(amountInput).prop('id', 'amt_' + numOrgs);
                $(newOrg).attr('id', 'paymentRow_' + numOrgs);
                $(newOrg).insertAfter($("table#paymentTable tr:last"));
                $('#removePaymentRow_' + numOrgs).bind("click", function(){
// $(amountInput).trigger('keyup');
        $('#paymentRow_' + numOrgs).remove();
                var count = 0;
                });
// $('#amt_'+numOrgs).bind('focus',function(){
//   console.log('hello from here');
// });

//});


                $('#paymentTable .pay_type  :selected').parent().each(function(){
        if ($(this).prop('selectedIndex') <= 0){
        //$('#new_payment_individual_form :submit').prop('disabled','disabled');
        //  $('#alertInfo').css('display','block').html("Please select a payment type!");
        }
        });
//console.log($(this).prop('name')+"->"+$('#paymentTable .pay_type  :selected').parent().length);

                });
                $('#save').on('click', function(e) {
        return (function(modal){ modal =alert("Are you sure you want to submit your results......."); setTimeout(function(){ modal.hide() }, 50000) })();
                });
                });    </script>

@endsection