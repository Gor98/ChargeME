@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
		<div class="col-12 mt-5">
			<h1 class="title m-b-md" style="text-align: center;">
				ChargeME LLC
			</h1>

		</div>
		<div class="row mt-5">
			<div class="col-6 link-navigate">
				<a href="{{url('api/stations')}}" role="button"  class="btn btn-success btn-lg btn-block">View All Sations</a>
			</div>
			<div class="col-6 link-navigate">
				<a href="{{url('api/companies/create')}}" role="button" class="btn btn-success btn-lg btn-block">Create Comany</a>
			</div>
		</div>
    </div>
</div>
@endsection
