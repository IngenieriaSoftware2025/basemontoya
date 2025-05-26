<?php

namespace Model;

class Cliente extends ActiveRecord {

    // 🎯 PUNTO CLAVE: El nombre de la tabla DEBE coincidir con tu CREATE TABLE
    public static $tabla = 'cliente';
    
    // 🎯 PUNTO CLAVE: Estos campos DEBEN ser EXACTAMENTE los de tu tabla (sin el ID)
    public static $columnasDB = [
        'cli_nombre',
        'cli_apellido', 
        'cli_nit',
        'cli_telefono',
        'cli_email',
        'cli_direccion',
        'cli_estado',
        'cli_fecha',
        'cli_pais',
        'cli_codigo_telefono',
        'situacion'
    ];

    // 🎯 PUNTO CLAVE: El nombre del ID DEBE coincidir con tu PRIMARY KEY
    public static $idTabla = 'cli_id';
    
    // 🎯 PUNTO CLAVE: Declara TODAS las propiedades (incluyendo el ID)
    public $cli_id;
    public $cli_nombre;
    public $cli_apellido;
    public $cli_nit;
    public $cli_telefono;
    public $cli_email;
    public $cli_direccion;
    public $cli_estado;
    public $cli_fecha;
    public $cli_pais;
    public $cli_codigo_telefono;
    public $situacion;

    // 🎯 PUNTO CLAVE: El constructor inicializa TODAS las propiedades
    public function __construct($args = []){
        $this->cli_id = $args['cli_id'] ?? null;
        $this->cli_nombre = $args['cli_nombre'] ?? '';
        $this->cli_apellido = $args['cli_apellido'] ?? '';
        $this->cli_nit = $args['cli_nit'] ?? 0;
        $this->cli_telefono = $args['cli_telefono'] ?? 0;
        $this->cli_email = $args['cli_email'] ?? '';
        $this->cli_direccion = $args['cli_direccion'] ?? '';
        $this->cli_estado = $args['cli_estado'] ?? 'ACTIVO';
        $this->cli_fecha = $args['cli_fecha'] ?? '';
        $this->cli_pais = $args['cli_pais'] ?? 'Guatemala';
        $this->cli_codigo_telefono = $args['cli_codigo_telefono'] ?? '+502';
        $this->situacion = $args['situacion'] ?? 1;
    }

    // 🎯 PUNTO CLAVE: Método personalizado para eliminar (cambia el nombre y tabla)
    public static function EliminarCliente($id){
        $sql = "DELETE FROM cliente WHERE cli_id = $id";
        return self::SQL($sql);
    }

}

/*
==========================================
📝 QUÉ CAMBIAR SI TE TOCA OTRA ENTIDAD:
==========================================

🔄 Si te toca PRODUCTOS:
- $tabla = 'producto'
- $idTabla = 'prod_id'  
- $columnasDB = ['prod_nombre', 'prod_precio', etc.]
- public $prod_id, $prod_nombre, etc.
- EliminarProducto($id)

🔄 Si te toca EMPLEADOS:
- $tabla = 'empleado'
- $idTabla = 'emp_id'
- $columnasDB = ['emp_nombre', 'emp_salario', etc.]
- public $emp_id, $emp_nombre, etc.
- EliminarEmpleado($id)

🔄 Si te toca PROVEEDORES:
- $tabla = 'proveedor'  
- $idTabla = 'prov_id'
- $columnasDB = ['prov_nombre', 'prov_empresa', etc.]
- public $prov_id, $prov_nombre, etc.
- EliminarProveedor($id)

==========================================
❌ ERRORES COMUNES QUE DEBES EVITAR:
==========================================

1. ❌ NO incluir el ID en $columnasDB
2. ❌ Nombres diferentes entre tabla y $tabla
3. ❌ Olvidar declarar propiedades públicas
4. ❌ No coincidir $idTabla con PRIMARY KEY
5. ❌ Valores por defecto incorrectos en constructor

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ SIEMPRE revisa tu CREATE TABLE antes de hacer el modelo
2. ✅ Copia EXACTAMENTE los nombres de campos
3. ✅ El namespace DEBE ser "Model"
4. ✅ La clase DEBE extender ActiveRecord
5. ✅ Todos los campos públicos
6. ✅ Constructor con valores por defecto
*/