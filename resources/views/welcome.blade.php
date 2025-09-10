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
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #1e293b;
            --accent-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--secondary-color) 0%, #334155 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 0 15px 15px 0;
            min-height: 100vh;
        }

        .sidebar-brand {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            margin: 1rem;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-item {
            margin: 0.5rem 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .nav-item a {
            color: #cbd5e1;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-item a i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        .nav-item a:hover {
            background: rgba(59, 130, 246, 0.2);
            color: white;
            transform: translateX(5px);
        }

        .nav-item a.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .main-content {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin: 1rem;
            min-height: calc(100vh - 2rem);
        }

        .content-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%);
            color: white;
            padding: 2rem;
            border-radius: 20px 20px 0 0;
            margin-bottom: 0;
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            display: inline-block;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: white;
        }

        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .btn-modern {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-modern:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }

        .btn-modern:hover:before {
            left: 100%;
        }

        .table-modern {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table-modern thead th {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            font-weight: 600;
            padding: 1rem;
            border: none;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
        }

        .table-modern tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.01);
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .mobile-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                z-index: 1000;
                transition: left 0.3s ease;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .mobile-toggle {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Mobile Toggle Button -->
            <button class="mobile-toggle btn btn-primary position-fixed" 
                    style="top: 1rem; left: 1rem; z-index: 1001; border-radius: 12px;"
                    onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Sidebar -->
            <nav class="col-lg-2 col-md-3 sidebar" id="sidebar">
                <div class="sidebar-brand">
                    <i class="fas fa-chart-line text-primary mb-2" style="font-size: 2rem;"></i>
                    <h4 class="text-white mb-0">API Dashboard</h4>
                    <small class="text-muted">Data Management</small>
                </div>

                <div class="mt-4">
                    @foreach($modules as $mod)
                        <div class="nav-item">
                            <a href="{{ route('module.show', $mod) }}"
                               class="{{ $activeModule == $mod ? 'active' : '' }}">
                                <i class="fas {{ getModuleIcon($mod) }}"></i>
                                {{ ucfirst($mod) }}
                                @if($activeModule == $mod)
                                    <span class="ms-auto">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Footer in sidebar -->
                <div class="mt-auto p-3 text-center" style="margin-top: auto;">
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

        // Auto-dismiss alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                if (alert.querySelector('.btn-close')) {
                    alert.querySelector('.btn-close').click();
                }
            });
        }, 5000);
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