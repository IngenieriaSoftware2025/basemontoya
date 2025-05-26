<!-- 
=======================================================
🎯 SECCIÓN 1: CONTENEDOR PRINCIPAL Y FONDO
=======================================================
-->

<!-- 1️⃣ CONTENEDOR PRINCIPAL CON FONDO GRADIENTE -->
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" 
     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    
    <!-- 2️⃣ SISTEMA DE GRILLA RESPONSIVE -->
    <div class="row w-100 justify-content-center">
        <div class="col-11 col-md-10 col-lg-8 col-xl-6">

<!-- 
📝 EXPLICACIÓN SECCIÓN 1:
- container-fluid: Ancho completo de la pantalla
- min-vh-100: Altura mínima del 100% de la ventana
- d-flex align-items-center justify-content-center: Centra el contenido vertical y horizontalmente
- background: linear-gradient: Fondo con gradiente azul-púrpura
- col-11 col-md-10 col-lg-8 col-xl-6: Responsive - cambia el ancho según el tamaño de pantalla
-->

<!-- 
=======================================================
🎯 SECCIÓN 2: CARD PRINCIPAL
=======================================================
-->

            <!-- 3️⃣ CARD PRINCIPAL CON DISEÑO MODERNO -->
            <div class="card shadow-lg border-0" 
                 style="border-radius: 25px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">

<!-- 
📝 EXPLICACIÓN SECCIÓN 2:
- card: Componente Bootstrap para contenedores
- shadow-lg: Sombra grande para efecto de profundidad
- border-0: Sin bordes
- border-radius: 25px: Esquinas muy redondeadas
- backdrop-filter: blur(10px): Efecto de desenfoque en el fondo
- background: rgba(255, 255, 255, 0.95): Fondo blanco semi-transparente
-->

<!-- 
=======================================================
🎯 SECCIÓN 3: HEADER DEL FORMULARIO
=======================================================
-->

                <!-- 4️⃣ HEADER CON GRADIENTE Y TÍTULO -->
                <div class="card-header text-center py-4 border-0" 
                     style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 25px 25px 0 0;">
                    
                    <!-- 5️⃣ CONTENIDO DEL HEADER: ICONO + TÍTULO -->
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <!-- Icono circular blanco -->
                        <div class="bg-white rounded-circle p-3 shadow-sm me-3">
                            <i class="bi bi-person-plus-fill text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <!-- Títulos -->
                        <div>
                            <h2 class="text-white mb-0 fw-bold">Registro de Clientes</h2>
                            <p class="text-white-50 mb-0">Complete la información del cliente</p>
                        </div>
                    </div>
                </div>

<!-- 
📝 EXPLICACIÓN SECCIÓN 3:
- card-header: Header específico de Bootstrap
- text-center py-4: Texto centrado con padding vertical
- background: linear-gradient: Gradiente azul claro
- border-radius: 25px 25px 0 0: Solo esquinas superiores redondeadas
- bg-white rounded-circle: Círculo blanco para el icono
- bi bi-person-plus-fill: Icono de Bootstrap Icons
- text-primary: Color azul de Bootstrap
- fw-bold: Texto en negrita
- text-white-50: Texto blanco semi-transparente
-->

<!-- 
=======================================================
🎯 SECCIÓN 4: INICIO DEL FORMULARIO
=======================================================
-->

                <!-- 6️⃣ BODY DEL CARD -->
                <div class="card-body p-5">
                    
                    <!-- 7️⃣ FORMULARIO PRINCIPAL -->
                    <form id="FormClientes" novalidate>
                        
                        <!-- 8️⃣ CAMPO OCULTO PARA ID (MODIFICACIONES) -->
                        <input type="hidden" id="cli_id" name="cli_id">

<!-- 
📝 EXPLICACIÓN SECCIÓN 4:
- card-body: Contenido principal del card
- p-5: Padding grande en todos los lados
- novalidate: Desactiva validación automática del navegador (usamos Bootstrap)
- type="hidden": Campo invisible para guardar el ID en modificaciones
-->

<!-- 
=======================================================
🎯 SECCIÓN 5: INFORMACIÓN PERSONAL
=======================================================
-->

                        <!-- 9️⃣ SECCIÓN: INFORMACIÓN PERSONAL -->
                        <div class="mb-4">
                            <!-- Título de sección con icono y línea -->
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-person-circle text-primary me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-primary fw-semibold">Información Personal</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <!-- 🔟 GRILLA DE CAMPOS -->
                            <div class="row g-3">
                                
                                <!-- Campo: Nombre -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="cli_nombre" name="cli_nombre" placeholder="Nombre" required>
                                        <label for="cli_nombre">
                                            <i class="bi bi-person me-1"></i>Nombre
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>El nombre es obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo: Apellido -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="cli_apellido" name="cli_apellido" placeholder="Apellido" required>
                                        <label for="cli_apellido">
                                            <i class="bi bi-person me-1"></i>Apellido
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>El apellido es obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo: NIT -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="cli_nit" name="cli_nit" placeholder="NIT" required>
                                        <label for="cli_nit">
                                            <i class="bi bi-card-text me-1"></i>NIT
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>El NIT es obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo: Email -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control border-2" 
                                               id="cli_email" name="cli_email" placeholder="Email" required>
                                        <label for="cli_email">
                                            <i class="bi bi-envelope me-1"></i>Correo Electrónico
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Email válido requerido
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

<!-- 
📝 EXPLICACIÓN SECCIÓN 5:
- mb-4: Margen inferior de 4 unidades
- d-flex align-items-center: Flexbox para alinear icono, título y línea
- text-primary: Color azul de Bootstrap
- fw-semibold: Peso de fuente semi-bold
- flex-grow-1: La línea <hr> crece para llenar el espacio
- row g-3: Grilla con gap de 3 unidades entre columnas
- col-md-6: En pantallas medianas y grandes, ocupa 6/12 columnas (50%)
- form-floating: Labels que "flotan" sobre el input cuando está enfocado
- border-2: Borde más grueso
- required: Campo obligatorio
- invalid-feedback: Mensaje de error que aparece cuando la validación falla
-->

<!-- 
=======================================================
🎯 SECCIÓN 6: CONTACTO Y UBICACIÓN
=======================================================
-->

                        <!-- 1️⃣1️⃣ SECCIÓN: CONTACTO Y UBICACIÓN -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-geo-alt-fill text-success me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-success fw-semibold">Contacto y Ubicación</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                
                                <!-- Campo: País (SELECT) -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select border-2" id="cli_pais" name="cli_pais" required>
                                            <option value="">Seleccionar país...</option>
                                            <option value="Guatemala" data-codigo="+502" data-flag="🇬🇹">Guatemala</option>
                                            <option value="México" data-codigo="+52" data-flag="🇲🇽">México</option>
                                            <option value="Estados Unidos" data-codigo="+1" data-flag="🇺🇸">Estados Unidos</option>
                                            <option value="España" data-codigo="+34" data-flag="🇪🇸">España</option>
                                            <option value="Colombia" data-codigo="+57" data-flag="🇨🇴">Colombia</option>
                                        </select>
                                        <label for="cli_pais"><i class="bi bi-flag me-1"></i>País</label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Seleccione un país
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo: Teléfono con código -->
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-2" id="codigo_display" 
                                              style="min-width: 80px;">
                                            <span id="flag_display">🇬🇹</span> +502
                                        </span>
                                        <div class="form-floating flex-fill">
                                            <input type="tel" class="form-control border-2" 
                                                   id="cli_telefono" name="cli_telefono" placeholder="Teléfono" required>
                                            <label for="cli_telefono">Número de Teléfono</label>
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>8 dígitos requeridos
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="cli_codigo_telefono" name="cli_codigo_telefono" value="+502">
                                </div>

                                <!-- Campo: Dirección (TEXTAREA) -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-2" id="cli_direccion" name="cli_direccion" 
                                                  placeholder="Dirección" style="height: 100px;" required></textarea>
                                        <label for="cli_direccion">
                                            <i class="bi bi-house me-1"></i>Dirección Completa
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>La dirección es obligatoria
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

<!-- 
📝 EXPLICACIÓN SECCIÓN 6:
- text-success: Color verde de Bootstrap
- form-select: Select estilizado de Bootstrap
- data-codigo y data-flag: Atributos personalizados para JavaScript
- input-group: Agrupa elementos (código + input teléfono)
- input-group-text: Texto que acompaña al input (el código +502)
- bg-light: Fondo gris claro
- flex-fill: El input telefono ocupa el espacio restante
- col-12: Ocupa las 12 columnas completas (ancho total)
- textarea: Campo de texto multi-línea
- height: 100px: Altura fija del textarea
-->

<!-- 
=======================================================
🎯 SECCIÓN 7: CONFIGURACIÓN
=======================================================
-->

                        <!-- 1️⃣2️⃣ SECCIÓN: CONFIGURACIÓN -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-gear-fill text-warning me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-warning fw-semibold">Configuración</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                
                                <!-- Campo: Estado (SELECT) -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select border-2" id="cli_estado" name="cli_estado" required>
                                            <option value="">Seleccionar estado...</option>
                                            <option value="ACTIVO">ACTIVO</option>
                                            <option value="INACTIVO">INACTIVO</option>
                                            <option value="SUSPENDIDO">SUSPENDIDO</option>
                                        </select>
                                        <label for="cli_estado">
                                            <i class="bi bi-check-circle me-1"></i>Estado del Cliente
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Seleccione un estado
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo: Fecha -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control border-2" 
                                               id="cli_fecha" name="cli_fecha" required>
                                        <label for="cli_fecha">
                                            <i class="bi bi-calendar-event me-1"></i>Fecha de Registro
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>La fecha es obligatoria
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

<!-- 
📝 EXPLICACIÓN SECCIÓN 7:
- text-warning: Color amarillo/naranja de Bootstrap
- type="date": Input especializado para fechas (abre calendario)
- Los valores de option coinciden con tu tabla cliente
-->

<!-- 
=======================================================
🎯 SECCIÓN 8: BOTONES DE ACCIÓN
=======================================================
-->

                        <!-- 1️⃣3️⃣ BOTONES DE ACCIÓN -->
                        <div class="d-flex flex-wrap gap-3 justify-content-center pt-3">
                            
                            <!-- Botón Guardar -->
                            <button type="submit" id="BtnGuardar" class="btn btn-lg px-4 py-2 shadow-sm" 
                                    style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); 
                                           border: none; border-radius: 15px; color: white; font-weight: 600;">
                                <i class="bi bi-save me-2"></i>Guardar Cliente
                            </button>
                            
                            <!-- Botón Modificar (oculto inicialmente) -->
                            <button type="button" id="BtnModificar" class="btn btn-lg px-4 py-2 shadow-sm d-none" 
                                    style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); 
                                           border: none; border-radius: 15px; color: white; font-weight: 600;">
                                <i class="bi bi-pencil-square me-2"></i>Modificar Cliente
                            </button>
                            
                            <!-- Botón Limpiar -->
                            <button type="reset" id="BtnLimpiar" class="btn btn-lg btn-outline-secondary px-4 py-2 shadow-sm" 
                                    style="border-radius: 15px; font-weight: 600;">
                                <i class="bi bi-arrow-clockwise me-2"></i>Limpiar Formulario
                            </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">USUARIOS REGISTRADOS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableUsuarios">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- 
📝 EXPLICACIÓN SECCIÓN 8:
- d-flex flex-wrap: Flexbox que permite que los botones se envuelvan en líneas
- gap-3: Espacio de 3 unidades entre botones
- justify-content-center: Centra los botones horizontalmente
- pt-3: Padding superior
- btn-lg: Botón grande
- px-4 py-2: Padding horizontal y vertical
- shadow-sm: Sombra pequeña
- type="submit": Envía el formulario
- type="button": Botón que no envía el formulario
- type="reset": Limpia todos los campos del formulario
- d-none: Clase de Bootstrap que oculta el elemento (display: none)
- btn-outline-secondary: Botón con borde pero sin relleno
- Gradientes personalizados en los estilos inline
-->

<!-- 
=======================================================
📋 RESUMEN DE CLASES BOOTSTRAP IMPORTANTES:
=======================================================

🎨 LAYOUT Y ESPACIADO:
- container-fluid: Ancho completo
- row / col-*: Sistema de grillas
- d-flex: Display flex
- align-items-center: Alineación vertical centro
- justify-content-center: Alineación horizontal centro
- mb-4, me-2, ms-3, py-4, px-4: Márgenes y paddings

🎯 COMPONENTES:
- card, card-header, card-body: Estructura de tarjetas
- form-floating: Labels flotantes
- form-control, form-select: Inputs estilizados
- input-group: Agrupación de inputs
- btn, btn-lg: Botones y tamaños

🎨 COLORES:
- text-primary, text-success, text-warning: Colores de texto
- bg-white, bg-light: Colores de fondo

🎯 UTILIDADES:
- shadow-lg, shadow-sm: Sombras
- border-0, border-2: Bordes
- rounded-circle: Círculo perfecto
- fw-bold, fw-semibold: Pesos de fuente
- d-none: Ocultar elemento

🔍 RESPONSIVE:
- col-11 col-md-10 col-lg-8 col-xl-6: Ancho según pantalla
- col-md-6: 50% en pantallas medianas+
- col-12: 100% en todas las pantallas
-->

<!-- 
=======================================================
💡 PUNTOS CLAVE PARA TU EXAMEN:
=======================================================

✅ ESTRUCTURA:
1. Contenedor principal con fondo
2. Card principal con header y body
3. Secciones organizadas con títulos e iconos
4. Campos agrupados en grillas responsive
5. Botones de acción al final

✅ CAMPOS IMPORTANTES:
- input hidden para ID (modificaciones)
- Todos los name="" coinciden con tu tabla
- required en campos obligatorios
- form-floating para labels elegantes
- invalid-feedback para errores

✅ JAVASCRIPT NECESARIO:
- Cambio de código telefónico según país
- Validaciones en tiempo real
- Funciones CRUD (guardar, buscar, modificar, eliminar)

✅ SI CAMBIAS DE ENTIDAD:
- Cambiar todos los id="" y name=""
- Actualizar opciones de selects
- Modificar títulos y textos
- Mantener la misma estructura


==========================================
❌ ERRORES COMUNES QUE DEBES EVITAR:
==========================================

1. ❌ Olvidar el input hidden para el ID
2. ❌ No cambiar los name="" de los inputs
3. ❌ Olvidar el required en campos obligatorios
4. ❌ No incluir todos los campos de tu tabla
5. ❌ Olvidar los botones Guardar, Modificar, Limpiar

==========================================
✅ PUNTOS CLAVE PARA EL EXAMEN:
==========================================

1. ✅ El ID del form DEBE coincidir con el JavaScript
2. ✅ Los name="" DEBEN coincidir con los campos de tu tabla
3. ✅ Los id="" DEBEN coincidir con el JavaScript
4. ✅ Incluir input hidden para modificaciones
5. ✅ Select con las opciones correctas para tu entidad
6. ✅ Input type="date" para fechas
7. ✅ Botones con IDs específicos para JavaScript
-->