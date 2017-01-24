@extends('app')
@inject('sys', 'App\Http\Controllers\SystemController')

@section('content')
<div class="container">
    <div class="row">
         
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
            <span> STEP 4 - UPLOAD EXAMINATION RESULTS HERE @if(@\Auth::user()->BIODATA_DONE=="1")
                    <div style="float: right">
                           <a class="text-success" style="color: red" href="{{url('/form/step3')}}">Previous Step</a>
                           |
                        @if(@\Auth::user()->FORM_TYPE=="BTECH")
                        <a class="text-success" style="color: blue" href="{{url('/form/preview')}}">Next Step</a>
                        @else
                        <a class="text-success" style="color: blue" href="{{url('/form/preview')}}">Next Step</a>

                        @endif
                      
                    </div>

                   @endif
            </span>
                    <form class="form-horizontal" role="form" id="form"   method="post" accept-charset="utf-8"  name="biodata" action="{{url('form/step3')}}" >
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
                            @if(@Auth::user()->COUNTRY=="GHANAIAN")
                               <table id="paymentTable" class="table"border="0" style="font-weight:bold" align="center">
                        <tr id="paymentRow" payment_row="payment_row"> 

                            <td valign="top">Index Number &nbsp;<input type="text"  id="indexno"  class="form-control"  name="indexno[]" style="width:auto;"></td>

	  <td valign="top">Exam Type &nbsp;
              <select name="type[]" required="" class="form-control"><option value="WASSCE">WASSCE</option><option value="SSSCE">SSSCE</option><option value="ABCE">ABCE</option><option value="GCE &#039;A&#039; LEVEL">GCE &#039;A&#039; LEVEL</option><option value="GCE &#039;O&#039; LEVEL">GCE &#039;O&#039; LEVEL</option><option value="NAPTEX">NAPTEX</option><option value="NVTI">NVTI</option></select>

          </td>

    
          <td valign="top">Subject &nbsp;
              <select name="subject[]" required="" class="form-control " data-live-search="true" ><option value="168">Accounting</option><option value="166">Agric Economics &amp; Extension</option><option value="219">Animal Husbandry</option><option value="176">Applied Electricity</option><option value="178">Auto Mechanics</option><option value="183">Basketry</option><option value="205">Bead Making</option><option value="22">Biology</option><option value="173">Building Construction</option><option value="216">Building Construction</option><option value="10">Business Management</option><option value="169">Business Maths and Principles of Costing</option><option value="14">Ceramics</option><option value="21">Chemistry</option><option value="5">Christian Religious Studies (CRS)</option><option value="170">Clerical &amp; Office Duties</option><option value="19">Clothing and Textiles</option><option value="23">Core Mathematics</option><option value="9">Cost Accounting</option><option value="220">Crop Husb. &amp; Horticulture</option><option value="211">Dagaare</option><option value="212">Dagbani</option><option value="210">Dangbe</option><option value="2">Economics</option><option value="222">Elective Mathematics</option><option value="177">Electronics</option><option value="25">English Language</option><option value="213">Ewe</option><option value="214">Fante</option><option value="164">Farm Management</option><option value="224">Farm Mechanisation</option><option value="8">Financial Accounting</option><option value="217">Fisheries</option><option value="181">Food &amp; Nutrition</option><option value="17">Food and Nutrition</option><option value="221">Forestry</option><option value="6">French</option><option value="190">Ga</option><option value="163">General Agriculture</option><option value="12">General Knowledge in Art (GKA)</option><option value="1">Geography</option><option value="7">Government</option><option value="11">Graphic Design</option><option value="3">History</option><option value="165">Horticulture</option><option value="26">Integrated Science</option><option value="167">Introduction to Management</option><option value="199">Islamic Religious Studies</option><option value="206">Jewellery</option><option value="184">Leatherwork</option><option value="208">Literature in English</option><option value="16">Management in Living</option><option value="175">Metalwork</option><option value="29">Music</option><option value="191">Nzema</option><option value="20">Physics</option><option value="13">Picture Making</option><option value="33">Sculpture</option><option value="24">Social Studies</option><option value="172">Technical Drawing and Engineering Science</option><option value="15">Textiles</option><option value="192">Twi (Akwapim)</option><option value="193">Twi (Asante)</option><option value="171">Typewriting (40 wpm)</option><option value="174">Woodwork</option></select>
          <td valign="top">Grades &nbsp;
              
             {!!   Form::select('grade[]',$grades , null,array('placeholder'=>'select grade' , "required"=>"required", "id"=>"-1", "class"=>"form-control")   )  !!}

          </td>

          
          <td valign="top">Exam Sitting &nbsp;
              
                                    {!!   Form::select('sitting[]',array("FIRST SITTING"=>"FIRST SITTING","SECOND SITTING"=>"SECOND SITTING","THIRD SITTING"=>"THIRD SITTING"),old('sitting',''),array(  'placeholder'=>'Select sitting',"required"=>"required","id"=>"-1","class"=>"form-control"))  !!}

                             
          </td>
              
          <td>Month of Exam &nbsp;
                <input required="" id="center" name="month[]" type="text" class="form-control" placeholder="MAY/JUNE 2001" required=''>
            
          </td>
          <td>Exam Center &nbsp;
              <input required="" id="center" name="center[]" type="text" class="form-control"  required=''>
                              
          </td>
          <td  id="insertPaymentCell"><button style="margin-top:19px" type="button" id="insertPaymentRow" class="btn btn-success btn-sm" title="click to add more grades" >Add More</button></td> 
	   
                        </tr>
                    </table>
                            @else
                            
                            
                            @endif
                    
                             <center>
                <table>

                    <tr><td><input type="submit" value="Save" id='save'   class="btn btn-primary">
                            <input type="reset" value="Cancel" class="btn btn-danger">
                        </td></tr></table></center>
                    </form>
                </div>
            </div>
        </div>
   
</div>
@endsection

@section('js')
 
	

So if I get it right, on click of a button, you want to open up a modal that lists the values entered by the users followed by submitting it.

For this, you first change your input type="submit" to input type="button" and add data-toggle="modal" data-target="#confirm-submit" so that the modal gets triggered when you click on it:

<input type="button" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-default" />

Next, the modal dialog:

<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Are you sure you want to submit the following details?

                <!-- We display the details entered by the user here -->
                <table class="table">
                    <tr>
                        <th>Last Name</th>
                        <td id="lname"></td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td id="fname"></td>
                    </tr>
                </table>

            </div>

  <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a href="#" id="submit" class="btn btn-success success">Submit</a>
        </div>
    </div>
</div>
   
<script>
$('#submitBtn').click(function() {
     /* when the button in the form, display the entered values in the modal */
     $('#lname').text($('#lastname').val());
     $('#fname').text($('#firstname').val());
});

$('#submit').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    alert('submitting');
    $('#formfield').submit();
});

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
            options: []

        },
    })

</script>
<script>


        $(document).ready(function(){
$("select").addClass('browser-default'),
        function checkFormElements(){}



        $("#insertPaymentRow").bind('click', function(){

        var numOrgs = $(" table#paymentTable tr[payment_row]").length + 1;
                var newOrg = $("table#paymentTable tr:first ").clone(true);
                $(newOrg).children(' td#insertPaymentCell ').html('<button  type="button" id="removePaymentRow_' + numOrgs + '"  title="click to delete grade" class="btn btn-warning btn-sm" ><i class="material-icons">remove</i></button>');
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