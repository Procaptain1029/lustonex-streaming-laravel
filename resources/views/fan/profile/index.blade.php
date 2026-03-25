@extends('layouts.fan')

@section('title', __('fan.profile.title'))



@section('content')
<style>
.profile-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 2rem;
}

/* Estilos de encabezado heredados del layout fan */

.benefits-section, .settings-section {
    background: rgba(31, 31, 35, 0.95);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.section-title {
    font-family: var(--font-titles);
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--color-oro-sensual);
    margin: 0 0 1.5rem 0;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
}

.benefit-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 12px;
}

.benefit-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--gradient-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #000;
}

.benefit-info {
    display: flex;
    flex-direction: column;
}

.benefit-name {
    font-weight: 600;
    color: white;
}

.benefit-level {
    font-size: 0.85rem;
    color: var(--color-oro-sensual);
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
}

.form-control {
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    color: white;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: var(--color-oro-sensual);
    background: rgba(255, 255, 255, 0.08);
}

.btn-save {
    padding: 1rem 2rem;
    background: var(--gradient-gold);
    color: #000;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    align-self: flex-start;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
}

@media (max-width: 768px) {
    .profile-container {
        padding: 1rem;
    }

    .profile-container {
        padding: 1rem;
    }

    /* Estilos responsivos de encabezado heredados */
}

@media (max-width: 480px) {
    /* Estilos responsivos heredados */
}
</style>
<div class="profile-container">
    
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-circle"></i> {{ __('fan.profile.title') }}
        </h1>
        <p class="page-subtitle">{{ __('fan.profile.subtitle') }}</p>
    </div>

    
    <x-fan-xp-panel 
        :userProgress="$userProgress"
        :currentLevel="$currentLevel"
        :nextLevel="$nextLevel"
        :xpPercentage="$xpPercentage"
        :currentXP="$currentXP"
        :requiredXP="$requiredXP"
    />

    
    <x-fan-profile-stats 
        :gamificationStats="$gamificationStats"
        :generalStats="$generalStats"
    />

    
    @if(count($unlockedBenefits) > 0)
    <div class="benefits-section">
        <h3 class="section-title"><i class="fas fa-unlock-alt"></i> {{ __('fan.profile.benefits_title') }}</h3>
        <div class="benefits-grid">
            @foreach($unlockedBenefits as $benefit)
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas {{ $benefit['icon'] }}"></i></div>
                <div class="benefit-info">
                    <span class="benefit-name">{{ $benefit['name'] }}</span>
                    <span class="benefit-level">{{ __('fan.missions.unlocks_level', ['level' => $benefit['level']]) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    
</div>
@endsection

@section('scripts')
<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("fan.profile.update") }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('{{ __('fan.profile.update_success') }}');
            window.location.reload();
        } else {
            alert(data.message || '{{ __('fan.profile.update_error') }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __('fan.profile.unexpected_error') }}');
    });
});
</script>
@endsection
