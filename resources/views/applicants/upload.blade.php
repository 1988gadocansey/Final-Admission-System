@extends('app')
@inject('sys', 'App\Http\Controllers\SystemController')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
       
            @if(Session::has('success'))
             <div class="card-panel light-green lighten-3">
            <div style="text-align: center" class=" white-text alert  alert-success"   >
                {!! Session::get('success') !!} <a href="{{url('form/step2')}}">Click to Move to Next Step</a>
            </div></div>
            @endif
             @if(Session::has('error'))
             <div class="card-panel red">
            <div style=" " class=" white-text alert  alert-danger"  >
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
            <div class="panel panel-default">
                <div class="panel-heading">STEP 1 - (<span style="color:red"class="">Maximum size 500KB JPG | Only white or Red background is accepted</span>) PICTURE UPLOAD @if(@\Auth::user()->PHOTO_UPLOAD=="YES")
                    <div style="float: right"><a class="text-success" style="color: red" href="{{url('/form/step2')}}">Next Step</a></div>
                    @endif</div>
                <div class="panel-body">
                   
                    <form  enctype="multipart/form-data"   id="uploadForm" class="uk-form-stacked"    method="post" accept-charset="utf-8"  name="uploadForm"   >
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 


                        <div id="file_upload-drop" style="margin-left:239px" class="uk-file-upload">
                            <div  class="fileinput fileinput-new" data-provides="fileinput" align="center">
                                <div class="fileinput-new thumbnail" style="width: 240px; height: 180px;">
                                    @if(@\Auth::user()->FORM_NO!="0")
                                    <img <?php $id = @\Auth::user()->FORM_NO;
echo $sys->picture("public/uploads/photos/$id.jpg", 200);
?>  src="<?php echo url("public/uploads/photos/$id.jpg"); ?>" alt=" Applicant Photo here"  />
                                    @else
                                    <img src="http://placehold.it/240x180"   />
                                    @endif
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; height: 160px;">


                                </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="btn btn-default fileinput-new">
                                            Select image </span>
                                        <span class="btn btn-warning fileinput-exists">
                                            Change </span>

                                        <input type="file" name="picture" required=""  >
                                    </span>
                                    <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">
                                        Remove </a>
                                    <button type="submit" name="photo" class="  btn btn-primary">
                                        Upload </button>
                                </div>



                            </div></div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection