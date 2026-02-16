<!-- Sidebar navigation -->
<div id="slide-out" class="side-nav fixed" width="200px">
    <ul class="custom-scrollbar">
        <!-- Logo -->
        <li class="logo-sn waves-effect">
            <div class="text-center">
                <a href="/" class="pl-0">
                    <img src="{{asset('images/logos/logo.png')}}" width="50px">
                </a>
            </div>
        </li>
        <!--/. Logo -->

        <!-- Side navigation links -->
        <li>
            <ul class="collapsible collapsible-accordion">
                    <li>
                        <div class="col text-center">
                            <img src="https://mdbootstrap.com/img/Photos/Others/images/49.jpg" 
                                class="img-fluid rounded-circle" width="120px">
                            <div class="row">
                                <a href="/profile" class="user blue-grey-text">
                                    {{ Auth::user()->name }} 
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <hr style="background-color:grey; border-style:solid; height: 1px; margin:0px 10px;">
                    </li>   
                    
                    <li>
                        <a class="collapsible-header waves-effect arrow-r blue-grey-text">
                            <i class="fa fa-wrench"></i> Utilerias<i class="fa fa-angle-down rotate-icon"></i>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a class="nav-link blue-grey-text" 
                                        href="#">
                                        <i class="fa fa-th-list" aria-hidden="true"></i> User's Role
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="pt-2">
                            <hr style="background-color:white; border-style:solid; height: 1px; margin:1px 10px;">
                        </div>
                    </li> 
                    
            </ul>
        </li>
        <!--/. Sidebar navigation -->
    </ul>
    
</div>

