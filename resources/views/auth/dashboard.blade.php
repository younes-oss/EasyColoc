<!-- resources/views/dashboard.blade.php -->
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
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Mes Colocations</div>
                <div class="stat-value">{{ Auth::user()->colocations->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Mes Dépenses</div>
                <div class="stat-value">{{ Auth::user()->expenses->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Paiements envoyés</div>
                <div class="stat-value">{{ Auth::user()->paymentsSent->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Paiements reçus</div>
                <div class="stat-value">{{ Auth::user()->paymentsReceived->count() }}</div>
            </div>
        </div>
        
        <h2>Mes Actions</h2>
        <div class="actions">
            <div class="action-btn">
                <div class="action-icon">🏠</div>
                <div class="action-text">Mes Colocations</div>
            </div>
            <div class="action-btn">
                <div class="action-icon">💰</div>
                <div class="action-text">Mes Dépenses</div>
            </div>
            <div class="action-btn">
                <div class="action-icon">💳</div>
                <div class="action-text">Mes Paiements</div>
            </div>
            <div class="action-btn">
                <div class="action-icon">⚙️</div>
                <div class="action-text">Paramètres</div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Se déconnecter</button>
        </form>
    </div>
</body>
</html>