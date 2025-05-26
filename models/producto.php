<?php

namespace Model;

class Producto extends ActiveRecord {

    // 🎯 PUNTO CLAVE: El nombre de la tabla DEBE coincidir con tu CREATE TABLE
    public static $tabla = 'producto';
    
    // 🎯 PUNTO CLAVE: Estos campos DEBEN ser EXACTAMENTE los de tu tabla (sin el ID)
    public static $columnasDB = [
        'prod_nombre',
        'prod_descripcion',
        'prod_categoria',
        'prod_talla',
        'prod_color',
        'prod_marca',
        'precio_compra',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'prov_id',
        'situacion',
        'fecha_ingreso'
    ];

    // 🎯 PUNTO CLAVE: El nombre del ID DEBE coincidir con tu PRIMARY KEY
    public static $idTabla = 'prod_id';
    
    // 🎯 PUNTO CLAVE: Declara TODAS las propiedades (incluyendo el ID)
    public $prod_id;
    public $prod_nombre;
    public $prod_descripcion;
    public $prod_categoria;
    public $prod_talla;
    public $prod_color;
    public $prod_marca;
    public $precio_compra;
    public $precio_venta;
    public $stock_actual;
    public $stock_minimo;
    public $prov_id;
    public $situacion;
    public $fecha_ingreso;

    // 🎯 PUNTO CLAVE: El constructor inicializa TODAS las propiedades
    public function __construct($args = []){
        $this->prod_id = $args['prod_id'] ?? null;
        $this->prod_nombre = $args['prod_nombre'] ?? '';
        $this->prod_descripcion = $args['prod_descripcion'] ?? '';
        $this->prod_categoria = $args['prod_categoria'] ?? '';
        $this->prod_talla = $args['prod_talla'] ?? '';
        $this->prod_color = $args['prod_color'] ?? '';
        $this->prod_marca = $args['prod_marca'] ?? '';
        $this->precio_compra = $args['precio_compra'] ?? 0.00;
        $this->precio_venta = $args['precio_venta'] ?? 0.00;
        $this->stock_actual = $args['stock_actual'] ?? 0;
        $this->stock_minimo = $args['stock_minimo'] ?? 1;
        $this->prov_id = $args['prov_id'] ?? null;
        $this->situacion = $args['situacion'] ?? 1;
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? '';
    }

    // 🎯 MÉTODO: Eliminar producto
    public static function EliminarProducto($id){
        $sql = "DELETE FROM producto WHERE prod_id = $id";
        return self::SQL($sql);
    }

    // 🎯 MÉTODO: Obtener productos con información del proveedor
    public static function obtenerProductosConProveedor(){
        $sql = "SELECT p.*, pr.prov_nombre, pr.prov_empresa 
                FROM producto p 
                LEFT JOIN proveedor pr ON p.prov_id = pr.prov_id 
                WHERE p.situacion = 1 
                ORDER BY p.prod_nombre";
        return self::fetchArray($sql);
    }

    // 🎯 MÉTODO: Obtener productos por categoría
    public static function obtenerProductosPorCategoria($categoria){
        $sql = "SELECT * FROM producto WHERE prod_categoria = '$categoria' AND situacion = 1";
        return self::fetchArray($sql);
    }

    // 🎯 MÉTODO: Obtener productos con stock bajo
    public static function obtenerProductosStockBajo(){
        $sql = "SELECT p.*, pr.prov_nombre 
                FROM producto p 
                LEFT JOIN proveedor pr ON p.prov_id = pr.prov_id 
                WHERE p.stock_actual <= p.stock_minimo AND p.situacion = 1";
        return self::fetchArray($sql);
    }

    // 🎯 MÉTODO: Actualizar stock (para cuando se hagan ventas)
    public static function actualizarStock($id, $cantidad){
        $sql = "UPDATE producto SET stock_actual = stock_actual - $cantidad WHERE prod_id = $id";
        return self::SQL($sql);
    }

    // 🎯 MÉTODO: Verificar si el nombre del producto ya existe
    public static function verificarNombreExistente($nombre, $idProducto = null) {
        $sql = "SELECT prod_id FROM producto WHERE prod_nombre = '$nombre' AND situacion = 1";
        if ($idProducto) {
            $sql .= " AND prod_id != $idProducto";
        }
        $resultado = self::fetchArray($sql);
        return !empty($resultado);
    }

    // 🎯 MÉTODO: Obtener estadísticas de productos
    public static function obtenerEstadisticas(){
        $sql = "SELECT 
                    COUNT(*) as total_productos,
                    SUM(stock_actual) as total_stock,
                    COUNT(CASE WHEN stock_actual <= stock_minimo THEN 1 END) as productos_stock_bajo,
                    AVG(precio_venta) as precio_promedio
                FROM producto WHERE situacion = 1";
        return self::fetchArray($sql);
    }

}

/*
==========================================
📝 CARACTERÍSTICAS ESPECÍFICAS DE PRODUCTOS:
==========================================

🔄 CAMPOS ÚNICOS:
- prod_descripcion: Descripción detallada del producto
- prod_categoria: Tipo de prenda (Camisas, Pantalones, etc.)
- prod_talla: Talla (XS, S, M, L, XL, XXL)
- prod_color: Color del producto
- prod_marca: Marca comercial
- precio_compra: Lo que pagamos al proveedor
- precio_venta: Lo que vendemos al cliente
- stock_actual: Cantidad disponible
- stock_minimo: Alerta de stock bajo
- prov_id: Relación con proveedor
- fecha_ingreso: Cuándo llegó el producto

🔄 MÉTODOS ADICIONALES:
- obtenerProductosConProveedor(): Join con proveedores
- obtenerProductosPorCategoria(): Filtrar por tipo
- obtenerProductosStockBajo(): Para alertas
- actualizarStock(): Para ventas/reservas
- verificarNombreExistente(): Evitar productos duplicados
- obtenerEstadisticas(): Dashboard de inventario

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ Prefijo prod_ en todos los campos
2. ✅ Relación con proveedor (prov_id)
3. ✅ Manejo de precios (compra y venta)
4. ✅ Control de inventario (stock actual/mínimo)
5. ✅ Métodos adicionales para reportes
6. ✅ Fecha de ingreso automática
*/