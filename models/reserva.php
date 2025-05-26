<?php

namespace Model;

class Reserva extends ActiveRecord {

    // 🎯 PUNTO CLAVE: El nombre de la tabla DEBE coincidir con tu CREATE TABLE
    public static $tabla = 'reserva';
    
    // 🎯 PUNTO CLAVE: Estos campos DEBEN ser EXACTAMENTE los de tu tabla (sin el ID)
    public static $columnasDB = [
        'cli_id',
        'fecha_reserva',
        'fecha_limite',
        'total_reserva',
        'estado_reserva',
        'observaciones',
        'situacion'
    ];

    // 🎯 PUNTO CLAVE: El nombre del ID DEBE coincidir con tu PRIMARY KEY
    public static $idTabla = 'res_id';
    
    // 🎯 PUNTO CLAVE: Declara TODAS las propiedades (incluyendo el ID)
    public $res_id;
    public $cli_id;
    public $fecha_reserva;
    public $fecha_limite;
    public $total_reserva;
    public $estado_reserva;
    public $observaciones;
    public $situacion;

    // 🎯 PUNTO CLAVE: El constructor inicializa TODAS las propiedades
    public function __construct($args = []){
        $this->res_id = $args['res_id'] ?? null;
        $this->cli_id = $args['cli_id'] ?? null;
        $this->fecha_reserva = $args['fecha_reserva'] ?? '';
        $this->fecha_limite = $args['fecha_limite'] ?? '';
        $this->total_reserva = $args['total_reserva'] ?? 0.00;
        $this->estado_reserva = $args['estado_reserva'] ?? 'P';
        $this->observaciones = $args['observaciones'] ?? '';
        $this->situacion = $args['situacion'] ?? 1;
    }

    // 🎯 MÉTODO: Eliminar reserva (elimina también los detalles por CASCADE)
    public static function EliminarReserva($id){
        // Primero eliminar detalles, luego la reserva
        $sqlDetalle = "DELETE FROM detalle_reserva WHERE res_id = $id";
        $resultadoDetalle = self::SQL($sqlDetalle);
        
        $sqlReserva = "DELETE FROM reserva WHERE res_id = $id";
        return self::SQL($sqlReserva);
    }

    // 🎯 MÉTODO: Obtener reservas con información completa
    public static function obtenerReservasCompletas(){
        $sql = "SELECT r.*, c.cli_nombre, c.cli_apellido, c.cli_email, c.cli_telefono
                FROM reserva r 
                LEFT JOIN cliente c ON r.cli_id = c.cli_id 
                WHERE r.situacion = 1 
                ORDER BY r.fecha_reserva DESC";
        return self::fetchArray($sql);
    }

    // 🎯 MÉTODO: Obtener reserva específica con sus detalles
    public static function obtenerReservaConDetalles($id){
        // Obtener información de la reserva
        $sqlReserva = "SELECT r.*, c.cli_nombre, c.cli_apellido 
                       FROM reserva r 
                       LEFT JOIN cliente c ON r.cli_id = c.cli_id 
                       WHERE r.res_id = $id";
        $reserva = self::fetchArray($sqlReserva);
        
        // Obtener detalles de la reserva
        $sqlDetalles = "SELECT dr.*, p.prod_nombre, p.prod_marca, p.prod_color, p.prod_talla
                        FROM detalle_reserva dr 
                        LEFT JOIN producto p ON dr.prod_id = p.prod_id 
                        WHERE dr.res_id = $id AND dr.situacion = 1";
        $detalles = self::fetchArray($sqlDetalles);
        
        return [
            'reserva' => $reserva[0] ?? null,
            'detalles' => $detalles
        ];
    }

    // 🎯 MÉTODO: Obtener estadísticas de reservas
    public static function obtenerEstadisticasReservas(){
        $sql = "SELECT 
                    COUNT(*) as total_reservas,
                    COUNT(CASE WHEN estado_reserva = 'P' THEN 1 END) as reservas_pendientes,
                    COUNT(CASE WHEN estado_reserva = 'C' THEN 1 END) as reservas_confirmadas,
                    COUNT(CASE WHEN estado_reserva = 'X' THEN 1 END) as reservas_canceladas,
                    SUM(total_reserva) as monto_total,
                    AVG(total_reserva) as monto_promedio
                FROM reserva WHERE situacion = 1";
        return self::fetchArray($sql);
    }

    // 🎯 MÉTODO: Obtener reservas por estado
    public static function obtenerReservasPorEstado($estado){
        $sql = "SELECT r.*, c.cli_nombre, c.cli_apellido 
                FROM reserva r 
                LEFT JOIN cliente c ON r.cli_id = c.cli_id 
                WHERE r.estado_reserva = '$estado' AND r.situacion = 1 
                ORDER BY r.fecha_reserva DESC";
        return self::fetchArray($sql);
    }

    // 🎯 MÉTODO: Actualizar estado de reserva
    public static function actualizarEstadoReserva($id, $nuevoEstado){
        $sql = "UPDATE reserva SET estado_reserva = '$nuevoEstado' WHERE res_id = $id";
        return self::SQL($sql);
    }

    // 🎯 MÉTODO: Obtener reservas próximas a vencer
    public static function obtenerReservasProximasVencer($dias = 3){
        $sql = "SELECT r.*, c.cli_nombre, c.cli_apellido, c.cli_telefono
                FROM reserva r 
                LEFT JOIN cliente c ON r.cli_id = c.cli_id 
                WHERE r.fecha_limite <= DATE_ADD(NOW(), INTERVAL $dias DAY) 
                AND r.estado_reserva = 'P' AND r.situacion = 1
                ORDER BY r.fecha_limite ASC";
        return self::fetchArray($sql);
    }

}

// =======================================================
// 🎯 MODELO PARA DETALLE_RESERVA
// =======================================================

class DetalleReserva extends ActiveRecord {

    public static $tabla = 'detalle_reserva';
    public static $columnasDB = [
        'res_id',
        'prod_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'situacion'
    ];

    public static $idTabla = 'det_res_id';
    
    public $det_res_id;
    public $res_id;
    public $prod_id;
    public $cantidad;
    public $precio_unitario;
    public $subtotal;
    public $situacion;

    public function __construct($args = []){
        $this->det_res_id = $args['det_res_id'] ?? null;
        $this->res_id = $args['res_id'] ?? null;
        $this->prod_id = $args['prod_id'] ?? null;
        $this->cantidad = $args['cantidad'] ?? 1;
        $this->precio_unitario = $args['precio_unitario'] ?? 0.00;
        $this->subtotal = $args['subtotal'] ?? 0.00;
        $this->situacion = $args['situacion'] ?? 1;
    }

    // 🎯 MÉTODO: Eliminar detalles de una reserva
    public static function EliminarDetallesPorReserva($reservaId){
        $sql = "DELETE FROM detalle_reserva WHERE res_id = $reservaId";
        return self::SQL($sql);
    }

    // 🎯 MÉTODO: Obtener detalles de una reserva específica
    public static function obtenerDetallesPorReserva($reservaId){
        $sql = "SELECT dr.*, p.prod_nombre, p.prod_marca, p.precio_venta
                FROM detalle_reserva dr 
                LEFT JOIN producto p ON dr.prod_id = p.prod_id 
                WHERE dr.res_id = $reservaId AND dr.situacion = 1";
        return self::fetchArray($sql);
    }

    // 🎯 MÉTODO: Guardar múltiples detalles de una vez
    public static function guardarDetallesReserva($reservaId, $productos){
        $resultados = [];
        
        foreach ($productos as $producto) {
            $detalle = new DetalleReserva([
                'res_id' => $reservaId,
                'prod_id' => $producto['prod_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $producto['subtotal'],
                'situacion' => 1
            ]);
            
            $resultado = $detalle->crear();
            $resultados[] = $resultado;
        }
        
        return $resultados;
    }

}

/*
==========================================
📝 CARACTERÍSTICAS DEL SISTEMA DE RESERVAS:
==========================================

🔄 FUNCIONALIDADES PRINCIPALES:
- Manejo de reserva + detalles en conjunto
- Cálculo automático de totales
- Estados de reserva (P=Pendiente, C=Confirmada, X=Cancelada)
- Fechas de límite para reservas
- Join con clientes y productos

🔄 MÉTODOS ESPECIALES:
- obtenerReservasCompletas(): Para DataTable principal
- obtenerReservaConDetalles(): Para ver/editar reserva específica
- obtenerEstadisticasReservas(): Para dashboard
- obtenerReservasProximasVencer(): Para alertas
- guardarDetallesReserva(): Para insertar múltiples productos

🔄 VALIDACIONES DE NEGOCIO:
- Fechas límite válidas
- Totales calculados correctamente
- Estados válidos (P, C, X)
- Relaciones con clientes y productos

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ DOS MODELOS pero UN SOLO CRUD
2. ✅ Métodos para manejar ambas tablas
3. ✅ JOINs complejos con múltiples tablas
4. ✅ Estados de reserva con lógica de negocio
5. ✅ Cálculos automáticos de totales
6. ✅ Manejo de fechas y vencimientos
*/