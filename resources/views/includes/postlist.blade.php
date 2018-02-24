<div class="col-sm-12">
	<div class="panel panel-white post panel-shadow">
	   <span ng-if="post.user.id == userlogin.id" class="editpost pull-right classpointer fa fa-edit" ng-click="updatepost(post , $index)"> </span>
		
		<div class="post-heading">
			<div class="pull-left image">
				<img ng-src="{{ asset('images/user.png') }}" class="img-circle avatar" alt="user profile image">
			</div>
			<div class="pull-left meta">
				<div class="title h5">
					<a href="#"><b><% post.user.name %></b></a>
					made a post, 
				in category: <b><% post.category.name %></b>
				</div>
				<h6 class="text-muted time"><time am-time-ago="post.created_at"> </time></h6>
			</div>
		</div> 
		<div class="post-description"> 
			<h4 class="cursor-pointer" > <a ng-click="singlepost(post.id)" ><% post.title %> </a></h4>
				<p ng-if="!showSinglePost"  style="white-space: pre-line;" ><% post.content | limitTo: post.limit ? post.content.length : 500 %><a ng-if="post.content.length > 500" href="" ng-click="post.limit = !post.limit"><% post.limit ? " Show Less" : " Show More" %></a>
				
				<p ng-if="showSinglePost" style="white-space: pre-line;" ><% post.content %>
				
			</p>
			<p class="pull-right" style="margin-top: -12px;" ><% post.comments_count %><i class="fa fa-reply"></i></p>
		</div>
		<div ng-if="showSinglePost" class="post-footer">
			<div class="input-group"> 
				<input class="form-control" id="<% post.id %>_com" ng-model="post.newcomments" placeholder="Add a comment" type="text">
				<span class="input-group-addon classpointer" ng-click="postComment(post)">
					<a><i class="fa fa-paper-plane"></i></a>  
				</span>
			</div>
			<ul class="comments-list">
				<li class="comment" ng-repeat="comment in post.comments" >
					<a class="pull-left" href="#">
						<img class="avatar" ng-src="{{ asset('images/user.png') }}" alt="avatar">
					</a>
					<div class="comment-body ">  <span ng-if="comment.user.id == userlogin.id" ng-click="updateComment(post, comment , $index)"  class="fa fa-edit pull-right classpointer"> </span>
						<div class="comment-heading">
							<h4 class="user"><% comment.user.name %></h4>
							<h5 class="time"><time am-time-ago="comment.created_at"> </time></h5>
						</div>
						 <p style="background: #f3f3f3a1;padding: 4px 7px 5px 9px;border-radius: 13px;"><% comment.content | limitTo: comment.limit ? comment.content.length : 200 %><a ng-if="comment.content.length > 200" href="" ng-click="comment.limit = !comment.limit"><% post.limit ? " Show Less" : " Show More" %></a>
						</p>
					</div>
					
				</li>
				<div class="cursor-pointer text-right" ng-if="!showSinglePost" ><a ng-click="singlepost(post.id)">More...</a></div> 
			</ul>
			
		</div>
		
	</div>
</div>
