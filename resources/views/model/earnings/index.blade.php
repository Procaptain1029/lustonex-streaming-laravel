@extends('layouts.model')

@section('title', __('model.earnings.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.earnings.index') }}" class="breadcrumb-item active">{{ __('model.earnings.title') }}</a>
@endsection

@section('styles')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
.earnings-container {
    padding: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
    box-sizing: border-box;
    overflow-x: hidden;
}

.page-header {
    margin-bottom: 1.5rem;
}

/* Estilos de encabezado heredados del layout model */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.stat-card-large {
    background: rgba(31, 31, 35, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(212, 175, 55, 0.15);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card-large:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.15);
    border-color: rgba(212, 175, 55, 0.3);
}

.stat-card-large.highlight {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(244, 227, 125, 0.05));
    border-color: rgba(212, 175, 55, 0.4);
    box-shadow: inset 0 0 20px rgba(212, 175, 55, 0.05), 0 4px 20px rgba(0, 0, 0, 0.2);
}

.stat-card-large.highlight:hover {
    box-shadow: inset 0 0 20px rgba(212, 175, 55, 0.1), 0 8px 30px rgba(212, 175, 55, 0.25);
}

.stat-icon-large {
    font-size: 2.2rem;
    color: var(--color-oro-sensual);
    margin-bottom: 0.75rem;
    filter: drop-shadow(0 2px 8px rgba(212, 175, 55, 0.3));
}

.stat-value-large {
    font-size: 1.8rem;
    font-weight: 700;
    font-family: var(--font-titles);
    color: var(--color-oro-sensual);
    margin-bottom: 0.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stat-label-large {
    font-size: 1rem;
    opacity: 0.8;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.content-card {
    background: rgba(31, 31, 35, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(212, 175, 55, 0.15);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    box-sizing: border-box;
}

.section-title {
    font-family: var(--font-titles);
    font-size: 1.2rem;
    color: var(--color-oro-sensual);
    margin: 0 0 1.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breakdown-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: rgba(11, 11, 13, 0.4);
    border: 1px solid transparent;
    border-radius: 12px;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.breakdown-item:hover {
    background: rgba(212, 175, 55, 0.05);
    border-color: rgba(212, 175, 55, 0.2);
    transform: translateX(4px);
}

.breakdown-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
}

.breakdown-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--gradient-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-size: 1.1rem;
    box-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
}

.breakdown-amount {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--color-oro-sensual);
}

.transactions-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.transaction-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: rgba(11, 11, 13, 0.4);
    border: 1px solid transparent;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.transaction-item:hover {
    background: rgba(212, 175, 55, 0.05);
    border-color: rgba(212, 175, 55, 0.2);
    transform: translateX(4px);
}

.transaction-info {
    flex: 1;
}

.transaction-type {
    font-weight: 600;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.transaction-type i {
    color: var(--color-oro-sensual);
}

.transaction-from {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
    word-break: break-all;
}

.transaction-date {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
}

.transaction-amount {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--color-oro-sensual);
    white-space: nowrap;
}

.commission-info {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(244, 227, 125, 0.02));
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(212, 175, 55, 0.3);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    text-align: center;
    box-sizing: border-box;
}

.commission-rate {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--color-oro-sensual);
    text-shadow: 0 2px 10px rgba(212, 175, 55, 0.2);
}

.filter-bar {
    background: rgba(31, 31, 35, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(212, 175, 55, 0.15);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    border-radius: 16px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
    box-sizing: border-box;
}

.filter-group {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.75rem 1.25rem;
    background: rgba(11, 11, 13, 0.6);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 10px;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 0.95rem;
    white-space: nowrap; /* Prevent text wrap inside button */
}

.filter-btn:hover {
    background: rgba(212, 175, 55, 0.15);
    border-color: rgba(212, 175, 55, 0.4);
}

.filter-btn.active {
    background: var(--gradient-gold);
    color: #000;
    border-color: var(--color-oro-sensual);
    box-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
}

.date-input {
    padding: 0.75rem 1rem;
    background: rgba(11, 11, 13, 0.6);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 10px;
    color: #fff;
    min-width: 220px;
    font-family: inherit;
    transition: all 0.3s ease;
    flex: 1;
}

.date-input:focus {
    outline: none;
    border-color: var(--color-oro-sensual);
    box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
}

.export-btn {
    margin-left: auto;
    padding: 0.75rem 1.5rem;
    background: var(--gradient-gold);
    border: none;
    border-radius: 10px;
    color: #000;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.export-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
}

.chart-container {
    background: rgba(31, 31, 35, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(212, 175, 55, 0.15);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    height: 320px;
    box-sizing: border-box;
}

.trend-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.9rem;
    margin-top: 0.5rem;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    background: rgba(11, 11, 13, 0.5);
}

.trend-indicator.positive {
    color: #00ff88;
    border: 1px solid rgba(0, 255, 136, 0.2);
}

.trend-indicator.negative {
    color: #ff4d4d;
    border: 1px solid rgba(255, 77, 77, 0.2);
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .earnings-container {
        padding: 0; 
        overflow: hidden; 
    }
    
    .page-header {
        margin-bottom: 1.5rem;
    }

    /* Estilos responsivos de encabezado heredados */
    
    .content-grid {
        grid-template-columns: 1fr;
    }

    .filter-bar {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
        padding: 1rem;
        max-width: 100%;
        overflow: hidden;
    }
    
    .filter-group {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        gap: 0.5rem;
        width: 100%;
        max-width: 100%;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; 
        -ms-overflow-style: none; 
    }
    
    .filter-group::-webkit-scrollbar {
        display: none; 
    }
    
    .filter-btn {
        flex: 0 0 auto; 
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }
    
    .date-input {
        width: 100%;
        box-sizing: border-box;
    }
    
    .export-btn {
        margin-left: 0;
        width: 100%;
        padding: 0.6rem 1rem;
    }
    
    .commission-rate {
        font-size: 1.8rem;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 columns for a more compact design */
        gap: 0.75rem;
    }
    
    .stat-card-large {
        padding: 1rem 0.5rem;
        border-radius: 12px;
    }
    
    .stat-icon-large {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .stat-value-large {
        font-size: 1.25rem;
    }
    
    .stat-label-large {
        font-size: 0.75rem;
    }
    
    .trend-indicator {
        font-size: 0.75rem;
        padding: 0.15rem 0.4rem;
        margin-top: 0.25rem;
    }
    
    .chart-container {
        height: 220px;
        padding: 0.75rem;
        border-radius: 12px;
    }
    
    .commission-info {
        padding: 0.75rem;
        border-radius: 12px;
        margin-bottom: 1rem;
    }
    
    .commission-rate {
        font-size: 1.6rem;
    }

    .filter-bar {
        padding: 0.75rem;
        border-radius: 12px;
    }
    
    .content-card {
        padding: 0.85rem;
        border-radius: 12px;
    }

    .breakdown-label {
        font-size: 0.85rem;
        gap: 0.5rem;
    }
    
    .breakdown-icon {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
    }
    
    .breakdown-amount {
        font-size: 0.95rem;
    }
    
    .breakdown-item {
        padding: 0.6rem;
    }

    .transaction-from {
        max-width: 100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .transaction-item {
        padding: 0.6rem;
    }
    
    .transaction-amount {
        font-size: 0.95rem;
    }
    
    .section-title {
        font-size: 1.05rem;
        margin-bottom: 0.8rem;
    }
}

    /* Estilos responsivos heredados */
</style>
@endsection

@section('content')
<div class="earnings-container">
    
    <div class="page-header">
        <h1 class="page-title">
             {{ __('model.earnings.title') }}
        </h1>
        <p class="page-subtitle">{{ __('model.earnings.subtitle') }}</p>
    </div>

    
    <div class="filter-bar">
        <div class="filter-group">
            <button class="filter-btn active" data-range="today">{{ __('model.earnings.filters.today') }}</button>
            <button class="filter-btn" data-range="week">{{ __('model.earnings.filters.this_week') }}</button>
            <button class="filter-btn" data-range="month">{{ __('model.earnings.filters.this_month') }}</button>
          
        </div>
        <input type="text" id="dateRangePicker" class="date-input" placeholder="{{ __('model.earnings.filters.custom_range') }}">
        <button class="export-btn" onclick="exportToCSV()">
            <i class="fas fa-download"></i> {{ __('model.earnings.filters.export_csv') }}
        </button>
    </div>

    
    <div class="commission-info">
        <div>{{ __('model.earnings.commission.label') }} <span class="commission-rate">{{ $stats['commission_rate'] }}%</span></div>
        <div style="font-size: 0.9rem; opacity: 0.8; margin-top: 0.5rem;">
            {{ __('model.earnings.commission.net_label') }} {{ number_format($stats['net_earnings']) }} {{ __('model.earnings.tokens') }}
        </div>
    </div>

    
    <div class="chart-container">
        <canvas id="earningsChart"></canvas>
    </div>

    
    <div class="stats-grid">
        <div class="stat-card-large highlight">
            <div class="stat-icon-large"><i class="fas fa-wallet"></i></div>
            <div class="stat-value-large">
                <span>{{ number_format($stats['total_earnings']) }}</span>
                <div class="trend-indicator positive">
                    <i class="fas fa-arrow-up"></i> 12.5%
                </div>
            </div>
            <div class="stat-label-large">{{ __('model.earnings.stats.total_label') }}</div>
        </div>
        <div class="stat-card-large">
            <div class="stat-icon-large"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-value-large">
                <span>{{ number_format($stats['this_month']) }}</span>
                <div class="trend-indicator positive">
                    <i class="fas fa-arrow-up"></i> 8.3%
                </div>
            </div>
            <div class="stat-label-large">{{ __('model.earnings.stats.this_month') }}</div>
        </div>
        <div class="stat-card-large">
            <div class="stat-icon-large"><i class="fas fa-calendar-week"></i></div>
            <div class="stat-value-large">{{ number_format($stats['this_week']) }}</div>
            <div class="stat-label-large">{{ __('model.earnings.stats.this_week') }}</div>
        </div>
        <div class="stat-card-large">
            <div class="stat-icon-large"><i class="fas fa-star"></i></div>
            <div class="stat-value-large">{{ number_format($stats['xp_earned'] ?? 0) }}</div>
            <div class="stat-label-large">{{ __('model.earnings.stats.xp_earned') }}</div>
        </div>
    </div>

    
    <div class="content-grid">
        
        <div class="content-card">
            <h3 class="section-title"> {{ __('model.earnings.breakdown.title') }}</h3>
            <div class="breakdown-item">
                <div class="breakdown-label">
                    <div class="breakdown-icon"><i class="fas fa-gift"></i></div>
                    <span>{{ __('model.earnings.breakdown.tips') }}</span>
                </div>
                <span class="breakdown-amount">{{ number_format($breakdown['tips']) }}</span>
            </div>
            <div class="breakdown-item">
                <div class="breakdown-label">
                    <div class="breakdown-icon"><i class="fas fa-crown"></i></div>
                    <span>{{ __('model.earnings.breakdown.subscriptions') }}</span>
                </div>
                <span class="breakdown-amount">{{ number_format($breakdown['subscriptions']) }}</span>
            </div>
            <div class="breakdown-item">
                <div class="breakdown-label">
                    <div class="breakdown-icon" style="background: linear-gradient(135deg, #ff4757, #ff6b81);"><i class="fas fa-dice"></i></div>
                    <span>{{ __('model.earnings.breakdown.roulette') }}</span>
                </div>
                <span class="breakdown-amount">{{ number_format($breakdown['roulette']) }}</span>
            </div>
            @if($breakdown['other'] > 0)
            <div class="breakdown-item">
                <div class="breakdown-label">
                    <div class="breakdown-icon" style="background: linear-gradient(135deg, #a29bfe, #6c5ce7);"><i class="fas fa-ellipsis-h"></i></div>
                    <span>{{ __('model.earnings.breakdown.other') }}</span>
                </div>
                <span class="breakdown-amount">{{ number_format($breakdown['other']) }}</span>
            </div>
            @endif
        </div>

        
        <div class="content-card">
            <h3 class="section-title"> {{ __('model.earnings.transactions.title') }}</h3>
            <div class="transactions-list">
                @foreach($recentTransactions as $transaction)
                <div class="transaction-item">
                    <div class="transaction-info">
                        <div class="transaction-type">
                            @if($transaction['type'] === 'tip')
                                <i class="fas fa-gift"></i> {{ __('model.earnings.transactions.types.tip') }}
                            @elseif($transaction['type'] === 'subscription')
                                <i class="fas fa-crown"></i> {{ __('model.earnings.transactions.types.subscription') }}
                            @elseif($transaction['type'] === 'roulette')
                                <i class="fas fa-dice"></i> {{ __('model.earnings.transactions.types.roulette') }}
                            @else
                                <i class="fas fa-coins"></i> {{ __('model.earnings.transactions.types.income') }}
                            @endif
                        </div>
                        <div class="transaction-from">{{ __('model.earnings.transactions.from') }} {{ $transaction['from'] }}</div>
                        <div class="transaction-date">{{ $transaction['date']->diffForHumans() }}</div>
                    </div>
                    <div class="transaction-amount">+{{ number_format($transaction['amount']) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get real data from backend
    const dailyEarnings = @json($dailyEarnings);
    const labels = dailyEarnings.map(d => d.date);
    const data = dailyEarnings.map(d => d.amount);

    // Initialize Earnings Chart
    const ctx = document.getElementById('earningsChart').getContext('2d');
    const earningsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "{{ __('model.earnings.charts.daily_label') }}",
                data: data,
                borderColor: '#d4af37',
                backgroundColor: 'rgba(212, 175, 55, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#d4af37',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#fff',
                        font: {
                            size: 14,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(31, 31, 35, 0.95)',
                    titleColor: '#d4af37',
                    bodyColor: '#fff',
                    borderColor: '#d4af37',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + " {{ __('model.earnings.tokens') }}";
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        callback: function(value) {
                            return value + ' Tk';
                        }
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    });

    // Initialize Date Range Picker
    flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                console.log('Date range selected:', dateStr);
                // TODO: Fetch filtered data from backend
                updateChartData(selectedDates);
            }
        }
    });

    // Filter Button Handlers
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const range = this.dataset.range;
            console.log('Filter selected:', range);
            
            // Update chart based on selected range
            updateChartByRange(range);
        });
    });

    function updateChartByRange(range) {
        let labels, data;
        
        switch(range) {
            case 'today':
                labels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'];
                data = [10, 25, 40, 65, 80, 95, 120];
                break;
            case 'week':
                labels = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
                data = [120, 190, 150, 220, 180, 240, 200];
                break;
            case 'month':
                labels = ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'];
                data = [450, 520, 480, 600];
                break;
            case 'last_month':
                labels = ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'];
                data = [380, 420, 390, 480];
                break;
        }
        
        earningsChart.data.labels = labels;
        earningsChart.data.datasets[0].data = data;
        earningsChart.update();
    }

    function updateChartData(dateRange) {
        // Placeholder for backend integration
        console.log('Updating chart for custom date range:', dateRange);
    }
});

// CSV Export Function
function exportToCSV() {
    window.location.href = "{{ route('model.export.csv') }}";
}
</script>
@endsection
