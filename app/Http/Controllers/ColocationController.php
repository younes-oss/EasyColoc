<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    // Afficher le formulaire
    public function create()
    {
        return view('colocations.create');
    }

    // Enregistrer la colocation
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Vérifier s'il a déjà une colocation active
        $activeColocation = $user->colocations()
            ->wherePivot('left_at', null)
            ->first();

        if ($activeColocation) {
            return back()->withErrors([
                'name' => 'Vous avez déjà une colocation active.'
            ]);
        }

        // Créer la colocation
        $colocation = Colocation::create([
            'name' => $request->name,
            'status' => 'active',
        ]);

        // Ajouter l'utilisateur comme owner dans le pivot
        $colocation->users()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect('/dashboard')->with('success', 'Colocation créée avec succès.');
    }
}