<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard API System')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Dashboard JS -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
           <!-- Sidebar -->
            <nav class="sidebar" id="sidebar">
                <!-- Brand -->
                <div class="sidebar-brand">
                    <i class="fas fa-chart-line text-primary mb-2" style="font-size: 2rem;"></i>
                    <h4 class="text-white mb-0">API Dashboard</h4>
                    <small class="text-white">Data Management</small>
                </div>

                <!-- Modules -->
                <div class="mt-4">
                    @foreach($modules as $mod)
                        <div class="nav-item">
                            @if($mod === 'productionprocess')
                                {{-- Modul khusus Production Process dengan 3 submenu --}}
                                <a href="{{ route('dashboard.module', $mod) }}?view=master"
                                class="d-flex justify-content-between align-items-center {{ $activeModule == $mod ? 'active' : '' }}">
                                    <div>
                                        <i class="fas {{ getModuleIcon($mod) }}"></i>
                                        <span>{{ ucfirst($mod) }}</span>
                                    </div>
                                    <i class="fas fa-caret-down"></i>
                                </a>

                                @if($activeModule == $mod)
                                    <div class="ps-4 py-2">
                                        <a href="{{ route('dashboard.module', $mod) }}?view=master" 
                                        class="d-block small mb-1 {{ request('view') == 'master' ? 'active text-white' : 'text-white-50' }}">
                                            Master Data
                                        </a>
                                        <a href="{{ route('dashboard.module', $mod) }}?view=inputs" 
                                        class="d-block small mb-1 {{ request('view') == 'inputs' ? 'active text-white' : 'text-white-50' }}">
                                            Input Items
                                        </a>
                                        <a href="{{ route('dashboard.module', $mod) }}?view=outputs" 
                                        class="d-block small {{ request('view') == 'outputs' ? 'active text-white' : 'text-white-50' }}">
                                            Output Items
                                        </a>
                                    </div>
                                @endif

                            @elseif(array_key_exists($mod, $detailMap))
                                {{-- Modul dengan 2 submenu --}}
                                <a href="{{ route('dashboard.module', $mod) }}?view=master"
                                class="d-flex justify-content-between align-items-center {{ $activeModule == $mod ? 'active' : '' }}">
                                    <div>
                                        <i class="fas {{ getModuleIcon($mod) }}"></i>
                                        <span>{{ ucfirst($mod) }}</span>
                                    </div>
                                    <i class="fas fa-caret-down"></i>
                                </a>

                                @if($activeModule == $mod)
                                    <div class="ps-4 py-2">
                                        <a href="{{ route('dashboard.module', $mod) }}?view=master" 
                                        class="d-block small mb-1 {{ request('view') == 'master' ? 'active text-white' : 'text-white-50' }}">
                                            Master Data
                                        </a>
                                        <a href="{{ route('dashboard.module', $mod) }}?view=detail" 
                                        class="d-block small {{ request('view') == 'detail' ? 'active text-white' : 'text-white-50' }}">
                                            Detail Items
                                        </a>
                                    </div>
                                @endif

                            @else
                                {{-- Modul tanpa detail --}}
                                <a href="{{ route('dashboard.module', $mod) }}" 
                                class="{{ $activeModule == $mod ? 'active' : '' }}">
                                    <i class="fas {{ getModuleIcon($mod) }}"></i>
                                    <span>{{ ucfirst($mod) }}</span>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Footer -->
                <div class="mt-auto p-3 text-center">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Last updated: {{ now()->format('H:i') }}
                    </small>
                </div>
            </nav>


            <!-- Main Content -->
            <main class="col-lg-10 col-md-9 ms-auto">
                <div class="main-content">
                    <!-- Content Header -->
                    <div class="content-header">
                        <nav class="breadcrumb mb-3">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                            <span class="mx-2">/</span>
                            <span>{{ ucfirst($activeModule ?? 'Home') }}</span>
                        </nav>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="mb-2">@yield('page-title', 'Dashboard')</h1>
                                <p class="mb-0 opacity-75">@yield('page-description', 'Kelola data API system Anda')</p>
                            </div>
                            
                            <div class="text-end">
                                @yield('header-actions')
                            </div>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

@php
function getModuleIcon($module) {
    $icons = [
        'users' => 'fa-users',
        'orders' => 'fa-shopping-cart',
        'products' => 'fa-box',
        'reports' => 'fa-chart-bar',
        'settings' => 'fa-cog',
        'default' => 'fa-database'
    ];
    
    return $icons[$module] ?? $icons['default'];
}
@endphp
