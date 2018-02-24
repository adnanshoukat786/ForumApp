angular.module('forumApp', ['angularMoment'] , function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
} ).controller('forumController', function($scope, $http) {
	
	$scope.selectedCat = 0;
	$scope.loader = false;
	$scope.showSinglePost = false;
	
	/*init to check if user is login or not, and get postd*/
	$scope.init = function(){
		$scope.loader = true;
		url = webroot+'/checkuserandgetPost';
		$http.get(url).then(function(response) {
			$scope.loader = false;
			$scope.posts = response.data.posts.data;
			$scope.userlogin = response.data.user;
			$scope.post_category = response.data.post_category;
		});
	};
	$scope.init();
	
	/*Login form to send request for user login*/
	$scope.loginsubmit = function(formStatus){
		url = webroot+'/dologin';
		if(formStatus.$valid){
		$scope.loader = true;	
		$http.post(url , $scope.user).then(function(response) {
			$scope.loader = false;
			if(response.data.status == 1){
				$scope.userlogin = response.data.user;
				$.notify("login successful",{type: 'response' , className: 'superblue',  timer: 2000});
			}else{
				$.notify("Email and password does't match",{type: 'response' , className: 'superblue',  timer: 2000});
			} 
			$('#loginModal').modal('hide');
		});
			
		}else{
			angular.forEach(formStatus.$error.required, function(field) {
				field.$setDirty();
			});
		}
	}
	
	/*Regsiter form to send request for user Regsiter*/
	$scope.registersubmit = function(formStatus){
		url = formStatus.$$element[0].action;
		if(formStatus.$valid){
			$scope.loader = true;
			$http.post(url , $scope.register).then(function(response) {
				$scope.loader = false;
				if(response.data.status == 1){
					$scope.userlogin = response.data.user;
					$('#registerModal').modal('hide');
				}else{
					angular.forEach(response.data.message , function(obj){
						$.notify(obj[0],{type: 'response' , className: 'superblue',  timer: 2000});
					}); 
				} 
			});
		}else{
			angular.forEach(formStatus.$error.required, function(field) {
				field.$setDirty();
			});
		}
	}
	
	/*Add New post or update post*/
	$scope.postsubmit = function(formStatus){
		if($scope.post.id){
			url = webroot+'/updatepost';
			$scope.update = true;
		}else{
			url = webroot+'/addPost';
			$scope.update = false;
		}
		if(formStatus.$valid){
			$scope.loader = true;
			$http.post(url , $scope.post).then(function(response) {
				$scope.loader = false;
				if(response.data.status == 1){
					$.notify(response.data.message,{type: 'response' , className: 'superblue',  timer: 2000});
					if($scope.update){
						$scope.posts[$scope.postforupdate] = response.data.post;
					}else{
						$scope.posts.push(response.data.post);
					}
					
					if($scope.post.category_id == 0){
						$scope.post_category[response.data.post.category.id] = response.data.post.category.name;
					}
					$scope.post.title 			= '';
					$scope.post.content 		= '';
					$scope.post.content.newcat  = '';
					formStatus.$setPristine();
					//$scope.post.title = '';
					$('#postModal').modal('hide');
				}else{
					angular.forEach(response.data.message , function(obj){
						$.notify(obj[0],{type: 'response' , className: 'superblue',  timer: 2000});
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
	
	$scope.resetpost = function(post){
		$scope.post=[];
		$('#postModal').modal('hide');
	}
	
	/*Get single post data*/
	$scope.singlepost = function(postid){
		$scope.loader = true;
		url = webroot+'/topic/'+postid;
		$http.get(url).then(function(response) {
			$scope.loader	= false;
			$scope.posts 	= response.data;
			$scope.showSinglePost = true;
		});
	}
	
	/*Add post comment*/
	$scope.postComment = function(post){
		url = webroot+'/commentPost';
		if(angular.isUndefinedOrNull($scope.userlogin) || $scope.userlogin == '' ){
			$.notify('Please login!',{type: 'response' , className: 'superblue',  timer: 2000});
			return false
		}
		if(!angular.isUndefinedOrNull(post.newcomments)){
			$scope.loader = true;
			$http.post(url , post).then(function(response) {
				$scope.loader = false;
				if(response.data.status == 1){
					if(!angular.isUndefinedOrNull(post.newcommentid) && post.newcommentid != ''){
						post.comments[post.newcommentindex] =  response.data.comment;
						$.notify(response.data.message,{type: 'response' , className: 'superblue',  timer: 2000});
					}else{
						post.comments.push(response.data.comment);
						$.notify(response.data.message,{type: 'response' , className: 'superblue',  timer: 2000});
					}
					post.newcomments = '';
					post.newcommentid = '';
				}else{
					$.notify(response.data.message,{type: 'response' , className: 'superblue',  timer: 2000});
				} 
			});
		}
	}
	
	/*Update post comment*/
	$scope.updateComment = function(post , comment , index){
		$('html,body').animate({
			scrollTop: $("#"+post.id+"_com").offset().top-50},
        'slow');
		$("#"+post.id+"_com").focus();
		post.newcomments = comment.content;
		post.newcommentid = comment.id;
		post.newcommentindex = index;
	}
	
	/*Update post popup*/
	$scope.updatepost = function(post , index){
		$scope.postforupdate = index;
		$scope.post  = angular.copy(post);
		$scope.post.category_id = post.category_id.toString();
		$('#postModal').modal('show');
	}
	
	/*get post by category*/
	$scope.getpostbyCat = function(key){
		$scope.showSinglePost = false;
		$scope.loader = true;
		$scope.selectedCat=key;
		$scope.searchquerytext = '';
		page=1;
		load_more(page)
	}
	
	/*Search Query*/
	$scope.searchquery = function(){
		if(!angular.isUndefinedOrNull($scope.searchquerytext) && $scope.searchquerytext != ''){
			$scope.loader = true;
			$scope.selectedCat = 0;
			page=1;
			load_more(page)
		}
	}
	
	/****/
$scope.moreData = true;	
var page = 1; //track user scroll as page number, right now page number is 1
$(window).scroll(function() { //detect page scroll
    if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
        if($scope.moreData && !$scope.showSinglePost){
			page++; //page number increment
			load_more(page); //load content  
		}		
    }
});     
function load_more(page){
	url = webroot+'/getposts?page=' + page;
	
	if($scope.selectedCat!=0){
		url = url+'&cat='+$scope.selectedCat;
	}
	
	if(!angular.isUndefinedOrNull($scope.searchquerytext) && $scope.searchquerytext != ''){
		url = url+'&querytext='+$scope.searchquerytext;
	}
	$http.get(url).then(function(success) {
		if(page == 1){
				$scope.posts = success.data.data;
		}else{
			if(success.data.data.length > 0){
				angular.forEach(success.data.data , function(obj){
					$scope.posts.push(obj);
				});
			}else{
				$scope.moreData = false;
			}
		}
		$scope.loader = false;
	});
}

	
angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null 
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