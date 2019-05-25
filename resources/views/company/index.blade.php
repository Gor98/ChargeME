@extends('layouts.app')

@section('content')
<div class="container mb-5">
	    <div class="row justify-content-center">
        <div class="col-10">
        	 <a href="{{url('api/companies/create')}}" role="button" class="btn btn-success btn-lg btn-block">Create Comany</a>

        </div>
    </div>
</div>
   <company-index url="{{url('')}}"></company-index>
@endsection
