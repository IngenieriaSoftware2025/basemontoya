<?php

namespace Model;

class Proveedor extends ActiveRecord {

    // 🎯 PUNTO CLAVE: El nombre de la tabla DEBE coincidir con tu CREATE TABLE
    public static $tabla = 'proveedor';
    
    // 🎯 PUNTO CLAVE: Estos campos DEBEN ser EXACTAMENTE los de tu tabla (sin el ID)
    public static $columnasDB = [
        'prov_nombre',
        'prov_empresa', 
        'prov_nit',
        'prov_telefono',
        'prov_email',
        'prov_direccion',
        'situacion'
    ];

    // 🎯 PUNTO CLAVE: El nombre del ID DEBE coincidir con tu PRIMARY KEY
    public static $idTabla = 'prov_id';
    
    // 🎯 PUNTO CLAVE: Declara TODAS las propiedades (incluyendo el ID)
    public $prov_id;
    public $prov_nombre;
    public $prov_empresa;
    public $prov_nit;
    public $prov_telefono;
    public $prov_email;
    public $prov_direccion;
    public $situacion;

    // 🎯 PUNTO CLAVE: El constructor inicializa TODAS las propiedades
    public function __construct($args = []){
        $this->prov_id = $args['prov_id'] ?? null;
        $this->prov_nombre = $args['prov_nombre'] ?? '';
        $this->prov_empresa = $args['prov_empresa'] ?? '';
        $this->prov_nit = $args['prov_nit'] ?? 0;
        $this->prov_telefono = $args['prov_telefono'] ?? 0;
        $this->prov_email = $args['prov_email'] ?? '';
        $this->prov_direccion = $args['prov_direccion'] ?? '';
        $this->situacion = $args['situacion'] ?? 1;
    }

    // 🎯 PUNTO CLAVE: Método personalizado para eliminar (cambia el nombre y tabla)
    public static function EliminarProveedor($id){
        $sql = "DELETE FROM proveedor WHERE prov_id = $id";
        return self::SQL($sql);
    }

    // 🎯 MÉTODO ADICIONAL: Obtener proveedores para select
    public static function obtenerProveedoresActivos(){
        $sql = "SELECT prov_id, prov_nombre, prov_empresa FROM proveedor WHERE situacion = 1 ORDER BY prov_nombre";
        return self::fetchArray($sql);
    }

}

/*
==========================================
📝 DIFERENCIAS CON CLIENTE:
==========================================

🔄 CAMBIOS PRINCIPALES:
- prov_ en lugar de cli_
- prov_empresa (campo adicional específico)
- No tiene país ni código telefónico (más simple)
- No tiene fecha de registro
- No tiene estado (ACTIVO/INACTIVO)

🔄 CAMPOS ESPECÍFICOS DE PROVEEDOR:
- prov_empresa: Nombre de la empresa proveedora
- Más enfocado en datos comerciales que personales

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ Prefijo prov_ en todos los campos
2. ✅ Tabla 'proveedor' (singular)
3. ✅ ID: 'prov_id'
4. ✅ Método EliminarProveedor()
5. ✅ Método obtenerProveedoresActivos() para usar en productos
*/