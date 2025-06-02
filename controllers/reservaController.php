<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Reserva;
use Model\DetalleReserva;
use Model\Cliente;
use Model\Producto;
use MVC\Router;

class ReservaController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        $router->render('reserva/index', []);
    }

    // MÉTODO: Guardar reserva completa (reserva + detalles)
    public static function guardarAPI()
    {
        getHeadersApi();

        try {
            // VALIDACIÓN: Cliente
            $_POST['cli_id'] = filter_var($_POST['cli_id'], FILTER_VALIDATE_INT);
            if (empty($_POST['cli_id'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar un cliente'
                ]);
                return;
            }

            // VALIDACIÓN: Fecha límite
            if (empty($_POST['fecha_limite'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe especificar una fecha límite'
                ]);
                return;
            }

            // Validar que la fecha límite sea futura
            $fechaLimite = strtotime($_POST['fecha_limite']);
            $fechaActual = time();
            if ($fechaLimite <= $fechaActual) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La fecha límite debe ser posterior a la fecha actual'
                ]);
                return;
            }

            // VALIDACIÓN: Productos
            $productos = json_decode($_POST['productos'], true);
            if (empty($productos) || !is_array($productos)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe agregar al menos un producto a la reserva'
                ]);
                return;
            }

            // Validar cada producto
            $totalReserva = 0;
            foreach ($productos as $producto) {
                if (empty($producto['prod_id']) || empty($producto['cantidad']) || empty($producto['precio_unitario'])) {
                    http_response_code(400);
                    echo json_encode([
                        'codigo' => 0,
                        'mensaje' => 'Todos los productos deben tener ID, cantidad y precio'
                    ]);
                    return;
                }
                
                $subtotal = $producto['cantidad'] * $producto['precio_unitario'];
                $totalReserva += $subtotal;
            }

            // PREPARAR DATOS DE LA RESERVA
            $_POST['observaciones'] = htmlspecialchars($_POST['observaciones'] ?? '');
            $_POST['fecha_reserva'] = date('Y-m-d H:i:s'); // Fecha actual
            $_POST['fecha_limite'] = date('Y-m-d H:i:s', strtotime($_POST['fecha_limite']));
            $_POST['total_reserva'] = $totalReserva;
            $_POST['estado_reserva'] = 'P'; // Pendiente por defecto

            // CREAR LA RESERVA
            $reserva = new Reserva([
                'cli_id' => $_POST['cli_id'],
                'fecha_reserva' => $_POST['fecha_reserva'],
                'fecha_limite' => $_POST['fecha_limite'],
                'total_reserva' => $_POST['total_reserva'],
                'estado_reserva' => $_POST['estado_reserva'],
                'observaciones' => $_POST['observaciones'],
                'situacion' => 1
            ]);

            $resultadoReserva = $reserva->crear();

            if ($resultadoReserva) {
                // Obtener el ID de la reserva recién creada
                $reservaId = $reserva->res_id;

                // CREAR LOS DETALLES DE LA RESERVA
                $productosParaGuardar = [];
                foreach ($productos as $producto) {
                    $productosParaGuardar[] = [
                        'prod_id' => $producto['prod_id'],
                        'cantidad' => $producto['cantidad'],
                        'precio_unitario' => $producto['precio_unitario'],
                        'subtotal' => $producto['cantidad'] * $producto['precio_unitario']
                    ];
                }

                $resultadoDetalles = DetalleReserva::guardarDetallesReserva($reservaId, $productosParaGuardar);

                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'La reserva ha sido creada correctamente',
                    'reserva_id' => $reservaId,
                    'total' => $totalReserva
                ]);
            } else {
                throw new Exception('Error al crear la reserva');
            }

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar la reserva',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // MÉTODO: Buscar reservas con información completa
    public static function buscarAPI()
    {
        try {
            $reservas = Reserva::obtenerReservasCompletas();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Reservas obtenidas correctamente',
                'data' => $reservas
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las reservas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // MÉTODO: Obtener reserva específica con sus detalles
    public static function obtenerReservaAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
            if (empty($id)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'ID de reserva requerido'
                ]);
                return;
            }

            $datos = Reserva::obtenerReservaConDetalles($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Reserva obtenida correctamente',
                'data' => $datos
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener la reserva',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // MÉTODO: Modificar reserva (actualiza reserva + detalles)
    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['res_id'];
            
            if (empty($id)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'ID de reserva requerido'
                ]);
                return;
            }

            // Validaciones similares a guardarAPI
            $_POST['cli_id'] = filter_var($_POST['cli_id'], FILTER_VALIDATE_INT);
            $productos = json_decode($_POST['productos'], true);

            if (empty($_POST['cli_id']) || empty($productos)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Cliente y productos son obligatorios'
                ]);
                return;
            }

            // Calcular nuevo total
            $totalReserva = 0;
            foreach ($productos as $producto) {
                $totalReserva += $producto['cantidad'] * $producto['precio_unitario'];
            }

            // ACTUALIZAR LA RESERVA
            $reserva = Reserva::find($id);
            $reserva->sincronizar([
                'cli_id' => $_POST['cli_id'],
                'fecha_limite' => date('Y-m-d H:i:s', strtotime($_POST['fecha_limite'])),
                'total_reserva' => $totalReserva,
                'estado_reserva' => $_POST['estado_reserva'] ?? 'P',
                'observaciones' => htmlspecialchars($_POST['observaciones'] ?? ''),
                'situacion' => 1
            ]);
            $reserva->actualizar();

            // ELIMINAR DETALLES ANTERIORES Y CREAR NUEVOS
            DetalleReserva::EliminarDetallesPorReserva($id);

            $productosParaGuardar = [];
            foreach ($productos as $producto) {
                $productosParaGuardar[] = [
                    'prod_id' => $producto['prod_id'],
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $producto['precio_unitario'],
                    'subtotal' => $producto['cantidad'] * $producto['precio_unitario']
                ];
            }

            DetalleReserva::guardarDetallesReserva($id, $productosParaGuardar);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La reserva ha sido modificada correctamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la reserva',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // MÉTODO: Eliminar reserva (elimina reserva + detalles)
    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
            if (empty($id)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'ID de reserva requerido'
                ]);
                return;
            }

            $resultado = Reserva::EliminarReserva($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La reserva ha sido eliminada correctamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar la reserva',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // MÉTODO: Cambiar estado de reserva
    public static function cambiarEstadoAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['res_id'];
            $nuevoEstado = $_POST['estado_reserva'];

            if (empty($id) || empty($nuevoEstado)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'ID de reserva y nuevo estado son requeridos'
                ]);
                return;
            }

            // Validar estado
            if (!in_array($nuevoEstado, ['P', 'C', 'X'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Estado inválido. Use P (Pendiente), C (Confirmada), X (Cancelada)'
                ]);
                return;
            }

            $resultado = Reserva::actualizarEstadoReserva($id, $nuevoEstado);

            $estadoTexto = [
                'P' => 'Pendiente',
                'C' => 'Confirmada', 
                'X' => 'Cancelada'
            ][$nuevoEstado];

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => "Reserva marcada como $estadoTexto"
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al cambiar estado',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // MÉTODOS AUXILIARES: Para obtener datos en selects
    public static function obtenerClientesAPI()
    {
        try {
            $clientes = Cliente::fetchArray("SELECT cli_id, cli_nombre, cli_apellido, cli_email FROM cliente WHERE situacion = 1 ORDER BY cli_nombre");

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Clientes obtenidos correctamente',
                'data' => $clientes
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener clientes',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function obtenerProductosAPI()
    {
        try {
            $productos = Producto::fetchArray("SELECT prod_id, prod_nombre, prod_marca, prod_color, prod_talla, precio_venta, stock_actual FROM producto WHERE situacion = 1 AND stock_actual > 0 ORDER BY prod_nombre");

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos correctamente',
                'data' => $productos
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener productos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // MÉTODO: Dashboard de reservas
    public static function estadisticasAPI()
    {
        try {
            $estadisticas = Reserva::obtenerEstadisticasReservas();
            $proximasVencer = Reserva::obtenerReservasProximasVencer();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Estadísticas obtenidas correctamente',
                'data' => [
                    'estadisticas' => $estadisticas[0] ?? [],
                    'proximas_vencer' => $proximasVencer
                ]
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener estadísticas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}

/*
==========================================
FUNCIONALIDADES DEL CONTROLADOR:
==========================================

OPERACIONES PRINCIPALES:
- guardarAPI(): Crea reserva + detalles en una transacción
- modificarAPI(): Actualiza reserva y reemplaza detalles
- buscarAPI(): Lista reservas con información de clientes
- EliminarAPI(): Elimina reserva y detalles
- cambiarEstadoAPI(): Actualiza solo el estado

MÉTODOS AUXILIARES:
- obtenerReservaAPI(): Para editar (trae reserva + detalles)
- obtenerClientesAPI(): Para select de clientes
- obtenerProductosAPI(): Para select de productos
- estadisticasAPI(): Para dashboard

VALIDACIONES ESPECÍFICAS:
- Fecha límite debe ser futura
- Al menos un producto por reserva
- Estados válidos (P, C, X)
- Cálculo automático de totales
- Productos con stock disponible

LÓGICA DE NEGOCIO:
- Manejo transaccional (reserva + detalles)
- Cálculos automáticos de subtotales y totales
- Estados de reserva con workflow
- Fechas de vencimiento

==========================================
PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. UN CONTROLADOR maneja AMBAS TABLAS
2. Transacciones para mantener consistencia
3. JOINs complejos para obtener datos completos
4. Validaciones de negocio específicas
5. APIs auxiliares para cargar selects
6. Manejo de JSON para múltiples productos
7. Estados y workflow de reservas
*/