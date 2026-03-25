@extends('layouts.public')

@section('content')
    <style>
        .legal-page-container {
            padding: 4rem 2rem;
            max-width: 1000px;
            margin: 0 auto;
            font-family: 'Raleway', sans-serif;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.8;
        }

        .legal-header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .legal-title {
            font-size: 2.5rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .legal-breadcrumb {
            color: var(--color-oro-sensual);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
            display: block;
        }

        .legal-content {
            background: rgba(255, 255, 255, 0.02);
            padding: 3rem;
            border-radius: 20px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(10px);
        }

        .legal-content h2 {
            color: #fff;
            font-size: 1.5rem;
            margin: 2rem 0 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .legal-content p {
            margin-bottom: 1.5rem;
        }

        .legal-content ul {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        .legal-content li {
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .legal-page-container {
                padding: 2rem 1rem;
            }
            .legal-content {
                padding: 1.5rem;
            }
            .legal-title {
                font-size: 1.8rem;
            }
        }
    </style>

    <div class="legal-page-container">
        <header class="legal-header">
            @if(isset($breadcrumb))
                <span class="legal-breadcrumb">{{ $breadcrumb }}</span>
            @endif
            <h1 class="legal-title text-gradient-gold">{{ $title }}</h1>
        </header>

        <article class="legal-content">
            {!! $content !!}
        </article>
    </div>
@endsection
