<nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.html"><img  alt="HR System" width="" height="" id="set_image_2"/></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                         <li class="nav-item dropdown connection">
                         </li>
                        <li class="nav-item dropdown connection">
                            <a class="nav-link language-flag" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >  </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                               <li>
                                       <a class="dropdown-item" href="javascript:void(0)" onclick="change_language('id')"><i class="flag-icon flag-icon-id"></i>Indonesia</a>
                                </li>
                                <li>
                                       <a class="dropdown-item" href="javascript:void(0)" onclick="change_language('us')"><i class="flag-icon flag-icon-us"></i>English</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{URL::to('/')}}/assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{ auth::user()->name}} </h5>
                                    <span class="status"></span><span class="ml-2">{{ auth::user()->name}}</span>
                                </div>
                                <a class="dropdown-item" href="{{url('/users/edit/')}}/{{auth::user()->id}}"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="{{url('/setting')}}"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="{{url('/logout')}}"><i class="fas fa-power-off mr-2"></i><span class="language" >Logout</span></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

           