<?php
// Configuración del título dinámico
$titulo_pagina = $titulo_pagina ?? 'Sistema de Papelería';

     session_start();
             
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    
    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    
    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ESTILOS ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 300px;
            background-color: rgb(50, 113, 121);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: 95px;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-header h3 {
            font-size: 1.4rem;
            margin: 0;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .sidebar-header h3 {
            font-size: 0;
        }

        .sidebar.collapsed .sidebar-header h3::first-letter {
            font-size: 1.5rem;
            display: inline-block;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 20px 0;
        }

        .toggle-btn {
            position: absolute;
            top: 20px;
            right: -15px;
            width: 30px;
            height: 30px;
            background: #0f3460;
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .toggle-btn:hover {
            background: #e94560;
            transform: scale(1.1);
        }

        .sidebar.collapsed .toggle-btn i {
            transform: rotate(180deg);
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin: 5px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-item.active {
            background: #e94560;
            box-shadow: 0 5px 15px rgba(233, 69, 96, 0.3);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-link i {
            width: 30px;
            font-size: 1.2rem;
        }

        .nav-text {
            margin-left: 10px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-text {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .nav-link i {
            width: auto;
            font-size: 1.3rem;
        }

        /* Submenú */
        .nav-submenu {
            list-style: none;
            padding-left: 45px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .sidebar.collapsed .nav-submenu {
            padding-left: 0;
        }

        .nav-item.open .nav-submenu {
            max-height: 300px;
        }

        .nav-submenu .nav-link {
            padding: 8px 20px;
            font-size: 0.9rem;
        }

        .nav-submenu .nav-link i {
            font-size: 0.9rem;
            width: 25px;
        }

        .has-submenu {
            position: relative;
        }

        .has-submenu > .nav-link::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .nav-item.open > .nav-link::after {
            transform: rotate(180deg);
        }

        .sidebar.collapsed .has-submenu > .nav-link::after {
            display: none;
        }

        /* Tooltip para sidebar colapsado */
        .sidebar.collapsed .nav-item:hover .nav-text {
            position: absolute;
            left: 70px;
            background: #1a1a2e;
            padding: 8px 15px;
            border-radius: 10px;
            white-space: nowrap;
            z-index: 1002;
            display: block;
            margin-left: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
            padding: 20px;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            border-radius: 15px;
            padding: 15px 25px;
            margin-left:20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #e94560;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Cards */
        .card-custom {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
            margin-left:20px;
        }

        /* Botones */
        .btn-custom-primary {
            background: #e94560;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .logo{
            width: 80px;
            height: auto;
            margin-right: 10px;
        }

        .btn-custom-primary:hover {
            background: #c73e56;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(233, 69, 96, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }
            .sidebar .nav-text {
                display: none;
            }
            .sidebar .nav-link {
                justify-content: center;
                padding: 12px 0;
            }
            .main-content {
                margin-left: 80px;
            }
            .sidebar-header h3 {
                font-size: 0;
            }
            .sidebar-header h3::first-letter {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <button class="toggle-btn" id="toggleSidebar">
        <i class="fas fa-chevron-left"></i>
    </button>
    
    <div class="sidebar-header">
        <h3><img src="/PapeApp/vistas/mnt_login/img/logo_transparente.png" alt="logo" class = "logo">Papelería El Tec</h3>
    </div>
    
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="../mnt_inicio" class="nav-link">
                <i class="fas fa-tachometer-alt"></i>
                <span class="nav-text">Inicio</span>
            </a>
        </li>
        
        <li class="nav-item has-submenu">
            <a class="nav-link">
                <i class="fas fa-boxes"></i>
                <span class="nav-text">Inventario</span>
            </a>
            <ul class="nav-submenu">
                <li class="nav-item">
                    <a href="../mnt_producto" class="nav-link">
                        <i class="fas fa-box"></i>
                        <span class="nav-text">Productos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../mnt_categoria" class="nav-link">
                        <i class="fas fa-tags"></i>
                        <span class="nav-text">Categorías</span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item has-submenu">
            <a class="nav-link">
                <i class="fas fa-exchange-alt"></i>
                <span class="nav-text">Movimientos</span>
            </a>
            <ul class="nav-submenu">
                <li class="nav-item">
                    <a href="../mnt_venta" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="nav-text">Ventas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../mnt_compra" class="nav-link">
                        <i class="fas fa-truck"></i>
                        <span class="nav-text">Compras</span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item">
            <a href="../mnt_proveedor" class="nav-link">
                <i class="fas fa-handshake"></i>
                <span class="nav-text">Proveedores</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="../mnt_pedido" class="nav-link">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="nav-text">Pedidos</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="../mnt_pedido" class="nav-link">
                <i class="fa-jelly-fill fa-regular fa-chart-bar"></i>
                <span class="nav-text">Reportes</span>
            </a>
        </li>
        
        
        <li class="nav-item">
            <a href="../mnt_usuario" class="nav-link">
                <i class="fas fa-users"></i>
                <span class="nav-text">Usuarios</span>
            </a>
        </li>
        

        
        <li class="nav-item">
            <a onclick="confirmarLogout()" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-text">Cerrar Sesión</span>
            </a>
        </li>
    </ul>
</aside>

<!-- MAIN CONTENT -->
<div class="main-content" id="mainContent">
    <div class="top-bar">
        <h4 class="page-title"><?php echo $titulo_pagina; ?></h4>
        <div class="user-info">
            <span><i class="fas fa-user"></i> <?php echo $_SESSION['nombre_usuario'] ?? 'Usuario';?></span>
            <br>
            <span><?php echo $_SESSION['rol'] ?? 'rol';?></span>
            <div class="user-avatar">
                <?php echo strtoupper(substr($_SESSION['nombre_usuario'] ?? 'U', 0, 1)); ?>
            </div>
        </div>
    </div>
    
    <div class="card-custom">

<script>
    // JavaScript para el Sidebar
    $(document).ready(function() {
        // Toggle sidebar
        $('#toggleSidebar').click(function() {
            $('#sidebar').toggleClass('collapsed');
            $('#mainContent').toggleClass('expanded');
            
            // Guardar estado en localStorage
            let isCollapsed = $('#sidebar').hasClass('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });
        
        // Restaurar estado del sidebar
        let savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            $('#sidebar').addClass('collapsed');
            $('#mainContent').addClass('expanded');
        }
        
        // Submenús
        $('.has-submenu > .nav-link').click(function(e) {
            e.preventDefault();
            let parent = $(this).parent('.has-submenu');
            
            // Cerrar otros submenús
            $('.has-submenu').not(parent).removeClass('open');
            
            // Toggle actual
            parent.toggleClass('open');
        });
        
        // Marcar item activo según la URL actual
        let currentUrl = window.location.pathname;
        $('.nav-link').each(function() {
            let href = $(this).attr('href');
            if (href && href !== '#' && currentUrl.includes(href)) {
                $(this).closest('.nav-item').addClass('active');
                // Abrir submenú padre si existe
                $(this).closest('.has-submenu').addClass('open');
            }
        });
    });
    
    // Función para logout
    function confirmarLogout() {
        Swal.fire({
            title: '¿Cerrar sesión?',
            text: "¿Estás seguro de que deseas salir?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#e94560',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../mnt_login';
            }
        });
    }
</script>