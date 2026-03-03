<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
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
            'invite_code' => Str::random(8),
        ]);

        // Ajouter l'utilisateur comme owner dans le pivot
        $colocation->users()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect('/dashboard')->with('success', 'Colocation créée avec succès.');
    }

    // Formulaire rejoindre
    public function joinForm()
    {
        return view('colocations.join');
    }

    // Traiter la demande
    public function join(Request $request)
    {
        $request->validate([
            'invite_code' => 'required|string'
        ]);

        $user = auth()->user();

        // Vérifier colocation active
        $activeColocation = $user->colocations()
            ->wherePivotNull('left_at')
            ->first();

        if ($activeColocation) {
            return back()->withErrors([
                'invite_code' => 'Vous avez déjà une colocation active.'
            ]);
        }

        $colocation = Colocation::where('invite_code', $request->invite_code)
            ->where('status', 'active')
            ->first();

        if (!$colocation) {
            return back()->withErrors([
                'invite_code' => 'Code invalide.'
            ]);
        }

        // Ajouter dans pivot
        $colocation->users()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return redirect('/dashboard')->with('success', 'Vous avez rejoint la colocation.');
    }
}
