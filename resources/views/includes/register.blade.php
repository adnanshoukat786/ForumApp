<!-- Modal -->
<div id="registerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Register</h4>
      </div>
      <div class="modal-body">
        
		
		<div class="panel-body">
                    <form name="registerForm" class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }} 
                        <div class="form-group" ng-class="{ 'has-error' : registerForm.name.$invalid && !registerForm.name.$pristine }" >
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" ng-model="register.name"  class="form-control" name="name" value="{{ old('name') }}" required autofocus>
							</div>
                        </div>

                        <div class="form-group" ng-class="{ 'has-error' : registerForm.email.$invalid && !registerForm.email.$pristine }" >
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" ng-model="register.email" class="form-control" name="email" value="{{ old('email') }}" required>

                              
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : registerForm.password.$invalid && !registerForm.password.$pristine }" >
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password"  ng-model="register.password" class="form-control" name="password" required>

                                
                            </div>
                        </div>

                        <div class="form-group" ng-class="{ 'has-error' : registerForm.password_confirmation.$invalid && !registerForm.password_confirmation.$pristine }" >
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" ng-model="register.password_confirmation" type="password" class="form-control" name="password_confirmation" required nx-equal-ex="register.password">
									<div class="error" ng-show="registerForm.password_confirmation.$error.nxEqualEx">Must be equal!</div>
							</div>
                        </div>
					</form>
                </div>
		
		
		
		
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<a  ng-click="registersubmit(registerForm)"  class="btn btn-primary">Register</a>
	  </div>
    </div>

  </div>
</div>