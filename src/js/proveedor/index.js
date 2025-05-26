// 🎯 IMPORTS NECESARIOS (igual que clientes)
import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";

// 🎯 ELEMENTOS DEL DOM PARA PROVEEDORES
const FormProveedores = document.getElementById('FormProveedores');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const InputProveedorTelefono = document.getElementById('prov_telefono');
const proveedor_nit = document.getElementById('prov_nit');

// 🎯 VALIDACIÓN: Teléfono (IGUAL que clientes, pero con nombres de proveedor)
const ValidarTelefono = () => {
    const CantidadDigitos = InputProveedorTelefono.value;

    if (CantidadDigitos.length < 1) {
        InputProveedorTelefono.classList.remove('is-valid', 'is-invalid');
    } else {
        if (CantidadDigitos.length != 8) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Revise el número de teléfono",
                text: "La cantidad de dígitos debe ser igual a 8",
                showConfirmButton: true,
            });

            InputProveedorTelefono.classList.remove('is-valid');
            InputProveedorTelefono.classList.add('is-invalid');
        } else {
            InputProveedorTelefono.classList.remove('is-invalid');
            InputProveedorTelefono.classList.add('is-valid');
        }
    }
}

// 🎯 VALIDACIÓN: NIT (IGUAL que clientes, pero con nombres de proveedor)
function validarNit() {
    const nit = proveedor_nit.value.trim();
    let nd, add = 0;

    if (nd = /^(\d+)-?([\dkK])$/.exec(nit)) {
        nd[2] = (nd[2].toLowerCase() === 'k') ? 10 : parseInt(nd[2], 10);

        for (let i = 0; i < nd[1].length; i++) {
            add += ((((i - nd[1].length) * -1) + 1) * parseInt(nd[1][i], 10));
        }
        return ((11 - (add % 11)) % 11) === nd[2];
    } else {
        return false;
    }
}

const EsValidoNit = () => {
    validarNit();

    if (validarNit()) {
        proveedor_nit.classList.add('is-valid');
        proveedor_nit.classList.remove('is-invalid');
    } else {
        proveedor_nit.classList.remove('is-valid');
        proveedor_nit.classList.add('is-invalid');

        Swal.fire({
            position: "center",
            icon: "error",
            title: "NIT INVÁLIDO",
            text: "El número de NIT ingresado es inválido",
            showConfirmButton: true,
        });
    }
}

// 🎯 FUNCIÓN: Guardar Proveedor
const GuardarProveedor = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormProveedores, ['prov_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe validar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormProveedores);

    const url = '/basemontoya/proveedores/guardarAPI';
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
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarProveedores();
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
    BtnGuardar.disabled = false;
}

// 🎯 FUNCIÓN: Buscar Proveedores
const BuscarProveedores = async () => {
    const url = '/basemontoya/proveedores/buscarAPI';
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

// 🎯 DATATABLE: Configuración para proveedores
const datatable = new DataTable('#TableProveedores', {
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
            data: 'prov_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        {
            title: 'Proveedor',
            data: 'prov_nombre',
            render: (data, type, row) => {
                // Si tiene empresa, mostrar ambos
                if (row.prov_empresa && row.prov_empresa.trim() !== '') {
                    return `
                        <div>
                            <strong>${data}</strong><br>
                            <small class="text-muted"><i class="bi bi-building me-1"></i>${row.prov_empresa}</small>
                        </div>
                    `;
                } else {
                    return `<strong>${data}</strong>`;
                }
            }
        },
        {
            title: 'Contacto',
            data: 'prov_email',
            render: (data, type, row) => {
                return `
                    <div>
                        <div><i class="bi bi-envelope me-1"></i>${data}</div>
                        <div><i class="bi bi-phone me-1"></i>+502 ${row.prov_telefono}</div>
                    </div>
                `;
            }
        },
        { 
            title: 'NIT', 
            data: 'prov_nit',
            render: (data, type, row) => {
                return `<span class="badge bg-secondary">${data}</span>`;
            }
        },
        {
            title: 'Dirección',
            data: 'prov_direccion',
            render: (data, type, row) => {
                // Limitar longitud de la dirección
                if (data && data.length > 30) {
                    return `
                        <span title="${data}">
                            <i class="bi bi-geo-alt me-1"></i>${data.substring(0, 30)}...
                        </span>
                    `;
                } else {
                    return `<i class="bi bi-geo-alt me-1"></i>${data || 'No especificada'}`;
                }
            }
        },
        {
            title: 'Acciones',
            data: 'prov_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombre="${row.prov_nombre}"  
                         data-empresa="${row.prov_empresa || ''}"  
                         data-nit="${row.prov_nit}"  
                         data-telefono="${row.prov_telefono}"  
                         data-email="${row.prov_email}"  
                         data-direccion="${row.prov_direccion}">  
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

    document.getElementById('prov_id').value = datos.id;
    document.getElementById('prov_nombre').value = datos.nombre;
    document.getElementById('prov_empresa').value = datos.empresa;
    document.getElementById('prov_nit').value = datos.nit;
    document.getElementById('prov_telefono').value = datos.telefono;
    document.getElementById('prov_email').value = datos.email;
    document.getElementById('prov_direccion').value = datos.direccion;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

// 🎯 FUNCIÓN: Limpiar formulario
const limpiarTodo = () => {
    FormProveedores.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    
    // Limpiar validaciones visuales
    FormProveedores.querySelectorAll('.is-valid, .is-invalid').forEach(element => {
        element.classList.remove('is-valid', 'is-invalid');
    });
}

// 🎯 FUNCIÓN: Modificar Proveedor
const ModificarProveedor = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormProveedores, [''])) {
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

    const body = new FormData(FormProveedores);

    const url = '/basemontoya/proveedores/modificarAPI';
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
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarProveedores();
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
    BtnModificar.disabled = false;
}

// 🎯 FUNCIÓN: Eliminar Proveedor
const EliminarProveedores = async (e) => {
    const idProveedor = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea eliminar este proveedor?",
        text: '¡Esta acción no se puede deshacer!',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#d33',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/basemontoya/proveedores/eliminar?id=${idProveedor}`;
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

                BuscarProveedores();
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

// 🎯 VALIDACIÓN: Email en tiempo real
const ValidarEmail = () => {
    const email = document.getElementById('prov_email').value;
    const inputEmail = document.getElementById('prov_email');
    
    if (email.length > 0) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(email)) {
            inputEmail.classList.remove('is-invalid');
            inputEmail.classList.add('is-valid');
        } else {
            inputEmail.classList.remove('is-valid');
            inputEmail.classList.add('is-invalid');
        }
    } else {
        inputEmail.classList.remove('is-valid', 'is-invalid');
    }
}

// 🎯 INICIALIZACIÓN: Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    // Cargar proveedores al iniciar
    BuscarProveedores();
});

// 🎯 EVENT LISTENERS
datatable.on('click', '.eliminar', EliminarProveedores);
datatable.on('click', '.modificar', llenarFormulario);
FormProveedores.addEventListener('submit', GuardarProveedor);
proveedor_nit.addEventListener('change', EsValidoNit);
InputProveedorTelefono.addEventListener('change', ValidarTelefono);
document.getElementById('prov_email').addEventListener('input', ValidarEmail);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarProveedor);

/*
=======================================================
📝 DIFERENCIAS CON CLIENTES:
=======================================================

🔄 CAMBIOS PRINCIPALES:
- FormClientes → FormProveedores
- cli_ → prov_ en todos los campos
- TableClientes → TableProveedores
- Sin API de países (más simple)
- Sin validaciones de duplicados

🔄 DATATABLE ESPECÍFICO:
- Columna combinada "Proveedor" (nombre + empresa)
- Columna "Contacto" (email + teléfono)
- NIT con badge
- Dirección truncada con tooltip
- Iconos empresariales

🔄 VALIDACIONES:
- Solo email, teléfono y NIT
- Sin validaciones de duplicados
- Validación de email en tiempo real

🔄 URLS:
- /proveedores/ en lugar de /clientes/
- Mismo patrón: guardarAPI, buscarAPI, modificarAPI, eliminar

=======================================================
🎯 PARA TU EXAMEN:
=======================================================

✅ PUNTOS CLAVE:
1. Cambiar TODOS los prefijos (prov_ en lugar de cli_)
2. URLs con /proveedores/
3. Nombres de funciones específicos
4. DataTable adaptado para mostrar datos empresariales
5. Validaciones más simples

✅ SI TE TOCA OTRA ENTIDAD:
- Cambiar prefijos: prov_ → prod_, emp_, etc.
- Cambiar URLs: /proveedores/ → /productos/
- Adaptar columnas del DataTable
- Mantener la misma estructura de funciones

✅ CARACTERÍSTICAS ESPECIALES:
- Columna combinada proveedor/empresa
- Validación de email en tiempo real
- Dirección truncada para mejor UI
- Iconos específicos de empresas
*/