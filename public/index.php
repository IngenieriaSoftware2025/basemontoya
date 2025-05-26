<?php 
require_once __DIR__ . '/../includes/app.php';


use Controllers\clienteController;  // 🎯 AGREGAR: Importar ClienteController
use MVC\Router;
use Controllers\AppController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

//Rutas Principales
$router->get('/', [AppController::class,'index']);

//Vistas
$router->get('/cliente', [clienteController::class, 'renderizarPagina']);

// 🎯 AGREGAR: RUTAS PARA CLIENTES (SIGUIENDO EL MISMO PATRÓN)
$router->get('/cliente', [ClienteController::class, 'renderizarPagina']);
$router->post('/clientes/guardarAPI', [ClienteController::class, 'guardarAPI']);
$router->get('/clientes/buscarAPI', [ClienteController::class, 'buscarAPI']);
$router->post('/clientes/modificarAPI', [ClienteController::class, 'modificarAPI']);
$router->get('/clientes/eliminar', [ClienteController::class, 'EliminarAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();

/*
==========================================
📝 QUÉ CAMBIAR SI TE TOCA OTRA ENTIDAD:
==========================================

🔄 Si te toca PRODUCTOS:
use Controllers\ProductoController;

$router->get('/producto', [ProductoController::class, 'renderizarPagina']);
$router->post('/productos/guardarAPI', [ProductoController::class, 'guardarAPI']);
$router->get('/productos/buscarAPI', [ProductoController::class, 'buscarAPI']);
$router->post('/productos/modificarAPI', [ProductoController::class, 'modificarAPI']);
$router->get('/productos/eliminar', [ProductoController::class, 'EliminarAPI']);

🔄 Si te toca EMPLEADOS:
use Controllers\EmpleadoController;

$router->get('/empleado', [EmpleadoController::class, 'renderizarPagina']);
$router->post('/empleados/guardarAPI', [EmpleadoController::class, 'guardarAPI']);
$router->get('/empleados/buscarAPI', [EmpleadoController::class, 'buscarAPI']);
$router->post('/empleados/modificarAPI', [EmpleadoController::class, 'modificarAPI']);
$router->get('/empleados/eliminar', [EmpleadoController::class, 'EliminarAPI']);

🔄 Si te toca PROVEEDORES:
use Controllers\ProveedorController;

$router->get('/proveedor', [ProveedorController::class, 'renderizarPagina']);
$router->post('/proveedores/guardarAPI', [ProveedorController::class, 'guardarAPI']);
$router->get('/proveedores/buscarAPI', [ProveedorController::class, 'buscarAPI']);
$router->post('/proveedores/modificarAPI', [ProveedorController::class, 'modificarAPI']);
$router->get('/proveedores/eliminar', [ProveedorController::class, 'EliminarAPI']);

==========================================
📋 PATRÓN DE RUTAS QUE SIEMPRE SE REPITE:
==========================================

✅ SINGULAR para mostrar la página:
/entidad (ej: /cliente, /producto, /empleado)

✅ PLURAL para las APIs:
/entidades/guardarAPI
/entidades/buscarAPI  
/entidades/modificarAPI
/entidades/eliminar

==========================================
❌ ERRORES COMUNES QUE DEBES EVITAR:
==========================================

1. ❌ Olvidar el "use Controllers\NombreController;"
2. ❌ Confundir singular/plural en las rutas
3. ❌ No seguir el patrón de nombres
4. ❌ Olvidar importar el controlador
5. ❌ Cambiar los métodos HTTP (GET/POST)

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ SIEMPRE agregar el use Controllers\
2. ✅ La ruta principal es SINGULAR (/cliente)
3. ✅ Las APIs son PLURAL (/clientes/guardarAPI)
4. ✅ Seguir EXACTAMENTE el mismo patrón que usuarios
5. ✅ Los métodos HTTP son importantes: GET para buscar/eliminar, POST para guardar/modificar
6. ✅ El nombre del controlador DEBE coincidir con el import

==========================================
🎯 URLs RESULTANTES PARA CLIENTES:
==========================================

GET  http://localhost/MVC/cliente                    ← Muestra el formulario
POST http://localhost/MVC/clientes/guardarAPI        ← Guarda cliente
GET  http://localhost/MVC/clientes/buscarAPI         ← Lista clientes  
POST http://localhost/MVC/clientes/modificarAPI      ← Modifica cliente
GET  http://localhost/MVC/clientes/eliminar?id=1     ← Elimina cliente
*/