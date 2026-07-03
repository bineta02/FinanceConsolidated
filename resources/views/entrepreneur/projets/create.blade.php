@extends('layouts.entrepreneur')

@section('content')
<h3 class="fw-bold mb-4"><i class="fas fa-plus-circle text-success"></i> Déposer un nouveau projet</h3>

<div class="card-modern p-4">
    <form action="{{ route('entrepreneur.projet.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom du projet *</label>
            <input type="text" name="titre" class="form-control" placeholder="ex: Eco-Transport Dakar" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description détaillée *</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Décrivez votre projet, son impact..." required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Montant recherché (FCFA) *</label>
            <input type="number" name="montant_demande" class="form-control" placeholder="ex: 5000000" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="categorie" class="form-select">
                <option value="Agriculture">Agriculture</option>
                <option value="Tech">Tech</option>
                <option value="Artisanat">Artisanat</option>
                <option value="Énergie">Énergie</option>
            </select>
        </div>

        <button type="submit" class="btn btn-green w-100"><i class="fas fa-save me-2"></i> Soumettre mon projet</button>
    </form>
</div>
@endsection