<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $colocation = $user->colocations()
            ->wherePivotNull('left_at')
            ->first();

        if (!$colocation) {
            return redirect('/dashboard');
        }

        // Vérifier si user est owner
        $membership = $colocation->users()
            ->where('user_id', $user->id)
            ->first()
            ->pivot;

        $isOwner = $membership->role === 'owner';

        $categories = $colocation->categories;

        return view('categories.index', compact('categories', 'isOwner'));
    }

    public function create()
    {
        return view('categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $colocation = $user->colocations()
            ->wherePivotNull('left_at')
            ->first();

        // Débogage temporaire
        if (!$colocation) {
            return redirect()->back()
                ->with('error', 'Aucune colocation active trouvée.');
        }

        // Vérifier si user est owner
        $membership = $colocation->users()
            ->where('user_id', $user->id)
            ->first()
            ->pivot;

        if ($membership->role !== 'owner') {
            abort(403, 'Seul le propriétaire peut créer une catégorie.');
        }

        Category::create([
            'name' => $request->name,
            'colocation_id' => $colocation->id,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Catégorie supprimée.');
    }
}
