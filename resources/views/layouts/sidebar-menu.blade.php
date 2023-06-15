<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                <p>
                    Dashboard
                </p>
            </router-link>
        </li>
        @if (in_array(Auth::user()->role_id, [1, 2, 3, 7]))
        <li class="settings-items nav-item ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-tasks nav-icon blue"></i>
                <p>Ventas</p>
            </a>
            <div id="collapseOne" class="collapse sub-item-settings sidebar-submenu">
                @if (in_array(Auth::user()->role_id, [1, 2]))    
                <div class="nav-item">
                    <router-link to="/solicitudes" class="nav-link">
                        <a class="nav-link collapsed nav-seeker" style="margin-left: -1rem;padding-left: 2.5rem; font-size: 0.85rem">
                            <i class="fas fa-dot-circle nav-icon blue"></i>
                            <p>Solicitudes</p>
                        </a>
                    </router-link>
                </div>
                @endif
                @if (in_array(Auth::user()->role_id, [1, 3,7]))
                <div class="nav-item">
                    <router-link to="/manage-ventas" class="nav-link">
                        <a class="nav-link collapsed " style="margin-left: -1rem;padding-left: 2.5rem; font-size: 0.85rem">
                            <i class="fas fa-dot-circle nav-icon blue"></i>
                            <p>Ventas</p>
                        </a>
                    </router-link>
                </div>
                <div class="nav-item">
                    <router-link to="/reporte-ventas" class="nav-link">
                        <a class="nav-link collapsed " style="margin-left: -1rem;padding-left: 2.5rem; font-size: 0.85rem">
                            <i class="fas fa-dot-circle nav-icon blue"></i>
                            <p>Reportes</p>
                        </a>
                    </router-link>
                </div>
                @endif
            </div>
        </li>
        @endif
        @if (in_array(Auth::user()->role_id, [1, 4, 6, 5, 8]))
        <li class="settings-items nav-item ">
            <a class="nav-link collapsed nav-seeker" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-wrench nav-icon blue"></i>
                <p>ODIS</p>
            </a>
            <div id="collapseTwo" class="collapse sub-item-settings sidebar-submenu">
                @if (in_array(Auth::user()->role_id, [1, 4, 6, 8]))
                <div class="nav-item">
                    <router-link to="/manage-odis" class="nav-link">
                        <a class="nav-link collapsed nav-seeker " style="margin-left: -1rem;padding-left: 2.5rem; font-size: 0.85rem">
                            <i class="fas fa-dot-circle nav-icon blue"></i>
                            <p>Instalaciones</p>
                        </a>
                    </router-link>
                </div>
                @endif
                @if (in_array(Auth::user()->role_id, [1, 4]))
                <div class="nav-item">
                    <router-link to="/install-odis" class="nav-link">
                        <a class="nav-link collapsed nav-seeker " style="margin-left: -1rem;padding-left: 2.5rem; font-size: 0.85rem">
                            <i class="fas fa-dot-circle nav-icon blue"></i>
                            <p>Instalaciones Pendientes</p>
                        </a>
                    </router-link>
                </div>
                @endif
                @if (in_array(Auth::user()->role_id, [5]))
                <div class="nav-item">
                    <router-link to="/install-odis" class="nav-link">
                        <a class="nav-link collapsed nav-seeker " style="margin-left: -1rem;padding-left: 2.5rem; font-size: 0.85rem">
                            <i class="fas fa-dot-circle nav-icon blue"></i>
                            <p>Instalaciones</p>
                        </a>
                    </router-link>
                </div>
                @endif
                @if (in_array(Auth::user()->role_id, [1, 4, 6, 8]))
                <div class="nav-item">
                    <router-link to="/reporte-odi" class="nav-link">
                        <a class="nav-link collapsed nav-seeker " style="margin-left: -1rem;padding-left: 2.5rem; font-size: 0.85rem">
                            <i class="fas fa-dot-circle nav-icon blue"></i>
                            <p>Reportes</p>
                        </a>
                    </router-link>
                </div>
                @endif
            </div>

        </li>
        @endif
        @if (in_array(Auth::user()->role_id, [1]))
        <li class="nav-item">
            <router-link to="/contracts" class="nav-link">
                <i class="fa fa-id-badge nav-icon blue"></i>
                <p>Contratos</p>
            </router-link>
        </li>
        @endif
        {{--@if (in_array(Auth::user()->role_id, [1]))
            <li class="nav-item">
                <router-link to="/users" class="nav-link">
                    <i class="fa fa-users nav-icon blue"></i>
                    <p>Usuarios</p>
                </router-link>
            </li>
        @endif--}}
        @if (in_array(Auth::user()->role_id, [1, 3, 7]))
        <li class="nav-item">
            <router-link to="/configurations" class="nav-link">
                <i class="fa fa-cog nav-icon blue"></i>
                <p>Configuraciones</p>
            </router-link>
        </li>
        @endif






        <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-power-off red"></i>
                <p>
                    {{ __('Logout') }}
                </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
