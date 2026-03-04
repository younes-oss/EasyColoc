@extends('layouts.app')

@section('content')
<div class="container">
    <div class="header">
        <h1>Gérer les catégories</h1>
        <a href="{{ route('dashboard') }}" class="btn-back">← Retour au dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Formulaire d'ajout rapide (seulement pour owner) --}}
    @if($isOwner)
        <div class="card">
            <h2>Ajouter une nouvelle catégorie</h2>
            <form action="{{ route('categories.store') }}" method="POST" class="form-inline">
                @csrf
                <input type="text" name="name" placeholder="Nom de la catégorie" 
                       value="{{ old('name') }}" required class="form-control">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    @endif

    {{-- Liste des catégories --}}
    <div class="card">
        <h2>Liste des catégories</h2>
        
        @if($categories->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date de création</th>
                        @if($isOwner)
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at->format('d/m/Y') }}</td>
                            @if($isOwner)
                                <td>
                                    <form action="{{ route('categories.destroy', $category->id) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            🗑️ Supprimer
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty-message">Aucune catégorie pour le moment.</p>
        @endif
    </div>
</div>

<style>
    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header h1 {
        color: #1e293b;
        font-size: 1.8rem;
        margin: 0;
    }

    .btn-back {
        color: #64748b;
        text-decoration: none;
        padding: 8px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        padding: 8px 12px;
        border-radius: 4px;
        margin-top: 8px;
        font-size: 0.9rem;
    }

    .card {
        background: white;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card h2 {
        color: #1e293b;
        font-size: 1.4rem;
        margin: 0 0 20px 0;
    }

    .form-inline {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .form-control {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        border: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        padding: 6px 12px;
        font-size: 0.9rem;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-sm {
        font-size: 0.875rem;
        padding: 6px 12px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background: #f8fafc;
    }

    .table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }

    .table td {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b;
    }

    .table tr:hover {
        background: #f8fafc;
    }

    .empty-message {
        color: #64748b;
        text-align: center;
        padding: 40px;
        font-style: italic;
    }
</style>
@endsection
