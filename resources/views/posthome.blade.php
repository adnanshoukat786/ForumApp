@extends('layouts.app')

@section('content')
@include('includes.header')
<div class="container" >
<div class="loader" ng-if="loader" ></div>
    <div class="row">
	<div class="col-md-10">
	    <div ng-repeat="post in posts" ng-if="posts.length > 0"  >
		@include('includes.postlist')
		</div>
		
		
		<h4 class="text-center"  ng-if="moreData == false && !showSinglePost ">No more posts!</h4>
		<h2  ng-if="posts.length == 0"  >
			No Posts Available!
		</h2>
    </div>
	<div class="col-md-2 no-padding">
		<div class="sidebar-nav">
			<div class="well">
			Categories 
				<ul class="nav ">
					<li ng-click="getpostbyCat(0)" class="nav-header"> <a href="#"> ALL </a></li>
					<li ng-repeat="(key, cat) in post_category" ng-click="getpostbyCat(key)" class="nav-header"> <a href="#"> <% cat %> </a></li>
				</ul>
			</div>
		</div>
	</div>
	</div>
</div>
@include('includes.login')
@include('includes.register')
@include('includes.post')
@endsection
