@php
    // Redireccionar automáticamente según el rol del usuario
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->role === 'fan') {
            header('Location: ' . route('fan.dashboard'));
            exit;
        } elseif ($user->role === 'model') {
            header('Location: ' . route('model.dashboard'));
            exit;
        } elseif ($user->role === 'admin') {
            header('Location: ' . route('admin.dashboard'));
            exit;
        }
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold mb-4">{{ __('dashboard.welcome') }}</h3>
                        <p class="mb-6">{{ __('dashboard.status') }}</p>

                        <div class="space-y-2">
                            @if(auth()->user()->role === 'fan')
                                <a href="{{ route('fan.dashboard') }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-tachometer-alt"></i> {{ __('dashboard.fan_dashboard') }}
                                </a>
                            @elseif(auth()->user()->role === 'model')
                                <a href="{{ route('model.dashboard') }}"
                                    class="inline-block bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-video"></i> {{ __('dashboard.model_dashboard') }}
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-crown"></i> {{ __('dashboard.admin_panel') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Redirección automática después de 2 segundos
        setTimeout(function () {
            @if(auth()->user()->role === 'fan')
                window.location.href = '{{ route('fan.dashboard') }}';
            @elseif(auth()->user()->role === 'model')
                window.location.href = '{{ route('model.dashboard') }}';
            @elseif(auth()->user()->role === 'admin')
                window.location.href = '{{ route('admin.dashboard') }}';
            @endif
        }, 2000);
    </script>
</x-app-layout>