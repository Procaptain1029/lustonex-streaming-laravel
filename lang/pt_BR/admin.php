<?php

return [
    'dashboard' => [
        'title' => 'Dashboard',
        'operational_dashboard' => 'Dashboard Operacional',
        'realtime_monitoring' => 'Monitoramento de métricas e atividades em tempo real',
        
        'stats' => [
            'total_models' => 'Total de Modelos',
            'models' => 'Modelos',
            'total_fans' => 'Total de Fãs',
            'fans' => 'Fãs',
            'live_now' => 'Ao Vivo Agora',
            'subscriptions' => 'Assinaturas',
            'total_revenue' => 'Receita Total',
            'global_platform' => 'Plataforma Global',
            'this_month' => 'este mês',
            'pending_review' => 'Revisão Pendente',
            'quick_access' => 'Acesso Rápido',
        ],

        'recent_streams' => [
            'title' => 'Streams Recentes',
            'view_all' => 'Ver Todos',
            'model' => 'Modelo',
            'status' => 'Status',
            'viewers' => 'Espectadores',
            'start' => 'Início',
            'live' => 'Ao vivo',
            'ended' => 'Encerrado',
            'na' => 'N/A',
            'no_activity' => 'Nenhuma atividade de streaming no momento',
        ],

        'content' => [
            'photos' => 'Fotos',
            'videos' => 'Vídeos',
        ],

        'quick_links' => [
            'admin' => 'Admin',
            'models' => 'Modelos',
            'verification' => 'Verif.',
            'settings' => 'Config.',
        ],
    ],

    'analytics' => [
        'title' => 'Estatísticas',
        'dashboard_title' => 'Painel de Estatísticas',
        'subtitle' => 'Visualização inteligente de métricas críticas e desempenho do ecossistema',
        
        'overview' => [
            'total_community' => 'Comunidade Total',
            'active_fans' => 'Fãs Ativos',
            'registered_models' => 'Modelos Registradas',
            'tokens_moved' => 'Tokens Movimentados',
            'live_now' => 'Ao Vivo Agora',
            'vs_previous_month' => 'vs mês anterior',
            'real_time' => 'Em tempo real',
        ],

        'charts' => [
            'revenue_trend' => 'Tendência de Receita',
            'live_data' => 'DADOS AO VIVO',
            'revenue_subtitle' => 'Análise comparativa dos últimos 12 meses de operação',
            'real_time_viz' => 'Visualização de Dados em Tempo Real',
            'projected_total' => 'Total projetado:',
            'tokens' => 'tokens',
        ],

        'metrics' => [
            'user_engagement' => 'Engajamento de Usuários',
            'engagement_subtitle' => 'Comportamento e retenção da audiência',
            'avg_session' => 'Duração Média da Sessão',
            'avg_concurrency' => 'Concorrência Média',
            'viewers' => 'espectadores',
            'tip_volume' => 'Volume de Gorjetas',
            'tips' => 'gorjetas',
            'sub_conversion' => 'Conversão para Subs',
            'users' => 'usuários',

            'content_inventory' => 'Inventário de Conteúdo',
            'inventory_subtitle' => 'Volume de mídia gerada por criadores',
            'published_photos' => 'Fotos Publicadas',
            'published_videos' => 'Vídeos Publicados',
            'live_broadcasts' => 'Total de Transmissões ao Vivo',
            'pending_moderation' => 'Moderação Pendente',
            'items' => 'itens',
        ],

        'top_models' => [
            'title' => 'Modelos de Destaque (Top Models)',
            'subtitle' => 'Ranking de modelos por tokens acumulados',
            'rank' => 'Posição',
            'model' => 'Modelo',
            'contact' => 'Contato',
            'accumulated_tokens' => 'Tokens Acumulados',
            'no_data' => 'Nenhum dado de desempenho disponível.',
        ],
    ],

    'content' => [
        'photos' => [
            'title' => 'Moderação de Fotos',
            'subtitle' => 'Analise e aprove o conteúdo visual das criadoras',
            'total' => 'Total de Fotos',
            'no_photos_title' => 'Nenhuma foto por aqui',
            'no_photos_desc' => 'Bom trabalho! Nenhuma foto encontrada com os filtros atuais.',
            'info' => 'Informação',
            'meta' => 'Metadados',
            'views' => 'Visualizações',
            'uploaded' => 'Enviada',
            'file_size' => 'Tamanho do Arquivo',
        ],
        'videos' => [
            'title' => 'Moderação de Vídeos',
            'subtitle' => 'Gerencie e aprove as produções de vídeo das criadoras',
            'total' => 'Total de Vídeos',
            'no_videos_title' => 'Nenhum vídeo pendente',
            'no_videos_desc' => 'Nenhum vídeo encontrado para moderação com os filtros atuais.',
            'delete_confirm' => 'Excluir este vídeo permanentemente?',
        ],
        'status' => [
            'pending' => 'Pendentes',
            'approved' => 'Aprovadas',
            'rejected' => 'Rejeitadas',
            'approved_masc' => 'Aprovados',
            'rejected_masc' => 'Rejeitados',
            'single_pending' => 'Pendente',
            'single_approved' => 'Aprovada',
            'single_rejected' => 'Rejeitada',
            'single_approved_masc' => 'Aprovado',
            'single_rejected_masc' => 'Rejeitado',
        ],
        'filters' => [
            'all' => 'Todas',
            'all_masc' => 'Todos',
            'filter_by_model' => 'Filtrar por modelo...',
            'search_by_title' => 'Pesquisar por título...',
            'filter_btn' => 'Filtrar',
            'clear_filters' => 'Limpar filtros',
        ],
        'actions' => [
            'select_all' => 'Selecionar Tudo',
            'selected' => 'selecionadas',
            'approve_selection' => 'Aprovar Seleção',
            'reject_selection' => 'Rejeitar Seleção',
            'approve' => 'Aprovar',
            'reject' => 'Rejeitar',
            'view' => 'Ver Vídeo',
            'delete' => 'Excluir',
        ],
        'misc' => [
            'untitled' => 'Sem título',
        ],
    ],

    'finance' => [
        'balance' => [
            'title' => 'Balanço Financeiro',
            'subtitle' => 'Status financeiro da plataforma — receitas, pagamentos e lucro líquido.',
            'token_rate' => '1 Token = :value USD',
            'total_income' => 'Receita Total',
            'tokens_sold' => 'tokens vendidos',
            'model_payouts' => 'Pagamentos de Modelos',
            'payouts_desc' => 'Pagamentos concluídos e processados',
            'net_profit' => 'Lucro Líquido',
            'profit_desc' => 'Receita menos pagamentos',
            'stats' => [
                'tokens_sold_title' => 'Tokens Vendidos',
                'tokens_sold_sub' => 'Compras acumuladas',
                'in_circulation' => 'Em Circulação',
                'pending_withdrawals' => 'Pagamentos Pendentes',
                'pending_withdrawals_sub' => 'tokens',
                'active_subscriptions' => 'Assinaturas Ativas',
                'completed_tips' => 'Gorjetas Concluídas',
            ],
            'monthly' => [
                'income' => 'Receita Deste Mês',
                'payouts' => 'Pagamentos Deste Mês',
                'profit' => 'Lucro Deste Mês',
            ],
            'tables' => [
                'recent_tips' => 'Gorjetas Recentes',
                'view_all' => 'Ver todas',
                'sender' => 'Remetente',
                'tokens' => 'Tokens',
                'status' => 'Status',
                'date' => 'Data',
                'recent_subs' => 'Assinaturas Recentes',
                'subscriber' => 'Assinante',
                'no_activity' => 'Sem atividade',
            ]
        ],
        'subscriptions' => [
            'title' => 'Assinaturas',
            'subtitle' => 'Gerencie a receita recorrente e o status das associações.',
            'stats' => [
                'total_charged' => 'Total de Tokens Cobrados',
                'total_charged_sub' => 'Acumulado histórico',
                'active_tokens' => 'Tokens Ativos',
                'active_tokens_sub' => 'Em assinaturas ativas',
                'monthly_tokens' => 'Tokens Deste Mês',
                'cancelled' => 'Canceladas',
                'cancelled_sub' => 'Retenção perdida',
            ],
            'filters' => [
                'all' => 'Todas',
                'active' => 'Ativas',
                'cancelled' => 'Canceladas',
                'expired' => 'Expiradas',
                'search' => 'Buscar...',
            ],
            'table' => [
                'subscriber' => 'Assinante (Fã)',
                'model' => 'Modelo (Criadora)',
                'cost' => 'Custo (Tokens)',
                'status' => 'Status',
                'dates' => 'Início / Renovação',
                'actions' => 'Ações',
                'deleted_user' => 'Usuário Excluído',
                'deleted_model' => 'Modelo Excluída',
                'renews' => 'Renova:',
                'view_details' => 'Ver Detalhes',
                'no_subs' => 'Nenhuma assinatura registrada.',
            ],
            'modal' => [
                'title' => 'Detalhes da Assinatura',
                'fan' => 'Fã Assinante',
                'model' => 'Modelo Assinada',
                'current_plan' => 'Plano Atual',
                'monthly' => 'Mensal',
                'cost' => 'Custo (Tokens)',
                'status' => 'Status',
                'close' => 'Fechar',
            ]
        ],
        'tips' => [
            'title' => 'Central de Gorjetas',
            'subtitle' => 'Monitore gestos de gratidão e transações diretas entre usuários',
            'stats' => [
                'total_tokens' => 'Tokens em Gorjetas',
                'total_tokens_sub' => 'Acumulado histórico',
                'avg_tokens' => 'Média por Gorjeta',
                'avg_tokens_sub' => 'Média de tokens',
                'monthly_tokens' => 'Tokens Deste Mês',
                'completed' => 'Concluídas',
                'pending' => 'Pendientes',
            ],
            'filters' => [
                'all' => 'Todas',
                'completed' => 'Concluídas',
                'pending' => 'Pendientes',
                'failed' => 'Falhas',
                'search' => 'Buscar usuário ou modelo...',
            ],
            'table' => [
                'sender' => 'Remetente (Fã)',
                'receiver' => 'Destinatário (Modelo)',
                'tokens' => 'Tokens',
                'status' => 'Status',
                'date' => 'Data',
                'actions' => 'Ações',
                'deleted_user' => 'Usuário Excluído',
                'deleted_model' => 'Modelo Excluída',
                'fan_role' => 'Fã',
                'model_role' => 'Modelo',
                'view_details' => 'Ver Detalhes',
                'no_tips' => 'Nenhuma gorjeta registrada.',
            ],
            'modal' => [
                'title' => 'Detalhe da Transação',
                'tokens_sent' => 'Tokens Enviados',
                'tx_id' => 'ID da Transação',
                'date' => 'Data',
                'message' => 'Mensagem Anexada',
                'no_message' => 'Sem mensagem',
                'from' => 'De (Fã)',
                'to' => 'Para (Modelo)',
                'close' => 'Fechar',
            ]
        ],
    ],

    'gamification-2' => [
        'achievements' => [
            'index' => [
                'title' => 'Gerenciar Conquistas',
                'title_header' => 'Conquistas',
                'subtitle' => 'Gerencie as recompensas e desafios para gamificar a experiência do usuário.',
                'create_btn' => 'Nova Conquista',
                'filters' => [
                    'all' => 'Todas',
                    'active' => 'Ativas',
                    'inactive' => 'Inativas',
                    'for_models' => 'Para Modelos',
                    'for_fans' => 'Para Fãs',
                ],
                'table' => [
                    'icon' => 'Ícone',
                    'achievement' => 'Conquista',
                    'description' => 'Descrição',
                    'type_role' => 'Tipo / Papel',
                    'reward' => 'Recompensa',
                    'status' => 'Status',
                    'actions' => 'Ações',
                    'active' => 'Ativa',
                    'inactive' => 'Inativa',
                    'edit' => 'Editar',
                    'delete' => 'Excluir',
                    'no_achievements' => 'Nenhuma missão registrada encontrada.',
                ],
                'delete_alert' => [
                    'title' => 'Excluir esta conquista?',
                    'text' => 'Esta ação não pode ser desfeita.',
                    'confirm' => 'Sim, excluir',
                    'cancel' => 'Cancelar',
                ]
            ],
            'create' => [
                'title' => 'Criar Conquista',
                'subtitle' => 'Configure um novo reconhecimento e marcos para a comunidade.',
            ],
            'edit' => [
                'title' => 'Editar Conquista',
                'subtitle' => 'Modificando os parâmetros de: ":name"',
            ],
            'form' => [
                'basic_info' => 'Informações Básicas',
                'name' => 'Nome',
                'name_placeholder' => 'Ex: Super Estrela',
                'slug' => 'Slug (Identificador)',
                'slug_placeholder' => 'ex: super-estrela',
                'description' => 'Descrição',
                'description_placeholder' => 'Descreva o que o usuário deve fazer para obter esta conquista...',
                'visualization' => 'Visualização',
                'icon' => 'Ícone',
                'icon_placeholder' => 'fa-trophy',
                'rarity' => 'Raridade',
                'rarities' => [
                    'common' => 'Comum (Cinza)',
                    'rare' => 'Raro (Azul)',
                    'epic' => 'Épico (Roxo)',
                    'legendary' => 'Lendário (Ouro)',
                ],
                'category' => 'Categoria',
                'categories_list' => [
                    'content' => 'Conteúdo',
                    'earnings' => 'Ganhos',
                    'popularity' => 'Popularidade',
                    'special' => 'Especial',
                ],
                'rewards_rules' => 'Recompensas e Regras',
                'role_recipient' => 'Papel Destinatário',
                'roles' => [
                    'fan' => 'Fãs',
                    'model' => 'Modelos',
                    'both' => 'Ambos',
                ],
                'status' => 'Status',
                'statuses' => [
                    'active' => 'Ativo',
                    'inactive' => 'Inativo',
                ],
                'xp' => 'XP (Experiência)',
                'tickets' => 'Tickets (Moeda)',
                'tickets_edit' => 'Tickets',
                'cancel' => 'Cancelar',
                'submit_create' => 'Criar Conquista',
                'submit_edit' => 'Salvar Alterações',
            ],
            'guide' => [
                'title' => 'Guia Rápido',
                'description' => 'Use esta referência para configurar adequadamente as missões.',
                'category' => 'Categoria',
                'category_desc' => 'Define em qual seção do perfil a conquista aparecerá.',
                'rarity' => 'Raridade',
                'rarity_desc' => 'Determina a cor da borda e o brilho do cartão.',
                'slug' => 'Slug',
                'slug_desc' => 'Deve ser único e no formato \'kebab-case\' (ex: primeiro-login).',
                'stats_title' => 'Estatísticas',
                'stats_desc' => 'Informações não editáveis.',
                'created_at' => 'Criado:',
            ],
        ],
        'levels' => [
            'index' => [
                'title' => 'Gerenciamento de Níveis',
                'title_header' => 'Níveis de Gamificação',
                'subtitle' => 'Gerencie a estrutura de progressão, experiência e recompensas para as modelos.',
                'create_button' => 'Adicionar Novo Nível',
                'table' => [
                    'level' => 'Nível',
                    'name_league' => 'Nome / Liga',
                    'xp_required' => 'XP Necessária',
                    'rewards' => 'Recompensas',
                    'actions' => 'Ações',
                    'standard' => 'Standard',
                    'no_tokens' => 'Sem tokens',
                    'tokens' => 'Tokens',
                    'edit' => 'Editar',
                    'delete' => 'Excluir',
                ],
                'empty' => [
                    'title' => 'Não há níveis configurados',
                    'subtitle' => 'Comece criando o primeiro nível para seu sistema de gamificação.',
                    'action' => 'Criar Primeiro Nível',
                ],
                'delete_alert' => [
                    'title' => 'Excluir este nível?',
                    'text' => 'Esta ação não pode ser desfeita.',
                    'confirm' => 'Sim, excluir',
                    'cancel' => 'Cancelar',
                ]
            ],
            'create' => [
                'title' => 'Novo Nível',
                'subtitle' => 'Defina o nome, número do nível e requisitos de progressão',
            ],
            'edit' => [
                'title' => 'Editar Nível',
            ],
            'form' => [
                'basic_config' => 'Configuração Básica',
                'name' => 'Nome do Nível (Liga)',
                'name_placeholder' => 'Ex: Liga Verde - Novato',
                'name_helper' => 'Recomendado: Incluir \'Liga [Cor]\' para atribuição de medalhas.',
                'level_number' => 'Número do Nível',
                'xp_required' => 'XP Necessária',
                'role_recipient' => 'Papel Destinatário',
                'roles' => [
                    'both' => 'Ambos (Fã e Modelo)',
                    'fan' => 'Apenas Fã',
                    'model' => 'Apenas Modelo',
                ],
                'role_helper' => 'O sistema usará esse filtro para atribuir o nível ao usuário correto.',
                'image' => 'Imagem do Nível',
                'image_current' => 'Imagem atual',
                'image_preview' => 'Pré-visualização',
                'image_helper' => 'JPG, PNG ou WebP. Máx. 2MB. Recomendado: 200x200px.',
                'rewards_section' => 'Recompensas ao Alcançar o Nível',
                'bonus_tokens' => 'Tokens de Bônus',
                'tokens_helper' => 'Tokens concedidos automaticamente ao atingir este nível.',
                'achievements' => 'Conquistas a Conceder (Opcional)',
                'no_achievements' => 'Nenhuma conquista ativa disponível.',
                'achievements_helper' => 'Serão concedidas automaticamente ao usuário quando ele alcançar este nível.',
                'badges' => 'Distintivos a Conceder (Opcional)',
                'no_badges' => 'Nenhum distintivo ativo disponível.',
                'badges_helper' => 'Serão concedidos automaticamente ao usuário quando ele alcançar este nível.',
                'cancel' => 'Cancelar',
                'submit_create' => 'Criar Nível',
                'submit_edit' => 'Salvar Alterações',
            ],
        ],
        'missions' => [
            'index' => [
                'title' => 'Gerenciar Missões',
                'subtitle' => 'Configure missões e desafios para incentivar a participação na plataforma',
                'stats' => [
                    'total' => 'Total de Missões',
                    'active' => 'Ativas',
                    'weekly' => 'Semanais',
                ],
                'search_placeholder' => 'Buscar por nome...',
                'create_button' => 'Nova Missão',
                'table' => [
                    'mission' => 'Missão',
                    'type' => 'Tipo',
                    'goal' => 'Objetivo',
                    'rewards' => 'Recompensas',
                    'status' => 'Status',
                    'actions' => 'Ações',
                    'active' => 'Ativa',
                    'inactive' => 'Inativa',
                    'edit' => 'Editar',
                    'delete' => 'Excluir',
                ],
                'empty' => [
                    'title' => 'Não há missões',
                    'subtitle' => 'Você ainda não criou nenhuma missão ou nenhuma corresponde à sua busca.',
                ],
                'delete_alert' => [
                    'title' => 'Excluir esta missão?',
                    'text' => 'Esta ação não pode ser desfeita.',
                    'confirm' => 'Sim, excluir',
                    'cancel' => 'Cancelar',
                ]
            ],
            'create' => [
                'title' => 'Nova Missão',
                'subtitle' => 'Defina os objetivos e recompensas para uma nova missão',
            ],
            'edit' => [
                'title' => 'Editar Missão',
            ],
            'form' => [
                'basic_config' => 'Configuração Básica',
                'name' => 'Nome da Missão *',
                'name_placeholder' => 'Ex: Espectadora Fiel',
                'description' => 'Descrição',
                'description_placeholder' => 'Descreva brevemente do que se trata esta missão...',
                'type' => 'Tipo de Missão *',
                'types' => [
                    'weekly' => 'Semanais (WEEKLY)',
                    'level_up' => 'Subida de Nível (LEVEL_UP)',
                    'parallel' => 'Paralelas (PARALLEL)',
                ],
                'role_target' => 'Papel Alvo *',
                'roles' => [
                    'both' => 'Ambos (Fã e Modelo)',
                    'fan' => 'Apenas Fã',
                    'model' => 'Apenas Modelo',
                ],
                'required_level' => 'Nível Necessário',
                'no_level' => '-- Nenhum (Para todos) --',
                'level_prefix' => 'Nível',
                'is_active' => 'Missão Ativa',
                'goals_section' => 'Metas e Objetivos',
                'target_action' => 'Ação Alvo *',
                'target_action_placeholder' => 'Ex: stream_watched',
                'target_action_helper' => 'Identificador interno da ação (slug).',
                'goal_amount' => 'Quantidade Necessária *',
                'rewards_section' => 'Recompensas ao Completar',
                'reward_xp' => 'Experiência (XP) *',
                'reward_tickets' => 'Tickets *',
                'achievement' => 'Conquista a Conceder (Opcional)',
                'no_achievement' => '— Nenhuma conquista vinculada —',
                'achievement_helper' => 'A conquista será desbloqueada automaticamente ao concluir esta missão.',
                'badge' => 'Distintivo a Conceder (Opcional)',
                'no_badge' => '— Nenhum distintivo vinculado —',
                'badge_helper' => 'O distintivo será concedido automaticamente ao concluir esta missão.',
                'cancel' => 'Cancelar',
                'submit_create' => 'Criar Missão',
                'submit_edit' => 'Salvar Alterações',
            ],
            'guide' => [
                'title' => 'Guia Técnico',
                'types_title' => 'Tipos de Missão',
                'types' => [
                    'weekly' => 'Reiniciam toda semana. Ideais para atividade recorrente.',
                    'level_up' => 'Missões únicas para alcançar certos marcos difíceis.',
                    'parallel' => 'Sempre ativas, podem ser concluídas a qualquer momento.',
                ],
                'actions_title' => 'Ações Comuns (Slugs)',
                'actions' => [
                    'stream_watched' => 'Assistir transmissão (por minutos)',
                    'chat_message_sent' => 'Enviar mensagens no chat',
                    'tip_sent' => 'Enviar gorjetas (tokens)',
                    'subscription_purchased' => 'Assinar um perfil',
                    'profile_updated' => 'Atualizar perfil completo',
                    'photo_uploaded' => 'Enviar fotos (Apenas Modelos)',
                ],
                'tips_title' => 'Dicas',
                'tips_text' => 'Certifique-se de que a <strong>Quantidade Necessária</strong> seja alcançável para o período de tempo selecionado. Para missões semanais, calcule o esforço de 7 dias.',
            ],
        ],
        'badges' => [
            'index' => [
                'title' => 'Gestão de Distintivos',
                'title_header' => 'Distintivos do Sistema',
                'subtitle' => 'Gerencie as distinções especiais e conquistas únicas da comunidade.',
                'create_btn' => 'Novo Distintivo',
                'filters' => [
                    'all' => 'Todos',
                    'hall_of_fame' => 'Hall of Fame',
                    'event' => 'Eventos',
                    'milestone' => 'Marcos',
                    'special' => 'Especiais',
                ],
                'table' => [
                    'icon' => 'Ícone',
                    'badge' => 'Distintivo',
                    'description' => 'Descrição',
                    'category' => 'Categoria',
                    'status' => 'Status',
                    'users' => 'Usuários',
                    'actions' => 'Ações',
                    'high_rarity' => 'ALTA RARIDADE',
                    'active' => 'Ativo',
                    'inactive' => 'Inativo',
                    'no_badges' => 'Nenhum distintivo encontrado.',
                    'deactivate' => 'Desativar',
                    'activate' => 'Ativar',
                    'edit' => 'Editar',
                    'delete' => 'Excluir',
                ],
                'delete_alert' => [
                    'title' => 'Excluir este distintivo?',
                    'text' => 'Esta ação não pode ser desfeita.',
                    'confirm' => 'Sim, excluir',
                    'cancel' => 'Cancelar',
                ],
            ],
            'create' => [
                'title' => 'Novo Distintivo',
                'subtitle' => 'Defina os atributos visuais e regras para esta conquista.',
            ],
            'edit' => [
                'title' => 'Editar Distintivo',
                'subtitle' => 'Modificando aparência e regras de: ":name"',
            ],
            'form' => [
                'preview_name' => 'Nome do Distintivo',
                'name' => 'Nome',
                'name_placeholder' => 'Ex: Elite Streamer',
                'icon' => 'Ícone (Font Awesome)',
                'icon_placeholder' => 'fa-crown',
                'color' => 'Cor Principal',
                'category' => 'Categoria',
                'categories' => [
                    'milestone' => 'Marco (Progressão)',
                    'hall_of_fame' => 'Hall of Fame',
                    'event' => 'Evento Especial',
                    'special' => 'Único / Manual',
                ],
                'description' => 'Descrição',
                'description_placeholder' => 'Descreva brevemente esta conquista...',
                'requirements' => 'Requisitos Técnicos (JSON)',
                'req_key' => 'Chave (ex: followers)',
                'req_val' => 'Valor (ex: 1000)',
                'req_key_placeholder' => 'Chave',
                'req_val_placeholder' => 'Valor',
                'add_req' => 'Adicionar Parâmetro',
                'active_now' => 'Ativar imediatamente',
                'is_active' => 'Distintivo Ativo',
                'cancel' => 'Cancelar',
                'submit_create' => 'Criar Distintivo',
                'submit_edit' => 'Salvar Alterações',
            ],
        ],
    ],
    
    'layout' => [
        'app' => [
            'toastr_success' => 'Sucesso',
            'toastr_error' => 'Erro',
            'toastr_warning' => 'Aviso',
            'toastr_info' => 'Informação',
        ],
    ],

    'logs' => [
        'title' => 'Logs do Sistema',
        'breadcrumb' => 'Logs de Auditoria',
        'title_header' => 'Registros do Sistema',
        'subtitle' => 'Auditoria completa de segurança e rastreamento de acessos.',
        
        'filters' => [
            'all' => 'Todos',
            'errors' => 'Erros',
            'warnings' => 'Avisos',
            'info' => 'Info',
            'search' => 'Buscar ID, IP ou usuário...',
        ],
        
        'table' => [
            'severity' => 'Severidade',
            'message_event' => 'Mensagem e Evento',
            'user' => 'Usuário Responsável',
            'ip' => 'Origem (IP)',
            'date' => 'Data',
            'actions' => 'Ações',
            'guest' => 'Sistema / Visitante',
            'view_payload' => 'Ver Payload',
            'copy_id' => 'Copiar ID',
            'empty' => 'Nenhum registro de auditoria recente.',
        ],

        'modal' => [
            'title' => 'Detalhe do Log',
            'message' => 'Mensagem',
            'payload' => 'Payload / Dados',
            'close' => 'Fechar',
        ],
    ],

    'messages' => [
        'title' => 'Moderação de Mensagens',
        'breadcrumb' => 'Mensagens',
        'subtitle' => 'Modere mensagens entre usuários',
        
        'stats' => [
            'total' => 'Total de Mensagens',
            'flagged' => 'Mensagens Marcadas',
            'today' => 'Hoje',
        ],
        
        'filters' => [
            'search' => 'Buscar conteúdo...',
            'all_users' => 'Todos os usuários',
            'all' => 'Todos',
            'flagged' => 'Marcados',
            'normal' => 'Normais',
            'filter_btn' => 'Filtrar',
        ],
        
        'table' => [
            'from' => 'De',
            'to' => 'Para',
            'message' => 'Mensagem',
            'status' => 'Status',
            'date' => 'Data',
            'actions' => 'Ações',
            'flagged' => 'Marcado',
            'normal' => 'Normal',
            'unflag' => 'Desmarcar',
            'flag' => 'Marcar',
            'delete' => 'Excluir',
            'delete_confirm' => 'Excluir esta mensagem?',
            'empty' => 'Nenhuma mensagem registrada',
        ],
    ],

    'models-2' => [
        'index' => [
            'title' => 'Gestão de Modelos',
            'breadcrumb' => 'Modelos',
            'subtitle' => 'Modere criadoras, verifique perfis e monitore atividades',
            
            'filters' => [
                'all' => 'Todos',
                'pending' => 'Pendentes',
                'verified' => 'Verificadas',
                'search' => 'Buscar por nome ou email...',
            ],
            
            'table' => [
                'model' => 'Modelo',
                'status_verification' => 'Status / Verificação',
                'registration' => 'Registro',
                'actions' => 'Ações',
                'live' => '🔴 Ao Vivo',
                
                'status' => [
                    'pending' => 'Pendente',
                    'under_review' => 'Em revisão',
                    'approved' => 'Verificada',
                    'rejected' => 'Rejeitada',
                    'default' => 'Pendente',
                ],
                
                'view_profile' => 'Ver Perfil Público',
                'view_details' => 'Ver Detalhes',
            ],
            
            'empty' => [
                'title' => 'Nenhuma modelo encontrada',
                'subtitle' => 'Não há criadoras registradas que correspondam aos critérios de busca.',
                'clear_filters' => 'Limpar filtros',
            ],
        ],
        'show' => [
            'title' => 'Detalhes da Modelo',
            'role' => 'Modelo',
            
            'info' => [
                'status' => 'Status',
                'active' => 'Ativa',
                'suspended' => 'Suspensa',
                'verification' => 'Verificação',
                'member_since' => 'Membro Desde',
                'last_activity' => 'Última Atividade',
                'stream_status' => 'Status do Stream',
                'live' => 'Ao Vivo',
                'back_to_list' => 'Voltar à lista',
            ],
            
            'stats' => [
                'title' => 'Estatísticas da Modelo',
                'subscribers' => 'Assinantes',
                'total_earnings' => 'Ganhos Totais',
                'content' => 'Conteúdo',
            ],
            
            'verification' => [
                'title' => 'Status de Verificação',
                'review' => 'Revisar Verificação',
                'notes' => 'Notas:',
            ],
            
            'content_summary' => [
                'title' => 'Resumo de Conteúdo',
                'photos' => 'Fotos',
                'videos' => 'Vídeos',
                'total_streams' => 'Streams Totais',
                'tips_received' => 'Gorjetas Recebidas',
            ],
        ],
    ],

    'reports' => [
        'title' => 'Gestão de Reportes',
        'breadcrumb' => 'Reportes',
        'subtitle' => 'Modere e assegure a qualidade da comunidade resolvendo conflitos.',
        
        'stats' => [
            'total' => 'Total de Reportes',
            'pending' => 'Pendentes',
            'resolved' => 'Resolvidos',
            'dismissed' => 'Descartados',
        ],
        
        'filters' => [
            'all' => 'Todos',
            'pending' => 'Pendentes',
            'resolved' => 'Resolvidos',
            'dismissed' => 'Descartados',
            'search' => 'Buscar usuário ou ID...',
        ],
        
        'table' => [
            'reported_by' => 'Reportado Por',
            'reported_item' => 'Elemento Reportado',
            'type' => 'Tipo',
            'reason' => 'Motivo',
            'status' => 'Status',
            'date' => 'Data',
            'actions' => 'Ações',
            'deleted_content' => 'Conteúdo Excluído',
            'view_details' => 'Ver Detalhes',
            'resolve' => 'Resolver',
            'dismiss' => 'Descartar',
            'empty' => 'Nenhum reporte corresponde à busca.',
        ],

        'modal' => [
            'title' => 'Detalhe do Reporte',
            'reported_by' => 'Reportado Por',
            'reporter_user' => 'Usuário Informante',
            'reported_content_user' => 'Conteúdo / Usuário Reportado',
            'reason_title' => 'MOTIVO DO REPORTE',
            'close' => 'Fechar',
            'deleted' => 'Excluído',
            'unknown' => 'Desconhecido',
            'no_reason' => 'Nenhum motivo especificado',
        ],

        'exports' => [
            'title' => 'Exportação de Relatórios',
            'subtitle' => 'Selecione o conjunto de dados que deseja baixar no formato CSV.',
            'users' => [
                'label' => 'Usuários',
                'desc' => 'Banco de dados completo de fãs e modelos com status de verificação KYC.',
            ],
            'transactions' => [
                'label' => 'Transações',
                'desc' => 'Histórico de compra de tokens, métodos de pagamento e status financeiros.',
            ],
            'withdrawals' => [
                'label' => 'Liquidações',
                'desc' => 'Relatório de pagamentos processados para modelos e solicitações pendentes.',
            ],
            'streams' => [
                'label' => 'Atividade de Streams',
                'desc' => 'Métricas de tempo no ar, audiência máxima e tokens gerados.',
            ],
            'subscriptions' => [
                'label' => 'Assinaturas',
                'desc' => 'Lista de assinaturas ativas, fãs inscritos e modelos beneficiárias.',
            ],
            'download' => 'Baixar CSV',
            'info_box' => [
                'title' => 'Informação:',
                'text' => 'Os arquivos exportados usam o padrão UTF-8. Se você abrir o arquivo no Microsoft Excel e vir caracteres estranhos, use a opção "Obter dados de texto/CSV" e selecione a origem do arquivo 65001: Unicode (UTF-8).',
            ],
        ],
    ],

    'settings' => [
        'title' => 'Configurações da Plataforma',
        'breadcrumb' => 'Configurações',
        'header_title' => 'Configurações do Sistema',
        'header_subtitle' => 'Gerencie parâmetros globais da plataforma, preferências de pagamento e segurança.',
        
        'nav' => [
            'general' => 'Geral',
            'finance' => 'Finanças',
            'media' => 'Mídia',
            'security' => 'Segurança',
        ],
        
        'general' => [
            'title' => 'Identidade e Sistema',
            'desc' => 'Configurações básicas de marca e acessibilidade.',
            'site_name' => 'Nome da Plataforma',
            'default_locale' => 'Idioma Global Padrão',
            'locales' => [
                'es' => 'Espanhol',
                'en' => 'Inglês',
                'pt_BR' => 'Português (Brasil)',
            ],
            'locale_help' => 'Idioma padrão para usuários não logados ou sem preferência.',
            'seo_desc' => 'Descrição SEO (Meta)',
            'maintenance_mode' => 'Modo de Manutenção',
            'maintenance_mode_desc' => 'Desative o acesso público temporariamente.',
        ],
        
        'finance' => [
            'title' => 'Economia e Pagamentos',
            'desc' => 'Regras de negócios, comissões e taxas de câmbio.',
            'commission_rate' => 'Comissão da Plataforma (%)',
            'min_withdrawal' => 'Pagamento Mínimo (USD)',
            'token_value' => 'Valor do Token (USD)',
            'token_help' => 'Define quanto vale 1 token em dólares americanos para os usuários.',
        ],
        
        'media' => [
            'title' => 'Mídia e Streaming',
            'desc' => 'Qualidade de vídeo e limites de armazenamento.',
            'stream_quality' => 'Qualidade de Streaming Padrão',
            'qualities' => [
                'sd' => 'SD (480p)',
                'hd' => 'HD (720p)',
                'fhd' => 'Full HD (1080p)',
                '4k' => 'Ultra HD (4K)',
            ],
            'upload_limit' => 'Limite de Upload (MB)',
        ],
        
        'security' => [
            'title' => 'Segurança e Acesso',
            'desc' => 'Controles de registro e verificação.',
            'allow_registrations' => 'Permitir Novos Registros',
            'allow_registrations_desc' => 'Os usuários podem criar contas livremente.',
            'email_verification' => 'Verificação de E-mail Necessária',
            'email_verification_desc' => 'Obrigatório para acessar os recursos da plataforma.',
        ],
        
        'save' => [
            'unsaved' => 'Você tem alterações não salvas',
            'button' => 'Salvar Alterações',
        ],
    ],

    'streams' => [
        'title' => 'Gerenciar Streams',
        'breadcrumb' => 'Streams',
        'subtitle' => 'Monitore e modere streams ao vivo',
        'wall_button' => 'Mural de Moderação',
        'list_button' => 'Visualização em Lista',
        
        'stats' => [
            'total' => 'Total de Streams',
            'live' => 'Ao Vivo',
            'ended' => 'Encerrados',
            'viewers' => 'Espectadores',
        ],
        
        'filters' => [
            'all' => 'Todos',
            'live' => 'Ao Vivo',
            'scheduled' => 'Programados',
            'ended' => 'Encerrados',
            'search_placeholder' => 'Buscar por título...',
            'filter_button' => 'Filtrar',
            'clear' => 'Limpar filtros',
        ],
        
        'badges' => [
            'live' => 'AO VIVO',
            'live_badge' => 'Ao Vivo',
            'ended' => 'Encerrado',
            'scheduled' => 'Programado',
            'historical' => 'Histórico',
        ],
        
        'actions' => [
            'view_mod' => 'Ver na Moderação',
            'end_stream' => 'Encerrar Stream',
            'end_confirm' => 'Encerrar este stream?',
            'end_trans' => 'Encerrar Transmissão',
            'end_confirm_trans' => 'Encerrar esta transmissão?',
            'moderating' => 'Moderando',
            'untitled' => 'Sem título',
        ],
        
        'empty' => [
            'title' => 'Nenhum stream encontrado',
            'desc' => 'Nenhuma transmissão correspondente aos filtros foi encontrada.',
            'mod_title' => 'Nenhuma transmissão ativa',
            'mod_desc' => 'Não há modelos transmitindo ao vivo no momento.',
        ],
        
        'moderate' => [
            'title' => 'Moderação de Transmissões',
            'header' => 'Mural de Moderação',
            'subtitle' => 'Monitoramento em tempo real de transmissões ativas',
        ],
    ],

    'token_packages' => [
        'title' => 'Pacotes de Tokens',
        'breadcrumb' => 'Pacotes de Tokens',
        'create_title' => 'Criar Pacote',
        'edit_title' => 'Editar Pacote',
        'create_header' => 'Novo Pacote',
        'create_subtitle' => 'Configure as recompensas e o custo do pacote de ingressos',
        'edit_header' => 'Editar Pacote',
        'edit_subtitle' => 'Atualize as recompensas e o custo do pacote:',
        'add_button' => 'Novo Pacote',
        
        'table' => [
            'id' => 'ID',
            'name_tokens' => 'Nome / Tokens',
            'price' => 'Preço (USD)',
            'bonus' => 'Bônus',
            'features' => 'Recursos',
            'status' => 'Status',
            'actions' => 'Ações',
        ],
        
        'features' => [
            'limited_time' => 'Tempo Limitado',
            'expires' => 'Expira:',
            'permanent' => 'Permanente',
        ],
        
        'status' => [
            'expired' => 'Expirado',
            'active' => 'Ativo',
            'inactive' => 'Inativo',
        ],
        
        'actions' => [
            'edit' => 'Editar',
            'delete' => 'Excluir',
            'delete_confirm' => 'Tem certeza de que deseja excluir este pacote de tokens?',
        ],
        
        'empty' => 'Nenhum pacote de tokens configurado.',
        
        'form' => [
            'config_title' => 'Configuração do Pacote',
            'name_label' => 'Nome do Pacote *',
            'name_placeholder' => 'Ex: Pacote Básico',
            'tokens_label' => 'Quantidade de Tokens *',
            'bonus_label' => 'Bônus de Tokens',
            'price_label' => 'Preço (USD) *',
            
            'availability_title' => 'Disponibilidade',
            'active_label' => 'Pacote Ativo',
            'active_desc' => 'Visível para os usuários',
            'limited_label' => 'Tempo Limitado',
            'limited_desc' => 'Promoção especial',
            'expires_label' => 'Data e Hora de Expiração *',
            
            'cancel' => 'Cancelar',
            'create_btn' => 'Criar Pacote',
            'update_btn' => 'Atualizar Pacote',
        ],
        
        'guide' => [
            'title' => 'Guia Comercial',
            'bonus_title' => 'Estratégia de Bônus',
            'bonus_desc' => 'Os bônus incentivam a compra de pacotes maiores. Um bônus de 10% a 20% é ideal para começar.',
            'popular_title' => 'Pacotes Populares',
            'pop_1_val' => '100 Tokens',
            'pop_1_desc' => 'Pacote de entrada, ideal para testes.',
            'pop_2_val' => '1000 Tokens',
            'pop_2_desc' => 'Geralmente o mais vendido. Oferece um pequeno bônus.',
            'pop_3_val' => '5000 Tokens',
            'pop_3_desc' => 'Para usuários VIP. O bônus deve ser muito atraente.',
            'time_title' => 'Tempo Limitado',
            'time_desc' => 'Use pacotes por <strong>Tempo Limitado</strong> durante feriados (Dia dos Namorados, Natal). Esses pacotes geralmente oferecem um bônus de +50% sobre os pacotes regulares.',
        ],
    ],

    'tokens' => [
        'title' => 'Gerenciamento de Tokens',
        'breadcrumb' => 'Tokens',
        'header' => 'Economia e Tokens',
        'subtitle' => 'Auditoria em tempo real do fluxo de tokens e transações da plataforma.',
        
        'stats' => [
            'total_sales' => 'Vendas Totais',
            'purchased_desc' => 'Tokens comprados',
            'in_circulation' => 'Em Circulação',
            'earned_desc' => 'Saldo atual dos usuários',
            'total_spent' => 'Gasto Total',
            'spent_desc' => 'Tokens consumidos',
            'active_users' => 'Usuários Ativos',
            'users_desc' => 'Participantes da economia',
        ],
        
        'filters' => [
            'all' => 'Todos',
            'purchases' => 'Compras 💰',
            'spent' => 'Gasto 🛒',
            'earned' => 'Ganhos 📈',
            'refund' => 'Reembolsos ↩️',
        ],
        
        'table' => [
            'title' => 'Diário de Transações',
            'user' => 'Usuário',
            'type' => 'Tipo',
            'amount' => 'Valor',
            'concept' => 'Conceito',
            'date' => 'Data',
            'deleted_user' => 'Usuário Excluído',
            'internal_movement' => 'Movimento interno',
            'empty' => 'Nenhuma transação registrada.',
        ],
        
        'leaderboard' => [
            'title' => 'Usuários Principais',
            'user' => 'Usuário',
            'tokens' => 'Tokens',
            'empty' => 'Sem dados',
        ],
    ],

    'users' => [
        'title' => 'Gestão de Usuários',
        'breadcrumb' => 'Usuários',
        'header' => 'Gestão de Usuários',
        'subtitle' => 'Gerencie fãs, modelos e permissões do sistema.',
        
        'search_placeholder' => 'Buscar por nome ou e-mail...',
        'add_button' => 'Adicionar Usuário',
        
        'table' => [
            'user' => 'Usuário',
            'role_level' => 'Cargo / Nível',
            'status' => 'Status',
            'registered' => 'Registrado',
            'actions' => 'Ações',
        ],
        
        'roles' => [
            'admin' => 'Admin',
            'model' => 'Modelo',
            'fan' => 'Fã',
        ],
        
        'status' => [
            'online' => 'Online',
            'offline' => 'Offline',
        ],
        
        'actions' => [
            'view' => 'Ver Perfil',
            'edit' => 'Editar',
            'disable' => 'Desativar',
            'enable' => 'Ativar',
        ],
        
        'empty' => [
            'title' => 'Nenhum usuário encontrado',
            'description' => 'Tente usar outros termos de pesquisa ou filtros.',
            'clear' => 'Limpar pesquisa',
        ],
        
        'modal' => [
            'title' => 'Confirmar Ação',
            'message' => 'Tem certeza que deseja realizar esta ação?',
            'cancel' => 'Cancelar',
            'confirm' => 'Confirmar',
        ],

        'create' => [
            'title' => 'Criar Usuário',
            'breadcrumb' => 'Novo Usuário',
            'header' => 'Novo Usuário',
            'subtitle' => 'Configure as credenciais e o cargo do novo membro',
            
            'form' => [
                'name' => 'Nome Completo *',
                'name_placeholder' => 'Nome e sobrenome',
                'email' => 'E-mail *',
                'email_placeholder' => 'email@exemplo.com',
                'password' => 'Senha *',
                'password_placeholder' => 'Mínimo 8 caracteres',
                'password_confirm' => 'Confirmar Senha *',
                'password_confirm_placeholder' => 'Repita a senha',
                
                'role' => 'Atribuir Cargo *',
                'role_select' => 'Selecione o cargo...',
                'role_fan' => '👤 Fã Premium',
                'role_fan_desc' => '<strong>Fã Premium:</strong> Pode seguir modelos, assinar conteúdo exclusivo e participar de bate-papos ao vivo.',
                'role_model' => '👸 Modelo / Criadora',
                'role_model_desc' => '<strong>Modelo / Criadora:</strong> Acesso a ferramentas de streaming, gestão de conteúdo e painel de receitas.',
                'role_admin' => '🛡️ Administrador',
                'role_admin_desc' => '<strong>Administrador:</strong> Acesso total ao sistema, moderação de conteúdo e análises da plataforma.',
                
                'initial_config' => 'Configuração Inicial',
                'activate_now' => 'Ativar conta imediatamente',
                'activate_now_desc' => 'O usuário poderá acessar o sistema após a criação.',
                'notice' => 'O sistema gerará automaticamente as estruturas necessárias de acordo com o cargo atribuído. Verifique se o e-mail está correto para notificações do sistema.',
                
                'cancel' => 'Cancelar',
                'submit' => 'Criar Usuário',
            ],
            
            'tips' => [
                'security_title' => 'Segurança',
                'sec_1' => 'Use no mínimo 8 caracteres com símbolos.',
                'sec_2' => 'Sempre verifique o domínio do e-mail.',
                'sec_3' => 'Não reutilize senhas de outros usuários.',
                
                'roles_title' => 'Cargos',
                'role_fan' => '<strong style="color:#fff;">Fã</strong> — Consumidor de conteúdo',
                'role_model' => '<strong style="color:#fff;">Modelo</strong> — Criadora de conteúdo',
                'role_admin' => '<strong style="color:#fff;">Admin</strong> — Acesso total ao sistema',
                'role_notice' => 'O cargo pode ser modificado na edição do usuário.',
                
                'shortcuts_title' => 'Links Rápidos',
                'link_users' => 'Ver todos os usuários',
                'link_models' => 'Gerenciar modelos',
                'link_verification' => 'Verificações pendentes',
            ],
        ],

        'edit' => [
            'title' => 'Editar Usuário',
            'breadcrumb' => 'Editar',
            'header' => 'Editar Perfil',
            
            'form' => [
                'name' => 'Nome Completo *',
                'name_placeholder' => 'Ex. John Doe',
                'email' => 'E-mail *',
                'email_placeholder' => 'exemplo@email.com',
                
                'role' => 'Cargo do Usuário *',
                'role_fan' => '👥 Fã',
                'role_model' => '👩‍💼 Modelo',
                'role_admin' => '👑 Administrador',
                
                'status' => 'Status',
                'user_active' => 'Usuário Ativo',
                
                'password_new' => 'Nova Senha (Opcional)',
                'password_new_placeholder' => 'Deixe em branco para manter a atual',
                'password_new_help' => 'Mínimo 8 caracteres.',
                'password_confirm' => 'Confirmar Senha',
                'password_confirm_placeholder' => 'Repita a nova senha',
                
                'cancel' => 'Cancelar',
                'submit' => 'Salvar Alterações',
            ],
        ],

        'show' => [
            'title' => 'Detalhes do Usuário',
            
            'profile' => [
                'status' => 'Status',
                'active' => 'Ativo',
                'suspended' => 'Suspenso',
                'member_since' => 'Membro Desde',
                'last_access' => 'Último Acesso',
                
                'actions' => [
                    'edit' => 'Editar',
                    'debug' => 'Debug',
                    'back' => 'Voltar para a lista',
                ],
            ],
            
            'stats' => [
                'title' => 'Estatísticas do Jogo',
                'level' => 'Nível',
                'experience' => 'Experiência',
                'tickets' => 'Ingressos',
                'xp_to_next_level' => '% para o Nível',
            ],
            
            'missions' => [
                'title' => 'Histórico de Missões',
                'completed' => 'Concluída',
                'progress' => 'Progresso:',
                'empty' => 'O usuário ainda não iniciou nenhuma missão.',
            ],
        ],
    ],

    'verification' => [
        'index' => [
            'title' => 'Verificação de Identidade',
            'subtitle' => 'Gerencie e valide a identidade das modelos para garantir a segurança da plataforma',
            
            'filters' => [
                'all' => 'Todos',
                'pending' => 'Pendentes',
                'approved' => 'Aprovados',
                'rejected' => 'Rejeitados',
            ],
            
            'table' => [
                'model' => 'Modelo',
                'email' => 'E-mail',
                'status' => 'Status de Verificação',
                'actions' => 'Ações',
                
                'id_prefix' => 'ID: #',
                'email_verified' => 'E-mail verificado',
                'email_unverified' => 'E-mail não verificado',
                
                'status_approved' => 'Aprovado',
                'status_under_review' => 'Em Revisão',
                'status_rejected' => 'Rejeitado',
                'status_pending' => 'Pendente',
                
                'action_approve_email' => 'Aprovar E-mail',
                'action_review' => 'Revisar Perfil',
            ],
            
            'empty' => [
                'title' => 'Sem solicitações pendentes',
                'subtitle' => 'Não há verificações que correspondam aos filtros selecionados.',
                'action' => 'Ver todos os registros',
            ],
            
            'modal' => [
                'approve_title' => 'Aprovar e-mail manualmente?',
                'approve_desc' => 'Esta ação marcará o e-mail do usuário como verificado.',
                'confirm' => 'Sim, aprovar',
                'cancel' => 'Cancelar',
            ],
        ],

        'show' => [
            'title' => 'Revisão de Identidade',
            'subtitle' => 'Valide os documentos para conceder o emblema de verificação',
            'breadcrumb' => 'Detalhe',
            
            'profile' => [
                'id' => 'ID: #',
                'email' => 'E-mail: ',
                'email_verified' => 'E-mail Verificado',
                'email_unverified' => 'E-mail Não Verificado',
                
                'legal_name' => 'Nome Legal',
                'country' => 'País',
                'age' => 'Idade (Nascimento)',
                'years' => 'anos',
                'id_document' => 'Documento ID',
                'registered_at' => 'Data de Registro',
                'not_provided' => '—',
            ],
            
            'documents' => [
                'title' => 'Documentos Anexados',
                'front' => 'FRENTE DO DOCUMENTO',
                'back' => 'VERSO DO DOCUMENTO',
                'selfie' => 'SELFIE VIP C/ ID',
                'empty' => 'Nenhum documento de identidade foi enviado.',
            ],
            
            'resolution' => [
                'title' => 'Resolução',
                'notes_label' => 'Notas Adicionais (Opcional)',
                'notes_placeholder' => 'Notas visíveis apenas para administradores...',
                'btn_approve' => 'APROVAR PERFIL',
                
                'reject_reason_label' => 'Motivo da Rejeição (Obrigatório)',
                'reject_reason_placeholder' => 'Explique por que está sendo rejeitado...',
                'btn_reject' => 'REJEITAR SOLICITAÇÃO',
                'confirm_reject' => 'Confirmar rejeição?',
                
                'verified_desc' => 'Este perfil já foi revisado e aprovado.',
            ],
        ],
    ],

    'withdrawals' => [
        'index' => [
            'title' => 'Pagamentos de Modelos',
            'subtitle' => 'Gerenciamento financeiro centralizado para pagamentos.',
            'breadcrumb' => 'Pagamentos',
            
            'stats' => [
                'pending' => 'Pendente de Aprovação',
                'pending_amount' => 'tokens',
                'processed_today' => 'Processados Hoje',
                'processed_today_desc' => 'Transações concluídas',
                'total_processed' => 'Total de Tokens Processados',
                'total_processed_desc' => 'Tokens convertidos com sucesso',
            ],
            
            'filters' => [
                'all' => 'Todos',
                'pending' => 'Pendentes',
                'completed' => 'Concluídos',
                'rejected' => 'Rejeitados',
            ],
            
            'table' => [
                'model' => 'Modelo',
                'tokens' => 'Tokens',
                'net' => 'Líquido (Tokens)',
                'method' => 'Método',
                'status' => 'Status',
                'date' => 'Data',
                'actions' => 'Ações',
                
                'deleted_user' => 'Usuário Excluído',
                'empty' => 'Não há solicitações de pagamento.',
                
                'action_view' => 'Ver Detalhes',
                'action_approve' => 'Aprovar',
                'action_reject' => 'Rejeitar',
            ],
            
            'modal' => [
                'approve_title' => 'Aprovar Pagamento',
                'approve_desc' => 'Você está prestes a aprovar a conversão de tokens para',
                'approve_requested' => 'Tokens Solicitados',
                'approve_net' => 'Líquido após comissão:',
                'confirm_approve' => 'Confirmar Pagamento',
                
                'reject_title' => 'Rejeitar Solicitação',
                'reject_reason_label' => 'Motivo da rejeição',
                'reject_reason_placeholder' => 'Explique o motivo...',
                'confirm_reject' => 'Rejeitar',
                
                'cancel' => 'Cancelar',
            ],
        ],

        'show' => [
            'title' => 'Detalhe do Pagamento #',
            'subtitle' => 'Informações completas da solicitação de pagamento',
            'breadcrumb' => 'Pagamento #',
            
            'info' => [
                'title' => 'Informações do Pagamento',
                'status' => 'Status:',
                'model' => 'Modelo:',
                'requested_amount' => 'Valor Solicitado:',
                'fee' => 'Taxa:',
                'net_amount' => 'Valor Líquido:',
                'payment_method' => 'Método de Pagamento:',
                'notes' => 'Notas:',
                'reject_reason' => 'Motivo da Rejeição:',
            ],
            
            'status' => [
                'pending' => 'PENDENTE',
                'processing' => 'PROCESSANDO',
                'completed' => 'CONCLUÍDO',
                'rejected' => 'REJEITADO',
                'cancelled' => 'CANCELADO',
            ],
            
            'payment_details' => [
                'title' => 'Detalhes de Pagamento',
                'bank' => 'Banco:',
                'account_holder' => 'Titular:',
                'account_number' => 'Número da Conta:',
                'swift' => 'SWIFT/BIC:',
                'paypal_email' => 'E-mail do PayPal:',
                'stripe_account' => 'Conta Stripe:',
                'crypto_type' => 'Criptomoeda:',
                'wallet_address' => 'Endereço da Carteira:',
                'empty' => 'Nenhum detalhe de pagamento disponível',
            ],
            
            'dates' => [
                'title' => 'Datas',
                'requested' => 'Solicitado:',
                'processed' => 'Processado:',
            ],
            
            'actions' => [
                'title' => 'Ações',
                'approve' => 'Aprovar Pagamento',
                'reject' => 'Rejeitar Pagamento',
                'back' => 'Voltar para a Lista',
            ],
            
            'modal' => [
                'approve_title' => 'Aprovar Pagamento #',
                'approve_desc' => 'Tem certeza de que deseja aprovar este pagamento?',
                'approve_model' => 'Modelo:',
                'approve_amount' => 'Valor:',
                'approve_net' => 'Líquido:',
                'approve_method' => 'Método:',
                'btn_cancel' => 'Cancelar',
                'btn_approve' => 'Aprovar Pagamento',
                
                'reject_title' => 'Rejeitar Pagamento #',
                'reject_reason_label' => 'Motivo da Rejeição *',
                'reject_reason_placeholder' => 'Explique por que este pagamento está sendo rejeitado...',
                'btn_reject' => 'Rejeitar Pagamento',
            ],
        ],
    ],

    'gamification' => [
        'xp_settings' => [
            'title' => 'Configurações Globais de XP',
            'subtitle' => 'Defina o XP que os modelos recebem por cada ação automática do sistema.',
            'breadcrumb' => 'Configurações de XP',
            'breadcrumb_parent' => 'Gamificação',
            
            'fans' => [
                'title' => 'XP por Ação — Fãs',
                'tokens_purchased' => 'Compra de Tokens (100%)',
                'tokens_purchased_desc' => 'Proporção para converter tokens comprados em XP (Ex: se colocar 10, cada 10 tokens comprados recompensam 10 XP; ou seja 1:1)',
                
                'tip_sent' => 'Enviar Tips (100%)',
                'tip_sent_desc' => 'Proporção para converter tokens doados em XP (Ex: se colocar 10, enviar uma tip de 10 adiciona 10 XP)',
                
                'subscription' => 'Inscrever-se em um Modelo',
                'subscription_desc' => 'XP fixo que o Fã recebe toda vez que compra uma assinatura de um modelo.',
                
                'chat_message' => 'Enviar Mensagem no Chat',
                'chat_message_desc' => 'XP fixo que o Fã recebe por enviar mensagens.',
                
                'stream_view' => 'Entrar em uma Transmissão',
                'stream_view_desc' => 'XP fixo por entrar na transmissão de um modelo.',
            ],
            
            'models' => [
                'title' => 'XP por Ação — Modelos',
                'tip_received' => 'Receber Tips (10%)',
                'tip_received_desc' => '% do total da tip convertido em XP (Ex: se colocar 10, e receber uma tip de 100, ganha 10 XP)',
                
                'new_subscriber' => 'Novo Inscrito',
                'new_subscriber_desc' => 'XP fixo que o modelo recebe a cada novo inscrito.',
                
                'chat_message' => 'Receber Mensagem no Chat',
                'chat_message_desc' => 'XP fixo por cada mensagem que os fãs enviem no chat.',
                
                'stream_view' => 'Espectador da Transmissão',
                'stream_view_desc' => 'XP fixo para cada fã visualizando/entrando em sua transmissão.',
            ],
            
            'units' => [
                'base_percent' => '% base',
                'fixed_xp' => 'XP fixo',
                'reward_percent' => '% prêmio',
            ],
            
            'save' => 'Salvar Alterações',
            
            'note' => 'Nota:',
            'note_desc' => 'As alterações são aplicadas imediatamente para eventos futuros. Ações passadas não são recalculadas. Os eventos de <em>chat</em> e <em>stream_view</em> devem ser acionados para o listener para que esses valores tenham efeito.',
        ],
    ],

    'flash' => [
        'users' => [
            'email_approved'       => 'E-mail aprovado manualmente.',
            'verification_sent'    => 'E-mail de verificação reenviado com sucesso.',
            'verification_testing' => 'Modo de teste: o envio de e-mails será ativado em produção.',
            'already_verified'     => 'Este usuário já tem seu e-mail verificado.',
            'created'              => 'Usuário criado com sucesso.',
            'updated'              => 'Usuário atualizado com sucesso.',
            'cannot_delete_self'   => 'Você não pode excluir sua própria conta.',
            'deleted'              => 'Usuário excluído com sucesso.',
            'status_updated'       => 'Status atualizado com sucesso.',
        ],
        'content' => [
            'photo_approved'  => 'Foto aprovada com sucesso.',
            'photo_rejected'  => 'Foto rejeitada.',
            'photo_deleted'   => 'Foto excluída com sucesso.',
            'video_approved'  => 'Vídeo aprovado com sucesso.',
            'video_rejected'  => 'Vídeo rejeitado.',
            'video_deleted'   => 'Vídeo excluído com sucesso.',
            'photos_approved' => ':count fotos aprovadas.',
            'photos_rejected' => ':count fotos rejeitadas.',
        ],
        'verification' => [
            'already_approved'  => 'Este perfil já foi aprovado.',
            'profile_approved'  => 'Perfil de :name aprovado com sucesso.',
            'profile_rejected'  => 'Perfil de :name rejeitado. O usuário foi notificado.',
            'profile_in_review' => 'Perfil de :name colocado em revisão.',
        ],
        'withdrawals' => [
            'only_pending_approve' => 'Apenas pagamentos pendentes podem ser aprovados.',
            'approved'             => 'Pagamento aprovado com sucesso.',
            'only_pending_reject'  => 'Apenas pagamentos pendentes podem ser rejeitados.',
            'rejected'             => 'Pagamento rejeitado.',
        ],
        'achievements' => [
            'created'       => 'Conquista criada com sucesso.',
            'updated'       => 'Conquista atualizada com sucesso.',
            'cannot_delete' => 'Esta conquista não pode ser excluída pois já foi desbloqueada por usuários.',
            'deleted'       => 'Conquista excluída com sucesso.',
            'activated'     => 'Conquista ativada com sucesso.',
            'deactivated'   => 'Conquista desativada com sucesso.',
        ],
        'missions' => [
            'created'       => 'Missão criada com sucesso.',
            'updated'       => 'Missão atualizada com sucesso.',
            'cannot_delete' => 'Esta missão não pode ser excluída pois já foi atribuída a usuários.',
            'deleted'       => 'Missão excluída com sucesso.',
            'activated'     => 'Missão ativada com sucesso.',
            'deactivated'   => 'Missão desativada com sucesso.',
        ],
        'levels' => [
            'created' => 'Nível criado com sucesso.',
            'updated' => 'Nível atualizado com sucesso.',
            'deleted' => 'Nível excluído com sucesso.',
        ],
        'badges' => [
            'created'        => 'Distintivo criado com sucesso.',
            'updated'        => 'Distintivo atualizado com sucesso.',
            'cannot_delete'  => 'Este distintivo não pode ser excluído pois já foi concedido.',
            'deleted'        => 'Distintivo excluído com sucesso.',
            'status_updated' => 'Status do distintivo atualizado.',
        ],
        'token_packages' => [
            'created' => 'Pacote de tokens criado com sucesso.',
            'updated' => 'Pacote de tokens atualizado com sucesso.',
            'deleted' => 'Pacote de tokens excluído com sucesso.',
        ],
        'settings' => [
            'updated'    => 'Configurações atualizadas com sucesso.',
            'xp_updated' => 'Configurações globais de XP atualizadas com sucesso.',
        ],
        'streams' => [
            'ended'      => 'Stream finalizado com sucesso.',
            'not_active' => 'O stream não está mais ativo.',
        ],
        'reports' => [
            'resolved'  => 'Reporte resolvido com sucesso.',
            'dismissed' => 'Reporte descartado.',
        ],
        'messages' => [
            'deleted'      => 'Mensagem excluída com sucesso.',
            'flag_updated' => 'Status da mensagem atualizado.',
        ],
        'auth' => [
            'register_model_success' => 'Registro realizado com sucesso! Por favor, verifique seu e-mail antes de continuar.',
            'default_bio'            => 'Novo modelo na plataforma.',
        ],
        'fan' => [
            'access_denied'             => 'Acesso negado.',
            'not_a_model'               => 'O usuário não é um modelo.',
            'invalid_content_type'      => 'Tipo de conteúdo inválido.',
            'invalid_data'              => 'Dados inválidos.',
            'favorite_added'            => 'Adicionado aos favoritos',
            'favorite_removed'          => 'Removido dos favoritos',
            'favorite_error'            => 'Erro ao atualizar favoritos.',
            'notification_read'         => 'Notificação marcada como lida',
            'notification_read_error'   => 'Erro ao marcar a notificação.',
            'notifications_all_read'    => 'Todas as notificações marcadas como lidas',
            'notifications_read_error'  => 'Erro ao marcar as notificações.',
            'wrong_password'            => 'A senha atual está incorreta.',
            'invalid_profile_data'      => 'Dados inválidos.',
            'profile_updated'           => 'Perfil atualizado com sucesso.',
            'profile_update_error'      => 'Erro ao atualizar o perfil.',
            'already_subscribed'        => 'Você já está inscrito neste modelo.',
            'insufficient_tokens'       => 'Tokens insuficientes.',
            'subscription_success'      => 'Assinatura bem-sucedida',
            'subscription_error'        => 'Erro ao processar a assinatura.',
            'subscription_cancelled'    => 'Assinatura cancelada com sucesso',
            'subscription_cancel_error' => 'Erro ao cancelar a assinatura.',
            'sub_tx_fan'                => 'Assinatura mensal para :name',
            'sub_tx_model'              => 'Assinatura mensal de :name',
            'invalid_package'           => 'Pacote de tokens inválido ou desatualizado.',
            'invalid_price'             => 'O preço ou pacote selecionado não é válido.',
            'recharge_success'          => 'Recarga bem-sucedida',
            'recharge_error'            => 'Erro ao processar a recarga. Por favor, tente novamente.',
            'recharge_tx'               => 'Recarga rápida de :count tokens',
            'purchase_success'          => 'Compra bem-sucedida',
            'purchase_tx'               => 'Compra de :total tokens (:base + bônus)',
        ],
        'benefits' => [
            'chat'        => 'Chat habilitado',
            'cashback_5'  => '5% Cashback em gorjetas',
            'invisible'   => 'Modo Invisível',
            'vip'         => '10% Cashback + Prioridade VIP',
            'elite'       => 'Acesso Elite Total',
            'default_league' => 'Cinza',
        ],
        'achievements' => [
            'first_tip_name'       => 'Primeira Gorjeta',
            'first_tip_desc'       => 'Envie sua primeira gorjeta',
            'generous_name'        => 'Generoso',
            'generous_desc'        => 'Envie 100 gorjetas',
            'vip_subscriber_name'  => 'Assinante VIP',
            'vip_subscriber_desc'  => 'Mantenha 5 assinaturas ativas',
            'climber_name'         => 'Escalador',
            'climber_desc'         => 'Alcance o nível 10',
            'legend_name'          => 'Lenda',
            'legend_desc'          => 'Alcance o nível 21',
        ],
        'model' => [
            'profile_required'           => 'Você precisa de um perfil aprovado para acessar :section.',
            'rejected_flash'             => 'Seu perfil foi rejeitado. Motivo: :reason. Você pode corrigir as informações e reenviar.',
            'under_review_flash'         => 'Seu perfil está em análise. Iremos notificá-lo por e-mail quando for aprovado.',
            'under_review_no_edit'       => 'Seu perfil está em análise. Você não pode modificá-lo até receber uma resposta.',
            'edit_blocked_review'        => 'Você não pode editar seu perfil enquanto ele está em análise.',
            'edit_blocked_rejected'      => 'Seu perfil foi rejeitado. Use o processo de onboarding para corrigir as informações.',
            'settings_approved_required' => 'Você precisa de um perfil aprovado para acessar as configurações.',
            'settings_updated'           => 'Configurações atualizadas com sucesso.',
            'profile_updated'            => 'Perfil atualizado com sucesso.',
            'profile_updated_approved'   => 'Perfil atualizado com sucesso. Alterações nas fotos requerem nova aprovação.',
            'default_bio'                => 'Novo modelo na plataforma',
            'analytics_required'         => 'Você precisa de um perfil aprovado para acessar as análises.',
            'earnings_required'          => 'Você precisa de um perfil aprovado para acessar os ganhos.',
            'leaderboard_required'       => 'Você precisa de um perfil aprovado para acessar o ranking.',
            'missions_required'          => 'Você precisa de um perfil aprovado para acessar as missões.',
            'achievements_required'      => 'Você precisa de um perfil aprovado para acessar as conquistas.',
            'not_authorized'             => 'Não autorizado',
            'access_denied'              => 'Acesso negado.',
            'notification_read'          => 'Notificação marcada como lida',
            'notification_read_error'    => 'Erro ao marcar a notificação.',
            'notifications_all_read'     => 'Todas as notificações marcadas como lidas',
            'notifications_read_error'   => 'Erro ao marcar as notificações.',
            'mission_not_found'          => 'Missão não encontrada.',
            'mission_already_claimed'    => 'Esta missão já foi reivindicada.',
            'mission_not_complete'       => 'Você ainda não completou esta missão.',
            'mission_reward_claimed'     => 'Recompensa reivindicada com sucesso!',
            'default_fan_name'           => 'Usuário',
        ],
        'onboarding' => [
            'step1_success'       => 'Passo 1 concluído. Agora envie seu documento de identidade.',
            'step2_success'       => 'Documentos enviados com sucesso. Último passo.',
            'step3_success'       => 'Perfil enviado para análise. Iremos notificá-lo quando for aprovado.',
            'complete_prev_steps' => 'Você deve concluir todas as etapas anteriores.',
            'profile_not_found'   => 'Perfil não encontrado. Por favor, conclua o passo 1 primeiro.',
            'docs_required'       => 'Todos os documentos obrigatórios (Frente, Verso, Selfie) são necessários.',
            'invalid_files'       => 'Os arquivos enviados não são válidos. Por favor, tente novamente.',
            'upload_error'        => 'Erro ao enviar os documentos. Por favor, tente novamente.',
            'unexpected_error'    => 'Erro inesperado: :message',
        ],
        'photo' => [
            'max_photos'   => 'Você não pode enviar mais de 10 fotos de uma vez.',
            'invalid_mime' => 'O arquivo deve ser uma imagem válida (jpeg, png, jpg, gif, webp, svg, bmp, tiff).',
            'max_size'     => 'Cada foto não deve ultrapassar 10MB.',
            'uploaded_one' => 'Foto enviada com sucesso.',
            'uploaded_many'=> ':count fotos enviadas com sucesso.',
            'deleted'      => 'Foto excluída com sucesso.',
        ],
        'video' => [
            'max_size'     => 'O vídeo selecionado excede o limite máximo de 50MB.',
            'invalid_mime' => 'O vídeo deve estar no formato MP4, MOV, AVI ou WMV.',
            'thumb_max'    => 'A miniatura não deve ultrapassar 5MB.',
            'uploaded'     => 'Vídeo enviado com sucesso.',
            'deleted'      => 'Vídeo excluído com sucesso.',
        ],
        'stream' => [
            'active_warning'     => 'Você tem :count stream(s) ativo(s): :titles. Eles serão encerrados automaticamente ao criar o novo stream.',
            'started'            => 'Stream iniciado com sucesso! Configure o OBS com sua chave de stream e comece a transmitir.',
            'paused'             => 'Stream pausado.',
            'resumed'            => 'Stream retomado.',
            'ended'              => 'Stream encerrado com sucesso.',
            'deleted'            => 'Stream excluído com sucesso.',
            'settings_updated'   => 'Configurações do stream atualizadas.',
            'not_live'           => 'O stream não está ativo. Configure o OBS primeiro.',
            'action_completed'   => 'Ação marcada como concluída',
            'message_sent'       => 'Mensagem enviada',
            'private_chat_label' => 'Chat Privado',
        ],
        'withdrawal' => [
            'tx_description' => 'Solicitação de pagamento via :method',
            'request_sent'   => 'Solicitação de pagamento enviada com sucesso.',
            'cancel_error'   => 'Você só pode cancelar pagamentos pendentes.',
            'cancelled'      => 'Pagamento cancelado com sucesso.',
        ],
        'notification' => [
            'all_read'    => 'Todas as notificações marcadas como lidas',
            'all_deleted' => 'Todas as notificações excluídas',
        ],
        'payment' => [
            'failed_default' => 'O pagamento não pôde ser processado',
        ],
        'profile_public' => [
            'login_required'            => 'Você deve fazer login para se inscrever.',
            'model_not_found'           => 'Modelo não encontrado.',
            'fans_only'                 => 'Somente fãs podem se inscrever em modelos.',
            'no_self_subscribe'         => 'Você não pode se inscrever no seu próprio perfil.',
            'already_subscribed'        => 'Você já tem uma assinatura :tier ativa para este modelo.',
            'insufficient_tokens'       => 'Você não tem tokens suficientes para esta assinatura.',
            'subscribe_success'         => 'Assinatura :tier ativada com sucesso por :amount tokens! Agora você tem acesso exclusivo a :name.',
            'subscribe_error'           => 'Ocorreu um erro ao processar sua assinatura. Por favor, tente novamente.',
            'login_required_short'      => 'Você deve fazer login.',
            'insufficient_tokens_short' => 'Você não tem tokens suficientes.',
            'tip_success'               => 'Gorjeta enviada com sucesso!',
            'tip_error'                 => 'Erro ao processar a gorjeta.',
            'roulette_success'          => 'Você girou a roleta!',
            'roulette_error'            => 'Erro ao processar o giro.',
            'chat_fans_only'            => 'Somente fãs ou o modelo podem conversar.',
            'chat_insufficient_tokens'  => 'Tokens insuficientes',
            'tx_subscribe_fan'          => 'Assinatura :tier de :name',
            'tx_subscribe_model'        => 'Assinatura :tier de :name',
            'tx_tip_fan'                => 'Gorjeta enviada a :name:menu',
            'tx_tip_model'              => 'Gorjeta recebida de :name:action',
            'tx_tip_menu_suffix'        => ' (Menu)',
            'tx_tip_action_suffix'      => ' - Ação do Menu',
            'tx_roulette_fan'           => 'Giro de Roleta na sala de :name',
            'tx_roulette_model'         => 'Giro de Roleta de :name',
            'tx_chat_fan'               => 'Desbloqueio de chat privado com :name (:hours h)',
            'tx_chat_model'             => 'Desbloqueio de chat privado de :name (:hours h)',
        ],
        'report' => [
            'no_self_report' => 'Você não pode se reportar.',
            'sent'           => 'Relatório enviado com sucesso. Obrigado por nos ajudar a manter a segurança.',
            'error'          => 'Ocorreu um erro ao enviar o relatório. Por favor, tente novamente.',
        ],
        'rtmp' => [
            'key_live_error' => 'Você não pode regenerar sua chave enquanto está ao vivo. Encerre sua transmissão primeiro.',
            'key_generated'  => 'Chave de stream gerada com sucesso',
        ],
        'streaming' => [
            'not_active'   => 'Stream não está ativo',
            'unauthorized' => 'Não autorizado',
            'started'      => 'Transmissão iniciada',
            'stopped'      => 'Transmissão encerrada',
            'connected'    => 'Conectado ao stream',
            'disconnected' => 'Desconectado do stream',
        ],
        'stream_view' => [
            'not_active'          => 'Este stream não está ativo.',
            'subscribe_required'  => 'Você precisa se inscrever para assistir este stream.',
            'insufficient_tokens' => 'Você não tem tokens suficientes. Você tem :count tokens disponíveis.',
            'tip_error'           => 'Erro ao enviar a gorjeta. Tente novamente.',
            'tx_tip_fan'          => 'Gorjeta no stream ":title" para :name',
            'tx_tip_model'        => 'Gorjeta no stream ":title" de :name',
        ],
        'middleware' => [
            'onboarding_required'   => 'Conclua seu processo de verificação para acessar.',
            'subscription_required' => 'Você precisa de uma assinatura ativa para acessar este conteúdo.',
            'role_denied'           => 'Você não tem permissão para acessar esta seção.',
            'verified_denied'       => 'Acesso negado.',
            'profile_incomplete'    => 'Você deve preencher seu perfil primeiro.',
            'profile_pending'       => 'Este recurso estará disponível quando seu perfil for aprovado.',
        ],
    ],
    
    'models' => [
        'profile' => [
            'not_specified' => 'Não especificado',
            'height'        => 'Altura',
            'weight'        => 'Peso',
            'measurements'  => 'Medidas',
            'years_old'     => 'anos',
            'social_networks' => [
                'instagram' => 'Instagram',
                'twitter'   => 'Twitter',
                'tiktok'    => 'TikTok',
                'facebook'  => 'Facebook',
                'youtube'   => 'YouTube',
                'onlyfans'  => 'OnlyFans',
            ],
            'body_types' => [
                'Delgado'       => '🌸 Magra',
                'Atlético'      => '💪 Atlética',
                'Talla mediana' => '🌺 Média',
                'Con curvas'    => '🍑 Com curvas',
                'BBW'           => '👸 BBW',
            ],
            'ethnicities' => [
                'Blanca'      => '🤍 Branca',
                'Latina'      => '🌹 Latina',
                'Asiática'    => '🌸 Asiática',
                'Árabe'       => '🌙 Árabe',
                'Negra'       => '🖤 Negra',
                'India'       => '🪷 Indiana',
                'Multiétnica' => '🌈 Multiétnica',
            ],
            'hair_colors' => [
                'Rubio'      => '👱‍♀️ Loira',
                'Moreno'     => '👩‍🦳 Morena',
                'Pelo Negro' => '👩‍🦲 Cabelo Preto',
                'Colorido'   => '🌈 Colorido',
                'Pelirroja'  => '👩‍🦰 Ruiva',
            ],
        ],
        'user' => [
            'benefits' => [
                'reduced_commission' => [
                    'name'        => 'Comissão Reduzida',
                    'description' => '15% de comissão (anteriormente 20%)',
                ],
                'search_priority' => [
                    'name'        => 'Prioridade na Busca',
                    'description' => 'Aparece primeiro nos resultados',
                ],
                'vip_badge' => [
                    'name'        => 'Distintivo VIP',
                    'description' => 'Distintivo especial no seu perfil',
                ],
                'priority_support' => [
                    'name'        => 'Suporte Prioritário',
                    'description' => 'Atendimento preferencial 24/7',
                ],
            ],
            'token_benefits' => [
                'level_6'  => '5% de Cashback em todas as gorjetas',
                'level_16' => '10% de Cashback + Prioridade no chat',
            ],
            'missions' => [
                'tokens' => [
                    'title'  => 'Recarregar 1000 tokens',
                    'reward' => '50 XP + 10 Ingressos',
                ],
                'subscription' => [
                    'title'  => 'Inscreva-se em 3 modelos',
                    'reward' => '100 XP + 20 Ingressos',
                ],
                'daily_tip' => [
                    'title'       => 'Envie 5 gorjetas',
                    'description' => 'Envie gorjetas para seus modelos favoritos',
                ],
                'weekly_login' => [
                    'title'       => 'Conecte-se 3 dias nesta semana',
                    'description' => 'Faça login pelo menos em 3 dias diferentes',
                ],
                'monthly_spend' => [
                    'title'       => 'Gaste 5000 tokens este mês',
                    'description' => 'Use tokens em gorjetas e assinaturas',
                ],
                'obligatory_level' => [
                    'title'       => 'Alcance :xp XP',
                    'description' => 'Conclua esta missão para chegar ao nível :level',
                ],
                'model_weekly_photos' => [
                    'title'       => 'Envie 5 fotos nesta semana',
                    'description' => 'Compartilhe novo conteúdo com seus fãs',
                ],
                'model_monthly_streams' => [
                    'title'       => 'Faça 3 streams este mês',
                    'description' => 'Conecte-se ao vivo com seu público',
                ],
                'model_daily_tips' => [
                    'title'       => 'Receba 10 gorjetas hoje',
                    'description' => 'Interaja com seus fãs',
                ],
            ],
        ],
    ],
    
    'notifications' => [
        'achievement' => [
            'unlocked' => 'Conquista desbloqueada! :name',
        ],
        'badge' => [
            'earned' => 'Insígnia especial obtida! :name',
        ],
        'chat' => [
            'extended' => [
                'model_title' => 'Chat Estendido',
                'model_msg'   => ':name estendeu o chat privado por 24 horas.',
                'model_btn'   => 'Ir para o Chat',
                'fan_title'   => 'Chat Estendido com Sucesso',
                'fan_msg'     => 'Você estendeu o chat com :name por 24 horas extras.',
                'fan_btn'     => 'Continuar Conversando',
            ],
            'unlocked' => [
                'model_title' => 'Novo Chat Desbloqueado!',
                'model_msg'   => ':name desbloqueou o chat privado.',
                'model_btn'   => 'Ir para o Chat',
                'fan_title'   => 'Chat Desbloqueado!',
                'fan_msg'     => 'Você desbloqueou o chat privado com :name.',
                'fan_btn'     => 'Começar a Conversar',
            ],
            'new_message' => [
                'title' => 'Nova Mensagem Privada',
                'btn'   => 'Responder',
            ],
        ],
        'level' => [
            'up' => 'Parabéns! Você alcançou o nível :level - :name',
        ],
        'model' => [
            'live_title' => 'Ao Vivo Agora!',
            'live_msg'   => ':name está transmitindo: :title',
            'live_btn'   => 'Ver Stream',
            'verify_email_subject' => 'Verifique sua conta de Modelo - Lustonex',
        ],
        'follower' => [
            'title' => 'Novo Seguidor!',
            'msg'   => ':name começou a seguir você',
            'btn'   => 'Ver Perfil',
        ],
        'subscriber' => [
            'fan_title'   => 'Assinatura Bem-sucedida!',
            'fan_msg'     => 'Você assinou com sucesso o conteúdo de :name',
            'fan_btn'     => 'Ver Perfil',
            'model_title' => 'Novo Assinante!',
            'model_msg'   => ':name assinou seu conteúdo',
            'model_btn'   => 'Ver Assinantes',
        ],
        'payment' => [
            'success_title' => 'Pagamento Bem-sucedido',
            'success_msg'   => 'Sua compra de :tokens tokens foi processada com sucesso',
            'success_btn'   => 'Ver Histórico',
        ],
        'tip' => [
            'received_title' => 'Gorjeta Recebida!',
            'received_msg'   => ':name enviou :amount tokens para você',
            'received_btn'   => 'Ver Ganhos',
        ],
        'withdrawal' => [
            'approved_title' => 'Pagamento Aprovado',
            'approved_msg'   => 'Seu pagamento de $:amount foi aprovado e processado',
            'approved_btn'   => 'Ver Pagamentos',
            'rejected_title' => 'Pagamento Rejeitado',
            'rejected_msg'   => 'Seu pagamento de $:amount foi rejeitado. Razão: :reason',
            'rejected_btn'   => 'Ver Detalhes',
            'not_specified'  => 'Não especificada',
        ],
        'gamification' => [
            'achievement_title' => 'Conquista Desbloqueada!',
            'achievement_msg'   => 'Você desbloqueou a conquista: :name',
            'level_title'       => 'Subiu de Nível!',
            'level_msg'         => 'Parabéns! Você alcançou o Nível :level: :name',
        ],
    ],
    
    'services' => [
        'payment' => [
            'invalid_paypal_email' => 'E-mail do PayPal inválido',
            'invalid_skrill_email' => 'E-mail do Skrill inválido',
            'processed_successfully' => 'Pagamento processado com sucesso',
            'card_declined' => 'Cartão recusado',
            'insufficient_funds' => 'Fundos insuficientes',
            'unknown_error' => 'Erro desconhecido',
            'payment_error' => 'Erro de pagamento',
            'paypal_success' => 'Pagamento via PayPal processado com sucesso',
            'paypal_rejected_reason' => 'Pagamento recusado pelo PayPal',
            'paypal_rejected' => 'O pagamento foi recusado pelo PayPal',
            'skrill_success' => 'Pagamento via Skrill processado com sucesso',
            'skrill_rejected_reason' => 'Pagamento recusado pelo Skrill',
            'skrill_rejected' => 'O pagamento foi recusado pelo Skrill',
            'required_field' => 'Campo obrigatório: :field',
            'invalid_card_number' => 'Número de cartão inválido',
            'invalid_cvv' => 'CVV inválido',
            'invalid_exp_month' => 'Mês de vencimento inválido',
            'expired_card' => 'Cartão expirado',
            'integration_not_implemented_card' => 'Integração de cartão real não implementada',
            'integration_not_implemented_paypal' => 'Integração real do PayPal não implementada',
            'integration_not_implemented_skrill' => 'Integração real do Skrill não implementada',
        ],
    ],
];
