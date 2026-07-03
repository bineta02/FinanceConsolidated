{{-- 1. On indique à Laravel quel design global utiliser --}}
@extends('layouts.entrepreneur') 

{{-- 2. On ouvre la zone où insérer le contenu spécifique --}}
@section('content')
<div class="container">
    <h2>Financements reçus</h2>
    <p>Bienvenue sur votre espace de suivi des financements. Voici le récapitulatif de vos fonds :</p>
    
    <div class="card">
        <div class="card-body">
            Aucun financement actif pour le moment.
        </div>
    </div>
</div>
@endsection