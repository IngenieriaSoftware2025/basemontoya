<!-- FORMULARIO PROVEEDORES -->
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" 
     style="background: linear-gradient(135deg, #2c5aa0 0%, #1e3c72 100%);">
    <div class="row w-100 justify-content-center">
        <div class="col-11 col-md-10 col-lg-8 col-xl-6">
            
            <div class="card shadow-lg border-0" 
                 style="border-radius: 25px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                
                <!-- Header con gradiente diferente -->
                <div class="card-header text-center py-4 border-0" 
                     style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); border-radius: 25px 25px 0 0;">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-white rounded-circle p-3 shadow-sm me-3">
                            <i class="bi bi-building-fill text-danger" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h2 class="text-white mb-0 fw-bold">Registro de Proveedores</h2>
                            <p class="text-white-50 mb-0">Gestione la información de sus proveedores</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <form id="FormProveedores" novalidate>
                        <input type="hidden" id="prov_id" name="prov_id">

                        <!-- Información de la Empresa -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-building text-danger me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-danger fw-semibold">Información de la Empresa</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                <!-- Nombre del Proveedor -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="prov_nombre" name="prov_nombre" placeholder="Nombre" required>
                                        <label for="prov_nombre">
                                            <i class="bi bi-person-badge me-1"></i>Nombre del Proveedor
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>El nombre es obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Empresa -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="prov_empresa" name="prov_empresa" placeholder="Empresa">
                                        <label for="prov_empresa">
                                            <i class="bi bi-building me-1"></i>Nombre de la Empresa
                                        </label>
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>Opcional - Si es una empresa
                                        </div>
                                    </div>
                                </div>

                                <!-- NIT -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="prov_nit" name="prov_nit" placeholder="NIT" required>
                                        <label for="prov_nit">
                                            <i class="bi bi-card-text me-1"></i>NIT
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>El NIT es obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control border-2" 
                                               id="prov_email" name="prov_email" placeholder="Email" required>
                                        <label for="prov_email">
                                            <i class="bi bi-envelope me-1"></i>Correo Electrónico
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Email válido requerido
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-telephone-fill text-info me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-info fw-semibold">Información de Contacto</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                <!-- Teléfono -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control border-2" 
                                               id="prov_telefono" name="prov_telefono" placeholder="Teléfono" required>
                                        <label for="prov_telefono">
                                            <i class="bi bi-phone me-1"></i>Número de Teléfono
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>8 dígitos requeridos
                                        </div>
                                    </div>
                                </div>

                                <!-- Dirección -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <textarea class="form-control border-2" id="prov_direccion" name="prov_direccion" 
                                                  placeholder="Dirección" style="height: 58px;" required></textarea>
                                        <label for="prov_direccion">
                                            <i class="bi bi-geo-alt me-1"></i>Dirección
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>La dirección es obligatoria
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex flex-wrap gap-3 justify-content-center pt-3">
                            <button type="submit" id="BtnGuardar" class="btn btn-lg px-4 py-2 shadow-sm" 
                                    style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); 
                                           border: none; border-radius: 15px; color: white; font-weight: 600;">
                                <i class="bi bi-save me-2"></i>Guardar Proveedor
                            </button>
                            
                            <button type="button" id="BtnModificar" class="btn btn-lg px-4 py-2 shadow-sm d-none" 
                                    style="background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%); 
                                           border: none; border-radius: 15px; color: white; font-weight: 600;">
                                <i class="bi bi-pencil-square me-2"></i>Modificar Proveedor
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

<!-- TABLA DE PROVEEDORES -->
<div class="container-fluid py-5" style="background: #f8f9fa;">
    <div class="row justify-content-center">
        <div class="col-11">
            <div class="card shadow border-0" style="border-radius: 20px;">
                <div class="card-header py-4 border-0" 
                     style="background: linear-gradient(135deg, #2c5aa0 0%, #1e3c72 100%); border-radius: 20px 20px 0 0;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-building-fill-gear text-white me-3" style="font-size: 1.5rem;"></i>
                        <h4 class="text-white mb-0 fw-bold">PROVEEDORES REGISTRADOS</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="TableProveedores">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/proveedor/index.js') ?>"></script>

<!-- 
==========================================
🎨 DIFERENCIAS VISUALES CON CLIENTES:
==========================================

🔄 COLORES Y TEMA:
- Gradiente azul-marino en lugar de azul-púrpura
- Header rojo-naranja en lugar de azul
- Iconos de empresa en lugar de persona
- Tema más "empresarial"

🔄 SECCIONES:
- "Información de la Empresa" (rojo)
- "Información de Contacto" (azul info)
- Sin sección de países/estados

🔄 CAMPOS ESPECÍFICOS:
- prov_empresa (opcional)
- Sin país ni código telefónico
- Dirección más pequeña
- Enfoque empresarial

🔄 ICONOS:
- bi-building-fill: Empresa
- bi-person-badge: Proveedor
- bi-telephone-fill: Contacto
- bi-building-fill-gear: Gestión

==========================================
✅ PUNTOS CLAVE:
==========================================

1. ✅ Todos los IDs con prefijo prov_
2. ✅ FormProveedores y TableProveedores
3. ✅ Colores diferentes para distinguir
4. ✅ Campos específicos para proveedores
5. ✅ Más simple que clientes (sin países)
-->

<style>
/* Estilos específicos para proveedores */
.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Hover effects para los botones de proveedor */
.btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Estilos para campos de empresa */
#prov_empresa {
    background: linear-gradient(45deg, #f8f9fa 0%, #ffffff 100%);
}

/* Indicador de campo opcional */
.form-text i {
    color: #17a2b8;
}
</style>