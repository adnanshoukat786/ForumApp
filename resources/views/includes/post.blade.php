<!-- Modal -->
<div id="postModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Register</h4>
      </div>
      <div class="modal-body">
        
		
		<div class="panel-body">
                    <form name="postForm" class="form-horizontal" method="POST" >
                        {{ csrf_field() }} 
                        <div class="form-group" ng-class="{ 'has-error' : postForm.title.$invalid && !postForm.title.$pristine }" >
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" ng-model="post.title"  class="form-control" name="title" value="{{ old('title') }}" required autofocus>
							</div>
                        </div>

                        <div class="form-group" ng-class="{ 'has-error' : postForm.category_id.$invalid && !postForm.category_id.$pristine }" >
                            <label for="category_id" class="col-md-4 control-label">Category</label>

                        <div class="col-md-6">
						<select ng-model="post.category_id" class="form-control" name="category_id">
							<option ng-repeat="(key, cat) in post_category" value="<% key %>"><% cat %></option>
							<option  value="0">Other</option>		
						</select>
						</div>
						</div>
					
						
						<div ng-if="post.category_id == 0" class="form-group" ng-class="{ 'has-error' : postForm.newcat.$invalid && !postForm.newcat.$pristine }" >
                            <label for="title" class="col-md-4 control-label">Which Category?</label>
							<div class="col-md-6">
                                <input id="title" type="text" ng-model="post.newcat"  class="form-control" name="newcat" value="{{ old('newcat') }}" required autofocus>
							</div>
                        </div>
						
                        
                        <div class="form-group" ng-class="{ 'has-error' : postForm.content.$invalid && !postForm.content.$pristine }" >
                            <label for="content" class="col-md-4 control-label">Content</label>
							<div class="col-md-6">
                            	<textarea rows="8" id="content" ng-model="post.content"  type="text"  ng-model="post.content" class="form-control" name="content" required>
								</textarea>
							</div>
                        </div>
					</form>
                </div>
		
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" ng-click="resetpost()" >Close</button>
		<button ng-click="postsubmit(postForm)" type="button" class="btn btn-primary" >Post</button>
		</div>
    </div>

  </div>
</div>