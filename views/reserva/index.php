<!-- FORMULARIO RESERVAS -->
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" 
     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);">
    <div class="row w-100 justify-content-center">
        <div class="col-11 col-md-12 col-lg-10 col-xl-9">
            
            <div class="card shadow-lg border-0" 
                 style="border-radius: 25px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                
                <!-- Header con gradiente específico para reservas -->
                <div class="card-header text-center py-4 border-0" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 25px 25px 0 0;">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-white rounded-circle p-3 shadow-sm me-3">
                            <i class="bi bi-calendar-check-fill text-primary" style="font-size: 2rem; color: #764ba2;"></i>
                        </div>
                        <div>
                            <h2 class="text-white mb-0 fw-bold">Gestión de Reservas</h2>
                            <p class="text-white-50 mb-0">Cree y administre reservas de productos</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <form id="FormReservas" novalidate>
                        <input type="hidden" id="res_id" name="res_id">

                        <!-- Información del Cliente y Fechas -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-person-check-fill text-primary me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-primary fw-semibold">Información de la Reserva</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                <!-- Cliente -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select border-2" id="cli_id" name="cli_id" required>
                                            <option value="">Cargando clientes...</option>
                                        </select>
                                        <label for="cli_id">
                                            <i class="bi bi-person me-1"></i>Cliente
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Debe seleccionar un cliente
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha Límite -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control border-2" 
                                               id="fecha_limite" name="fecha_limite" required>
                                        <label for="fecha_limite">
                                            <i class="bi bi-calendar-event me-1"></i>Fecha Límite
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>La fecha límite es obligatoria
                                        </div>
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle text-info me-1"></i>
                                        Fecha hasta la cual el cliente puede recoger la reserva
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-2" id="observaciones" name="observaciones" 
                                                  placeholder="Observaciones" style="height: 100px;"></textarea>
                                        <label for="observaciones">
                                            <i class="bi bi-chat-text me-1"></i>Observaciones (Opcional)
                                        </label>
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>Notas adicionales sobre la reserva
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Selección de Productos -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-bag-plus-fill text-success me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-success fw-semibold">Agregar Productos</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                <!-- Seleccionar Producto -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select border-2" id="select_producto">
                                            <option value="">Cargando productos...</option>
                                        </select>
                                        <label for="select_producto">
                                            <i class="bi bi-box me-1"></i>Producto
                                        </label>
                                    </div>
                                </div>

                                <!-- Cantidad -->
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control border-2" 
                                               id="cantidad_producto" value="1" min="1" max="999">
                                        <label for="cantidad_producto">
                                            <i class="bi bi-123 me-1"></i>Cantidad
                                        </label>
                                    </div>
                                </div>

                                <!-- Botón Agregar -->
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" id="btn_agregar_producto" class="btn btn-success w-100 py-3">
                                        <i class="bi bi-plus-circle me-2"></i>Agregar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de Productos Agregados -->
                        <div class="mb-4 seccion-productos-reserva d-none">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-list-check text-warning me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-warning fw-semibold">Productos en la Reserva</h5>
                                <span class="badge bg-info ms-2" id="contador_productos">0</span>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-end">Precio Unit.</th>
                                            <th class="text-end">Subtotal</th>
                                            <th class="text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_productos_tbody">
                                        <!-- Productos se agregan dinámicamente -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total de la Reserva -->
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <div class="alert alert-success border-0" style="border-radius: 15px;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="bi bi-calculator me-2"></i>Total:
                                            </h5>
                                            <h4 class="mb-0 fw-bold" id="total_reserva">Q 0.00</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex flex-wrap gap-3 justify-content-center pt-3">
                            <button type="submit" id="BtnGuardar" class="btn btn-lg px-4 py-2 shadow-sm" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                           border: none; border-radius: 15px; color: white; font-weight: 600;">
                                <i class="bi bi-save me-2"></i>Crear Reserva
                            </button>
                            
                            <button type="button" id="BtnModificar" class="btn btn-lg px-4 py-2 shadow-sm d-none" 
                                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
                                           border: none; border-radius: 15px; color: white; font-weight: 600;">
                                <i class="bi bi-pencil-square me-2"></i>Modificar Reserva
                            </button>
                            
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

<!-- SECCIÓN DE TABLAS DE RESERVAS CON PESTAÑAS -->
<div class="container-fluid py-5" style="background: #f8f9fa;">
    <div class="row justify-content-center">
        <div class="col-11">
            <div class="card shadow border-0" style="border-radius: 20px;">
                <!-- Header con pestañas -->
                <div class="card-header py-4 border-0" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check text-white me-3" style="font-size: 1.5rem;"></i>
                            <h4 class="text-white mb-0 fw-bold">GESTIÓN DE RESERVAS</h4>
                        </div>
                        
                        <!-- Estadísticas rápidas -->
                        <div class="d-flex gap-3">
                            <span class="badge bg-warning fs-6" id="badge_pendientes">
                                <i class="bi bi-clock me-1"></i>
                                <span id="count_pendientes">0</span> Pendientes
                            </span>
                            <span class="badge bg-success fs-6" id="badge_completadas">
                                <i class="bi bi-check-circle me-1"></i>
                                <span id="count_completadas">0</span> Completadas
                            </span>
                            <span class="badge bg-danger fs-6" id="badge_canceladas">
                                <i class="bi bi-x-circle me-1"></i>
                                <span id="count_canceladas">0</span> Canceladas
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs nav-fill border-0 mb-4" id="reservaTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active position-relative" id="pendientes-tab" 
                                    data-bs-toggle="tab" data-bs-target="#pendientes" type="button" 
                                    role="tab" aria-controls="pendientes" aria-selected="true"
                                    style="border-radius: 15px 15px 0 0; font-weight: 600;">
                                <i class="bi bi-clock-history me-2"></i>PENDIENTES
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning" id="tab_badge_pendientes">
                                    0
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="completadas-tab" 
                                    data-bs-toggle="tab" data-bs-target="#completadas" type="button" 
                                    role="tab" aria-controls="completadas" aria-selected="false"
                                    style="border-radius: 15px 15px 0 0; font-weight: 600;">
                                <i class="bi bi-check-circle me-2"></i>COMPLETADAS
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" id="tab_badge_completadas">
                                    0
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="canceladas-tab" 
                                    data-bs-toggle="tab" data-bs-target="#canceladas" type="button" 
                                    role="tab" aria-controls="canceladas" aria-selected="false"
                                    style="border-radius: 15px 15px 0 0; font-weight: 600;">
                                <i class="bi bi-x-circle me-2"></i>CANCELADAS
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="tab_badge_canceladas">
                                    0
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="todas-tab" 
                                    data-bs-toggle="tab" data-bs-target="#todas" type="button" 
                                    role="tab" aria-controls="todas" aria-selected="false"
                                    style="border-radius: 15px 15px 0 0; font-weight: 600;">
                                <i class="bi bi-list me-2"></i>TODAS
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info" id="tab_badge_todas">
                                    0
                                </span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="reservaTabContent">
                        <!-- TABLA PENDIENTES -->
                        <div class="tab-pane fade show active" id="pendientes" role="tabpanel" aria-labelledby="pendientes-tab">
                            <div class="alert alert-warning border-0" style="border-radius: 15px;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Reservas Pendientes:</strong> Estas reservas están esperando ser completadas por el cliente
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- ✅ SOLO ESTO - DataTable hace el resto -->
                                <table class="table table-hover align-middle" id="TableReservasPendientes">
                                </table>
                            </div>
                        </div>

                        <!-- TABLA COMPLETADAS -->
                        <div class="tab-pane fade" id="completadas" role="tabpanel" aria-labelledby="completadas-tab">
                            <div class="alert alert-success border-0" style="border-radius: 15px;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <strong>Reservas Completadas:</strong> Estas reservas ya fueron entregadas al cliente
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- ✅ SOLO ESTO - DataTable hace el resto -->
                                <table class="table table-hover align-middle" id="TableReservasCompletadas">
                                </table>
                            </div>
                        </div>

                        <!-- TABLA CANCELADAS -->
                        <div class="tab-pane fade" id="canceladas" role="tabpanel" aria-labelledby="canceladas-tab">
                            <div class="alert alert-danger border-0" style="border-radius: 15px;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Reservas Canceladas:</strong> Estas reservas fueron canceladas y no se entregaron
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- ✅ SOLO ESTO - DataTable hace el resto -->
                                <table class="table table-hover align-middle" id="TableReservasCanceladas">
                                </table>
                            </div>
                        </div>

                        <!-- TABLA TODAS -->
                        <div class="tab-pane fade" id="todas" role="tabpanel" aria-labelledby="todas-tab">
                            <div class="alert alert-info border-0" style="border-radius: 15px;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-list-ul me-2"></i>
                                    <strong>Todas las Reservas:</strong> Vista completa de todas las reservas sin filtros
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- ✅ SOLO ESTO - DataTable hace el resto -->
                                <table class="table table-hover align-middle" id="TableReservasTodas">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLES DE RESERVA -->
<div class="modal fade" id="modalDetallesReserva" tabindex="-1" aria-labelledby="modalDetallesReservaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title text-white fw-bold" id="modalDetallesReservaLabel">
                    <i class="bi bi-eye me-2"></i>Detalles de la Reserva
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modalDetallesContent">
                <!-- Contenido se carga dinámicamente desde JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/reserva/index.js') ?>"></script>

<style>
/* Estilos específicos para reservas */
.nav-tabs .nav-link {
    border: none;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    border: none;
    background: rgba(102, 126, 234, 0.1);
}

.nav-tabs .nav-link.active {
    background: linear-gradient(135deg, #667eea 20%, #764ba2 80%);
    color: white !important;
    border: none;
}

.badge.fs-6 {
    font-size: 0.9rem !important;
    padding: 0.5rem 0.8rem;
}

.seccion-productos-reserva {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid #dee2e6;
}

.table thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    font-weight: 600;
}

/* Animaciones para badges */
.badge {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
}

/* Responsive */
@media (max-width: 768px) {
    .nav-tabs {
        flex-direction: column;
    }
    
    .nav-tabs .nav-link {
        margin-bottom: 0.5rem;
        border-radius: 10px !important;
    }
    
    .badge.fs-6 {
        font-size: 0.8rem !important;
        padding: 0.3rem 0.6rem;
    }
}
</style>