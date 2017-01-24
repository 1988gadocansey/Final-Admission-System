@extends('layouts.app')


@section('style')

@endsection
@section('content')
<div class="md-card-content">
    @if(Session::has('success'))
    <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
        {!! Session::get('success') !!}
    </div>
    @endif

    @if (count($errors) > 0)

    <div class="uk-form-row">
        <div class="uk-alert uk-alert-danger" style="background-color: red;color: white">

            <ul>
                @foreach ($errors->all() as $error)
                <li> {{  $error  }} </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
<main class="mn-inner container">
 <div class="row">
     
     <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <div id="todo-lists" >
                             <table style="text-align:justify" width="851" align="center" cellpadding="0" cellspacing="0" class="displaytable">
                                  <tr>
                                    <td valign="top"><div class="banner">
                                     
                                 
                                     <div class="newsitem_text">
                                                      
                                                
                                        
                                        <p><center><strong>DOMESTIC (GHANAIAN) APPLICANTS</strong></center></p>
                                        <hr>
                                <p>All Ghanaian applicants for the <?php echo (date("Y") ) ."/".(date("Y")+1);?> Academic year admission are required to use Takoradi Polytechnic online admission portal. The procedure for the online application process is as follows:</p>
                                <p><strong style="line-height: 12.0000009536743px;">I. </strong><span style="line-height: 12.0000009536743px;">Applicants are required to purchase Takoradi Polytechnic  E-Vouchers at </span><strong style="line-height: 12.0000009536743px;">GHC....</strong><span style="line-height: 12.0000009536743px;"> from any branch of the following banks:</span><span style="line-height: 12.0000009536743px;">                                                                                              </span></p>
                                <ul>
                                <li style="text-align: left;"><strong style="line-height: 12.0000009536743px;">BANK A</strong></li>
                                <li style="text-align: left;"><strong style="line-height: 12.0000009536743px;">BANK B</strong></li>
                                <li style="text-align: left;"><strong style="line-height: 12.0000009536743px;">BANK C</strong></li>
                                </ul>
                                  <p><strong>IV</strong>. In completing the online form, applicants will be required to upload their passport size photograph (not more than 20KB) with a white background.</p>
                                <p><strong>V. </strong>Applicants are advised to check thoroughly all details entered before they finally submit their online applications. A form, once submitted, can be viewed, but cannot be edited.</p>
                                <p><strong>VI.</strong> Applicants should print out application summary; attach result slips,certificates (WASSCE/SSSCE)or Certificates(Top and Access Course) and all other relevant documents.</p>
                                <p><strong>VII. </strong>The application documents as specified (VI) above should sent by post to The Registrar, TAKORADI POLYTECHNIC, Post Office Box 256 Takoradi, Western Region, Ghana</p>
								 <p><strong>VII. </strong>An Envelope Number generated on your completion to the online application must be written at the back of 
								 the envelope before posting</p>
								
                               <hr>
                              
                                
                                <p><center><strong>FOREIGN APPLICANTS </strong></center></p>
                                <hr>
                                <p>Foreign applicants who have the above qualifications or their equivalent from an accredited / recognized institution can apply as follows:</p>
                                <p>I. Make payment of a non - refundable fee of <strong>$.....</strong> or its equivalent to :</p>
                                <p><strong>Bank Details</strong>: ...............</p>
                                <p><strong>Account Details:</strong> Takoradi Polytechnic  Foreign Account</p>
                                <p>II. Access the online form by visiting our online admission portal at tpolyonline.com/Admissions and click on "<strong>Click to apply as a Foreign Student".</strong></p>
                                <p>IV. An activation code will be sent to your mobile number and email address.</p>
                                <p>V. Use the activation code to access the application form.</p>
                                <p>VI. Applicants will be required to upload their passport size photo graph <strong>(not more than 20KB) </strong>with a white background. </p>
                                <p>VII. After filling the online form scan your pay-in slip and certificates/results slips into one PDF or WORD document and attach it to the application forms before submission online</p>
                                <p>VIII. Applicants should note that no application will be processed without proof of payment of the application fee.</p>
                                <p><strong> </strong></p>
                                <p><strong>CLOSING DATE</strong></p>
                                <p>Closing date for submission of completed application is .................</p>
                                <p>Enquires may be addressed to:</p>
                                <p align="center"><strong>The Registrar</strong></p>
                                <p align="center"><strong>Takoradi Polytechnic,</strong></p>
                                <p align="center"><strong>P. O Box 256, Takoradi, W/R.</strong></p>
								<p align="left"><strong>For more information call 033 2094767 / 0262321123</strong></p>
                                 
                                        </div>
                                 
                                    </div></td>
                                  </tr>
                                  <tr>
                                      <td><center><a href="{{url('/upload/photo')}}" class="btn bgm-lime">Accept and Continue</center></a>
                                </td>
                                  </tr>
                             </table>
                                 
                            </div>
                            </div>
                        </div>
                    </div>
 </div>
</main>
@endsection
@section('js')


@endsection