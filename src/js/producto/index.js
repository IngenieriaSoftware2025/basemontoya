// 🎯 IMPORTS NECESARIOS
import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";

// 🎯 ELEMENTOS DEL DOM PARA PRODUCTOS
const FormProductos = document.getElementById('FormProductos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

// Elementos específicos de productos
const SelectProveedor = document.getElementById('prov_id');
const InputPrecioCompra = document.getElementById('precio_compra');
const InputPrecioVenta = document.getElementById('precio_venta');
const GananciaCalculada = document.getElementById('ganancia_calculada');
const PorcentajeGanancia = document.getElementById('porcentaje_ganancia');
const StockBajoIndicator = document.getElementById('stock_bajo_indicator');
const ProductosStockBajo = document.getElementById('productos_stock_bajo');

// 🌍 FUNCIÓN: CARGAR PROVEEDORES DESDE LA BASE DE DATOS
const CargarProveedores = async () => {
    try {
        const url = '/basemontoya/productos/obtenerProveedoresAPI';
        const respuesta = await fetch(url);
        const datos = await respuesta.json();
        
        if (datos.codigo === 1) {
            // Limpiar select y agregar opción por defecto
            SelectProveedor.innerHTML = '<option value="">Seleccionar proveedor...</option>';
            
            // Agregar cada proveedor al select
            datos.data.forEach(proveedor => {
                const option = document.createElement('option');
                option.value = proveedor.prov_id;
                
                // Si tiene empresa, mostrar nombre + empresa, si no solo nombre
                if (proveedor.prov_empresa && proveedor.prov_empresa.trim() !== '') {
                    option.textContent = `${proveedor.prov_nombre} - ${proveedor.prov_empresa}`;
                } else {
                    option.textContent = proveedor.prov_nombre;
                }
                
                SelectProveedor.appendChild(option);
            });
            
            console.log(`✅ ${datos.data.length} proveedores cargados correctamente`);
        } else {
            console.error('Error al cargar proveedores:', datos.mensaje);
            SelectProveedor.innerHTML = '<option value="">Error al cargar proveedores</option>';
        }
        
    } catch (error) {
        console.error('Error en CargarProveedores:', error);
        
        // Fallback en caso de error
        SelectProveedor.innerHTML = `
            <option value="">Error de conexión</option>
            <option disabled>Verifique su conexión e intente nuevamente</option>
        `;
    }
};

// 🧮 FUNCIÓN: CALCULAR GANANCIA EN TIEMPO REAL
const CalcularGanancia = () => {
    const precioCompra = parseFloat(InputPrecioCompra.value) || 0;
    const precioVenta = parseFloat(InputPrecioVenta.value) || 0;
    
    if (precioCompra > 0 && precioVenta > 0) {
        const ganancia = precioVenta - precioCompra;
        const porcentaje = ((ganancia / precioCompra) * 100);
        
        // Actualizar elementos en la UI
        GananciaCalculada.textContent = `Q ${ganancia.toFixed(2)}`;
        PorcentajeGanancia.textContent = `${porcentaje.toFixed(1)}%`;
        
        // Colores según la ganancia
        if (ganancia > 0) {
            GananciaCalculada.className = 'ms-2 fw-bold text-success';
            PorcentajeGanancia.className = 'text-success';
        } else if (ganancia === 0) {
            GananciaCalculada.className = 'ms-2 fw-bold text-warning';
            PorcentajeGanancia.className = 'text-warning';
        } else {
            GananciaCalculada.className = 'ms-2 fw-bold text-danger';
            PorcentajeGanancia.className = 'text-danger';
        }
        
        // Validación visual de precios
        if (precioVenta <= precioCompra) {
            InputPrecioVenta.classList.add('is-invalid');
            InputPrecioVenta.classList.remove('is-valid');
        } else {
            InputPrecioVenta.classList.remove('is-invalid');
            InputPrecioVenta.classList.add('is-valid');
            InputPrecioCompra.classList.add('is-valid');
        }
    } else {
        GananciaCalculada.textContent = 'Q 0.00';
        PorcentajeGanancia.textContent = '0%';
        GananciaCalculada.className = 'ms-2 fw-bold text-muted';
        PorcentajeGanancia.className = 'text-muted';
    }
};

// 🎯 VALIDACIÓN: Validar campos específicos de productos
const ValidarCamposProducto = () => {
    let esValido = true;
    
    // Validar nombre del producto
    const nombre = document.getElementById('prod_nombre').value.trim();
    if (nombre.length < 2) {
        document.getElementById('prod_nombre').classList.add('is-invalid');
        esValido = false;
    } else {
        document.getElementById('prod_nombre').classList.remove('is-invalid');
        document.getElementById('prod_nombre').classList.add('is-valid');
    }
    
    // Validar precios
    const precioCompra = parseFloat(InputPrecioCompra.value) || 0;
    const precioVenta = parseFloat(InputPrecioVenta.value) || 0;
    
    if (precioCompra <= 0) {
        InputPrecioCompra.classList.add('is-invalid');
        esValido = false;
    }
    
    if (precioVenta <= precioCompra) {
        InputPrecioVenta.classList.add('is-invalid');
        esValido = false;
    }
    
    return esValido;
};

// 🎯 FUNCIÓN: Guardar Producto
const GuardarProducto = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    // Validar campos específicos primero
    if (!ValidarCamposProducto()) {
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Validación de Precios",
            text: "El precio de venta debe ser mayor al precio de compra",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    if (!validarFormulario(FormProductos, ['prod_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe validar todos los campos obligatorios",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);

    const url = '/basemontoya/productos/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        console.log(datos)
        const { codigo, mensaje } = datos

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Producto Guardado!",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error al Guardar",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error)
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de Conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: true,
        });
    }
    BtnGuardar.disabled = false;
}

// 🎯 FUNCIÓN: Buscar Productos
const BuscarProductos = async () => {
    const url = '/basemontoya/productos/buscarAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {
            datatable.clear().draw();
            datatable.rows.add(data).draw();
            
            // Actualizar indicador de stock bajo
            ActualizarIndicadorStockBajo(data);
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error)
    }
}

// 📊 FUNCIÓN: Actualizar indicador de stock bajo
const ActualizarIndicadorStockBajo = (productos) => {
    const productosStockBajo = productos.filter(producto => 
        producto.stock_actual <= producto.stock_minimo
    );
    
    if (productosStockBajo.length > 0) {
        ProductosStockBajo.textContent = productosStockBajo.length;
        StockBajoIndicator.classList.remove('d-none');
    } else {
        StockBajoIndicator.classList.add('d-none');
    }
};

// 🎯 DATATABLE: Configuración para productos
const datatable = new DataTable('#TableProductos', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'prod_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        {
            title: 'Producto',
            data: 'prod_nombre',
            render: (data, type, row) => {
                const stockClass = row.stock_actual <= row.stock_minimo ? 'text-danger' : 'text-success';
                return `
                    <div>
                        <strong>${data}</strong>
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-tag me-1"></i>${row.prod_marca} | 
                            <i class="bi bi-palette me-1"></i>${row.prod_color}
                        </small>
                        <br>
                        <span class="badge bg-light text-dark">${row.prod_categoria}</span>
                        <span class="badge bg-secondary">${row.prod_talla}</span>
                    </div>
                `;
            }
        },
        {
            title: 'Proveedor',
            data: 'prov_nombre',
            render: (data, type, row) => {
                if (row.prov_empresa && row.prov_empresa.trim() !== '') {
                    return `
                        <div>
                            <i class="bi bi-building me-1"></i><strong>${data}</strong>
                            <br>
                            <small class="text-muted">${row.prov_empresa}</small>
                        </div>
                    `;
                } else {
                    return `<i class="bi bi-person me-1"></i>${data || 'Sin proveedor'}`;
                }
            }
        },
        {
            title: 'Precios',
            data: 'precio_venta',
            render: (data, type, row) => {
                const ganancia = parseFloat(row.precio_venta) - parseFloat(row.precio_compra);
                const porcentaje = ((ganancia / parseFloat(row.precio_compra)) * 100).toFixed(1);
                return `
                    <div>
                        <div><strong>Venta: Q ${parseFloat(row.precio_venta).toFixed(2)}</strong></div>
                        <div><small>Compra: Q ${parseFloat(row.precio_compra).toFixed(2)}</small></div>
                        <div><small class="text-success">Ganancia: ${porcentaje}%</small></div>
                    </div>
                `;
            }
        },
        {
            title: 'Stock',
            data: 'stock_actual',
            render: (data, type, row) => {
                const stockClass = data <= row.stock_minimo ? 'bg-danger' : 'bg-success';
                const iconClass = data <= row.stock_minimo ? 'bi-exclamation-triangle' : 'bi-check-circle';
                return `
                    <div class="text-center">
                        <span class="badge ${stockClass}">
                            <i class="bi ${iconClass} me-1"></i>${data}
                        </span>
                        <br>
                        <small class="text-muted">Mín: ${row.stock_minimo}</small>
                    </div>
                `;
            }
        },
        {
            title: 'Acciones',
            data: 'prod_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombre="${row.prod_nombre}"  
                         data-descripcion="${row.prod_descripcion || ''}"  
                         data-categoria="${row.prod_categoria}"  
                         data-talla="${row.prod_talla}"  
                         data-color="${row.prod_color}"  
                         data-marca="${row.prod_marca}"  
                         data-precio_compra="${row.precio_compra}"  
                         data-precio_venta="${row.precio_venta}"  
                         data-stock_actual="${row.stock_actual}"  
                         data-stock_minimo="${row.stock_minimo}"  
                         data-prov_id="${row.prov_id}">  
                         <i class='bi bi-pencil-square me-1'></i> Modificar
                     </button>
                     <button class='btn btn-danger eliminar mx-1' 
                         data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                     </button>
                 </div>`;
            }
        }
    ]
});

// 🎯 FUNCIÓN: Llenar formulario para modificar
const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset

    document.getElementById('prod_id').value = datos.id;
    document.getElementById('prod_nombre').value = datos.nombre;
    document.getElementById('prod_descripcion').value = datos.descripcion;
    document.getElementById('prod_categoria').value = datos.categoria;
    document.getElementById('prod_talla').value = datos.talla;
    document.getElementById('prod_color').value = datos.color;
    document.getElementById('prod_marca').value = datos.marca;
    document.getElementById('precio_compra').value = datos.precio_compra;
    document.getElementById('precio_venta').value = datos.precio_venta;
    document.getElementById('stock_actual').value = datos.stock_actual;
    document.getElementById('stock_minimo').value = datos.stock_minimo;
    document.getElementById('prov_id').value = datos.prov_id;

    // Recalcular ganancia
    CalcularGanancia();

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

// 🎯 FUNCIÓN: Limpiar formulario
const limpiarTodo = () => {
    FormProductos.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    
    // Restablecer valores por defecto
    document.getElementById('stock_minimo').value = 1;
    
    // Limpiar validaciones visuales
    FormProductos.querySelectorAll('.is-valid, .is-invalid').forEach(element => {
        element.classList.remove('is-valid', 'is-invalid');
    });
    
    // Restablecer calculadora de ganancia
    GananciaCalculada.textContent = 'Q 0.00';
    PorcentajeGanancia.textContent = '0%';
    GananciaCalculada.className = 'ms-2 fw-bold text-muted';
}

// 🎯 FUNCIÓN: Modificar Producto
const ModificarProducto = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!ValidarCamposProducto()) {
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Validación de Precios",
            text: "El precio de venta debe ser mayor al precio de compra",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    if (!validarFormulario(FormProductos, [''])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);

    const url = '/basemontoya/productos/modificarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Producto Actualizado!",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error)
    }
    BtnModificar.disabled = false;
}

// 🎯 FUNCIÓN: Eliminar Producto
const EliminarProductos = async (e) => {
    const idProducto = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Eliminar este producto?",
        text: '¡Esta acción eliminará el producto del inventario!',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#d33',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/basemontoya/productos/eliminar?id=${idProducto}`;
        const config = {
            method: 'GET'
        }

        try {
            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "¡Eliminado!",
                    text: mensaje,
                    showConfirmButton: true,
                });

                BuscarProductos();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            console.log(error)
        }
    }
}

// 🎯 INICIALIZACIÓN: Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    // Cargar proveedores al iniciar
    CargarProveedores();
    
    // Buscar productos al iniciar
    BuscarProductos();
    
    // Establecer fecha actual si es necesario
    console.log('✅ Módulo de productos iniciado correctamente');
});

// 🎯 EVENT LISTENERS
// Calculadora de ganancia en tiempo real
InputPrecioCompra.addEventListener('input', CalcularGanancia);
InputPrecioVenta.addEventListener('input', CalcularGanancia);

// CRUD operations
datatable.on('click', '.eliminar', EliminarProductos);
datatable.on('click', '.modificar', llenarFormulario);
FormProductos.addEventListener('submit', GuardarProducto);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarProducto);

/*
=======================================================
📝 FUNCIONALIDADES IMPLEMENTADAS:
=======================================================

🎯 SELECT DINÁMICO DE PROVEEDORES:
- Carga desde base de datos al iniciar
- Manejo de errores de conexión
- Muestra nombre + empresa si existe

🧮 CALCULADORA DE GANANCIA:
- Actualización en tiempo real
- Colores según ganancia (verde/amarillo/rojo)
- Validación precio venta > precio compra
- Porcentaje de ganancia calculado

📊 DATATABLE AVANZADO:
- Información completa del producto
- Indicadores visuales de stock
- Alertas de stock bajo
- Precios con ganancia calculada
- Información del proveedor

🔔 INDICADORES Y ALERTAS:
- Counter de productos con stock bajo
- Badges de colores para stock
- Validaciones visuales en tiempo real
- Mensajes específicos para productos

🎯 VALIDACIONES ESPECÍFICAS:
- Precios mayores a 0
- Precio venta > precio compra
- Stock no negativo
- Campos obligatorios
- Proveedores válidos

=======================================================
🎯 PARA TU EXAMEN:
=======================================================

✅ PUNTOS CLAVE:
1. Select dinámico cargado desde API
2. Calculadora en tiempo real
3. DataTable con información completa
4. Validaciones de negocio específicas
5. Indicadores visuales de stock

✅ SI TE TOCA OTRA ENTIDAD:
- Adaptar campos específicos
- Cambiar URLs de APIs
- Modificar validaciones según negocio
- Mantener estructura de funciones
*/