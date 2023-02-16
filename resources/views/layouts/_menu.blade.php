<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
          <span class="app-brand-text demo menu-text fw-bolder ms-2">Empresa</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Inicio</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Administrar</span>
        </li>

        <li class="menu-item" style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Cuenta">Cuenta</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                <a href="#" class="menu-link">
                    <div data-i18n="Mi perfil">Mi perfil</div>
                </a>
                </li>
                <li class="menu-item">
                <a href="{{ route('logout') }}" class="menu-link">
                    <div data-i18n="Cerrar sesion">Cerrar sesion</div>
                </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @if(Route::is('business.index') || Route::is('user.index')) active open @endif " style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Cuenta">Gestionar</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item @if(Route::is('business.index')) active @endif ">
                <a href="{{ route('business.index') }}" class="menu-link">
                    <div data-i18n="Mi perfil">Empresas</div>
                </a>
                </li>
                <li class="menu-item @if(Route::is('user.index')) active @endif">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <div data-i18n="Cerrar sesion">Usuarios</div>
                </a>
                </li>
                <li class="menu-item">
                <a href="#" class="menu-link">
                    <div data-i18n="Cerrar sesion">Routes</div>
                </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <li class="menu-item">
                <a href="" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div data-i18n="Analytics">Opcion 1</div>
                </a>
            </li>
        </li>
    </ul>
</aside>
<!-- / Menu -->
