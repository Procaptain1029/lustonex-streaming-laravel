<?php

return [
    'dashboard' => [
        'title' => 'Dashboard',
        'operational_dashboard' => 'Dashboard Operativo',
        'realtime_monitoring' => 'Monitoreo de métricas y actividad en tiempo real',
        
        'stats' => [
            'total_models' => 'Modelos Totales',
            'models' => 'Modelos',
            'total_fans' => 'Fans Totales',
            'fans' => 'Fans',
            'live_now' => 'En Vivo Ahora',
            'subscriptions' => 'Suscripciones',
            'total_revenue' => 'Ingresos Totales',
            'global_platform' => 'Plataforma Global',
            'this_month' => 'este mes',
            'pending_review' => 'Pendientes de Revisión',
            'quick_access' => 'Accesos Rápidos',
        ],

        'recent_streams' => [
            'title' => 'Streams Recientes',
            'view_all' => 'Ver Todos',
            'model' => 'Modelo',
            'status' => 'Estado',
            'viewers' => 'Espectadores',
            'start' => 'Inicio',
            'live' => 'En vivo',
            'ended' => 'Terminado',
            'na' => 'N/A',
            'no_activity' => 'No hay actividad de streaming actualmente',
        ],

        'content' => [
            'photos' => 'Fotos',
            'videos' => 'Videos',
        ],

        'quick_links' => [
            'admin' => 'Admin',
            'models' => 'Modelos',
            'verification' => 'Verif.',
            'settings' => 'Config.',
        ],
    ],

    'analytics' => [
        'title' => 'Estadísticas',
        'dashboard_title' => 'Panel de Estadísticas',
        'subtitle' => 'Visualización inteligente de métricas críticas y rendimiento del ecosistema',
        
        'overview' => [
            'total_community' => 'Comunidad Total',
            'active_fans' => 'Fans Activos',
            'registered_models' => 'Modelos Registradas',
            'tokens_moved' => 'Tokens Movidos',
            'live_now' => 'Live Ahora',
            'vs_previous_month' => 'vs mes anterior',
            'real_time' => 'En tiempo real',
        ],

        'charts' => [
            'revenue_trend' => 'Tendencia de Ingresos',
            'live_data' => 'DATOS EN VIVO',
            'revenue_subtitle' => 'Análisis comparativo de los últimos 12 meses de operación',
            'real_time_viz' => 'Visualización de Datos en Tiempo Real',
            'projected_total' => 'Total proyectado:',
            'tokens' => 'tokens',
        ],

        'metrics' => [
            'user_engagement' => 'Engagement de Usuarios',
            'engagement_subtitle' => 'Comportamiento y retención de la audiencia',
            'avg_session' => 'Duración Media Sesión',
            'avg_concurrency' => 'Concurrencia Media',
            'viewers' => 'espectadores',
            'tip_volume' => 'Volumen de Propinas',
            'tips' => 'propinas',
            'sub_conversion' => 'Conversión a Subs',
            'users' => 'usuarios',

            'content_inventory' => 'Inventario de Contenido',
            'inventory_subtitle' => 'Volumen de medios generados por creadores',
            'published_photos' => 'Fotos Publicadas',
            'published_videos' => 'Videos Publicados',
            'live_broadcasts' => 'Total Emisiones en Vivo',
            'pending_moderation' => 'Pendiente Moderación',
            'items' => 'items',
        ],

        'top_models' => [
            'title' => 'Modelos destacadas (Top Models)',
            'subtitle' => 'Ranking de modelos por tokens acumulados',
            'rank' => 'Rango',
            'model' => 'Modelo',
            'contact' => 'Contacto',
            'accumulated_tokens' => 'Tokens Acumulados',
            'no_data' => 'No hay datos de rendimiento disponibles.',
        ],
    ],

    'content' => [
        'photos' => [
            'title' => 'Moderación de Fotos',
            'subtitle' => 'Revisa y aprueba el contenido visual de las creadoras',
            'total' => 'Total Fotos',
            'no_photos_title' => 'No hay fotos por aquí',
            'no_photos_desc' => '¡Buen trabajo! No se han encontrado fotos que coincidan con los filtros.',
            'info' => 'Información',
            'meta' => 'Metadatos',
            'views' => 'Vistas',
            'uploaded' => 'Subida',
            'file_size' => 'Tamaño de Archivo',
        ],
        'videos' => [
            'title' => 'Moderación de Videos',
            'subtitle' => 'Gestiona y aprueba las producciones de video de las creadoras',
            'total' => 'Total Videos',
            'no_videos_title' => 'No hay videos pendientes',
            'no_videos_desc' => 'No se han encontrado videos para moderar que coincidan con los filtros.',
            'delete_confirm' => '¿Eliminar este video permanentemente?',
        ],
        'status' => [
            'pending' => 'Pendientes',
            'approved' => 'Aprobadas',
            'rejected' => 'Rechazadas',
            'approved_masc' => 'Aprobados',
            'rejected_masc' => 'Rechazados',
            'single_pending' => 'Pendiente',
            'single_approved' => 'Aprobada',
            'single_rejected' => 'Rechazada',
            'single_approved_masc' => 'Aprobado',
            'single_rejected_masc' => 'Rechazado',
        ],
        'filters' => [
            'all' => 'Todas',
            'all_masc' => 'Todos',
            'filter_by_model' => 'Filtrar por modelo...',
            'search_by_title' => 'Buscar por título...',
            'filter_btn' => 'Filtrar',
            'clear_filters' => 'Limpiar filtros',
        ],
        'actions' => [
            'select_all' => 'Seleccionar Todo',
            'selected' => 'seleccionadas',
            'approve_selection' => 'Aprobar Selección',
            'reject_selection' => 'Rechazar Selección',
            'approve' => 'Aprobar',
            'reject' => 'Rechazar',
            'view' => 'Ver Video',
            'delete' => 'Eliminar',
        ],
        'misc' => [
            'untitled' => 'Sin título',
        ],
    ],

    'finance' => [
        'balance' => [
            'title' => 'Balance Financiero',
            'subtitle' => 'Estado financiero de la plataforma — ingresos, pagos y ganancia neta.',
            'token_rate' => '1 Token = :value USD',
            'total_income' => 'Ingresos Totales',
            'tokens_sold' => 'tokens vendidos',
            'model_payouts' => 'Pagos a Modelos',
            'payouts_desc' => 'Pagos completados y procesados',
            'net_profit' => 'Ganancia Neta',
            'profit_desc' => 'Ingresos menos pagos',
            'stats' => [
                'tokens_sold_title' => 'Tokens Vendidos',
                'tokens_sold_sub' => 'Compras acumuladas',
                'in_circulation' => 'En Circulación',
                'pending_withdrawals' => 'Pagos Pendientes',
                'pending_withdrawals_sub' => 'tokens',
                'active_subscriptions' => 'Suscripciones Activas',
                'completed_tips' => 'Propinas Completadas',
            ],
            'monthly' => [
                'income' => 'Ingreso Este Mes',
                'payouts' => 'Pagos Este Mes',
                'profit' => 'Ganancia Este Mes',
            ],
            'tables' => [
                'recent_tips' => 'Propinas Recientes',
                'view_all' => 'Ver todas',
                'sender' => 'Remitente',
                'tokens' => 'Tokens',
                'status' => 'Estado',
                'date' => 'Fecha',
                'recent_subs' => 'Suscripciones Recientes',
                'subscriber' => 'Suscriptor',
                'no_activity' => 'Sin actividad',
            ]
        ],
        'subscriptions' => [
            'title' => 'Suscripciones',
            'subtitle' => 'Gestiona los ingresos recurrentes y el estado de las membresías.',
            'stats' => [
                'total_charged' => 'Tokens Totales Cobrados',
                'total_charged_sub' => 'Acumulado histórico',
                'active_tokens' => 'Tokens Activos',
                'active_tokens_sub' => 'En suscripciones vigentes',
                'monthly_tokens' => 'Tokens Este Mes',
                'cancelled' => 'Canceladas',
                'cancelled_sub' => 'Retención perdida',
            ],
            'filters' => [
                'all' => 'Todas',
                'active' => 'Activas',
                'cancelled' => 'Canceladas',
                'expired' => 'Expiradas',
                'search' => 'Buscar...',
            ],
            'table' => [
                'subscriber' => 'Suscriptor (Fan)',
                'model' => 'Modelo (Creadora)',
                'cost' => 'Costo (Tokens)',
                'status' => 'Estado',
                'dates' => 'Inicio / Renovación',
                'actions' => 'Acciones',
                'deleted_user' => 'Usuario Eliminado',
                'deleted_model' => 'Modelo Eliminada',
                'renews' => 'Renueva:',
                'view_details' => 'Ver Detalles',
                'no_subs' => 'No hay suscripciones registradas.',
            ],
            'modal' => [
                'title' => 'Detalle de Suscripción',
                'fan' => 'Fan Suscriptor',
                'model' => 'Modelo Suscrita',
                'current_plan' => 'Plan Actual',
                'monthly' => 'Mensual',
                'cost' => 'Costo (Tokens)',
                'status' => 'Estado',
                'close' => 'Cerrar',
            ]
        ],
        'tips' => [
            'title' => 'Centro de Propinas',
            'subtitle' => 'Monitorea los gestos de gratitud y transacciones directas entre usuarios',
            'stats' => [
                'total_tokens' => 'Tokens en Propinas',
                'total_tokens_sub' => 'Acumulado histórico',
                'avg_tokens' => 'Promedio por Propina',
                'avg_tokens_sub' => 'Tokens promedio',
                'monthly_tokens' => 'Tokens Este Mes',
                'completed' => 'Completadas',
                'pending' => 'Pendientes',
            ],
            'filters' => [
                'all' => 'Todas',
                'completed' => 'Completadas',
                'pending' => 'Pendientes',
                'failed' => 'Fallidas',
                'search' => 'Buscar usuario o modelo...',
            ],
            'table' => [
                'sender' => 'Remitente (Fan)',
                'receiver' => 'Destinatario (Modelo)',
                'tokens' => 'Tokens',
                'status' => 'Estado',
                'date' => 'Fecha',
                'actions' => 'Acciones',
                'deleted_user' => 'Usuario Eliminado',
                'deleted_model' => 'Modelo Eliminada',
                'fan_role' => 'Fan',
                'model_role' => 'Modelo',
                'view_details' => 'Ver Detalles',
                'no_tips' => 'No se encontraron propinas registradas.',
            ],
            'modal' => [
                'title' => 'Detalle de Transacción',
                'tokens_sent' => 'Tokens Enviados',
                'tx_id' => 'ID Transacción',
                'date' => 'Fecha',
                'message' => 'Mensaje Adjunto',
                'no_message' => 'Sin mensaje',
                'from' => 'De (Fan)',
                'to' => 'Para (Modelo)',
                'close' => 'Cerrar',
            ]
        ],
    ],

    'gamification-2' => [
        'achievements' => [
            'index' => [
                'title' => 'Gestionar Logros',
                'title_header' => 'Logros',
                'subtitle' => 'Gestiona las recompensas y desafíos para gamificar la experiencia de usuario.',
                'create_btn' => 'Nuevo Logro',
                'filters' => [
                    'all' => 'Todas',
                    'active' => 'Activas',
                    'inactive' => 'Inativas',
                    'for_models' => 'Para Modelos',
                    'for_fans' => 'Para Fans',
                ],
                'table' => [
                    'icon' => 'Icono',
                    'achievement' => 'Logro',
                    'description' => 'Descripción',
                    'type_role' => 'Tipo / Rol',
                    'reward' => 'Recompensa',
                    'status' => 'Estado',
                    'actions' => 'Acciones',
                    'active' => 'Activa',
                    'inactive' => 'Inactiva',
                    'edit' => 'Editar',
                    'delete' => 'Eliminar',
                    'no_achievements' => 'No se encontraron misiones registradas.',
                ],
                'delete_alert' => [
                    'title' => '¿Eliminar este logro?',
                    'text' => 'Esta acción no se puede deshacer.',
                    'confirm' => 'Sí, eliminar',
                    'cancel' => 'Cancelar',
                ]
            ],
            'create' => [
                'title' => 'Crear Logro',
                'subtitle' => 'Configura un nuevo reconocimiento e hitos para la comunidad.',
            ],
            'edit' => [
                'title' => 'Editar Logro',
                'subtitle' => 'Modificando parámetros para: ":name"',
            ],
            'form' => [
                'basic_info' => 'Información Básica',
                'name' => 'Nombre',
                'name_placeholder' => 'Ej: Super Estrella',
                'slug' => 'Slug (Identificador)',
                'slug_placeholder' => 'ej: super-estrella',
                'description' => 'Descripción',
                'description_placeholder' => 'Describe qué debe hacer el usuario para obtener este logro...',
                'visualization' => 'Visualización',
                'icon' => 'Icono',
                'icon_placeholder' => 'fa-trophy',
                'rarity' => 'Rareza',
                'rarities' => [
                    'common' => 'Común (Gris)',
                    'rare' => 'Raro (Azul)',
                    'epic' => 'Épico (Morado)',
                    'legendary' => 'Legendario (Oro)',
                ],
                'category' => 'Categoría',
                'categories_list' => [
                    'content' => 'Contenido',
                    'earnings' => 'Ganancias',
                    'popularity' => 'Popularidad',
                    'special' => 'Especial',
                ],
                'rewards_rules' => 'Recompensas y Reglas',
                'role_recipient' => 'Rol Destinatario',
                'roles' => [
                    'fan' => 'Fans',
                    'model' => 'Modelos',
                    'both' => 'Ambos',
                ],
                'status' => 'Estado',
                'statuses' => [
                    'active' => 'Activo',
                    'inactive' => 'Inactivo',
                ],
                'xp' => 'XP (Experiencia)',
                'tickets' => 'Tickets (Moneda)',
                'tickets_edit' => 'Tickets',
                'cancel' => 'Cancelar',
                'submit_create' => 'Crear Logro',
                'submit_edit' => 'Guardar Cambios',
            ],
            'guide' => [
                'title' => 'Guía Rápida',
                'description' => 'Utiliza esta referencia para configurar correctamente las misiones.',
                'category' => 'Categoría',
                'category_desc' => 'Define en qué sección del perfil aparecerá el logro.',
                'rarity' => 'Rareza',
                'rarity_desc' => 'Determina el color del borde y el brillo de la tarjeta.',
                'slug' => 'Slug',
                'slug_desc' => 'Debe ser único y en formato \'kebab-case\' (ej: primer-login).',
                'stats_title' => 'Estadísticas',
                'stats_desc' => 'Información no editable.',
                'created_at' => 'Creado:',
            ],
        ],
        'levels' => [
            'index' => [
                'title' => 'Gestión de Niveles',
                'title_header' => 'Niveles de Gamificación',
                'subtitle' => 'Gestiona la estructura de progresión, experiencia y recompensas para las modelos.',
                'create_button' => 'Añadir Nuevo Nivel',
                'table' => [
                    'level' => 'Nivel',
                    'name_league' => 'Nombre / Liga',
                    'xp_required' => 'XP Requerida',
                    'rewards' => 'Recompensas',
                    'actions' => 'Acciones',
                    'standard' => 'Standard',
                    'no_tokens' => 'Sin tokens',
                    'tokens' => 'Tokens',
                    'edit' => 'Editar',
                    'delete' => 'Eliminar',
                ],
                'empty' => [
                    'title' => 'No hay niveles configurados',
                    'subtitle' => 'Comienza creando el primer nivel para tu sistema de gamificación.',
                    'action' => 'Crear Primer Nivel',
                ],
                'delete_alert' => [
                    'title' => '¿Eliminar este nivel?',
                    'text' => 'Esta acción no se puede deshacer.',
                    'confirm' => 'Sí, eliminar',
                    'cancel' => 'Cancelar',
                ]
            ],
            'create' => [
                'title' => 'Nuevo Nivel',
                'subtitle' => 'Define el nombre, número de nivel y los requisitos de progresión',
            ],
            'edit' => [
                'title' => 'Editar Nivel',
            ],
            'form' => [
                'basic_config' => 'Configuración Básica',
                'name' => 'Nombre del Nivel (Liga)',
                'name_placeholder' => 'Ej: Liga Verde - Novice',
                'name_helper' => 'Recomendado: Incluir \'Liga [Color]\' para asignación de medallas.',
                'level_number' => 'Número de Nivel',
                'xp_required' => 'XP Requerida',
                'role_recipient' => 'Rol Destinatario',
                'roles' => [
                    'both' => 'Ambos (Fan y Modelo)',
                    'fan' => 'Solo Fan',
                    'model' => 'Solo Modelo',
                ],
                'role_helper' => 'El sistema usará este filtro para asignar el nivel al usuario correcto.',
                'image' => 'Imagen del Nivel',
                'image_current' => 'Imagen actual',
                'image_preview' => 'Vista previa',
                'image_helper' => 'JPG, PNG o WebP. Máx. 2MB. Recomendado: 200x200px.',
                'rewards_section' => 'Recompensas al Alcanzar el Nivel',
                'bonus_tokens' => 'Tokens de Bonificación',
                'tokens_helper' => 'Tokens otorgados automáticamente al alcanzar este nivel.',
                'achievements' => 'Logros a Otorgar (Opcional)',
                'no_achievements' => 'No hay logros activos disponibles.',
                'achievements_helper' => 'Se otorgarán automáticamente al usuario cuando alcance este nivel.',
                'badges' => 'Insignias a Otorgar (Opcional)',
                'no_badges' => 'No hay insignias activas disponibles.',
                'badges_helper' => 'Se otorgarán automáticamente al usuario cuando alcance este nivel.',
                'cancel' => 'Cancelar',
                'submit_create' => 'Crear Nivel',
                'submit_edit' => 'Guardar Cambios',
            ],
        ],
        'missions' => [
            'index' => [
                'title' => 'Gestionar Misiones',
                'subtitle' => 'Configura misiones y desafíos para incentivar la participación en la plataforma',
                'stats' => [
                    'total' => 'Total Misiones',
                    'active' => 'Activas',
                    'weekly' => 'Semanales',
                ],
                'search_placeholder' => 'Buscar por nombre...',
                'create_button' => 'Nueva Misión',
                'table' => [
                    'mission' => 'Misión',
                    'type' => 'Tipo',
                    'goal' => 'Objetivo',
                    'rewards' => 'Recompensas',
                    'status' => 'Estado',
                    'actions' => 'Acciones',
                    'active' => 'Activa',
                    'inactive' => 'Inactiva',
                    'edit' => 'Editar',
                    'delete' => 'Eliminar',
                ],
                'empty' => [
                    'title' => 'No hay misiones',
                    'subtitle' => 'Aún no has creado ninguna misión o ninguna coincide con tu búsqueda.',
                ],
                'delete_alert' => [
                    'title' => '¿Eliminar esta misión?',
                    'text' => 'Esta acción no se puede deshacer.',
                    'confirm' => 'Sí, eliminar',
                    'cancel' => 'Cancelar',
                ]
            ],
            'create' => [
                'title' => 'Nueva Misión',
                'subtitle' => 'Define los objetivos y recompensas para una nueva misión',
            ],
            'edit' => [
                'title' => 'Editar Misión',
            ],
            'form' => [
                'basic_config' => 'Configuración Básica',
                'name' => 'Nombre de la Misión *',
                'name_placeholder' => 'Ej: Espectadora Fiel',
                'description' => 'Descripción',
                'description_placeholder' => 'Describe brevemente de qué trata esta misión...',
                'type' => 'Tipo de Misión *',
                'types' => [
                    'weekly' => 'Semanales (WEEKLY)',
                    'level_up' => 'Subida de Nivel (LEVEL_UP)',
                    'parallel' => 'Paralelas (PARALLEL)',
                ],
                'role_target' => 'Rol Objetivo *',
                'roles' => [
                    'both' => 'Ambos (Fan y Modelo)',
                    'fan' => 'Solo Fan',
                    'model' => 'Solo Modelo',
                ],
                'required_level' => 'Nivel Requerido',
                'no_level' => '-- Ninguno (Para todos) --',
                'level_prefix' => 'Nivel',
                'is_active' => 'Misión Activa',
                'goals_section' => 'Metas y Objetivos',
                'target_action' => 'Acción Objetivo *',
                'target_action_placeholder' => 'Ej: stream_watched',
                'target_action_helper' => 'Identificador interno de la acción (slug).',
                'goal_amount' => 'Cantidad Requerida *',
                'rewards_section' => 'Recompensas al Completar',
                'reward_xp' => 'Experiencia (XP) *',
                'reward_tickets' => 'Tickets *',
                'achievement' => 'Logro a Otorgar (Opcional)',
                'no_achievement' => '— Sin logro vinculado —',
                'achievement_helper' => 'El logro se desbloqueará automáticamente al completar esta misión.',
                'badge' => 'Insignia a Otorgar (Opcional)',
                'no_badge' => '— Sin insignia vinculada —',
                'badge_helper' => 'La insignia se otorgará automáticamente al completar esta misión.',
                'cancel' => 'Cancelar',
                'submit_create' => 'Crear Misión',
                'submit_edit' => 'Guardar Cambios',
            ],
            'guide' => [
                'title' => 'Guía Técnica',
                'types_title' => 'Tipos de Misión',
                'types' => [
                    'weekly' => 'Se reinician cada semana. Ideales para actividad recurrente.',
                    'level_up' => 'Misiones únicas para alcanzar ciertos hitos difíciles.',
                    'parallel' => 'Siempre activas, se pueden completar en cualquier momento.',
                ],
                'actions_title' => 'Acciones Comunes (Slugs)',
                'actions' => [
                    'stream_watched' => 'Ver transmisión (por minutos)',
                    'chat_message_sent' => 'Enviar mensajes en el chat',
                    'tip_sent' => 'Enviar propinas (tokens)',
                    'subscription_purchased' => 'Suscribirse a un perfil',
                    'profile_updated' => 'Actualizar perfil completo',
                    'photo_uploaded' => 'Subir fotos (Solo Modelos)',
                ],
                'tips_title' => 'Consejos',
                'tips_text' => 'Asegúrate de que la <strong>Cantidad Requerida</strong> sea alcanzable para el periodo de tiempo seleccionado. Para misiones semanales, calcula el esfuerzo de 7 días.',
            ],
        ],
        'badges' => [
            'index' => [
                'title' => 'Gestión de Insignias',
                'title_header' => 'Insignias del Sistema',
                'subtitle' => 'Gestiona las distinciones especiales y logros únicos de la comunidad.',
                'create_btn' => 'Nueva Insignia',
                'filters' => [
                    'all' => 'Todas',
                    'hall_of_fame' => 'Hall of Fame',
                    'event' => 'Eventos',
                    'milestone' => 'Hitos',
                    'special' => 'Especiales',
                ],
                'table' => [
                    'icon' => 'Icono',
                    'badge' => 'Insignia',
                    'description' => 'Descripción',
                    'category' => 'Categoría',
                    'status' => 'Estado',
                    'users' => 'Usuarios',
                    'actions' => 'Acciones',
                    'high_rarity' => 'RAREZA ALTA',
                    'active' => 'Activa',
                    'inactive' => 'Inactiva',
                    'no_badges' => 'No se encontraron insignias.',
                    'deactivate' => 'Desactivar',
                    'activate' => 'Activar',
                    'edit' => 'Editar',
                    'delete' => 'Eliminar',
                ],
                'delete_alert' => [
                    'title' => '¿Eliminar esta insignia?',
                    'text' => 'Esta acción no se puede deshacer.',
                    'confirm' => 'Sí, eliminar',
                    'cancel' => 'Cancelar',
                ],
            ],
            'create' => [
                'title' => 'Nueva Insignia',
                'subtitle' => 'Define los atributos visuales y reglas para este logro.',
            ],
            'edit' => [
                'title' => 'Editar Insignia',
                'subtitle' => 'Modificando apariencia y reglas de: ":name"',
            ],
            'form' => [
                'preview_name' => 'Nombre de Insignia',
                'name' => 'Nombre',
                'name_placeholder' => 'Ej: Streamer Elite',
                'icon' => 'Icono (Font Awesome)',
                'icon_placeholder' => 'fa-crown',
                'color' => 'Color Principal',
                'category' => 'Categoría',
                'categories' => [
                    'milestone' => 'Hito (Progresión)',
                    'hall_of_fame' => 'Hall of Fame',
                    'event' => 'Evento Especial',
                    'special' => 'Única / Manual',
                ],
                'description' => 'Descripción',
                'description_placeholder' => 'Describe brevemente este logro...',
                'requirements' => 'Requisitos Técnicos (JSON)',
                'req_key' => 'Clave (ej: followers)',
                'req_val' => 'Valor (ej: 1000)',
                'req_key_placeholder' => 'Clave',
                'req_val_placeholder' => 'Valor',
                'add_req' => 'Añadir Parámetro',
                'active_now' => 'Activar inmediatamente',
                'is_active' => 'Insignia Activa',
                'cancel' => 'Cancelar',
                'submit_create' => 'Crear Insignia',
                'submit_edit' => 'Guardar Cambios',
            ],
        ],
    ],
    'layout' => [
        'app' => [
            'toastr_success' => 'Éxito',
            'toastr_error' => 'Error',
            'toastr_warning' => 'Advertencia',
            'toastr_info' => 'Información',
        ],
    ],

    'logs' => [
        'title' => 'Logs del Sistema',
        'breadcrumb' => 'Logs de Auditoría',
        'title_header' => 'Registros del Sistema',
        'subtitle' => 'Auditoría completa de seguridad y rastreo de accesos.',
        
        'filters' => [
            'all' => 'Todos',
            'errors' => 'Errores',
            'warnings' => 'Avisos',
            'info' => 'Info',
            'search' => 'Buscar ID, IP o usuario...',
        ],
        
        'table' => [
            'severity' => 'Severidad',
            'message_event' => 'Mensaje y Evento',
            'user' => 'Usuario Responsable',
            'ip' => 'Origen (IP)',
            'date' => 'Fecha',
            'actions' => 'Acciones',
            'guest' => 'System / Guest',
            'view_payload' => 'Ver Payload',
            'copy_id' => 'Copiar ID',
            'empty' => 'No hay registros de auditoría recientes.',
        ],

        'modal' => [
            'title' => 'Detalle del Log',
            'message' => 'Mensaje',
            'payload' => 'Payload / Datos',
            'close' => 'Cerrar',
        ],
    ],

    'messages' => [
        'title' => 'Moderación de Mensajes',
        'breadcrumb' => 'Mensajes',
        'subtitle' => 'Modera mensajes entre usuarios',
        
        'stats' => [
            'total' => 'Total Mensajes',
            'flagged' => 'Mensajes Marcados',
            'today' => 'Hoy',
        ],
        
        'filters' => [
            'search' => 'Buscar contenido...',
            'all_users' => 'Todos los usuarios',
            'all' => 'Todos',
            'flagged' => 'Marcados',
            'normal' => 'Normales',
            'filter_btn' => 'Filtrar',
        ],
        
        'table' => [
            'from' => 'De',
            'to' => 'Para',
            'message' => 'Mensaje',
            'status' => 'Estado',
            'date' => 'Fecha',
            'actions' => 'Acciones',
            'flagged' => 'Marcado',
            'normal' => 'Normal',
            'unflag' => 'Desmarcar',
            'flag' => 'Marcar',
            'delete' => 'Eliminar',
            'delete_confirm' => '¿Eliminar este mensaje?',
            'empty' => 'No hay mensajes registrados',
        ],
    ],

    'models-2' => [
        'index' => [
            'title' => 'Gestión de Modelos',
            'breadcrumb' => 'Modelos',
            'subtitle' => 'Modera creadoras, verifica perfiles y monitorea actividad',
            
            'filters' => [
                'all' => 'Todos',
                'pending' => 'Pendientes',
                'verified' => 'Verificadas',
                'search' => 'Buscar por nombre o email...',
            ],
            
            'table' => [
                'model' => 'Modelo',
                'status_verification' => 'Estado / Verificación',
                'registration' => 'Registro',
                'actions' => 'Acciones',
                'live' => '🔴 En Vivo',
                
                'status' => [
                    'pending' => 'Pendiente',
                    'under_review' => 'En revisión',
                    'approved' => 'Verificada',
                    'rejected' => 'Rechazada',
                    'default' => 'Pendiente',
                ],
                
                'view_profile' => 'Ver Perfil Público',
                'view_details' => 'Ver Detalles',
            ],
            
            'empty' => [
                'title' => 'No se encontraron modelos',
                'subtitle' => 'No hay creadoras registradas que coincidan con los criterios de búsqueda.',
                'clear_filters' => 'Limpiar filtros',
            ],
        ],
        'show' => [
            'title' => 'Detalles de Modelo',
            'role' => 'Modelo',
            
            'info' => [
                'status' => 'Estado',
                'active' => 'Activa',
                'suspended' => 'Suspendida',
                'verification' => 'Verificación',
                'member_since' => 'Miembro Desde',
                'last_activity' => 'Última Actividad',
                'stream_status' => 'Estado Stream',
                'live' => 'En Vivo',
                'back_to_list' => 'Volver a la lista',
            ],
            
            'stats' => [
                'title' => 'Estadísticas de Modelo',
                'subscribers' => 'Suscriptores',
                'total_earnings' => 'Ganancias Totales',
                'content' => 'Contenido',
            ],
            
            'verification' => [
                'title' => 'Estado de Verificación',
                'review' => 'Revisar Verificación',
                'notes' => 'Notas:',
            ],
            
            'content_summary' => [
                'title' => 'Resumen de Contenido',
                'photos' => 'Fotos',
                'videos' => 'Videos',
                'total_streams' => 'Streams Totales',
                'tips_received' => 'Propinas Recibidas',
            ],
        ],
    ],

    'reports' => [
        'title' => 'Gestión de Reportes',
        'breadcrumb' => 'Reportes',
        'subtitle' => 'Modera y asegura la calidad de la comunidad mediante la resolución de conflictos.',
        
        'stats' => [
            'total' => 'Total Reportes',
            'pending' => 'Pendientes',
            'resolved' => 'Resueltos',
            'dismissed' => 'Descartados',
        ],
        
        'filters' => [
            'all' => 'Todos',
            'pending' => 'Pendientes',
            'resolved' => 'Resueltos',
            'dismissed' => 'Descartados',
            'search' => 'Buscar usuario o ID...',
        ],
        
        'table' => [
            'reported_by' => 'Reportado Por',
            'reported_item' => 'Elemento Reportado',
            'type' => 'Tipo',
            'reason' => 'Motivo',
            'status' => 'Estado',
            'date' => 'Fecha',
            'actions' => 'Acciones',
            'deleted_content' => 'Contenido Eliminado',
            'view_details' => 'Ver Detalles',
            'resolve' => 'Resolver',
            'dismiss' => 'Descartar',
            'empty' => 'No hay reportes que coincidan con la búsqueda.',
        ],

        'modal' => [
            'title' => 'Detalle del Reporte',
            'reported_by' => 'Reportado Por',
            'reporter_user' => 'Usuario Informante',
            'reported_content_user' => 'Contenido / Usuario Reportado',
            'reason_title' => 'MOTIVO DEL REPORTE',
            'close' => 'Cerrar',
            'deleted' => 'Eliminado',
            'unknown' => 'Desconocido',
            'no_reason' => 'Sin motivo especificado',
        ],

        'exports' => [
            'title' => 'Exportación de Reportes',
            'subtitle' => 'Selecciona el conjunto de datos que deseas descargar en formato CSV.',
            'users' => [
                'label' => 'Usuarios',
                'desc' => 'Base de datos completa de fans y modelos con estado de verificación KYC.',
            ],
            'transactions' => [
                'label' => 'Transacciones',
                'desc' => 'Historial de compras de tokens, métodos de pago y estados financieros.',
            ],
            'withdrawals' => [
                'label' => 'Liquidaciones',
                'desc' => 'Reporte de pagos procesados para modelos y solicitudes pendientes.',
            ],
            'streams' => [
                'label' => 'Actividad Streams',
                'desc' => 'Métricas de tiempo al aire, audiencia máxima y tokens generados.',
            ],
            'subscriptions' => [
                'label' => 'Suscripciones',
                'desc' => 'Listado de membresías activas, fans suscritos y modelos beneficiarias.',
            ],
            'download' => 'Descargar CSV',
            'info_box' => [
                'title' => 'Información:',
                'text' => 'Los archivos exportados utilizan el estándar UTF-8. Si abres el archivo en Microsoft Excel y ves caracteres extraños, utiliza la opción "Obtener datos desde texto/CSV" y selecciona el origen de archivo 65001: Unicode (UTF-8).',
            ],
        ],
    ],

    'settings' => [
        'title' => 'Configuración de Plataforma',
        'breadcrumb' => 'Configuración',
        'header_title' => 'Configuración del Sistema',
        'header_subtitle' => 'Gestiona los parámetros globales de la plataforma, preferencias de pagos y seguridad.',
        
        'nav' => [
            'general' => 'General',
            'finance' => 'Finanzas',
            'media' => 'Multimedia',
            'security' => 'Seguridad',
        ],
        
        'general' => [
            'title' => 'Identidad & Sistema',
            'desc' => 'Configuración básica de la marca y accesibilidad.',
            'site_name' => 'Nombre de la Plataforma',
            'default_locale' => 'Idioma Global por Defecto',
            'locales' => [
                'es' => 'Español',
                'en' => 'Inglés',
                'pt_BR' => 'Portugués (Brasil)',
            ],
            'locale_help' => 'Idioma por defecto para usuarios no logueados o sin preferencia.',
            'seo_desc' => 'Descripción SEO (Meta)',
            'maintenance_mode' => 'Modo Mantenimiento',
            'maintenance_mode_desc' => 'Desactiva el acceso público temporalmente.',
        ],
        
        'finance' => [
            'title' => 'Economía & Pagos',
            'desc' => 'Reglas de negocio, comisiones y tasas de cambio.',
            'commission_rate' => 'Comisión Plataforma (%)',
            'min_withdrawal' => 'Mínimo Pago (USD)',
            'token_value' => 'Valor del Token (USD)',
            'token_help' => 'Define cuánto vale 1 token en dólares americanos para los usuarios.',
        ],
        
        'media' => [
            'title' => 'Multimedia & Streaming',
            'desc' => 'Calidad de video y límites de almacenamiento.',
            'stream_quality' => 'Calidad de Streaming Predeterminada',
            'qualities' => [
                'sd' => 'SD (480p)',
                'hd' => 'HD (720p)',
                'fhd' => 'Full HD (1080p)',
                '4k' => 'Ultra HD (4K)',
            ],
            'upload_limit' => 'Límite de Subida (MB)',
        ],
        
        'security' => [
            'title' => 'Seguridad & Acceso',
            'desc' => 'Controles de registro y verificación.',
            'allow_registrations' => 'Permitir Nuevos Registros',
            'allow_registrations_desc' => 'Usuarios pueden crear cuentas libremente.',
            'email_verification' => 'Verificación de Email Requerida',
            'email_verification_desc' => 'Obligatorio para acceder a funciones de la plataforma.',
        ],
        
        'save' => [
            'unsaved' => 'Tienes cambios sin guardar',
            'button' => 'Guardar Cambios',
        ],
    ],

    'streams' => [
        'title' => 'Gestionar Streams',
        'breadcrumb' => 'Streams',
        'subtitle' => 'Monitorea y modera streams en vivo',
        'wall_button' => 'Muro de Moderación',
        'list_button' => 'Vista de Lista',
        
        'stats' => [
            'total' => 'Total Streams',
            'live' => 'En Vivo',
            'ended' => 'Finalizados',
            'viewers' => 'Viewers',
        ],
        
        'filters' => [
            'all' => 'Todos',
            'live' => 'En Vivo',
            'scheduled' => 'Programados',
            'ended' => 'Finalizados',
            'search_placeholder' => 'Buscar por título...',
            'filter_button' => 'Filtrar',
            'clear' => 'Limpiar filtros',
        ],
        
        'badges' => [
            'live' => 'EN VIVO',
            'live_badge' => 'En Vivo',
            'ended' => 'Finalizado',
            'scheduled' => 'Programado',
            'historical' => 'Histórico',
        ],
        
        'actions' => [
            'view_mod' => 'Ver en Moderación',
            'end_stream' => 'Finalizar Stream',
            'end_confirm' => '¿Finalizar este stream?',
            'end_trans' => 'Finalizar Transmisión',
            'end_confirm_trans' => '¿Finalizar esta transmisión?',
            'moderating' => 'Moderando',
            'untitled' => 'Sin título',
        ],
        
        'empty' => [
            'title' => 'No hay streams encontrados',
            'desc' => 'No se han encontrado transmisiones que coincidan con los filtros.',
            'mod_title' => 'No hay transmisiones activas',
            'mod_desc' => 'En este momento no hay modelos transmitiendo en vivo.',
        ],
        
        'moderate' => [
            'title' => 'Moderación de Transmisiones',
            'header' => 'Muro de Moderación',
            'subtitle' => 'Monitoreo en tiempo real de transmisiones activas',
        ],
    ],

    'token_packages' => [
        'title' => 'Paquetes de Tokens',
        'breadcrumb' => 'Paquetes de Tokens',
        'create_title' => 'Crear Paquete',
        'edit_title' => 'Editar Paquete',
        'create_header' => 'Nuevo Paquete',
        'create_subtitle' => 'Configura las recompensas y costo del paquete de tickets',
        'edit_header' => 'Editar Paquete',
        'edit_subtitle' => 'Actualizar recompensas y costo del paquete:',
        'add_button' => 'Nuevo Paquete',
        
        'table' => [
            'id' => 'ID',
            'name_tokens' => 'Nombre / Tokens',
            'price' => 'Precio (USD)',
            'bonus' => 'Bono',
            'features' => 'Características',
            'status' => 'Estado',
            'actions' => 'Acciones',
        ],
        
        'features' => [
            'limited_time' => 'Tiempo Limitado',
            'expires' => 'Expira:',
            'permanent' => 'Permanente',
        ],
        
        'status' => [
            'expired' => 'Expirado',
            'active' => 'Activo',
            'inactive' => 'Inactivo',
        ],
        
        'actions' => [
            'edit' => 'Editar',
            'delete' => 'Eliminar',
            'delete_confirm' => '¿Estás seguro de que deseas eliminar este paquete de tokens?',
        ],
        
        'empty' => 'No hay paquetes de tokens configurados.',
        
        'form' => [
            'config_title' => 'Configuración del Paquete',
            'name_label' => 'Nombre del Paquete *',
            'name_placeholder' => 'Ej: Paquete Básico',
            'tokens_label' => 'Cantidad de Tokens *',
            'bonus_label' => 'Bono de Tokens',
            'price_label' => 'Precio (USD) *',
            
            'availability_title' => 'Disponibilidad',
            'active_label' => 'Paquete Activo',
            'active_desc' => 'Visible para usuarios',
            'limited_label' => 'Tiempo Limitado',
            'limited_desc' => 'Promoción especial',
            'expires_label' => 'Fecha y Hora de Expiración *',
            
            'cancel' => 'Cancelar',
            'create_btn' => 'Crear Paquete',
            'update_btn' => 'Actualizar Paquete',
        ],
        
        'guide' => [
            'title' => 'Guía Comercial',
            'bonus_title' => 'Estrategia de Bonos',
            'bonus_desc' => 'Los bonos incentivan la compra de paquetes más grandes. Un bono del 10% al 20% es ideal para empezar.',
            'popular_title' => 'Paquetes Populares',
            'pop_1_val' => '100 Tokens',
            'pop_1_desc' => 'Paquete de entrada, ideal para pruebas.',
            'pop_2_val' => '1000 Tokens',
            'pop_2_desc' => 'Suele ser el más vendido. Ofrece un pequeño bono.',
            'pop_3_val' => '5000 Tokens',
            'pop_3_desc' => 'Para usuarios VIP. El bono debe ser muy atractivo.',
            'time_title' => 'Tiempo Limitado',
            'time_desc' => 'Utiliza paquetes de <strong>Tiempo Limitado</strong> durante días festivos (San Valentín, Navidad). Estos paquetes suelen ofrecer +50% de bonificación sobre los paquetes regulares.',
        ],
    ],

    'tokens' => [
        'title' => 'Gestión de Tokens',
        'breadcrumb' => 'Tokens',
        'header' => 'Economía y Tokens',
        'subtitle' => 'Auditoría en tiempo real del flujo de tokens y transacciones de la plataforma.',
        
        'stats' => [
            'total_sales' => 'Ventas Totales',
            'purchased_desc' => 'Tokens comprados',
            'in_circulation' => 'En Circulación',
            'earned_desc' => 'Balance actual de usuarios',
            'total_spent' => 'Gasto Total',
            'spent_desc' => 'Tokens consumidos',
            'active_users' => 'Usuarios Activos',
            'users_desc' => 'Participantes en economía',
        ],
        
        'filters' => [
            'all' => 'Todos',
            'purchases' => 'Compras 💰',
            'spent' => 'Gasto 🛒',
            'earned' => 'Ganancias 📈',
            'refund' => 'Reembolsos ↩️',
        ],
        
        'table' => [
            'title' => 'Registro de Transacciones',
            'user' => 'Usuario',
            'type' => 'Tipo',
            'amount' => 'Monto',
            'concept' => 'Concepto',
            'date' => 'Fecha',
            'deleted_user' => 'Usuario Eliminado',
            'internal_movement' => 'Movimiento interno',
            'empty' => 'No hay transacciones registradas.',
        ],
        
        'leaderboard' => [
            'title' => 'Usuarios Top',
            'user' => 'Usuario',
            'tokens' => 'Tokens',
            'empty' => 'Sin datos',
        ],
    ],

    'users' => [
        'title' => 'Gestión de Usuarios',
        'breadcrumb' => 'Usuarios',
        'header' => 'Gestión de Usuarios',
        'subtitle' => 'Administra fans, modelos y permisos del sistema.',
        
        'search_placeholder' => 'Buscar por nombre o email...',
        'add_button' => 'Añadir Usuario',
        
        'table' => [
            'user' => 'Usuario',
            'role_level' => 'Rol / Nivel',
            'status' => 'Estado',
            'registered' => 'Registro',
            'actions' => 'Acciones',
        ],
        
        'roles' => [
            'admin' => 'Admin',
            'model' => 'Modelo',
            'fan' => 'Fan',
        ],
        
        'status' => [
            'online' => 'Conectado',
            'offline' => 'Desconectado',
        ],
        
        'actions' => [
            'view' => 'Ver Perfil',
            'edit' => 'Editar',
            'disable' => 'Inhabilitar',
            'enable' => 'Habilitar',
        ],
        
        'empty' => [
            'title' => 'No se encontraron usuarios',
            'description' => 'Prueba con otros términos de búsqueda o filtros.',
            'clear' => 'Limpiar búsqueda',
        ],
        
        'modal' => [
            'title' => 'Confirmar Acción',
            'message' => '¿Estás seguro de realizar esta acción?',
            'cancel' => 'Cancelar',
            'confirm' => 'Confirmar',
        ],

        'create' => [
            'title' => 'Crear Usuario',
            'breadcrumb' => 'Nuevo Usuario',
            'header' => 'Nuevo Usuario',
            'subtitle' => 'Configura las credenciales y rol del nuevo integrante',
            
            'form' => [
                'name' => 'Nombre Completo *',
                'name_placeholder' => 'Nombre y apellidos',
                'email' => 'Correo Electrónico *',
                'email_placeholder' => 'correo@ejemplo.com',
                'password' => 'Contraseña *',
                'password_placeholder' => 'Mínimo 8 caracteres',
                'password_confirm' => 'Confirmar Contraseña *',
                'password_confirm_placeholder' => 'Repite la contraseña',
                
                'role' => 'Asignar Rol *',
                'role_select' => 'Seleccionar rol...',
                'role_fan' => '👤 Fan Premium',
                'role_fan_desc' => '<strong>Fan Premium:</strong> Permite seguir modelos, suscribirse a contenido exclusivo y participar en chats en vivo.',
                'role_model' => '👸 Modelo / Creadora',
                'role_model_desc' => '<strong>Modelo / Creadora:</strong> Acceso a herramientas de streaming, gestión de contenido y panel de ingresos.',
                'role_admin' => '🛡️ Administrador',
                'role_admin_desc' => '<strong>Administrador:</strong> Acceso total al sistema, moderación de contenido y analíticas de la plataforma.',
                
                'initial_config' => 'Configuración Inicial',
                'activate_now' => 'Activar cuenta inmediatamente',
                'activate_now_desc' => 'El usuario podrá acceder al sistema tras su creación.',
                'notice' => 'El sistema generará automáticamente las estructuras necesarias según el rol asignado. Verifica que el email sea correcto para notificaciones del sistema.',
                
                'cancel' => 'Cancelar',
                'submit' => 'Crear Usuario',
            ],
            
            'tips' => [
                'security_title' => 'Seguridad',
                'sec_1' => 'Usa mínimo 8 caracteres con símbolos.',
                'sec_2' => 'Verifica el dominio del email siempre.',
                'sec_3' => 'No reutilices contraseñas de otros usuarios.',
                
                'roles_title' => 'Roles',
                'role_fan' => '<strong style="color:#fff;">Fan</strong> — Consumidor de contenido',
                'role_model' => '<strong style="color:#fff;">Modelo</strong> — Creadora de contenido',
                'role_admin' => '<strong style="color:#fff;">Admin</strong> — Acceso total al sistema',
                'role_notice' => 'El rol puede modificarse desde la edición del usuario.',
                
                'shortcuts_title' => 'Accesos Rápidos',
                'link_users' => 'Ver todos los usuarios',
                'link_models' => 'Gestionar modelos',
                'link_verification' => 'Verificaciones pendientes',
            ],
        ],

        'edit' => [
            'title' => 'Editar Usuario',
            'breadcrumb' => 'Editar',
            'header' => 'Editar Perfil',
            
            'form' => [
                'name' => 'Nombre Completo *',
                'name_placeholder' => 'Ej. Juan Pérez',
                'email' => 'Correo Electrónico *',
                'email_placeholder' => 'ejemplo@email.com',
                
                'role' => 'Rol del Usuario *',
                'role_fan' => '👥 Fan',
                'role_model' => '👩‍💼 Modelo',
                'role_admin' => '👑 Administrador',
                
                'status' => 'Estado',
                'user_active' => 'Usuario Activo',
                
                'password_new' => 'Nueva Contraseña (Opcional)',
                'password_new_placeholder' => 'Dejar vacío para mantener la actual',
                'password_new_help' => 'Mínimo 8 caracteres.',
                'password_confirm' => 'Confirmar Contraseña',
                'password_confirm_placeholder' => 'Repite la nueva contraseña',
                
                'cancel' => 'Cancelar',
                'submit' => 'Guardar Cambios',
            ],
        ],

        'show' => [
            'title' => 'Detalles de Usuario',
            
            'profile' => [
                'status' => 'Estado',
                'active' => 'Activo',
                'suspended' => 'Suspendido',
                'member_since' => 'Miembro Desde',
                'last_access' => 'Último Acceso',
                
                'actions' => [
                    'edit' => 'Editar',
                    'debug' => 'Debug',
                    'back' => 'Volver a la lista',
                ],
            ],
            
            'stats' => [
                'title' => 'Estadísticas de Juego',
                'level' => 'Nivel',
                'experience' => 'Experiencia',
                'tickets' => 'Tickets',
                'xp_to_next_level' => '% para Nivel',
            ],
            
            'missions' => [
                'title' => 'Historial de Misiones',
                'completed' => 'Completada',
                'progress' => 'Progresso:',
                'empty' => 'El usuario aún no ha iniciado ninguna misión.',
            ],
        ],
    ],

    'verification' => [
        'index' => [
            'title' => 'Verificación de Identidad',
            'subtitle' => 'Gestiona y valida la identidad de las modelos para garantizar la seguridad de la plataforma',
            
            'filters' => [
                'all' => 'Todos',
                'pending' => 'Pendientes',
                'approved' => 'Aprobados',
                'rejected' => 'Rechazados',
            ],
            
            'table' => [
                'model' => 'Modelo',
                'email' => 'Email',
                'status' => 'Estado de Verificación',
                'actions' => 'Acciones',
                
                'id_prefix' => 'ID: #',
                'email_verified' => 'Email verificado',
                'email_unverified' => 'Email no verificado',
                
                'status_approved' => 'Aprobado',
                'status_under_review' => 'En Revisión',
                'status_rejected' => 'Rechazado',
                'status_pending' => 'Pendiente',
                
                'action_approve_email' => 'Aprovar Email',
                'action_review' => 'Revisar Perfil',
            ],
            
            'empty' => [
                'title' => 'Sin solicitudes pendientes',
                'subtitle' => 'No hay verificaciones que coincidan con los filtros seleccionados.',
                'action' => 'Ver todos los registros',
            ],
            
            'modal' => [
                'approve_title' => '¿Aprobar email manualmente?',
                'approve_desc' => 'Esta acción marcará el email del usuario como verificado.',
                'confirm' => 'Sí, aprobar',
                'cancel' => 'Cancelar',
            ],
        ],

        'show' => [
            'title' => 'Revisión de Identidad',
            'subtitle' => 'Valida los documentos para otorgar la insignia de verificación',
            'breadcrumb' => 'Detalle',
            
            'profile' => [
                'id' => 'ID: #',
                'email' => 'Email: ',
                'email_verified' => 'Email Verificado',
                'email_unverified' => 'Email No Verificado',
                
                'legal_name' => 'Nombre Legal',
                'country' => 'País',
                'age' => 'Edad (Nacimiento)',
                'years' => 'años',
                'id_document' => 'Documento ID',
                'registered_at' => 'Fecha Registro',
                'not_provided' => '—',
            ],
            
            'documents' => [
                'title' => 'Documentos Adjuntos',
                'front' => 'FRENTE DEL DOCUMENTO',
                'back' => 'DORSO DEL DOCUMENTO',
                'selfie' => 'SELFIE VIP C/ ID',
                'empty' => 'No se han subido documentos de identidad.',
            ],
            
            'resolution' => [
                'title' => 'Resolución',
                'notes_label' => 'Notas Adicionales (Opcional)',
                'notes_placeholder' => 'Notas visibles solo para administradores...',
                'btn_approve' => 'APROBAR PERFIL',
                
                'reject_reason_label' => 'Motivo de Rechazo (Requerido)',
                'reject_reason_placeholder' => 'Explica por qué se rechaza...',
                'btn_reject' => 'RECHAZAR SOLICITUD',
                'confirm_reject' => '¿Confirmar rechazo?',
                
                'verified_desc' => 'Este perfil ya ha sido revisado y aprobado.',
            ],
        ],
    ],

    'withdrawals' => [
        'index' => [
            'title' => 'Pagos a Modelos',
            'subtitle' => 'Gestión financiera centralizada para pagos.',
            'breadcrumb' => 'Pagos',
            
            'stats' => [
                'pending' => 'Pendiente de Aprobación',
                'pending_amount' => 'tokens',
                'processed_today' => 'Procesados Hoy',
                'processed_today_desc' => 'Transacciones completadas',
                'total_processed' => 'Total Tokens Procesados',
                'total_processed_desc' => 'Tokens convertidos exitosamente',
            ],
            
            'filters' => [
                'all' => 'Todos',
                'pending' => 'Pendientes',
                'completed' => 'Completados',
                'rejected' => 'Rechazados',
            ],
            
            'table' => [
                'model' => 'Modelo',
                'tokens' => 'Tokens',
                'net' => 'Neto (Tokens)',
                'method' => 'Método',
                'status' => 'Estado',
                'date' => 'Fecha',
                'actions' => 'Acciones',
                
                'deleted_user' => 'Usuario Eliminado',
                'empty' => 'No hay solicitudes de pago.',
                
                'action_view' => 'Ver Detalles',
                'action_approve' => 'Aprobar',
                'action_reject' => 'Rechazar',
            ],
            
            'modal' => [
                'approve_title' => 'Aprobar Pago',
                'approve_desc' => 'Estás a punto de aprobar la conversión de tokens para',
                'approve_requested' => 'Tokens Solicitados',
                'approve_net' => 'Neto después de comisión:',
                'confirm_approve' => 'Confirmar Pago',
                
                'reject_title' => 'Rechazar Solicitud',
                'reject_reason_label' => 'Motivo del rechazo',
                'reject_reason_placeholder' => 'Explique la razón...',
                'confirm_reject' => 'Rechazar',
                
                'cancel' => 'Cancelar',
            ],
        ],

        'show' => [
            'title' => 'Detalle de Pago #',
            'subtitle' => 'Información completa de la solicitud de pago',
            'breadcrumb' => 'Pago #',
            
            'info' => [
                'title' => 'Información del Pago',
                'status' => 'Estado:',
                'model' => 'Modelo:',
                'requested_amount' => 'Monto Solicitado:',
                'fee' => 'Comisión:',
                'net_amount' => 'Monto Neto:',
                'payment_method' => 'Método de Pago:',
                'notes' => 'Notas:',
                'reject_reason' => 'Razón del Rechazo:',
            ],
            
            'status' => [
                'pending' => 'PENDIENTE',
                'processing' => 'PROCESANDO',
                'completed' => 'COMPLETADO',
                'rejected' => 'RECHAZADO',
                'cancelled' => 'CANCELADO',
            ],
            
            'payment_details' => [
                'title' => 'Detalles de Pago',
                'bank' => 'Banco:',
                'account_holder' => 'Titular:',
                'account_number' => 'Número de Cuenta:',
                'swift' => 'SWIFT/BIC:',
                'paypal_email' => 'Email PayPal:',
                'stripe_account' => 'Stripe Account:',
                'crypto_type' => 'Criptomoneda:',
                'wallet_address' => 'Wallet Address:',
                'empty' => 'No hay detalles de pago disponibles',
            ],
            
            'dates' => [
                'title' => 'Fechas',
                'requested' => 'Solicitado:',
                'processed' => 'Procesado:',
            ],
            
            'actions' => [
                'title' => 'Acciones',
                'approve' => 'Aprobar Pago',
                'reject' => 'Rechazar Pago',
                'back' => 'Volver a la Lista',
            ],
            
            'modal' => [
                'approve_title' => 'Aprobar Pago #',
                'approve_desc' => '¿Estás seguro de que deseas aprobar este pago?',
                'approve_model' => 'Modelo:',
                'approve_amount' => 'Monto:',
                'approve_net' => 'Neto:',
                'approve_method' => 'Método:',
                'btn_cancel' => 'Cancelar',
                'btn_approve' => 'Aprobar Pago',
                
                'reject_title' => 'Rechazar Pago #',
                'reject_reason_label' => 'Razón del Rechazo *',
                'reject_reason_placeholder' => 'Explica por qué se rechaza este pago...',
                'btn_reject' => 'Rechazar Pago',
            ],
        ],
    ],

    'gamification' => [
        'xp_settings' => [
            'title' => 'Configuración Global de XP',
            'subtitle' => 'Define el XP que reciben los modelos por cada acción automática del sistema.',
            'breadcrumb' => 'Configuración XP',
            'breadcrumb_parent' => 'Gamificación',
            
            'fans' => [
                'title' => 'XP por Acción — Fans',
                'tokens_purchased' => 'Compra de Tokens (100%)',
                'tokens_purchased_desc' => 'Ratio para convertir tokens comprados a XP (Ej: si pones 10, cada 10 tokens comprados se premian con 10 XP; es decir 1:1)',
                
                'tip_sent' => 'Enviar Tips (100%)',
                'tip_sent_desc' => 'Ratio para convertir tokens donados en XP (Ej: si pones 10, enviar un tip de 10 suma 10 XP)',
                
                'subscription' => 'Suscribirse a un Modelo',
                'subscription_desc' => 'XP fijo que recibe el Fan cada vez que compra una suscripción a un modelo.',
                
                'chat_message' => 'Enviar Mensaje en Chat',
                'chat_message_desc' => 'XP fijo que recibe el Fan por enviar mensajes.',
                
                'stream_view' => 'Entrar a un Stream',
                'stream_view_desc' => 'XP fijo por unirse al stream de un modelo.',
            ],
            
            'models' => [
                'title' => 'XP por Acción — Modelos',
                'tip_received' => 'Recibir Tips (10%)',
                'tip_received_desc' => '% del total del tip que se convierte en XP (Ej: si pones 10, y recibe 100 de tip, gana 10 XP)',
                
                'new_subscriber' => 'Nuevo Suscriptor',
                'new_subscriber_desc' => 'XP fijo que recibe el modelo cada vez que gana un nuevo suscriptor.',
                
                'chat_message' => 'Recibir Mensaje en Chat',
                'chat_message_desc' => 'XP fijo por cada mensaje que los fans le envíen en chat.',
                
                'stream_view' => 'Espectador de Stream',
                'stream_view_desc' => 'XP fijo por cada visualización/ingreso de un fan a su streaming.',
            ],
            
            'units' => [
                'base_percent' => '% base',
                'fixed_xp' => 'XP fijo',
                'reward_percent' => '% premio',
            ],
            
            'save' => 'Guardar Cambios',
            
            'note' => 'Nota:',
            'note_desc' => 'Los cambios aplican inmediatamente para futuros eventos. Las acciones pasadas no se recalculan. Los eventos de <em>chat</em> y <em>stream_view</em> deben estar disparados hacia el listener para que estos valores tengan efecto.',
        ],
    ],

    'flash' => [
        'users' => [
            'email_approved'       => 'El email fue aprobado manualmente.',
            'verification_sent'    => 'Correo de verificación reenviado correctamente.',
            'verification_testing' => 'Sistema en pruebas: el envío de correos se habilitará en producción.',
            'already_verified'     => 'Este usuario ya tiene su email verificado.',
            'created'              => 'Usuario creado correctamente.',
            'updated'              => 'Usuario actualizado correctamente.',
            'cannot_delete_self'   => 'No puedes eliminar tu propia cuenta.',
            'deleted'              => 'Usuario eliminado correctamente.',
            'status_updated'       => 'Estado actualizado correctamente.',
        ],
        'content' => [
            'photo_approved'  => 'Foto aprobada correctamente.',
            'photo_rejected'  => 'Foto rechazada.',
            'photo_deleted'   => 'Foto eliminada correctamente.',
            'video_approved'  => 'Video aprobado correctamente.',
            'video_rejected'  => 'Video rechazado.',
            'video_deleted'   => 'Video eliminado correctamente.',
            'photos_approved' => ':count fotos aprobadas.',
            'photos_rejected' => ':count fotos rechazadas.',
        ],
        'verification' => [
            'already_approved'   => 'Este perfil ya fue aprobado.',
            'profile_approved'   => 'Perfil de :name aprobado exitosamente.',
            'profile_rejected'   => 'Perfil de :name rechazado. Se ha notificado al usuario.',
            'profile_in_review'  => 'Perfil de :name puesto en revisión.',
        ],
        'withdrawals' => [
            'only_pending_approve' => 'Solo se pueden aprobar pagos pendientes.',
            'approved'             => 'Pago aprobado exitosamente.',
            'only_pending_reject'  => 'Solo se pueden rechazar pagos pendientes.',
            'rejected'             => 'Pago rechazado.',
        ],
        'achievements' => [
            'created'       => 'Logro creado exitosamente.',
            'updated'       => 'Logro actualizado exitosamente.',
            'cannot_delete' => 'No se puede eliminar este logro porque ya ha sido desbloqueado por usuarios.',
            'deleted'       => 'Logro eliminado exitosamente.',
            'activated'     => 'Logro activado exitosamente.',
            'deactivated'   => 'Logro desactivado exitosamente.',
        ],
        'missions' => [
            'created'       => 'Misión creada exitosamente.',
            'updated'       => 'Misión actualizada exitosamente.',
            'cannot_delete' => 'No se puede eliminar esta misión porque ya ha sido asignada a usuarios.',
            'deleted'       => 'Misión eliminada exitosamente.',
            'activated'     => 'Misión activada exitosamente.',
            'deactivated'   => 'Misión desactivada exitosamente.',
        ],
        'levels' => [
            'created' => 'Nivel creado exitosamente.',
            'updated' => 'Nivel actualizado exitosamente.',
            'deleted' => 'Nivel eliminado exitosamente.',
        ],
        'badges' => [
            'created'       => 'Insignia creada exitosamente.',
            'updated'       => 'Insignia actualizada exitosamente.',
            'cannot_delete' => 'No se puede eliminar una insignia que ya ha sido otorgada.',
            'deleted'       => 'Insignia eliminada exitosamente.',
            'status_updated'=> 'Estado de la insignia actualizado.',
        ],
        'token_packages' => [
            'created' => 'Paquete de tokens creado correctamente.',
            'updated' => 'Paquete de tokens actualizado correctamente.',
            'deleted' => 'Paquete de tokens eliminado correctamente.',
        ],
        'settings' => [
            'updated'    => 'Configuración actualizada exitosamente.',
            'xp_updated' => 'Configuración de XP global actualizada correctamente.',
        ],
        'streams' => [
            'ended'      => 'Stream finalizado exitosamente.',
            'not_active' => 'El stream ya no está activo.',
        ],
        'reports' => [
            'resolved'  => 'Reporte resuelto exitosamente.',
            'dismissed' => 'Reporte descartado.',
        ],
        'messages' => [
            'deleted'      => 'Mensaje eliminado exitosamente.',
            'flag_updated' => 'Estado del mensaje actualizado.',
        ],
        'auth' => [
            'register_model_success' => '¡Registro exitoso! Por favor verifica tu email antes de continuar.',
            'default_bio'            => 'Nuevo modelo en la plataforma.',
        ],
        'fan' => [
            'access_denied'             => 'Acceso denegado.',
            'not_a_model'               => 'El usuario no es un modelo.',
            'invalid_content_type'      => 'Tipo de contenido inválido.',
            'invalid_data'              => 'Datos inválidos.',
            'favorite_added'            => 'Agregado a favoritas',
            'favorite_removed'          => 'Eliminado de favoritas',
            'favorite_error'            => 'Error al actualizar favoritas.',
            'notification_read'         => 'Notificación marcada como leída',
            'notification_read_error'   => 'Error al marcar la notificación.',
            'notifications_all_read'    => 'Todas las notificaciones marcadas como leídas',
            'notifications_read_error'  => 'Error al marcar las notificaciones.',
            'wrong_password'            => 'La contraseña actual es incorrecta.',
            'invalid_profile_data'      => 'Datos inválidos.',
            'profile_updated'           => 'Perfil actualizado exitosamente.',
            'profile_update_error'      => 'Error al actualizar el perfil.',
            'already_subscribed'        => 'Ya estás suscrito a este modelo.',
            'insufficient_tokens'       => 'Tokens insuficientes.',
            'subscription_success'      => 'Suscripción exitosa',
            'subscription_error'        => 'Error al procesar la suscripción.',
            'subscription_cancelled'    => 'Suscripción cancelada exitosamente',
            'subscription_cancel_error' => 'Error al cancelar la suscripción.',
            'sub_tx_fan'                => 'Suscripción mensual a :name',
            'sub_tx_model'              => 'Suscripción mensual de :name',
            'invalid_package'           => 'Paquete de tokens no válido o desactualizado.',
            'invalid_price'             => 'El precio o paquete seleccionado no es válido.',
            'recharge_success'          => 'Recarga exitosa',
            'recharge_error'            => 'Error al procesar la recarga. Inténtalo de nuevo.',
            'recharge_tx'               => 'Recarga rápida de :count tokens',
            'purchase_success'          => 'Compra exitosa',
            'purchase_tx'               => 'Compra de :total tokens (:base + bonus)',
        ],
        'benefits' => [
            'chat'        => 'Chat habilitado',
            'cashback_5'  => '5% Cashback en propinas',
            'invisible'   => 'Modo Invisible',
            'vip'         => '10% Cashback + Prioridad VIP',
            'elite'       => 'Acceso Elite Total',
            'default_league' => 'Gris',
        ],
        'achievements' => [
            'first_tip_name'       => 'Primera Propina',
            'first_tip_desc'       => 'Envía tu primera propina',
            'generous_name'        => 'Generoso',
            'generous_desc'        => 'Envía 100 propinas',
            'vip_subscriber_name'  => 'Suscriptor VIP',
            'vip_subscriber_desc'  => 'Mantén 5 suscripciones activas',
            'climber_name'         => 'Escalador',
            'climber_desc'         => 'Alcanza el nivel 10',
            'legend_name'          => 'Leyenda',
            'legend_desc'          => 'Alcanza el nivel 21',
        ],
        'model' => [
            'profile_required'           => 'Debes tener un perfil aprobado para acceder a :section.',
            'rejected_flash'             => 'Tu perfil fue rechazado. Motivo: :reason. Puedes corregir la información y volver a enviarlo.',
            'under_review_flash'         => 'Tu perfil está en revisión. Te notificaremos por email cuando sea aprobado.',
            'under_review_no_edit'       => 'Tu perfil está en revisión. No puedes modificarlo hasta recibir una respuesta.',
            'edit_blocked_review'        => 'No puedes editar tu perfil mientras está en revisión.',
            'edit_blocked_rejected'      => 'Tu perfil fue rechazado. Usa el proceso de onboarding para corregir la información.',
            'settings_approved_required' => 'Debes tener un perfil aprobado para acceder a configuración.',
            'settings_updated'           => 'Configuración actualizada correctamente.',
            'profile_updated'            => 'Perfil actualizado correctamente.',
            'profile_updated_approved'   => 'Perfil actualizado correctamente. Los cambios en fotos requieren nueva aprobación.',
            'default_bio'                => 'Nuevo modelo en Lustonex',
            'analytics_required'         => 'Debes tener un perfil aprobado para acceder a analytics.',
            'earnings_required'          => 'Debes tener un perfil aprobado para acceder a las ganancias.',
            'leaderboard_required'       => 'Debes tener un perfil aprobado para acceder al ranking.',
            'missions_required'          => 'Debes tener un perfil aprobado para acceder a las misiones.',
            'achievements_required'      => 'Debes tener un perfil aprobado para acceder a achievements.',
            'not_authorized'             => 'No autorizado',
            'access_denied'              => 'Acceso denegado.',
            'notification_read'          => 'Notificación marcada como leída',
            'notification_read_error'    => 'Error al marcar la notificación.',
            'notifications_all_read'     => 'Todas las notificaciones marcadas como leídas',
            'notifications_read_error'   => 'Error al marcar las notificaciones.',
            'mission_not_found'          => 'Misión no encontrada.',
            'mission_already_claimed'    => 'Esta misión ya fue reclamada.',
            'mission_not_complete'       => 'Aún no has completado esta misión.',
            'mission_reward_claimed'     => '¡Recompensa reclamada exitosamente!',
            'default_fan_name'           => 'Usuario',
        ],
        'onboarding' => [
            'step1_success'         => 'Paso 1 completado. Ahora sube tu identificación.',
            'step2_success'         => 'Documentos subidos correctamente. Último paso.',
            'step3_success'         => 'Perfil enviado para revisión. Te notificaremos cuando sea aprobado.',
            'complete_prev_steps'   => 'Debes completar todos los pasos anteriores.',
            'profile_not_found'     => 'Perfil no encontrado. Por favor, completa el paso 1 primero.',
            'docs_required'         => 'Todos los documentos obligatorios (Frontal, Trasero, Selfie) son requeridos.',
            'invalid_files'         => 'Los archivos subidos no son válidos. Por favor, intenta de nuevo.',
            'upload_error'          => 'Error al subir los documentos. Por favor, intenta de nuevo.',
            'unexpected_error'      => 'Error inesperado: :message',
        ],
        'photo' => [
            'max_photos'  => 'No puedes subir más de 10 fotos a la vez.',
            'invalid_mime'=> 'El archivo debe ser una imagen válida (jpeg, png, jpg, gif, webp, svg, bmp, tiff).',
            'max_size'    => 'Cada foto no debe superar los 10MB.',
            'uploaded_one'=> 'Foto subida correctamente.',
            'uploaded_many'=> ':count fotos subidas correctamente.',
            'deleted'     => 'Foto eliminada correctamente.',
        ],
        'video' => [
            'max_size'    => 'El video seleccionado supera el límite máximo de 50MB.',
            'invalid_mime'=> 'El video debe estar en formato MP4, MOV, AVI o WMV.',
            'thumb_max'   => 'La portada (miniatura) no debe superar los 5MB.',
            'uploaded'    => 'Video subido correctamente.',
            'deleted'     => 'Video eliminado correctamente.',
        ],
        'stream' => [
            'active_warning'         => 'Tienes :count stream(s) activo(s): :titles. Se finalizarán automáticamente al crear el nuevo stream.',
            'started'                => '¡Stream iniciado exitosamente! Configura OBS con tu stream key y comienza a transmitir.',
            'paused'                 => 'Stream pausado.',
            'resumed'                => 'Stream reanudado.',
            'ended'                  => 'Stream finalizado correctamente.',
            'deleted'                => 'Stream eliminado correctamente.',
            'settings_updated'       => 'Configuraciones de stream actualizadas.',
            'not_live'               => 'El stream no está activo. Configura OBS primero.',
            'action_completed'       => 'Acción marcada como completada',
            'message_sent'           => 'Mensaje enviado',
            'private_chat_label'     => 'Chat Privado',
        ],
        'withdrawal' => [
            'tx_description'   => 'Solicitud de pago vía :method',
            'request_sent'     => 'Solicitud de pago enviada exitosamente.',
            'cancel_error'     => 'Solo puedes cancelar pagos pendientes.',
            'cancelled'        => 'Pago cancelado exitosamente.',
        ],
        'notification' => [
            'all_read'    => 'Todas las notificaciones marcadas como leídas',
            'all_deleted' => 'Todas las notificaciones eliminadas',
        ],
        'payment' => [
            'failed_default' => 'El pago no pudo ser procesado',
        ],
        'profile_public' => [
            'login_required'        => 'Debes iniciar sesión para suscribirte.',
            'model_not_found'       => 'Modelo no encontrado.',
            'fans_only'             => 'Solo los fans pueden suscribirse a modelos.',
            'no_self_subscribe'     => 'No puedes suscribirte a tu propio perfil.',
            'already_subscribed'    => 'Ya tienes una suscripción activa de nivel :tier a este modelo.',
            'insufficient_tokens'   => 'No tienes suficientes tokens para esta suscripción.',
            'subscribe_success'     => '¡Suscripción nivel :tier activada correctamente por :amount tokens! Ahora tienes acceso exclusivo a :name.',
            'subscribe_error'       => 'Ocurrió un error al procesar tu suscripción. Por favor, inténtalo de nuevo.',
            'login_required_short'  => 'Debes iniciar sesión.',
            'insufficient_tokens_short' => 'No tienes suficientes tokens.',
            'tip_success'           => '¡Propina enviada con éxito!',
            'tip_error'             => 'Error al procesar la propina.',
            'roulette_success'      => '¡Has girado la ruleta!',
            'roulette_error'        => 'Error al procesar el giro.',
            'chat_fans_only'        => 'Solo fans o el modelo pueden chatear.',
            'chat_insufficient_tokens' => 'Tokens insuficientes',
            'tx_subscribe_fan'      => 'Suscripción :tier a :name',
            'tx_subscribe_model'    => 'Suscripción :tier de :name',
            'tx_tip_fan'            => 'Propina enviada a :name:menu',
            'tx_tip_model'          => 'Propina recibida de :name:action',
            'tx_tip_menu_suffix'    => ' (Menú)',
            'tx_tip_action_suffix'  => ' - Acción del Menú',
            'tx_roulette_fan'       => 'Giro de Ruleta en sala de :name',
            'tx_roulette_model'     => 'Giro de Ruleta de :name',
            'tx_chat_fan'           => 'Desbloqueo chat privado con :name (:hours h)',
            'tx_chat_model'         => 'Desbloqueo chat privado de :name (:hours h)',
        ],
        'report' => [
            'no_self_report' => 'No puedes reportarte a ti mismo.',
            'sent'           => 'Reporte enviado exitosamente. Gracias por ayudarnos a mantener la seguridad.',
            'error'          => 'Ocurrió un error al enviar el reporte. Por favor, inténtalo de nuevo.',
        ],
        'rtmp' => [
            'key_live_error' => 'No puedes regenerar tu clave mientras estás en vivo. Finaliza primero tu transmisión.',
            'key_generated'  => 'Stream key generado exitosamente',
        ],
        'streaming' => [
            'not_active'   => 'Stream no está activo',
            'unauthorized' => 'No autorizado',
            'started'      => 'Transmisión iniciada',
            'stopped'      => 'Transmisión finalizada',
            'connected'    => 'Conectado al stream',
            'disconnected' => 'Desconectado del stream',
        ],
        'stream_view' => [
            'not_active'         => 'Este stream no está activo.',
            'subscribe_required' => 'Necesitas suscribirte para ver este stream.',
            'insufficient_tokens'=> 'No tienes suficientes tokens. Tienes :count tokens disponibles.',
            'tip_error'          => 'Error al enviar la propina. Inténtalo de nuevo.',
            'tx_tip_fan'         => 'Propina en stream ":title" a :name',
            'tx_tip_model'       => 'Propina en stream ":title" de :name',
        ],
        'middleware' => [
            'onboarding_required'   => 'Completa tu proceso de verificación para acceder.',
            'subscription_required' => 'Necesitas una suscripción activa para acceder a este contenido.',
            'role_denied'           => 'No tienes permiso para acceder a esta sección.',
            'verified_denied'       => 'Acceso denegado.',
            'profile_incomplete'    => 'Debes completar tu perfil primero.',
            'profile_pending'       => 'Esta funcionalidad estará disponible cuando tu perfil sea aprobado.',
        ],
    ],
    
    'models' => [
        'profile' => [
            'not_specified' => 'No especificado',
            'height'        => 'Altura',
            'weight'        => 'Peso',
            'measurements'  => 'Medidas',
            'years_old'     => 'años',
            'social_networks' => [
                'instagram' => 'Instagram',
                'twitter'   => 'Twitter',
                'tiktok'    => 'TikTok',
                'facebook'  => 'Facebook',
                'youtube'   => 'YouTube',
                'onlyfans'  => 'OnlyFans',
            ],
            'body_types' => [
                'Delgado'       => '🌸 Delgado',
                'Atlético'      => '💪 Atlético',
                'Talla mediana' => '🌺 Talla mediana',
                'Con curvas'    => '🍑 Con curvas',
                'BBW'           => '👸 BBW',
            ],
            'ethnicities' => [
                'Blanca'      => '🤍 Blanca',
                'Latina'      => '🌹 Latina',
                'Asiática'    => '🌸 Asiática',
                'Árabe'       => '🌙 Árabe',
                'Negra'       => '🖤 Negra',
                'India'       => '🪷 India',
                'Multiétnica' => '🌈 Multiétnica',
            ],
            'hair_colors' => [
                'Rubio'      => '👱‍♀️ Rubio',
                'Moreno'     => '👩‍🦳 Moreno',
                'Pelo Negro' => '👩‍🦲 Negro',
                'Colorido'   => '🌈 Colorido',
                'Pelirroja'  => '👩‍🦰 Pelirroja',
            ],
        ],
        'user' => [
            'benefits' => [
                'reduced_commission' => [
                    'name'        => 'Comisión Reducida',
                    'description' => '15% de comisión (antes 20%)',
                ],
                'search_priority' => [
                    'name'        => 'Prioridad en Búsqueda',
                    'description' => 'Aparece primero en resultados',
                ],
                'vip_badge' => [
                    'name'        => 'Badge VIP',
                    'description' => 'Insignia especial en tu perfil',
                ],
                'priority_support' => [
                    'name'        => 'Soporte Prioritario',
                    'description' => 'Atención preferencial 24/7',
                ],
            ],
            'token_benefits' => [
                'level_6'  => '5% Cashback en todas las propinas',
                'level_16' => '10% Cashback + Prioridad en chat',
            ],
            'missions' => [
                'tokens' => [
                    'title'  => 'Recarga 1000 tokens',
                    'reward' => '50 XP + 10 Tickets',
                ],
                'subscription' => [
                    'title'  => 'Suscríbete a 3 modelos',
                    'reward' => '100 XP + 20 Tickets',
                ],
                'daily_tip' => [
                    'title'       => 'Envía 5 propinas',
                    'description' => 'Envía propinas a tus modelos favoritos',
                ],
                'weekly_login' => [
                    'title'       => 'Conecta 3 días esta semana',
                    'description' => 'Inicia sesión al menos 3 días diferentes',
                ],
                'monthly_spend' => [
                    'title'       => 'Gasta 5000 tokens este mes',
                    'description' => 'Usa tokens en propinas y suscripciones',
                ],
                'obligatory_level' => [
                    'title'       => 'Alcanza :xp XP',
                    'description' => 'Completa esta misión para subir al nivel :level',
                ],
                'model_weekly_photos' => [
                    'title'       => 'Subir 5 fotos esta semana',
                    'description' => 'Comparte contenido nuevo con tus fans',
                ],
                'model_monthly_streams' => [
                    'title'       => 'Hacer 3 streams este mes',
                    'description' => 'Conecta en vivo con tu audiencia',
                ],
                'model_daily_tips' => [
                    'title'       => 'Recibir 10 propinas hoy',
                    'description' => 'Interactúa con tus fans',
                ],
            ],
        ],
    ],
    
    'notifications' => [
        'achievement' => [
            'unlocked' => '¡Logro desbloqueado! :name',
        ],
        'badge' => [
            'earned' => '¡Badge especial obtenido! :name',
        ],
        'chat' => [
            'extended' => [
                'model_title' => 'Chat Extendido',
                'model_msg'   => ':name ha extendido el chat privado por 24 horas.',
                'model_btn'   => 'Ir al Chat',
                'fan_title'   => 'Chat Extendido con Éxito',
                'fan_msg'     => 'Has extendido el chat con :name por 24 horas extras.',
                'fan_btn'     => 'Continuar Chateando',
            ],
            'unlocked' => [
                'model_title' => '¡Nuevo Chat Desbloqueado!',
                'model_msg'   => ':name ha desbloqueado tu chat privado.',
                'model_btn'   => 'Ir al Chat',
                'fan_title'   => '¡Chat Desbloqueado!',
                'fan_msg'     => 'Has desbloqueado el chat privado con :name.',
                'fan_btn'     => 'Comenzar a Chatear',
            ],
            'new_message' => [
                'title' => 'Nuevo Mensaje Privado',
                'btn'   => 'Responder',
            ],
        ],
        'level' => [
            'up' => '¡Felicidades! Has alcanzado el nivel :level - :name',
        ],
        'model' => [
            'live_title' => '¡En Vivo Ahora!',
            'live_msg'   => ':name está transmitiendo: :title',
            'live_btn'   => 'Ver Stream',
            'verify_email_subject' => 'Verifica tu cuenta de Modelo - Lustonex',
        ],
        'follower' => [
            'title' => '¡Nuevo Seguidor!',
            'msg'   => ':name comenzó a seguirte',
            'btn'   => 'Ver Perfil',
        ],
        'subscriber' => [
            'fan_title'   => '¡Suscripción Exitosa!',
            'fan_msg'     => 'Te has suscrito correctamente al contenido de :name',
            'fan_btn'     => 'Ver Perfil',
            'model_title' => '¡Nuevo Suscriptor!',
            'model_msg'   => ':name se suscribió a tu contenido',
            'model_btn'   => 'Ver Suscriptores',
        ],
        'payment' => [
            'success_title' => 'Pago Exitoso',
            'success_msg'   => 'Tu compra de :tokens tokens fue procesada exitosamente',
            'success_btn'   => 'Ver Historial',
        ],
        'tip' => [
            'received_title' => '¡Propina Recibida!',
            'received_msg'   => ':name te envió :amount tokens',
            'received_btn'   => 'Ver Ganancias',
        ],
        'withdrawal' => [
            'approved_title' => 'Pago Aprobado',
            'approved_msg'   => 'Tu pago de $:amount ha sido aprobado y procesado',
            'approved_btn'   => 'Ver Pagos',
            'rejected_title' => 'Pago Rechazado',
            'rejected_msg'   => 'Tu pago de $:amount fue rechazado. Razón: :reason',
            'rejected_btn'   => 'Ver Detalles',
            'not_specified'  => 'No especificada',
        ],
        'gamification' => [
            'achievement_title' => '¡Logro Desbloqueado!',
            'achievement_msg'   => 'Has desbloqueado el logro: :name',
            'level_title'       => '¡Subiste de Nivel!',
            'level_msg'         => '¡Felicidades! Has alcanzado el Nivel :level: :name',
        ],
    ],
    
    'services' => [
        'payment' => [
            'invalid_paypal_email' => 'Email de PayPal inválido',
            'invalid_skrill_email' => 'Email de Skrill inválido',
            'processed_successfully' => 'Pago procesado exitosamente',
            'card_declined' => 'Tarjeta declinada',
            'insufficient_funds' => 'Fondos insuficientes',
            'unknown_error' => 'Error desconocido',
            'payment_error' => 'Error en el pago',
            'paypal_success' => 'Pago con PayPal procesado exitosamente',
            'paypal_rejected_reason' => 'Pago rechazado por PayPal',
            'paypal_rejected' => 'El pago fue rechazado por PayPal',
            'skrill_success' => 'Pago con Skrill procesado exitosamente',
            'skrill_rejected_reason' => 'Pago rechazado por Skrill',
            'skrill_rejected' => 'El pago fue rechazado por Skrill',
            'required_field' => 'Campo requerido: :field',
            'invalid_card_number' => 'Número de tarjeta inválido',
            'invalid_cvv' => 'CVV inválido',
            'invalid_exp_month' => 'Mes de expiración inválido',
            'expired_card' => 'Tarjeta expirada',
            'integration_not_implemented_card' => 'Integración real de tarjeta no implementada',
            'integration_not_implemented_paypal' => 'Integración real de PayPal no implementada',
            'integration_not_implemented_skrill' => 'Integración real de Skrill no implementada',
        ],
    ],
];
