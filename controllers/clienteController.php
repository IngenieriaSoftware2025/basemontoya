<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Cliente;  // ✅ CORRECTO - con mayúscula
use MVC\Router;

class ClienteController extends ActiveRecord  // 🎯 CAMBIO: ClienteController en lugar de UsuarioController
{

    // 🎯 CAMBIO: Renderizar vista de clientes
    public static function renderizarPagina(Router $router)
    {
        $router->render('cliente/index', []);  // 🎯 CAMBIO: clientes/index
    }


    //*************************************************************************************** */
    //Guardar

    public static function guardarAPI()
    {

        getHeadersApi();

        // echo json_encode($_POST);
        // return;

        // 🎯 VALIDACIÓN: Apellidos (IGUAL que usuarios)
        $_POST['cli_apellido'] = htmlspecialchars($_POST['cli_apellido']);

        $cantidad_apellidos = strlen($_POST['cli_apellido']);

        if ($cantidad_apellidos < 2) {

            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de digitos que debe de contener el apellido debe de ser mayor a dos'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Nombres (IGUAL que usuarios)
        $_POST['cli_nombre'] = htmlspecialchars($_POST['cli_nombre']);

        $cantidad_nombres = strlen($_POST['cli_nombre']);

        if ($cantidad_nombres < 2) {

            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de digitos que debe de contener el nombre debe de ser mayor a dos'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Teléfono (IGUAL que usuarios)
        $_POST['cli_telefono'] = filter_var($_POST['cli_telefono'], FILTER_VALIDATE_INT);

        if (strlen($_POST['cli_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de digitos de telefono debe de ser igual a 8'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: NIT (IGUAL que usuarios)
        $_POST['cli_nit'] = filter_var($_POST['cli_nit'], FILTER_SANITIZE_NUMBER_INT);
        
        // 🎯 VALIDACIÓN: Email (CAMBIO de campo)
        $_POST['cli_email'] = filter_var($_POST['cli_email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($_POST['cli_email'], FILTER_VALIDATE_EMAIL)) {  // 🎯 CAMBIO: VALIDATE en lugar de SANITIZE
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electronico ingresado es invalido'
            ]);
            return;
        }

        //Verifico si ya esta en la base de datos el nit e email
        $clienteExistente = Cliente::verificarClienteExistente($_POST['cli_email'], $_POST['cli_nit']);
    
    if ($clienteExistente['email_existe']) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Ya existe un cliente registrado con este correo electrónico'
        ]);
        return;
    }

    if ($clienteExistente['nit_existe']) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Ya existe un cliente registrado con este número de NIT'
        ]);
        return;
    }


        // 🎯 NUEVOS CAMPOS: Validar campos específicos de cliente
        $_POST['cli_estado'] = htmlspecialchars($_POST['cli_estado']);
        $_POST['cli_direccion'] = htmlspecialchars($_POST['cli_direccion']);
        $_POST['cli_pais'] = htmlspecialchars($_POST['cli_pais']);
        $_POST['cli_codigo_telefono'] = htmlspecialchars($_POST['cli_codigo_telefono']);

        // 🎯 FECHA: Formatear fecha (IGUAL que usuarios)
        $_POST['cli_fecha'] = date('Y-m-d H:i:s', strtotime($_POST['cli_fecha']));

        $estado = $_POST['cli_estado'];

        // 🎯 CAMBIO: Validación de estados (ACTIVO, INACTIVO, SUSPENDIDO en lugar de P, F, C)
        if ($estado == "ACTIVO" || $estado == "INACTIVO" || $estado == "SUSPENDIDO") {

            try {

                // 🎯 CAMBIO: Crear instancia de Cliente con TODOS los campos
                $data = new Cliente([
                    'cli_nombre' => $_POST['cli_nombre'],
                    'cli_apellido' => $_POST['cli_apellido'],
                    'cli_nit' => $_POST['cli_nit'],
                    'cli_telefono' => $_POST['cli_telefono'],
                    'cli_email' => $_POST['cli_email'],
                    'cli_direccion' => $_POST['cli_direccion'],
                    'cli_estado' => $_POST['cli_estado'],
                    'cli_fecha' => $_POST['cli_fecha'],
                    'cli_pais' => $_POST['cli_pais'],
                    'cli_codigo_telefono' => $_POST['cli_codigo_telefono'],
                    'situacion' => 1
                ]);

                $crear = $data->crear();

                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Exito el cliente ha sido registrado correctamente'  // 🎯 CAMBIO: cliente en lugar de usuario
                ]);
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al guardar',
                    'detalle' => $e->getMessage(),
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los estados solo pueden ser "ACTIVO, INACTIVO, SUSPENDIDO"'  // 🎯 CAMBIO: nuevos estados
            ]);
            return;
        }
    }


    //*************************************************************************** */
    //Buscar
    public static function buscarAPI()
    {

        try {

            // 🎯 CAMBIO: Consulta a tabla cliente
            $sql = "SELECT * FROM cliente where situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Clientes obtenidos correctamente',  // 🎯 CAMBIO: Clientes
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los clientes',  // 🎯 CAMBIO: clientes
                'detalle' => $e->getMessage(),
            ]);
        }
    }



    //*************************************************************************** */
    //Modificar
    public static function modificarAPI()
    {

        getHeadersApi();

        // 🎯 CAMBIO: ID de cliente
        $id = $_POST['cli_id'];
        
        // 🎯 MISMAS VALIDACIONES que en guardarAPI (apellidos)
        $_POST['cli_apellido'] = htmlspecialchars($_POST['cli_apellido']);

        $cantidad_apellidos = strlen($_POST['cli_apellido']);

        if ($cantidad_apellidos < 2) {

            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de digitos que debe de contener el apellido debe de ser mayor a dos'
            ]);
            return;
        }

        // 🎯 MISMAS VALIDACIONES que en guardarAPI (nombres)
        $_POST['cli_nombre'] = htmlspecialchars($_POST['cli_nombre']);

        $cantidad_nombres = strlen($_POST['cli_nombre']);

        if ($cantidad_nombres < 2) {

            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de digitos que debe de contener el nombre debe de ser mayor a dos'
            ]);
            return;
        }

        // 🎯 MISMAS VALIDACIONES que en guardarAPI (teléfono)
        $_POST['cli_telefono'] = filter_var($_POST['cli_telefono'], FILTER_VALIDATE_INT);

        if (strlen($_POST['cli_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de digitos de telefono debe de ser igual a 8'
            ]);
            return;
        }

        $_POST['cli_nit'] = filter_var($_POST['cli_nit'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['cli_email'] = filter_var($_POST['cli_email'], FILTER_SANITIZE_EMAIL);
        $_POST['cli_fecha'] = date('Y-m-d H:i:s', strtotime($_POST['cli_fecha']));  // 🎯 CAMBIO: formato fecha
        $_POST['cli_direccion'] = htmlspecialchars($_POST['cli_direccion']);
        $_POST['cli_pais'] = htmlspecialchars($_POST['cli_pais']);
        $_POST['cli_codigo_telefono'] = htmlspecialchars($_POST['cli_codigo_telefono']);

        if (!filter_var($_POST['cli_email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electronico ingresado es invalido'
            ]);
            return;
        }
        $_POST['cli_estado'] = htmlspecialchars($_POST['cli_estado']);

        $estado = $_POST['cli_estado'];

        if ($estado == "ACTIVO" || $estado == "INACTIVO" || $estado == "SUSPENDIDO") {

            try {

                // 🎯 CAMBIO: Buscar Cliente y sincronizar
                $data = Cliente::find($id);
                $data->sincronizar([
                    'cli_nombre' => $_POST['cli_nombre'],
                    'cli_apellido' => $_POST['cli_apellido'],
                    'cli_nit' => $_POST['cli_nit'],
                    'cli_telefono' => $_POST['cli_telefono'],
                    'cli_email' => $_POST['cli_email'],
                    'cli_direccion' => $_POST['cli_direccion'],
                    'cli_estado' => $_POST['cli_estado'],
                    'cli_fecha' => $_POST['cli_fecha'],
                    'cli_pais' => $_POST['cli_pais'],
                    'cli_codigo_telefono' => $_POST['cli_codigo_telefono'],
                    'situacion' => 1
                ]);
                $data->actualizar();

                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'La informacion del cliente ha sido modificada exitosamente'  // 🎯 CAMBIO: cliente
                ]);
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al guardar',
                    'detalle' => $e->getMessage(),
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los estados solo pueden ser "ACTIVO, INACTIVO, SUSPENDIDO"'
            ]);
            return;
        }
    }

    //****************************************************************** */
    //Eliminar
    public static function EliminarAPI()
    {

        try {

            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            // 🎯 CAMBIO: Usar método de Cliente
            $ejecutar = Cliente::EliminarCliente($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El registro ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al Eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}

/*
==========================================
📝 QUÉ CAMBIAR SI TE TOCA OTRA ENTIDAD:
==========================================

🔄 Si te toca PRODUCTOS:
- use Model\Producto;
- class ProductoController
- $router->render('productos/index', []);
- $_POST['prod_nombre'], $_POST['prod_precio'], etc.
- new Producto([...])
- "SELECT * FROM producto where situacion = 1"
- Producto::find($id)
- Producto::EliminarProducto($id)

🔄 Si te toca EMPLEADOS:
- use Model\Empleado;
- class EmpleadoController
- $_POST['emp_nombre'], $_POST['emp_salario'], etc.
- new Empleado([...])
- "SELECT * FROM empleado where situacion = 1"

==========================================
❌ ERRORES COMUNES QUE DEBES EVITAR:
==========================================

1. ❌ Olvidar cambiar el namespace del modelo (use Model\Cliente)
2. ❌ No cambiar el nombre de la clase (ClienteController)
3. ❌ Usar nombres de campos incorrectos ($_POST['usuario_nombre'] en lugar de $_POST['cli_nombre'])
4. ❌ No actualizar la consulta SQL (FROM usuarios → FROM cliente)
5. ❌ Olvidar cambiar los mensajes de respuesta
6. ❌ No validar campos nuevos específicos de la entidad

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ SIEMPRE cambia el use Model\NombreModelo;
2. ✅ Actualiza TODOS los $_POST['campo'] con los nombres correctos
3. ✅ Cambia las consultas SQL a la tabla correcta
4. ✅ Actualiza las validaciones según los campos de tu entidad
5. ✅ Verifica que los mensajes de error sean coherentes
6. ✅ Incluye TODOS los campos nuevos en el array de creación/modificación
*/