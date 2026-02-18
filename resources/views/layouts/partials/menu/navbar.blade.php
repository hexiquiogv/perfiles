<!-- Navbar -->
<nav class="navbar fixed-top navbar-toggleable-md navbar-blue scrolling-navbar">

    <div class="d-flex flex-row">
        <div>
            <a href="{{route('home')}}">
                <img src="{{asset('images/logos/transparente.png')}}" width="180px">
            </a>    
        </div>
        <span class="pt-3 pl-2 h6"></span>
    </div>

    <!--Navbar links-->
    <ul class="nav navbar-nav nav-flex-icons ml-auto">
        @if (!Auth::guest())         
            <li class="nav-item mt-2">
                <span class="h6 px-2">Bienvenido - {{ Auth::user()->name }} </span>
            </li>    
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bars white-text"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('seguros.index')}}">
                        <i class="fa fa-paste pink-text"></i> Polizas Seguros </a>
                    <a class="dropdown-item" href="{{route('personas.index')}}">
                        <i class="fa fa-users orange-text"></i> Personas </a>
                    <a class="dropdown-item" href="{{route('reports.index')}}">
                        <i class="fa fa-print text-info"></i> Reportes</a>
                    
                    <div class="dropdown-divider"></div>
                    @hasanyrole( 'super_admin' )
                        <a class="dropdown-item" href="{{route('consultas.index')}}">
                            <i class="fa fa-square blue-text"></i> 
                            Consultas
                        </a>
                        <a class="dropdown-item" href="{{route('catalogos.index')}}">
                            <i class="fa fa-square orange-text" aria-hidden="true"></i> 
                            Catalogos
                        </a>
                        <a class="dropdown-item" href="{{route('users.index')}}">
                            <i class="fa fa-users cyan-text" aria-hidden="true"></i> 
                            Usuarios
                        </a>
                        <a class="dropdown-item" href="{{route('roles.index')}}">
                            <i class="fa fa-tags cyan-text" aria-hidden="true"></i> 
                            Roles
                        </a>
                        <div class="dropdown-divider"></div>
                    @endhasanyrole  
                    
                    <a class="dropdown-item" href="#" id="change_password"
                        data-toggle="modal" data-target="#change_password_modal">
                        <i class="fa fa-lock red-text"></i>
                        Contraseña
                    </a>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out teal-text"></i> Salir
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link btn waves-effect" 
                    href="{{route('login')}}" id="btn-acceso">
                    <span class="hidden-sm-down text-warning h5 mx-3"> Acceso </span>
                </a>
            </li>
        @endif
    </ul>
    <!--/Navbar links-->

</nav>
<!-- /.Navbar -->
