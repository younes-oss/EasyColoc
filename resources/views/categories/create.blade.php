@extends('layouts.app')

@section('content')
<div class="container">
    <div class="header">
        <h1>Nouvelle catégorie</h1>
        <a href="{{ route('categories.index') }}" class="btn-back">← Retour</a>
    </div>

    <div class="card">
        <h2>Créer une catégorie</h2>
        
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">Nom de la catégorie</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}" 
                       placeholder="Ex: Loyer, Électricité, Eau, Internet..." 
                       required
                       class="form-control">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Créer la catégorie</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<style>
    .container {
        max-width: 700px;
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

    .card {
        background: white;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
        color: #1e293b;
        font-size: 1.4rem;
        margin: 0 0 20px 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        color: #475569;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        padding: 8px 12px;
        border-radius: 4px;
        margin-top: 8px;
        font-size: 0.9rem;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        border: none;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
    }
</style>
@endsection
