<!-- FORMULARIO PRODUCTOS -->
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" 
     style="background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%);">
    <div class="row w-100 justify-content-center">
        <div class="col-11 col-md-12 col-lg-10 col-xl-8">
            
            <div class="card shadow-lg border-0" 
                 style="border-radius: 25px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                
                <!-- Header con gradiente Instagram -->
                <div class="card-header text-center py-4 border-0" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 25px 25px 0 0;">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-white rounded-circle p-3 shadow-sm me-3">
                            <i class="bi bi-bag-fill text-purple" style="font-size: 2rem; color: #764ba2;"></i>
                        </div>
                        <div>
                            <h2 class="text-white mb-0 fw-bold">Gestión de Productos</h2>
                            <p class="text-white-50 mb-0">Administre el inventario de su tienda</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <form id="FormProductos" novalidate>
                        <input type="hidden" id="prod_id" name="prod_id">

                        <!-- Información Básica del Producto -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-tag-fill text-info me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-info fw-semibold">Información del Producto</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                <!-- Nombre del Producto -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="prod_nombre" name="prod_nombre" placeholder="Nombre" required>
                                        <label for="prod_nombre">
                                            <i class="bi bi-tag me-1"></i>Nombre del Producto
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>El nombre es obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Marca -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="prod_marca" name="prod_marca" placeholder="Marca" required>
                                        <label for="prod_marca">
                                            <i class="bi bi-award me-1"></i>Marca
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>La marca es obligatoria
                                        </div>
                                    </div>
                                </div>

                                <!-- Descripción -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-2" id="prod_descripcion" name="prod_descripcion" 
                                                  placeholder="Descripción" style="height: 100px;"></textarea>
                                        <label for="prod_descripcion">
                                            <i class="bi bi-card-text me-1"></i>Descripción del Producto
                                        </label>
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>Opcional - Descripción detallada
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Características del Producto -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-palette-fill text-warning me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-warning fw-semibold">Características</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                <!-- Categoría -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select border-2" id="prod_categoria" name="prod_categoria" required>
                                            <option value="">Seleccionar categoría...</option>
                                            <option value="Camisas">👔 Camisas</option>
                                            <option value="Pantalones">👖 Pantalones</option>
                                            <option value="Vestidos">👗 Vestidos</option>
                                            <option value="Blusas">👚 Blusas</option>
                                            <option value="Faldas">🩱 Faldas</option>
                                            <option value="Chaquetas">🧥 Chaquetas</option>
                                            <option value="Zapatos">👠 Zapatos</option>
                                            <option value="Accesorios">👜 Accesorios</option>
                                            <option value="Ropa Interior">🩲 Ropa Interior</option>
                                        </select>
                                        <label for="prod_categoria">
                                            <i class="bi bi-grid me-1"></i>Categoría
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Seleccione una categoría
                                        </div>
                                    </div>
                                </div>

                                <!-- Talla -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select border-2" id="prod_talla" name="prod_talla" required>
                                            <option value="">Seleccionar talla...</option>
                                            <option value="XS">XS - Extra Small</option>
                                            <option value="S">S - Small</option>
                                            <option value="M">M - Medium</option>
                                            <option value="L">L - Large</option>
                                            <option value="XL">XL - Extra Large</option>
                                            <option value="XXL">XXL - Double XL</option>
                                            <option value="XXXL">XXXL - Triple XL</option>
                                            <option value="Única">Talla Única</option>
                                        </select>
                                        <label for="prod_talla">
                                            <i class="bi bi-rulers me-1"></i>Talla
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Seleccione una talla
                                        </div>
                                    </div>
                                </div>

                                <!-- Color -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-2" 
                                               id="prod_color" name="prod_color" placeholder="Color" required>
                                        <label for="prod_color">
                                            <i class="bi bi-palette me-1"></i>Color
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>El color es obligatorio
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Precios e Inventario -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-cash-coin text-success me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-success fw-semibold">Precios e Inventario</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                <!-- Precio de Compra -->
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control border-2" 
                                               id="precio_compra" name="precio_compra" 
                                               placeholder="0.00" step="0.01" min="0.01" required>
                                        <label for="precio_compra">
                                            <i class="bi bi-cart-dash me-1"></i>Precio Compra (Q)
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Precio obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Precio de Venta -->
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control border-2" 
                                               id="precio_venta" name="precio_venta" 
                                               placeholder="0.00" step="0.01" min="0.01" required>
                                        <label for="precio_venta">
                                            <i class="bi bi-cart-plus me-1"></i>Precio Venta (Q)
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Precio obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Actual -->
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control border-2" 
                                               id="stock_actual" name="stock_actual" 
                                               placeholder="0" min="0" required>
                                        <label for="stock_actual">
                                            <i class="bi bi-boxes me-1"></i>Stock Actual
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Stock obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Mínimo -->
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control border-2" 
                                               id="stock_minimo" name="stock_minimo" 
                                               placeholder="1" min="1" value="1" required>
                                        <label for="stock_minimo">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Stock Mínimo
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Stock mínimo obligatorio
                                        </div>
                                    </div>
                                </div>

                                <!-- Ganancia Calculada -->
                                <div class="col-12">
                                    <div class="alert alert-info border-0" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calculator text-info me-2" style="font-size: 1.2rem;"></i>
                                            <span class="fw-semibold">Ganancia por producto: </span>
                                            <span id="ganancia_calculada" class="ms-2 fw-bold text-success">Q 0.00</span>
                                            <span class="ms-2 text-muted">(<span id="porcentaje_ganancia">0%</span> de ganancia)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Proveedor -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-building text-danger me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-danger fw-semibold">Proveedor</h5>
                                <hr class="flex-grow-1 ms-3">
                            </div>
                            
                            <div class="row g-3">
                                <!-- Select de Proveedores (Dinámico) -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select border-2" id="prov_id" name="prov_id" required>
                                            <option value="">Cargando proveedores...</option>
                                            <!-- Los proveedores se cargan dinámicamente desde la API -->
                                        </select>
                                        <label for="prov_id">
                                            <i class="bi bi-building me-1"></i>Seleccionar Proveedor
                                        </label>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>Debe seleccionar un proveedor
                                        </div>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="bi bi-info-circle text-primary me-1"></i>
                                        Si no encuentra el proveedor, primero debe registrarlo en el módulo de proveedores
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex flex-wrap gap-3 justify-content-center pt-3">
                            <button type="submit" id="BtnGuardar" class="btn btn-lg px-4 py-2 shadow-sm" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                           border: none; border-radius: 15px; color: white; font-weight: 600;">
                                <i class="bi bi-save me-2"></i>Guardar Producto
                            </button>
                            
                            <button type="button" id="BtnModificar" class="btn btn-lg px-4 py-2 shadow-sm d-none" 
                                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
                                           border: none; border-radius: 15px; color: white; font-weight: 600;">
                                <i class="bi bi-pencil-square me-2"></i>Modificar Producto
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

<!-- TABLA DE PRODUCTOS -->
<div class="container-fluid py-5" style="background: #f8f9fa;">
    <div class="row justify-content-center">
        <div class="col-11">
            <div class="card shadow border-0" style="border-radius: 20px;">
                <div class="card-header py-4 border-0" 
                     style="background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%); border-radius: 20px 20px 0 0;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-bag-check-fill text-white me-3" style="font-size: 1.5rem;"></i>
                            <h4 class="text-white mb-0 fw-bold">PRODUCTOS EN INVENTARIO</h4>
                        </div>
                        <!-- Indicador de Stock Bajo -->
                        <div id="stock_bajo_indicator" class="d-none">
                            <span class="badge bg-warning text-dark fs-6">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                <span id="productos_stock_bajo">0</span> con stock bajo
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="TableProductos">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/producto/index.js') ?>"></script>

<!-- 
==========================================
🎨 CARACTERÍSTICAS ESPECIALES:
==========================================

🔄 DISEÑO MODERNO:
- Gradiente Instagram (púrpura-rojo-naranja)
- 4 secciones organizadas con colores
- Calculadora de ganancia en tiempo real
- Indicador de stock bajo en header de tabla

🔄 SELECTS DINÁMICOS:
- Proveedores desde base de datos
- Categorías con emojis
- Tallas estándar de ropa

🔄 VALIDACIONES VISUALES:
- Precios con Q (quetzales)
- Ganancia calculada automáticamente
- Stock mínimo por defecto: 1
- Campos obligatorios marcados

🔄 UX MEJORADA:
- Descripción opcional
- Form-text explicativo
- Indicadores de stock bajo
- Botones con gradientes únicos

==========================================
🎯 JAVASCRIPT NECESARIO:
==========================================

1. ✅ Cargar proveedores al iniciar
2. ✅ Calcular ganancia en tiempo real
3. ✅ Validar precios (venta > compra)
4. ✅ DataTable con stock y proveedores
5. ✅ Alertas de stock bajo
-->

<style>
/* Estilos específicos para productos */
.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Hover effects mejorados */
.btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Estilos para inputs de precio */
#precio_compra, #precio_venta {
    background: linear-gradient(45deg, #e8f5e8 0%, #ffffff 100%);
}

/* Indicador de ganancia */
#ganancia_calculada {
    font-size: 1.1rem;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
}

/* Select de categorías con emojis */
#prod_categoria option {
    padding: 8px;
}

/* Indicador de stock bajo */
.badge.bg-warning {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .card-body {
        padding: 2rem 1.5rem;
    }
    
    .col-md-3, .col-md-4 {
        margin-bottom: 1rem;
    }
}
</style>