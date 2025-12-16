<!-- Menu Technicien -->
<div class="flex items-center">
    <a href="{{ route('home') }}" class="flex items-center mr-8">
        <img src="{{ asset('images/logo-crefer.png') }}" alt="Logo CREFER" class="h-12 w-auto mr-2">
    </a>
</div>
<div class="hidden md:flex space-x-10">
    <a href="{{ route('home') }}" class="navbar-link {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
    <a href="{{ route('technician.installations') }}" class="navbar-link {{ request()->routeIs('technician.installations') ? 'active' : '' }}">Installations</a>
    <a href="{{ route('technician.maintenance') }}" class="navbar-link {{ request()->routeIs('technician.maintenance') ? 'active' : '' }}">Maintenance</a>
</div>