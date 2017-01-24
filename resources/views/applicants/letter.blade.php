@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">ADMISSION LETTER</div>

                <div class="panel-body">
                    <div id='page1'>
                        <table border='0'>
                            <tr>
                                <td> <img src='{{url("public/logo.png")}}' style="width:220px;height: auto"  class="image-responsive"/> 

                                </td>

                                <td align='right' style="width:600px">
                                    <p style="font-size:14px">ACADEMIC AFFAIRS UNIT<br/>
                                        ADMISSIONS OFFICE<br/>
                                        TEL:+233-031-2022917/8<br/>
                                        EMAIL:info@tpoly.edu.gh<br/>
                                        P.O.BOX 256,TAKORADI,GHANA



                                </td>
                            </tr>
                        </table>
                        <hr>
                    </div>	
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
