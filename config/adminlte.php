<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */
'logo' => '
    <div style="
        display: inline-block; /* Asegura que el bloque sea adecuado */
        animation: fade-in-out 3s infinite; /* Animación de desvanecimiento */
    ">
        <b style="
            background: linear-gradient(to right, green, yellow);
            -webkit-background-clip: text;
            color: transparent;
            font-size: 1.2rem; /* Tamaño más pequeño del texto */
        ">Recarga</b>
        <span style="
            background: linear-gradient(to right, blue, lightblue);
            -webkit-background-clip: text;
            color: transparent;
            font-size: 1.2rem; /* Tamaño más pequeño del texto */
        ">Veloz</span>
    </div>
    <style>
        @keyframes fade-in-out {
            0% {
                opacity: 0; /* Completamente invisible */
            }
            50% {
                opacity: 1; /* Completamente visible */
            }
            100% {
                opacity: 0; /* Vuelve a desaparecer */
            }
        }
    </style>
',

'logo_img' => 'logo/empresafondo.png',  // Ruta relativa desde 'public'
'logo_img_class' => 'brand-image img-circle elevation-1',
'logo_img_style' => 'object-fit: cover; width: 50px; height: 50px;', // Asegúrate de que sea cuadrado
'logo_img_alt' => 'Logo de Recarga Veloz',



    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

   'preloader' => [
    'enabled' => false,
    'mode' => 'fullscreen',  // o 'cwrapper' si prefieres que no cubra toda la pantalla
    'img' => [
        'path' => 'logo/empresa.png',  // Ruta a la imagen de tu logo en la carpeta 'public'
        'alt' => 'Logo de Recarga Veloz',
        'effect' => 'animation__shake',  // Puedes experimentar con otros efectos si prefieres
        'width' => 50,
        'height' => 50,
    ],
],


    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */
'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',



    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '/dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => 'user/profile',

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

'menu' => [
    // Navbar items:
    [
        'type' => 'navbar-search',
        'text' => 'Centro de Ayuda',
        'topnav_right' => false,
    ],
    [
        'type' => 'fullscreen-widget',
        'topnav_right' => true,
    ],
    [
        'type' => 'link',
        'text' => 'Centro de Ayuda',
        'icon' => 'fas fa-question-circle',
        'url'  => '/centroayuda', // Ruta que desees
        'topnav_right' => true,
    ],

    // Sidebar items:
    [
        'type' => 'sidebar-menu-search',
        'text' => 'Buscar',
    ],
    [
        'text' => 'blog',
        'url' => 'admin/blog',
        'can' => 'manage-blog',
    ],
  
    
    ['header' => 'SECCIONES'],

    [
        'text' => 'EMPLEADOS',
        'icon' => 'fas fa-user-tie',
        'icon_color' => 'green',
        'url' => '/empleados',
    ],
    [
        'text' => 'EQUIPOS',
        'icon' => 'fas fa-desktop',
        'icon_color' => 'yellow',
        'url' => '/equipos',
    ],

    [
        'text' => 'ASIGNACION',
        'icon' => 'fas fa-tasks',
        'icon_color' => 'purple',
        'submenu' => [

            [
                'text' => 'SUMINISTROS',
                'url' => '/suministros', // Cambia esto a la URL correcta
                'icon' => 'fas fa-cogs'
            ],

            [
                'text' => 'ASIGNACIONES',
                'url' => '/asignaciones', // Cambia esto a la URL correcta
                'icon' => 'fas fa-clipboard-list'
            ],

            [
                'text' => 'PROVEEDORES',
                'url' => '/proveedor', // Cambia esto a la URL correcta
                'icon' => 'fas fa-truck'
            ],

    ],
],

    [
        'text' => 'MANTENIMIENTOS',
        'icon' => 'fas fa-wrench',
        'icon_color' => 'orange',
        'submenu' => [
            [
                'text' => 'SERVICIOS MANTENIMIENTO',
                'url' => '/servicios', // Cambia esto a la URL correcta
                'icon' => 'fas fa-tools'
            ],
            [
                'text' => 'PRODUCTO MANTENIMIENTO',
                'url' => '/productos', // Cambia esto a la URL correcta
                'icon' => 'fas fa-cogs'
            ],
           
            
        ],
        
    ],

    [
        'text' => 'FACTURAS',
        'url' => '/facturas', // Cambia esto a la URL correcta
        'icon' => 'fas fa-file-invoice',
        'icon_color' => 'blue'
    ],

    [
        'text' => 'REPORTES',
        'icon' => 'fas fa-chart-bar', 
        'icon_color' => 'cyan',
        'url' => '/reportes',
    ],

    ['header' => 'CONFIGURACIONES'],
     
    [
        'text' => 'SEGURIDAD',
        'icon' => 'fas fa-fw fa-lock',
        'submenu' => [
            
            [
                'text' => 'BITACORA',
                'url' => '/bitacora',
                'icon' => 'fas fa-solid fa-clipboard-list'
                
            ],
 
            [
                'text' => 'ROLES',
                'url' => '/roles',
                'icon' => 'fas fa-users-cog fa-fw'
            ],
            [
                'text' => 'GESTION DE INTERFACES',
                'url' => '/objetos',
                'icon' => 'fas fa-users fa-fw',
                
            ],
            [
                'text' => 'USUARIOS',
                'url' => '/usuarios',
                'icon' => 'fas fa-users fa-fw',
                
            ],

            [
                'text' => 'RESPALDO',
                'url' => '/backup',
                'icon' => 'fas fa-database fa-fw',
                
            ],
           
        ],
    ],

],






    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
