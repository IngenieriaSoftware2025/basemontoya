<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Proveedor;
use MVC\Router;

class ProveedorController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        $router->render('proveedor/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // 🎯 VALIDACIÓN: Nombre del proveedor
        $_POST['prov_nombre'] = htmlspecialchars($_POST['prov_nombre']);
        $cantidad_nombre = strlen($_POST['prov_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del proveedor debe tener más de 2 caracteres'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Empresa (opcional pero si se llena, mínimo 2 caracteres)
        $_POST['prov_empresa'] = htmlspecialchars($_POST['prov_empresa']);
        if (!empty($_POST['prov_empresa']) && strlen($_POST['prov_empresa']) < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la empresa debe tener más de 2 caracteres'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Teléfono
        $_POST['prov_telefono'] = filter_var($_POST['prov_telefono'], FILTER_VALIDATE_INT);
        if (strlen($_POST['prov_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El teléfono debe tener exactamente 8 dígitos'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: NIT
        $_POST['prov_nit'] = filter_var($_POST['prov_nit'], FILTER_SANITIZE_NUMBER_INT);
        
        // 🎯 VALIDACIÓN: Email
        $_POST['prov_email'] = filter_var($_POST['prov_email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($_POST['prov_email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electrónico ingresado es inválido'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Dirección
        $_POST['prov_direccion'] = htmlspecialchars($_POST['prov_direccion']);

        try {
            $data = new Proveedor([
                'prov_nombre' => $_POST['prov_nombre'],
                'prov_empresa' => $_POST['prov_empresa'],
                'prov_nit' => $_POST['prov_nit'],
                'prov_telefono' => $_POST['prov_telefono'],
                'prov_email' => $_POST['prov_email'],
                'prov_direccion' => $_POST['prov_direccion'],
                'situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El proveedor ha sido registrado correctamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el proveedor',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $sql = "SELECT * FROM proveedor WHERE situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Proveedores obtenidos correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los proveedores',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['prov_id'];
        
        // 🎯 MISMAS VALIDACIONES que en guardarAPI
        $_POST['prov_nombre'] = htmlspecialchars($_POST['prov_nombre']);
        $cantidad_nombre = strlen($_POST['prov_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del proveedor debe tener más de 2 caracteres'
            ]);
            return;
        }

        $_POST['prov_empresa'] = htmlspecialchars($_POST['prov_empresa']);
        if (!empty($_POST['prov_empresa']) && strlen($_POST['prov_empresa']) < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la empresa debe tener más de 2 caracteres'
            ]);
            return;
        }

        $_POST['prov_telefono'] = filter_var($_POST['prov_telefono'], FILTER_VALIDATE_INT);
        if (strlen($_POST['prov_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El teléfono debe tener exactamente 8 dígitos'
            ]);
            return;
        }

        $_POST['prov_nit'] = filter_var($_POST['prov_nit'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['prov_email'] = filter_var($_POST['prov_email'], FILTER_SANITIZE_EMAIL);
        $_POST['prov_direccion'] = htmlspecialchars($_POST['prov_direccion']);

        if (!filter_var($_POST['prov_email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electrónico ingresado es inválido'
            ]);
            return;
        }

        try {
            $data = Proveedor::find($id);
            $data->sincronizar([
                'prov_nombre' => $_POST['prov_nombre'],
                'prov_empresa' => $_POST['prov_empresa'],
                'prov_nit' => $_POST['prov_nit'],
                'prov_telefono' => $_POST['prov_telefono'],
                'prov_email' => $_POST['prov_email'],
                'prov_direccion' => $_POST['prov_direccion'],
                'situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del proveedor ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el proveedor',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Proveedor::EliminarProveedor($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El proveedor ha sido eliminado correctamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el proveedor',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // 🎯 MÉTODO ADICIONAL: Para obtener proveedores en otros módulos
    public static function obtenerProveedoresAPI()
    {
        try {
            $proveedores = Proveedor::obtenerProveedoresActivos();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Proveedores obtenidos para select',
                'data' => $proveedores
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener proveedores',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}

/*
==========================================
📝 DIFERENCIAS CON CLIENTE:
==========================================

🔄 CAMBIOS PRINCIPALES:
- Todos los campos con prefijo prov_
- No tiene validación de países
- No tiene validación de estados
- prov_empresa es opcional
- Método adicional obtenerProveedoresAPI() para usar en productos

🔄 VALIDACIONES ESPECÍFICAS:
- prov_empresa puede estar vacía
- Mismas validaciones de email y teléfono
- NIT sin validación específica de Guatemala

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ Cambiar TODOS los prefijos cli_ → prov_
2. ✅ Usar tabla 'proveedor'
3. ✅ Mensajes específicos para proveedores
4. ✅ Método obtenerProveedoresAPI() para productos
5. ✅ Validaciones más simples que clientes
*/