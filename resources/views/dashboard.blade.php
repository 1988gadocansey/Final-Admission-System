@extends('app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table style="text-align:justify"   align="center" cellpadding="0" cellspacing="0" class="displaytable">
                <tr>
                    <td valign="top"><div class="banner">


                            <div class="newsitem_text">

                                @if(Auth::user()->COUNTRY=="GHANAIAN")   

                                <p><center><strong>GHANAIAN APPLICANTS</strong></center></p>
                                <hr>
                                <p>All Ghanaian applicants for the <?php echo (date("Y") ) . "/" . (date("Y") + 1); ?> Academic year admission are required to use Takoradi Technical University online admission portal. The procedure for the online application process is as follows:</p>

                                <p><strong>I</strong>. In completing the online form, applicants will be required to upload their passport size photograph (not more than 500KB) with a white background.</p>
                                <p><strong>II. </strong>Applicants are advised to check thoroughly all details entered before they finally submit their online applications. A form, once submitted, can be viewed, but cannot be edited.</p>
                                <p><strong>III.</strong> Applicants should print out application summary; attach result slips,certificates  and all other relevant documents.</p>
                                <p><strong>VI. </strong>The application documents as specified (III) above should sent by post to  
                                    @else

                                <p><center><strong>FORIEGN APPLICANTS</strong></center></p>
                                <hr>
                                <p>All Foreign applicants for the <?php echo (date("Y") ) . "/" . (date("Y") + 1); ?> Academic year admission are required to use Takoradi Technical University online admission portal. The procedure for the online application process is as follows:</p>

                                <p><strong>I</strong>. In completing the online form, applicants will be required to upload their passport size photograph (not more than 500KB) with a white background.</p>
                                <p><strong>II. </strong>Applicants are advised to check thoroughly all details entered before they finally submit their online applications. A form, once submitted, can be viewed, but cannot be edited.</p>
                                <p><strong>III.</strong> Applicants should print out application summary; attach result slips,certificates and all other relevant documents.</p>
                                <p><strong>VI. </strong>The application documents as specified (III) above should sent by post to  
                                    @endif

                                <p align="center"><strong>The Registrar</strong></p>
                                <p align="center"><strong>Takoradi Technical University</strong></p>
                                <p align="center"><strong>P. O Box 256, Takoradi, W/R.</strong></p>

                                <center><p><strong>For more information call 033 2094767 / 0243039730 / 0246091283 / 0505284060</strong></p></center>

                            </div>

                        </div></td>
                </tr>
                <tr>
                    <td><center><a href="{{url('/upload/photo')}}" class="btn btn-success">Accept and Continue</center></a>
                </td>
                </tr>
            </table>

        </div>
    </div>
</div>

@endsection
