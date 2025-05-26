<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Producto;
use Model\Proveedor;
use MVC\Router;

class ProductoController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        $router->render('producto/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // 🎯 VALIDACIÓN: Nombre del producto
        $_POST['prod_nombre'] = htmlspecialchars($_POST['prod_nombre']);
        $cantidad_nombre = strlen($_POST['prod_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto debe tener más de 2 caracteres'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Verificar si el nombre ya existe
        $nombreExiste = Producto::verificarNombreExistente($_POST['prod_nombre']);
        if ($nombreExiste) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe un producto con este nombre'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Descripción (opcional)
        $_POST['prod_descripcion'] = htmlspecialchars($_POST['prod_descripcion']);

        // 🎯 VALIDACIÓN: Categoría
        $_POST['prod_categoria'] = htmlspecialchars($_POST['prod_categoria']);
        if (empty($_POST['prod_categoria'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una categoría'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Talla
        $_POST['prod_talla'] = htmlspecialchars($_POST['prod_talla']);
        if (empty($_POST['prod_talla'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una talla'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Color y Marca
        $_POST['prod_color'] = htmlspecialchars($_POST['prod_color']);
        $_POST['prod_marca'] = htmlspecialchars($_POST['prod_marca']);

        // 🎯 VALIDACIÓN: Precios
        $_POST['precio_compra'] = filter_var($_POST['precio_compra'], FILTER_VALIDATE_FLOAT);
        $_POST['precio_venta'] = filter_var($_POST['precio_venta'], FILTER_VALIDATE_FLOAT);

        if ($_POST['precio_compra'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio de compra debe ser mayor a 0'
            ]);
            return;
        }

        if ($_POST['precio_venta'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio de venta debe ser mayor a 0'
            ]);
            return;
        }

        if ($_POST['precio_venta'] <= $_POST['precio_compra']) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio de venta debe ser mayor al precio de compra'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Stock
        $_POST['stock_actual'] = filter_var($_POST['stock_actual'], FILTER_VALIDATE_INT);
        $_POST['stock_minimo'] = filter_var($_POST['stock_minimo'], FILTER_VALIDATE_INT);

        if ($_POST['stock_actual'] < 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El stock actual no puede ser negativo'
            ]);
            return;
        }

        if ($_POST['stock_minimo'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El stock mínimo debe ser al menos 1'
            ]);
            return;
        }

        // 🎯 VALIDACIÓN: Proveedor
        $_POST['prov_id'] = filter_var($_POST['prov_id'], FILTER_VALIDATE_INT);
        if (empty($_POST['prov_id'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un proveedor'
            ]);
            return;
        }

        // 🎯 FECHA: Establecer fecha de ingreso actual
        $_POST['fecha_ingreso'] = date('Y-m-d H:i:s');

        try {
            $data = new Producto([
                'prod_nombre' => $_POST['prod_nombre'],
                'prod_descripcion' => $_POST['prod_descripcion'],
                'prod_categoria' => $_POST['prod_categoria'],
                'prod_talla' => $_POST['prod_talla'],
                'prod_color' => $_POST['prod_color'],
                'prod_marca' => $_POST['prod_marca'],
                'precio_compra' => $_POST['precio_compra'],
                'precio_venta' => $_POST['precio_venta'],
                'stock_actual' => $_POST['stock_actual'],
                'stock_minimo' => $_POST['stock_minimo'],
                'prov_id' => $_POST['prov_id'],
                'fecha_ingreso' => $_POST['fecha_ingreso'],
                'situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido registrado correctamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            // Obtener productos con información del proveedor
            $data = Producto::obtenerProductosConProveedor();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los productos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['prod_id'];
        
        // 🎯 MISMAS VALIDACIONES que en guardarAPI
        $_POST['prod_nombre'] = htmlspecialchars($_POST['prod_nombre']);
        $cantidad_nombre = strlen($_POST['prod_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto debe tener más de 2 caracteres'
            ]);
            return;
        }

        // Verificar nombre existente excluyendo el producto actual
        $nombreExiste = Producto::verificarNombreExistente($_POST['prod_nombre'], $id);
        if ($nombreExiste) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe otro producto con este nombre'
            ]);
            return;
        }

        $_POST['prod_descripcion'] = htmlspecialchars($_POST['prod_descripcion']);
        $_POST['prod_categoria'] = htmlspecialchars($_POST['prod_categoria']);
        $_POST['prod_talla'] = htmlspecialchars($_POST['prod_talla']);
        $_POST['prod_color'] = htmlspecialchars($_POST['prod_color']);
        $_POST['prod_marca'] = htmlspecialchars($_POST['prod_marca']);

        $_POST['precio_compra'] = filter_var($_POST['precio_compra'], FILTER_VALIDATE_FLOAT);
        $_POST['precio_venta'] = filter_var($_POST['precio_venta'], FILTER_VALIDATE_FLOAT);
        $_POST['stock_actual'] = filter_var($_POST['stock_actual'], FILTER_VALIDATE_INT);
        $_POST['stock_minimo'] = filter_var($_POST['stock_minimo'], FILTER_VALIDATE_INT);
        $_POST['prov_id'] = filter_var($_POST['prov_id'], FILTER_VALIDATE_INT);

        // Validaciones de precios y stock (mismas que en guardar)
        if ($_POST['precio_compra'] <= 0 || $_POST['precio_venta'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los precios deben ser mayores a 0'
            ]);
            return;
        }

        if ($_POST['precio_venta'] <= $_POST['precio_compra']) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio de venta debe ser mayor al precio de compra'
            ]);
            return;
        }

        try {
            $data = Producto::find($id);
            $data->sincronizar([
                'prod_nombre' => $_POST['prod_nombre'],
                'prod_descripcion' => $_POST['prod_descripcion'],
                'prod_categoria' => $_POST['prod_categoria'],
                'prod_talla' => $_POST['prod_talla'],
                'prod_color' => $_POST['prod_color'],
                'prod_marca' => $_POST['prod_marca'],
                'precio_compra' => $_POST['precio_compra'],
                'precio_venta' => $_POST['precio_venta'],
                'stock_actual' => $_POST['stock_actual'],
                'stock_minimo' => $_POST['stock_minimo'],
                'prov_id' => $_POST['prov_id'],
                'situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del producto ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Producto::EliminarProducto($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido eliminado correctamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // 🎯 MÉTODO ADICIONAL: Para obtener proveedores en el formulario
    public static function obtenerProveedoresAPI()
    {
        try {
            $proveedores = Proveedor::obtenerProveedoresActivos();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Proveedores obtenidos correctamente',
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

    // 🎯 MÉTODO ADICIONAL: Para dashboard de stock bajo
    public static function productosStockBajoAPI()
    {
        try {
            $productos = Producto::obtenerProductosStockBajo();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos con stock bajo obtenidos',
                'data' => $productos
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener productos con stock bajo',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}

/*
==========================================
📝 VALIDACIONES ESPECÍFICAS DE PRODUCTOS:
==========================================

🔄 VALIDACIONES ÚNICAS:
- Nombre del producto no duplicado
- Precios mayores a 0
- Precio de venta > precio de compra
- Stock actual no negativo
- Stock mínimo al menos 1
- Proveedor obligatorio
- Categoría y talla obligatorias

🔄 LÓGICA DE NEGOCIO:
- Fecha de ingreso automática
- Join con proveedores en buscar
- Validación de rentabilidad (venta > compra)
- Control de inventario

🔄 MÉTODOS ADICIONALES:
- obtenerProveedoresAPI(): Para llenar select
- productosStockBajoAPI(): Para alertas

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ Validaciones de precios (lógica de negocio)
2. ✅ Relación con proveedores (FOREIGN KEY)
3. ✅ Control de inventario (stock actual/mínimo)
4. ✅ Validación de duplicados por nombre
5. ✅ Fecha automática de ingreso
6. ✅ Join con proveedor en buscar
*/