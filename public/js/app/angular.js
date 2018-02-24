angular.module('forumApp', ['angularMoment'] , function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    } ).controller('forumController', function($scope, $http) {
	
	
	$scope.init = function(){
		url = webroot+'/checkuser';
		$http.get(url).then(function(response) {
			console.log(response.data.posts.data);
			$scope.posts = response.data.posts.data;
			$scope.userlogin = response.data.user;
		});
	};
	$scope.init();
	
	$scope.loginsubmit = function(formStatus){
		url = webroot+'/dologin';
		if(formStatus.$valid){
			
		$http.post(url , $scope.user).then(function(response) {
			console.log(response.data);
		});
			
		}else{
			angular.forEach(formStatus.$error.required, function(field) {
				field.$setDirty();
			});
		}
	}
	
	
	$scope.registersubmit = function(formStatus){
		url = formStatus.$$element[0].action;
		if(formStatus.$valid){
			$http.post(url , $scope.register).then(function(response) {
				if(response.data.status == 1){
					$.notify(response.data.message,{type: 'response' , timer: 2000, placement: {from: "bottom",align: "right"}});
					$scope.userlogin = response.data.user;
				}else{
					angular.forEach(response.data.message , function(obj){
						$.notify(obj[0],{type: 'response'});
					}); 
					$scope.loaderCart = false;
				} 
			});
		}else{
			angular.forEach(formStatus.$error.required, function(field) {
				field.$setDirty();
			});
		}
	}
	
	
	$scope.postsubmit = function(formStatus){
		if($scope.post.id){
			url = webroot+'/updatepost';
			$scope.update = true;
		}else{
			url = webroot+'/addPost';
			$scope.update = false;
		}
		
		if(formStatus.$valid){
			$http.post(url , $scope.post).then(function(response) {
				if(response.data.status == 1){
					$.notify(response.data.message,{type: 'response' , timer: 2000, placement: {from: "bottom",align: "right"}});
					if($scope.update){
						console.log(response.data.post);
						$scope.posts[$scope.postforupdate] = response.data.post;
					}else{
						$scope.posts.push(response.data.post);
					}
				}else{
					angular.forEach(response.data.message , function(obj){
						$.notify(obj[0],{type: 'response'});
					}); 
					$scope.loaderCart = false;
				} 
			});
			$('#postModal').modal('hide');
		}else{
			angular.forEach(formStatus.$error.required, function(field) {
				field.$setDirty();
			});
		}
	}
	
	$scope.postComment = function(post){
		url = webroot+'/commentPost';
		if(post.newcomments != ''){
			$http.post(url , post).then(function(response) {
				console.log(response);
				if(response.data.status == 1){
					if(post.newcommentid != ''){
						post.comments[post.newcommentindex] =  response.data.comment;
					}else{
						post.comments.push(response.data.comment);
					}
					post.newcomments = '';
					post.newcommentid = '';
				}else{
					$.notify(response.data.message,{type: 'response' , timer: 2000, placement: {from: "bottom",align: "right"}});
				} 
			});
		}
	}
	
	$scope.updateComment = function(post , comment , index){
		post.newcomments = comment.content;
		post.newcommentid = comment.id;
		post.newcommentindex = index;
	}
	
	$scope.updatepost = function(post , index){
		$scope.postforupdate = index;
		$scope.post  = angular.copy(post);
		$scope.post.category_id = post.category_id.toString();
		$('#postModal').modal('show');
	}
	
	/****/
	
	
	
	
var page = 1; //track user scroll as page number, right now page number is 1
$(window).scroll(function() { //detect page scroll
    if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
        page++; //page number increment
        load_more(page); //load content   
    }
});     
function load_more(page){
	url = webroot+'/getposts?page=' + page;
	$http.get(url).then(function(success) {
		angular.forEach(success.data.data , function(obj){
			$scope.posts.push(obj);
		});
	});
	
	
	
}
	
	

	


}).directive('nxEqualEx', function() {
    return {
        require: 'ngModel',
        link: function (scope, elem, attrs, model) {
            if (!attrs.nxEqualEx) {
                console.error('nxEqualEx expects a model as an argument!');
                return;
            }
            scope.$watch(attrs.nxEqualEx, function (value) {
                // Only compare values if the second ctrl has a value.
                if (model.$viewValue !== undefined && model.$viewValue !== '') {
                    model.$setValidity('nxEqualEx', value === model.$viewValue);
                }
            });
            model.$parsers.push(function (value) {
                // Mute the nxEqual error if the second ctrl is empty.
                if (value === undefined || value === '') {
                    model.$setValidity('nxEqualEx', true);
                    return value;
                }
                var isValid = value === scope.$eval(attrs.nxEqualEx);
                model.$setValidity('nxEqualEx', isValid);
                return isValid ? value : undefined;
            });
        }
    };
})