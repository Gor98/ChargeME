@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
		<div class="col-10 mt-5">
			<h1 class="title m-b-md" style="text-align: center;">
				ChargeME LLC
			</h1>

		</div>

		<div class="col-5 mt-5 link-navigate">
			<a href="{{url('api/stations')}}" role="button"  class="btn btn-success btn-lg btn-block">All Sations</a>
		</div>
		<div class="col-5 mt-5 link-navigate">
			<a href="{{url('api/companies')}}" role="button" class="btn btn-success btn-lg btn-block">List Comany</a>
		</div>
	
    </div>
</div>
@endsection
