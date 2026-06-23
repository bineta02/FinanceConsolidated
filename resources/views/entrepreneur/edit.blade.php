@extends('layouts.entrepreneur')

@section('content')
<h3 class="fw-bold mb-4"><i class="fas fa-user-edit text-success"></i> Modifier mon profil Entrepreneur</h3>

<div class="card-modern p-4">
    <form action="{{ route('entrepreneur.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Secteur d'activité *</label>
            <input type="text" name="secteur_dactivite" class="form-control" value="{{ old('secteur_dactivite', $entrepreneur->secteur_dactivite) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Années d'expérience *</label>
            <input type="number" name="annees_experiences" class="form-control" value="{{ old('annees_experiences', $entrepreneur->annees_experiences) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description du profil *</label>
            <textarea name="description_profil" class="form-control" rows="4" required>{{ old('description_profil', $entrepreneur->description_profil) }}</textarea>
        </div>

        <button type="submit" class="btn btn-green w-100"><i class="fas fa-check me-2"></i> Enregistrer les modifications</button>
    </form>
</div>
@endsection