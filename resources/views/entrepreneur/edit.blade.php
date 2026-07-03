@extends('layouts.entrepreneur')

@section('content')
<div class="card-modern p-4" style="max-width: 800px; margin: 0 auto;">
    <h3 class="fw-bold text-dark mb-4">
        <i class="fas fa-user-edit text-success me-2"></i>Modifier mon profil professionnel
    </h3>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('entrepreneur.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Secteur d'activité</label>
                <input type="text" name="secteur_dactivite" class="form-control @error('secteur_dactivite') is-invalid @enderror" 
                       value="{{ old('secteur_dactivite', $entrepreneur->secteur_dactivite) }}" placeholder="Ex: Agriculture, Tech, Artisanat...">
                @error('secteur_dactivite')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Années d'expérience</label>
                <input type="number" name="annees_experiences" class="form-control @error('annees_experiences') is-invalid @enderror" 
                       value="{{ old('annees_experiences', $entrepreneur->annees_experiences) }}" min="0">
                @error('annees_experiences')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Présentation ou description du profil</label>
                <textarea name="description_profil" class="form-control @error('description_profil') is-invalid @enderror" rows="5" placeholder="Décrivez brièvement votre parcours et l'activité de votre structure...">{{ old('description_profil', $entrepreneur->description_profil) }}</textarea>
                @error('description_profil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('dashboard') }}" class="btn btn-light rounded-4 me-2">Annuler</a>
            <button type="submit" class="btn btn-success rounded-4 px-4">Sauvegarder les modifications</button>
        </div>
    </form>
</div>
@endsection