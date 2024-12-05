<div class="p-6 lg:p-8 bg-white border-b border-gray-200 shadow-md rounded-lg">
    <!-- Logo centrado -->
    <div class="flex justify-center mb-6">
        <x-application-logo class="block h-16 w-auto" />
    </div>

    <!-- Título principal -->
    <h1 class="text-center text-3xl font-semibold text-gray-900">
        Bienvenido
    </h1>

    <!-- Descripción del dashboard -->
    <p class="mt-4 text-center text-gray-600">
        Gestiona tu empresa de manera rápida y eficiente con nuestro panel de administración.
    </p>

    <!-- Cuadrados de información -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <!-- Cuadro de Empleados -->
        <div class="p-4 bg-indigo-100 border border-indigo-200 rounded-lg shadow-md">
            <div class="flex items-center">
                <i class="fas fa-users fa-2x text-indigo-600"></i>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-indigo-800">Empleados</h2>
                    <div class="flex items-center">
                        <a href="{{ url('/empleados') }}" class="text-indigo-600 hover:underline">VER EMPLEADOS</a>
                        <i class="fas fa-info-circle ml-2 text-indigo-600"></i> <!-- Ícono de More Info -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuadro de Reportes -->
        <div class="p-4 bg-green-100 border border-green-200 rounded-lg shadow-md">
            <div class="flex items-center">
                <i class="fas fa-file-alt fa-2x text-green-600"></i>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-green-800">Reportes</h2>
                    
                    <div class="flex items-center">
                        <a href="{{ url('/reportes') }}" class="text-green-600 hover:underline">VER REPORTES</a>
                        <i class="fas fa-info-circle ml-2 text-green-600"></i> <!-- Ícono de More Info -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuadro de Rutas de Asignaciones -->
<div class="p-4 bg-blue-100 border border-blue-200 rounded-lg shadow-md">
    <div class="flex items-center">
        <i class="fas fa-route fa-2x text-blue-600"></i>
        <div class="ml-4">
            <h2 class="text-lg font-semibold text-blue-800">Rutas de Asignaciones</h2>
            <div class="flex items-center">
                <a href="{{ url('/asignaciones') }}" class="text-blue-600 hover:underline">VER ASIGNACIONES</a>
                <i class="fas fa-info-circle ml-2 text-blue-600"></i> <!-- Ícono de More Info -->
            </div>
        </div>
    </div>
</div>

        <!-- Cuadro de Inventario -->
        <div class="p-4 bg-yellow-100 border border-yellow-200 rounded-lg shadow-md">
            <div class="flex items-center">
                <i class="fas fa-box-open fa-2x text-yellow-600"></i>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-yellow-800">Inventario</h2>
                    <div class="flex items-center">
                        <a href="{{ url('/equipos') }}" class="text-yellow-600 hover:underline">VER EQUIPOS</a>
                        <i class="fas fa-info-circle ml-2 text-yellow-600"></i> <!-- Ícono de More Info -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuadro de Servicios -->
<div class="p-4 bg-blue-100 border border-blue-300 rounded-lg shadow-md">
    <div class="flex items-center">
        <i class="fas fa-cogs fa-2x text-blue-600"></i>
        <div class="ml-4">
            <h2 class="text-lg font-semibold text-blue-800">Servicios</h2>
            <div class="flex items-center">
                <a href="{{ url('/servicios') }}" class="text-blue-600 hover:underline">VER SERVICIOS</a>
                <i class="fas fa-info-circle ml-2 text-blue-600"></i> <!-- Ícono de More Info -->
            </div>
        </div>
    </div>
</div>

<!-- Cuadro de Factura -->
<div class="p-4 bg-teal-100 border border-teal-300 rounded-lg shadow-md">
    <div class="flex items-center">
    <i class="fas fa-file-invoice fa-2x text-teal-600"></i>
        <div class="ml-4">
            <h2 class="text-lg font-semibold text-teal-800">Facturas</h2>
            <div class="flex items-center">
                <a href="{{ url('/facturas') }}" class="text-teal-600 hover:underline">VER FACTURAS</a>
                <i class="fas fa-info-circle ml-2 text-teal-600"></i> <!-- Ícono de More Info -->
            </div>
        </div>
    </div>
</div>

    </div>
</div>