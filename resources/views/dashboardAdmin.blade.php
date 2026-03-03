<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - nomEasyColoc</title>
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
            background: linear-gradient(45deg, #00f2ea, #a855f7);
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
        
        .admin-badge {
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-left: 10px;
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
            border-left: 4px solid #00f2ea;
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
            border-color: #00f2ea;
            box-shadow: 0 2px 8px rgba(0, 242, 234, 0.2);
        }
        
        .action-icon {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #00f2ea;
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
                @if(Auth::user()->is_admin)
                    <span class="admin-badge">Administrateur</span>
                @endif
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
        
        <div class="stats-grid">
            {{-- 👑 Statistiques globales pour Admin --}}
            <div class="stat-card" style="border-left-color: #10b981;">
                <div class="stat-label">Nombre total d'utilisateurs</div>
                <div class="stat-value">{{ \App\Models\User::count() }}</div>
            </div>
            <div class="stat-card" style="border-left-color: #3b82f6;">
                <div class="stat-label">Nombre de colocations</div>
                <div class="stat-value">{{ \App\Models\Colocation::count() }}</div>
            </div>
            <div class="stat-card" style="border-left-color: #ef4444;">
                <div class="stat-label">Utilisateurs bannis</div>
                <div class="stat-value">{{ \App\Models\User::where('is_banned', true)->count() }}</div>
            </div>
            <div class="stat-card" style="border-left-color: #8b5cf6;">
                <div class="stat-label">Total dépenses</div>
                <div class="stat-value">{{ \App\Models\Expense::count() }}</div>
            </div>
        </div>
        
        <h2 style="margin-bottom: 20px;">Administration</h2>
        <div class="actions">
            <div class="action-btn">
                <div class="action-icon">👥</div>
                <div class="action-text">Gérer les utilisateurs</div>
            </div>
            <div class="action-btn">
                <div class="action-icon">🏠</div>
                <div class="action-text">Voir les colocations</div>
            </div>
            <div class="action-btn">
                <div class="action-icon">📊</div>
                <div class="action-text">Statistiques</div>
            </div>
            <div class="action-btn">
                <div class="action-icon">⚙️</div>
                <div class="action-text">Paramètres système</div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Se déconnecter</button>
        </form>
    </div>
</body>
</html>