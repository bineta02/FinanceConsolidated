@extends('layouts.bailleur')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Garanties & Contrats</h3>
        <p class="text-muted small mb-0">Gestion des documents juridiques, garanties et contrats de prêt d'honneur.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-3">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if($financements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Projet / Entrepreneur</th>
                                <th>Montant du prêt</th>
                                <th>Durée & Taux</th>
                                <th>Date de signature</th>
                                <th>Statut du contrat</th>
                                <th class="text-end pe-4">Document / Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financements as $financement)
                                @php
                                    $contrat = $financement->contrat;
                                    $entrepreneur = $financement->projet->entrepreneur ?? $financement->projet->utilisateur ?? null;
                                    $nomEntrepreneur = $entrepreneur 
                                        ? trim(($entrepreneur->prenom ?? '') . ' ' . ($entrepreneur->nom ?? '')) 
                                        : 'Entrepreneur';
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <strong class="d-block text-dark">{{ $financement->projet->titre ?? 'Projet' }}</strong>
                                        <small class="text-muted"><i class="fas fa-user me-1"></i> {{ $nomEntrepreneur }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ number_format($financement->montant_accorde, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td>{{ $financement->duree }} mois ({{ $financement->taux_interet }}%)</td>
                                    <td>
                                        {{ $contrat && $contrat->date_signature ? \Carbon\Carbon::parse($contrat->date_signature)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $contrat ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3">
                                            {{ $contrat->statut ?? 'En attente de contrat' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        {{-- Boutons Voir et Télécharger si un contrat existe --}}
                                        @if($contrat && !empty($contrat->fichier_url))
                                            <div class="btn-group me-2" role="group">
                                                <a href="{{ asset('storage/' . $contrat->fichier_url) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Visualiser dans le navigateur">
                                                    <i class="fas fa-eye me-1"></i> Voir
                                                </a>
                                                <a href="{{ asset('storage/' . $contrat->fichier_url) }}" download="Contrat_Financement_{{ $financement->id }}.pdf" class="btn btn-sm btn-success" title="Télécharger le fichier PDF">
                                                    <i class="fas fa-download me-1"></i> Télécharger
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Bouton Déclencheur Modal Upload -->
                                        <button type="button" class="btn btn-sm btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalContrat{{ $financement->id }}">
                                            <i class="fas fa-upload me-1"></i> {{ $contrat ? 'Remplacer' : 'Ajouter' }}
                                        </button>

                                        <!-- Modal Upload pour chaque financement -->
                                        <div class="modal fade text-start" id="modalContrat{{ $financement->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content rounded-4 border-0">
                                                    <form action="{{ route('bailleur.contrats.upload', $financement->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header border-0 pb-0">
                                                            <h5 class="modal-title fw-bold">Ajouter un Contrat PDF</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-muted small mb-3">Projet : <strong>{{ $financement->projet->titre ?? 'Projet' }}</strong></p>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Date de signature</label>
                                                                <input type="date" name="date_signature" class="form-control" value="{{ $contrat->date_signature ?? date('Y-m-d') }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Fichier du contrat (PDF/DOC)</label>
                                                                <input type="file" name="fichier_contrat" class="form-control" accept=".pdf,.doc,.docx" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-success rounded-3">Enregistrer le contrat</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-file-contract fa-3x mb-3 text-secondary d-block"></i>
                    <h5 class="fw-bold">Aucun contrat actif</h5>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection