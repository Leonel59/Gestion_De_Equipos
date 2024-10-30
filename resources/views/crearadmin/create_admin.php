<?php
use App\Models\User;

User::create([
    'name' => 'Leonel Romero',
    'email' => 'luisleonel596@gmail.com',
    'username' => 'LMejia', // Asegúrate de incluir el campo 'username'
    'password' => bcrypt('Leonel56$'), // Cambia la contraseña según necesites
    'role' => 'admin', // Establece el rol
    
]);
