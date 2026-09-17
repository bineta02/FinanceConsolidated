@extends('layouts.entrepreneur')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Contrats & Garanties</h3>
        <p class="text-muted small mb-0">Consultez, téléchargez et signez vos contrats de financement.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-3">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h5 class="card-title mb-0 fw-bold text-dark">Vos documents officiels</h5>
        </div>
        
        <div class="card-body p-0">
            @if(isset($financements) && $financements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Projet</th>
                                <th>Bailleur</th>
                                <th>Montant Accordé</th>
                                <th>Statut du contrat</th>
                                <th>Date de signature</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financements as $financement)
                                @php
                                    $contrat = $financement->contrat;
                                    $bailleur = $financement->bailleur;
                                    
                                    // Récupération de l'utilisateur rattaché au profil bailleur
                                    $userBailleur = $bailleur->utilisateur ?? $bailleur->user ?? null;

                                    if ($userBailleur) {
                                        $nomBailleur = trim(($userBailleur->prenom ?? '') . ' ' . ($userBailleur->nom ?? ''));
                                    } elseif ($bailleur) {
                                        $nomBailleur = trim(($bailleur->prenom ?? '') . ' ' . ($bailleur->nom ?? ''));
                                    } else {
                                        $nomBailleur = 'Bailleur';
                                    }

                                    if (empty(trim($nomBailleur))) {
                                        $nomBailleur = 'Bailleur';
                                    }
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <strong class="d-block text-dark">{{ $financement->projet->titre ?? 'Mon Projet' }}</strong>
                                        <small class="text-muted">{{ $financement->duree }} mois ({{ $financement->taux_interet }}%)</small>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-secondary">
                                            <i class="fas fa-user-tie me-1"></i> {{ $nomBailleur }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ number_format($financement->montant_accorde, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td>
                                        @if(!$contrat)
                                            <span class="badge bg-secondary rounded-pill px-3">Non généré</span>
                                        @elseif(in_array(strtolower($contrat->statut), ['signe', 'signé', 'valide', 'actif']))
                                            <span class="badge bg-success rounded-pill px-3">
                                                <i class="fas fa-check-circle me-1"></i> Signé
                                            </span>
                                        @elseif(in_array(strtolower($contrat->statut), ['a_signer', 'en_attente', 'en attente de signature', 'à signé']))
                                            <span class="badge bg-warning text-dark rounded-pill px-3">
                                                <i class="fas fa-clock me-1"></i> À signer
                                            </span>
                                        @else
                                            <span class="badge bg-info text-dark rounded-pill px-3">{{ $contrat->statut }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $contrat && $contrat->date_signature ? \Carbon\Carbon::parse($contrat->date_signature)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        {{-- BOUTON : Accès au plan d'échéances --}}
                                        <a href="{{ route('entrepreneur.echeances', ['financement_id' => $financement->id]) }}" class="btn btn-sm btn-outline-primary rounded-3 me-1" title="Voir le plan de remboursement">
                                            <i class="fas fa-calendar-alt me-1"></i> Échéances
                                        </a>

                                        @if($contrat && !empty($contrat->fichier_url))
                                            {{-- Bouton pour lire le PDF --}}
                                            <a href="{{ asset('storage/' . $contrat->fichier_url) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 me-1">
                                                <i class="fas fa-eye me-1"></i> Lire
                                            </a>

                                            {{-- Bouton de signature (si non signé) --}}
                                            @if(in_array(strtolower($contrat->statut), ['a_signer', 'en_attente', 'en attente de signature', 'à signé']))
                                                <form action="{{ route('entrepreneur.contrats.signer', $contrat->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success rounded-3" onclick="return confirm('Confirmez-vous la signature de ce contrat ?')">
                                                        <i class="fas fa-signature me-1"></i> Valider & Signer
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Téléchargement du contrat signé --}}
                                                <a href="{{ asset('storage/' . $contrat->fichier_url) }}" download class="btn btn-sm btn-success rounded-3">
                                                    <i class="fas fa-download me-1"></i> Télécharger
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted small ms-1">Aucun document</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-file-signature fa-3x mb-3 text-secondary d-block"></i>
                    <h5 class="fw-bold">Aucun contrat ou garantie</h5>
                    <p class="small mb-0">Dès qu'un bailleur vous transmettra un contrat, il apparaîtra ici pour signature.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection