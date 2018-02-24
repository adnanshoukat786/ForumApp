<nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand cursor-pointer" ng-click="getpostbyCat(0)">
                        {{ config('app.name', 'Vanhack Test') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li ng-if="!userlogin" class="classpointer"  ><a data-toggle="modal" data-target="#loginModal">Add Post</a></li>
						<li ng-if="userlogin" class="classpointer" ><a data-toggle="modal"  data-target="#postModal">Add Post</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
					

					
                    <ul class="nav navbar-nav navbar-right">
							<li class="nav-item searchbar">
          <form class="form-inline mr-lg-10">
            <div class="input-group">
              <input ng-model="searchquerytext" class="form-control" type="text" placeholder="Search for...">
              <span ng-click="searchquery()" class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
                        <!-- Authentication Links -->
                        
							<li ng-if="!userlogin" class="classpointer" ><a data-toggle="modal" data-target="#loginModal">Login</a></li>
                            <li ng-if="!userlogin" class="classpointer" ><a data-toggle="modal" data-target="#registerModal" >Register</a></li>
                        
                            <li ng-if="userlogin" class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    <% userlogin.name %><span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        
                    </ul>
                </div>
            </div>
        </nav>