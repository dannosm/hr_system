<div style="overflow: auto;">
<div class="menu-list" style="max-height:750px;">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="{{url('/home')}}"><i class="fa fa-fw fa-user-circle"></i><span class="language">Dashboard</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i><span class="language">Attendance</span></a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/attendance')}}"><span class="language">Attendance</span></a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" href="{{url('/permission')}}"><span class="language">Permission</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/finger-print')}}"><span class="language">Module Finger Print</span></a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="{{url('/rekruitmen')}}"><i class="fas fa-fw fa-chart-pie"></i><span class="language">Recruitmen</span></a>
                            </li>
                            
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-fw fa-wpforms"></i><span class="language">Doc Archive</span></a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/application-letter')}}"><span class="language">Application Letter</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/multiple-documents')}}"><span class="language">Multiple Documents</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-users"></i><span class="language">Employee</span></a>
                                <div id="submenu-5" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/employee')}}"><span class="language">Employee</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/shift')}}"><span class="language">Shift</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/loan')}}"><span class="language">Loan</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/division')}}"><span class="language">Division</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/position')}}"><span class="language">Position</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-divider">
                               <span class="language">Administrator</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="far fa-money-bill-alt"></i><span class="language">Payroll</span></a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                         <li class="nav-item">
                                            <a class="nav-link language" href="{{url('/payroll')}}">Payroll</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link language" href="{{url('/payroll/print')}}">Payroll Print</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link language" href="{{url('/payroll/salary-attribute')}}">Salary Attribute</a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link language" href="{{url('/salary-module')}}">Salary Module</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-user-md"></i><span class="language">General Setting</span></a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/users')}}"><span class="language">Users Master</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/group-role')}}"><span class="language">Role</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/setting')}}"><span class="language">Config</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
</div>