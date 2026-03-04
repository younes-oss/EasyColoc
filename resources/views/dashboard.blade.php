<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - nomEasyColoc</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .welcome {
            font-size: 1.5rem;
            color: #1e293b;
        }
        
        .user-details {
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .banned-badge {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-left: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            border-left: 4px solid #3b82f6;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #1e293b;
            margin: 10px 0;
        }
        
        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }
        
        .action-btn {
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            border-color: #3b82f6;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
        }
        
        .action-icon {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #3b82f6;
        }
        
        .action-text {
            color: #1e293b;
            font-weight: 500;
        }
        
        .logout-form {
            margin-top: 30px;
            text-align: center;
        }
        
        .logout-btn {
            background: #f87171;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
        }
        
        .logout-btn:hover {
            background: #ef4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="welcome">
                Bienvenue, {{ Auth::user()->name }} 
                @if(Auth::user()->is_banned)
                    <span class="banned-badge">Banni</span>
                @endif
            </div>
            <div class="user-info">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-details">
                    <div>{{ Auth::user()->email }}</div>
                    <div>Réputation: {{ Auth::user()->reputation ?? 0 }}</div>
                </div>
            </div>
        </div>
        
        {{-- Vérifier si l'utilisateur a une colocation active --}}
        @php
            $hasColocation = Auth::user()->hasActiveColocation();
            $activeColocation = $hasColocation ? Auth::user()->getActiveColocation() : null;
        @endphp
        
        @if($hasColocation)
            {{-- 🏠 Utilisateur avec colocation active --}}
            <h2 style="margin-bottom: 20px;">Ma Colocation</h2>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Dépenses totales</div>
                    <div class="stat-value">{{ $activeColocation->expenses->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Balance</div>
                    <div class="stat-value">0 €</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Membres</div>
                    <div class="stat-value">{{ $activeColocation->activeUsers->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Paiements</div>
                    <div class="stat-value">{{ Auth::user()->paymentsSent->count() + Auth::user()->paymentsReceived->count() }}</div>
                </div>
            </div>
            
            <h2>Liste des dépenses</h2>
            <div class="actions">
                <div class="action-btn">
                    <div class="action-icon">💰</div>
                    <div class="action-text">Ajouter une dépense</div>
                </div>
                <div class="action-btn">
                    <div class="action-icon">📊</div>
                    <div class="action-text">Voir toutes les dépenses</div>
                </div>
                <div class="action-btn">
                    <div class="action-icon">💳</div>
                    <div class="action-text">Effectuer un paiement</div>
                </div>
                <div class="action-btn">
                    <div class="action-icon">👥</div>
                    <div class="action-text">Gérer les membres</div>
                </div>
                @if(Auth::user()->isOwnerOfActiveColocation())
                    <a href="{{ route('categories.index') }}" class="action-btn" style="border-color: #10b981; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2); text-decoration: none;">
                        <div class="action-icon" style="color: #10b981;">📁</div>
                        <div class="action-text">Gérer les catégories</div>
                    </a>
                @endif
            </div>
        @else
            {{--  Utilisateur sans colocation --}}
            <h2 style="margin-bottom: 20px;">Bienvenue dans votre espace</h2>
            <p style="color: #64748b; margin-bottom: 30px;">Vous n'avez pas encore de colocation. Commencez maintenant !</p>
            
            <div class="actions" style="max-width: 600px; margin: 0 auto;">
                <a href="{{ route('colocations.create') }}" class="action-btn" style="border-color: #00f2ea; box-shadow: 0 2px 8px rgba(0, 242, 234, 0.2); text-decoration: none;">
                    <div class="action-icon" style="color: #00f2ea;">🏠</div>
                    <div class="action-text">Créer une colocation</div>
                </a>
                <a href="{{ route('colocations.join.form') }}" class="action-btn" style="border-color: #a855f7; box-shadow: 0 2px 8px rgba(168, 85, 247, 0.2); text-decoration: none;">
                    <div class="action-icon" style="color: #a855f7;">🔑</div>
                    <div class="action-text">Rejoindre une colocation</div>
                </a>
            </div>
        @endif
        
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Se déconnecter</button>
        </form>
    </div>
</body>
</html>