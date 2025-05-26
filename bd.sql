-- ===============================================
-- TABLA CLIENTE CON PAÍSES
-- ===============================================
CREATE TABLE cliente (
    cli_id SERIAL PRIMARY KEY,
    cli_nombre VARCHAR(255) NOT NULL,
    cli_apellido VARCHAR(255) NOT NULL,
    cli_nit INTEGER,
    cli_telefono INTEGER,
    cli_email VARCHAR(255),
    cli_direccion TEXT,
    cli_estado VARCHAR(20) DEFAULT 'ACTIVO',
    cli_fecha DATETIME YEAR TO SECOND,
    cli_pais VARCHAR(100),
    cli_codigo_telefono VARCHAR(10) DEFAULT '+502',
    situacion SMALLINT DEFAULT 1
);

-- ===============================================
-- TABLA PROVEEDOR
-- ===============================================
CREATE TABLE proveedor (
    prov_id SERIAL PRIMARY KEY,
    prov_nombre VARCHAR(255) NOT NULL,
    prov_empresa VARCHAR(255),
    prov_nit INTEGER,
    prov_telefono INTEGER,
    prov_email VARCHAR(255),
    prov_direccion TEXT,
    situacion SMALLINT DEFAULT 1
);

-- ===============================================
-- TABLA PRODUCTO
-- ===============================================
CREATE TABLE producto (
    prod_id SERIAL PRIMARY KEY,
    prod_nombre VARCHAR(255) NOT NULL,
    prod_descripcion TEXT,
    prod_categoria VARCHAR(100),
    prod_talla VARCHAR(10),
    prod_color VARCHAR(50),
    prod_marca VARCHAR(100),
    precio_compra DECIMAL(10,2),
    precio_venta DECIMAL(10,2) NOT NULL,
    stock_actual INTEGER DEFAULT 0,
    stock_minimo INTEGER DEFAULT 1,
    prov_id INTEGER,
    situacion SMALLINT DEFAULT 1,
    fecha_ingreso DATETIME YEAR TO SECOND,
    FOREIGN KEY (prov_id) REFERENCES proveedor(prov_id)
);

-- ===============================================
-- TABLA RESERVA
-- ===============================================
CREATE TABLE reserva (
    res_id SERIAL PRIMARY KEY,
    cli_id INTEGER NOT NULL,
    fecha_reserva DATETIME YEAR TO SECOND,
    fecha_limite DATETIME YEAR TO SECOND,
    total_reserva DECIMAL(10,2),
    estado_reserva VARCHAR(20) DEFAULT 'P',
    observaciones TEXT,
    situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (cli_id) REFERENCES cliente(cli_id)
);


-- ===============================================
-- TABLA DETALLE DE RESERVA
-- ===============================================
CREATE TABLE detalle_reserva (
    det_res_id SERIAL PRIMARY KEY,
    res_id INTEGER NOT NULL,
    prod_id INTEGER NOT NULL,
    cantidad INTEGER NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (res_id) REFERENCES reserva(res_id),
    FOREIGN KEY (prod_id) REFERENCES producto(prod_id)
);