// 🎯 IMPORTS NECESARIOS (igual que usuarios)
import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";


// 🎯 CAMBIO: Elementos del DOM para CLIENTES (en lugar de usuarios)
const FormClientes = document.getElementById('FormClientes');  // 🔄 CAMBIO: FormUsuarios → FormClientes
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const InputClienteTelefono = document.getElementById('cli_telefono');  // 🔄 CAMBIO: usuario_telefono → cli_telefono
const cliente_nit = document.getElementById('cli_nit');  // 🔄 CAMBIO: usuario_nit → cli_nit




// 🌍 NUEVO: Elementos para manejo de países
const SelectPais = document.getElementById('cli_pais');
const CodigoDisplay = document.getElementById('codigo_display');
const FlagDisplay = document.getElementById('flag_display');
const CodigoTelefonoHidden = document.getElementById('cli_codigo_telefono');


// 🌍 NUEVO: CARGAR PAÍSES DESDE API PÚBLICA
const CargarPaises = async () => {
    try {
        // API REST Countries - Información completa de países
        const respuesta = await fetch('https://restcountries.com/v3.1/all?fields=name,cca2,idd,flag');
        const paises = await respuesta.json();
        
        // Limpiar select y agregar opción por defecto
        SelectPais.innerHTML = '<option value="">Seleccionar país...</option>';
        
        // Ordenar países alfabéticamente
        paises.sort((a, b) => a.name.common.localeCompare(b.name.common));
        
        // Agregar países al select
        paises.forEach(pais => {
            const nombrePais = pais.name.common;
            const codigoPais = pais.cca2;
            const bandera = pais.flag;
            
            // Construir código telefónico (algunos países tienen múltiples códigos)
            let codigoTelefono = '';
            if (pais.idd && pais.idd.root) {
                const root = pais.idd.root;
                const sufijos = pais.idd.suffixes || [''];
                codigoTelefono = root + sufijos[0];
            }
            
            // Solo agregar si tiene código telefónico
            if (codigoTelefono) {
                const option = document.createElement('option');
                option.value = nombrePais;
                option.setAttribute('data-codigo', codigoTelefono);
                option.setAttribute('data-flag', bandera);
                option.setAttribute('data-pais-codigo', codigoPais);
                option.textContent = `${bandera} ${nombrePais}`;
                
                SelectPais.appendChild(option);
            }
        });
        
        // Establecer Guatemala por defecto
        const guatemalaOption = Array.from(SelectPais.options).find(option => 
            option.value.toLowerCase().includes('guatemala')
        );
        if (guatemalaOption) {
            SelectPais.value = guatemalaOption.value;
            CambiarCodigoTelefono(); // Aplicar el código de Guatemala
        }
        
    } catch (error) {
        console.error('Error al cargar países:', error);
        
        // Fallback: Países estáticos si la API falla
        const paisesFallback = [
            { nombre: 'Guatemala', codigo: '+502', bandera: '🇬🇹' },
            { nombre: 'México', codigo: '+52', bandera: '🇲🇽' },
            { nombre: 'Estados Unidos', codigo: '+1', bandera: '🇺🇸' },
            { nombre: 'España', codigo: '+34', bandera: '🇪🇸' },
            { nombre: 'Colombia', codigo: '+57', bandera: '🇨🇴' }
        ];
        
        SelectPais.innerHTML = '<option value="">Seleccionar país...</option>';
        paisesFallback.forEach(pais => {
            const option = document.createElement('option');
            option.value = pais.nombre;
            option.setAttribute('data-codigo', pais.codigo);
            option.setAttribute('data-flag', pais.bandera);
            option.textContent = `${pais.bandera} ${pais.nombre}`;
            SelectPais.appendChild(option);
        });
    }
};



// 🌍 NUEVO: CAMBIAR CÓDIGO TELEFÓNICO SEGÚN PAÍS SELECCIONADO
const CambiarCodigoTelefono = () => {
    const option = SelectPais.selectedOptions[0];
    
    if (option && option.dataset.codigo) {
        const codigo = option.dataset.codigo;
        const bandera = option.dataset.flag || '🌍';
        
        // Actualizar display del código
        if (CodigoDisplay) {
            CodigoDisplay.innerHTML = `${bandera} ${codigo}`;
        }
        
        // Actualizar campo hidden
        if (CodigoTelefonoHidden) {
            CodigoTelefonoHidden.value = codigo;
        }
        
        console.log(`País seleccionado: ${option.value}, Código: ${codigo}`);
    } else {
        // Restablecer a Guatemala por defecto
        if (CodigoDisplay) {
            CodigoDisplay.innerHTML = '🇬🇹 +502';
        }
        if (CodigoTelefonoHidden) {
            CodigoTelefonoHidden.value = '+502';
        }
    }
};



// 🎯 VALIDACIÓN: Teléfono (IGUAL que usuarios, pero con nombres de cliente)
const ValidarTelefono = () => {
    const CantidadDigitos = InputClienteTelefono.value;

    if (CantidadDigitos.length < 1) {
        InputClienteTelefono.classList.remove('is-valid', 'is-invalid');
    } else {
        if (CantidadDigitos.length != 8) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Revise el numero de telefono",
                text: "La cantidad de digitos debe ser igual a 8 digitos",
                showConfirmButton: true,
            });

            InputClienteTelefono.classList.remove('is-valid');
            InputClienteTelefono.classList.add('is-invalid');
        } else {
            InputClienteTelefono.classList.remove('is-invalid');
            InputClienteTelefono.classList.add('is-valid');
        }
    }
}

// 🎯 VALIDACIÓN: NIT (IGUAL que usuarios, pero con nombres de cliente)
function validarNit() {
    const nit = cliente_nit.value.trim();
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
        cliente_nit.classList.add('is-valid');
        cliente_nit.classList.remove('is-invalid');
    } else {
        cliente_nit.classList.remove('is-valid');
        cliente_nit.classList.add('is-invalid');

        Swal.fire({
            position: "center",
            icon: "error",
            title: "NIT INVALIDO",
            text: "El numero de nit ingresado es invalido",
            showConfirmButton: true,
        });
    }
}

// 🎯 FUNCIÓN: Guardar Cliente (CAMBIOS en URL y variables)
const GuardarCliente = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormClientes, ['cli_id'])) {  // 🔄 CAMBIO: FormUsuarios → FormClientes, usuario_id → cli_id
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;  // 🔄 AGREGAR: return para salir si hay error
    }

    const body = new FormData(FormClientes);  // 🔄 CAMBIO: FormUsuarios → FormClientes

    const url = '/basemontoya/clientes/guardarAPI';  // 🔄 CAMBIO: usuarios → clientes
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
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarClientes();  // 🔄 CAMBIO: BuscarUsuarios → BuscarClientes
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

// 🎯 FUNCIÓN: Buscar Clientes (CAMBIOS en URL y variables)
const BuscarClientes = async () => {
    const url = '/basemontoya/clientes/buscarAPI';  // 🔄 CAMBIO: usuarios → clientes
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

// 🎯 DATATABLE: Configuración para clientes (CAMBIOS en campos)
const datatable = new DataTable('#TableClientes', {  // 🔄 CAMBIO: TableUsuarios → TableClientes
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
            data: 'cli_id',  // 🔄 CAMBIO: usuario_id → cli_id
            width: '%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Nombre', data: 'cli_nombre' },  // 🔄 CAMBIO: usuario_nombres → cli_nombre
        { title: 'Apellido', data: 'cli_apellido' },  // 🔄 CAMBIO: usuario_apellidos → cli_apellido
        { title: 'Email', data: 'cli_email' },  // 🔄 CAMBIO: usuario_correo → cli_email
        { 
            title: 'Teléfono', 
            data: 'cli_telefono',  // 🔄 CAMBIO: usuario_telefono → cli_telefono
            render: (data, type, row) => {
                return `${row.cli_codigo_telefono || '+502'} ${data}`;  // 🔄 NUEVO: Mostrar código + número
            }
        },
        { title: 'NIT', data: 'cli_nit' },  // 🔄 CAMBIO: usuario_nit → cli_nit
        { title: 'País', data: 'cli_pais' },  // 🔄 NUEVO: Campo país
        { title: 'Fecha', data: 'cli_fecha' },  // 🔄 CAMBIO: usuario_fecha → cli_fecha
        {
            title: 'Estado',  // 🔄 CAMBIO: Destino → Estado
            data: 'cli_estado',  // 🔄 CAMBIO: usuario_estado → cli_estado
            render: (data, type, row) => {
                const estado = row.cli_estado;
                
                // 🔄 CAMBIO: Nuevos estados en lugar de P, F, C
                if (estado == "ACTIVO") {
                    return '<span class="badge bg-success">ACTIVO</span>';
                } else if (estado == "INACTIVO") {
                    return '<span class="badge bg-warning">INACTIVO</span>';
                } else if (estado == "SUSPENDIDO") {
                    return '<span class="badge bg-danger">SUSPENDIDO</span>';
                }
            }
        },
        {
            title: 'Acciones',
            data: 'cli_id',  // 🔄 CAMBIO: usuario_id → cli_id
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombre="${row.cli_nombre}"  
                         data-apellido="${row.cli_apellido}"  
                         data-nit="${row.cli_nit}"  
                         data-telefono="${row.cli_telefono}"  
                         data-email="${row.cli_email}"  
                         data-direccion="${row.cli_direccion}"  
                         data-estado="${row.cli_estado}"  
                         data-fecha="${row.cli_fecha}"
                         data-pais="${row.cli_pais}"
                         data-codigo="${row.cli_codigo_telefono}">  
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

// 🎯 FUNCIÓN: Llenar formulario para modificar (CAMBIOS en campos)
const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset

    document.getElementById('cli_id').value = datos.id;  // 🔄 CAMBIO: usuario_id → cli_id
    document.getElementById('cli_nombre').value = datos.nombre;  // 🔄 CAMBIO
    document.getElementById('cli_apellido').value = datos.apellido;  // 🔄 CAMBIO
    document.getElementById('cli_nit').value = datos.nit;
    document.getElementById('cli_telefono').value = datos.telefono;
    document.getElementById('cli_email').value = datos.email;  // 🔄 CAMBIO
    document.getElementById('cli_direccion').value = datos.direccion;  // 🔄 NUEVO
    document.getElementById('cli_estado').value = datos.estado;
    document.getElementById('cli_fecha').value = datos.fecha;
    document.getElementById('cli_pais').value = datos.pais;  // 🔄 NUEVO
    document.getElementById('cli_codigo_telefono').value = datos.codigo;  // 🔄 NUEVO

    // Actualizar display del código telefónico
    CambiarCodigoTelefono();

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

// 🎯 FUNCIÓN: Limpiar formulario (CAMBIO en nombre de form)
const limpiarTodo = () => {
    FormClientes.reset();  // 🔄 CAMBIO: FormUsuarios → FormClientes
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    
    // 🔄 NUEVO: Restablecer país y código por defecto
    setTimeout(() => {
        const guatemalaOption = Array.from(SelectPais.options).find(option => 
            option.value.toLowerCase().includes('guatemala')
        );
        if (guatemalaOption) {
            SelectPais.value = guatemalaOption.value;
            CambiarCodigoTelefono();
        }
    }, 100);
}

// 🎯 FUNCIÓN: Modificar Cliente (CAMBIOS en URL y variables)
const ModificarCliente = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormClientes, [''])) {  // 🔄 CAMBIO: FormUsuarios → FormClientes
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;  // 🔄 CAMBIO: BtnGuardar → BtnModificar
        return;
    }

    const body = new FormData(FormClientes);  // 🔄 CAMBIO: FormUsuarios → FormClientes

    const url = '/basemontoya/clientes/modificarAPI';  // 🔄 CAMBIO: usuarios → clientes
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
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarClientes();  // 🔄 CAMBIO: BuscarUsuarios → BuscarClientes
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

// 🎯 FUNCIÓN: Eliminar Cliente (CAMBIOS en URL)
const EliminarClientes = async (e) => {
    const idCliente = e.currentTarget.dataset.id  // 🔄 CAMBIO: idUsuario → idCliente

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "info",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar este registro',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/basemontoya/clientes/eliminar?id=${idCliente}`;  // 🔄 CAMBIO: usuarios → clientes, idUsuario → idCliente
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
                    title: "Exito",
                    text: mensaje,
                    showConfirmButton: true,
                });

                BuscarClientes();  // 🔄 CAMBIO: BuscarUsuarios → BuscarClientes
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

// 🎯 INICIALIZACIÓN: Event Listeners (CAMBIOS en nombres)
document.addEventListener('DOMContentLoaded', () => {
    // 🌍 NUEVO: Cargar países al iniciar
    CargarPaises();
    
    // 🌍 NUEVO: Establecer fecha actual por defecto
    const fechaInput = document.getElementById('cli_fecha');
    if (fechaInput) {
        fechaInput.value = new Date().toISOString().split('T')[0];
    }
});

// 🌍 NUEVO: Event listener para cambio de país
SelectPais.addEventListener('change', CambiarCodigoTelefono);

// 🎯 EVENT LISTENERS: (CAMBIOS en nombres de variables)
BuscarClientes();  // 🔄 CAMBIO: BuscarUsuarios → BuscarClientes
datatable.on('click', '.eliminar', EliminarClientes);  // 🔄 CAMBIO: EliminarUsuarios → EliminarClientes
datatable.on('click', '.modificar', llenarFormulario);
FormClientes.addEventListener('submit', GuardarCliente);  // 🔄 CAMBIO: FormUsuarios → FormClientes, GuardarUsuario → GuardarCliente
cliente_nit.addEventListener('change', EsValidoNit);  // 🔄 CAMBIO: usuario_nit → cliente_nit
InputClienteTelefono.addEventListener('change', ValidarTelefono);  // 🔄 CAMBIO: InputUsuarioTelefono → InputClienteTelefono
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarCliente);  // 🔄 CAMBIO: ModificarUsuario → ModificarCliente

/*
=======================================================
📝 RESUMEN DE CAMBIOS PARA CLIENTES:
=======================================================

🔄 CAMBIOS DE NOMBRES:
- FormUsuarios → FormClientes
- usuario_telefono → cli_telefono
- usuario_nit → cli_nit
- TableUsuarios → TableClientes
- usuario_id → cli_id
- usuario_nombres → cli_nombre
- usuario_apellidos → cli_apellido
- usuario_correo → cli_email
- usuario_fecha → cli_fecha
- usuario_estado → cli_estado

🔄 CAMBIOS DE URLs:
- /usuarios/ → /clientes/
- BuscarUsuarios → BuscarClientes
- GuardarUsuario → GuardarCliente
- ModificarUsuario → ModificarCliente
- EliminarUsuarios → EliminarClientes

🌍 NUEVAS FUNCIONALIDADES:
- CargarPaises(): Carga países desde API REST Countries
- CambiarCodigoTelefono(): Cambia código según país seleccionado
- Campos nuevos: cli_pais, cli_direccion, cli_codigo_telefono
- Estados nuevos: ACTIVO, INACTIVO, SUSPENDIDO (con badges de colores)

🔄 CAMBIOS EN DATATABLE:
- Columna de teléfono muestra código + número
- Nueva columna de país
- Estados con badges de colores
- Más data-attributes en botones de modificar

=======================================================
🌍 API DE PAÍSES UTILIZADA:
=======================================================

URL: https://restcountries.com/v3.1/all?fields=name,cca2,idd,flag
- name.common: Nombre del país
- cca2: Código de país (GT, MX, US)
- idd.root + idd.suffixes: Código telefónico (+502, +52, +1)
- flag: Emoji de bandera

FALLBACK: Si la API falla, usa países estáticos predefinidos

=======================================================
🎯 PARA TU EXAMEN:
=======================================================

✅ SI TE TOCA OTRA ENTIDAD:
1. Cambiar TODOS los prefijos (cli_ → prod_, emp_, etc.)
2. Actualizar URLs (/clientes/ → /productos/, /empleados/)
3. Cambiar nombres de funciones y variables
4. Adaptar columnas del DataTable
5. Modificar campos específicos de la entidad

✅ LA API DE PAÍSES:
- Funciona automáticamente
- Se puede usar en cualquier entidad que tenga país
- Tiene fallback si falla la conexión
- Carga +200 países automáticamente

✅ VALIDACIONES IMPORTANTES:
- NIT de Guatemala (algoritmo específico)
- Teléfono de 8 dígitos
- Email válido
- Campos requeridos
*/