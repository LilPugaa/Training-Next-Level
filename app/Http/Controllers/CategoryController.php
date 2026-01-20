<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::with('prerequisites');

        // Fitur search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($queryKategori) use ($search) {
                $queryKategori->where('name', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->statusKategori === 'prerequisite') {
            $query->whereHas('prerequisites');
        }

        if ($request->statusKategori === 'non-prerequisite') {
            $query->whereDoesntHave('prerequisites');
        }
        
        $categories = $query->get();

        $allCategories = Category::all();

        // $categories = Category::with('prerequisites')->get();

        // Menghitung jumlah kategori
        $kategoriPelatihanCounts = [
            'totalKategori' => Category::count(),
            'denganPrerequisite' => Category::has('prerequisites')->count(),
            'tanpaPrerequisite' => Category::doesntHave('prerequisites')->count()
        ];

        return view('coordinator.kategori-pelatihan', compact('categories','kategoriPelatihanCounts', 'allCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'prerequisites' => 'nullable|array',
            'prerequisites.*' => 'exists:categories,id'
        ]);

        // Simpan kategori
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Simpan prerequisite (jika ada)
        if ($request->filled('prerequisites')) {
            $category->prerequisites()->sync($request->prerequisites);
        }

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'prerequisites' => 'nullable|array',
            'prerequisites.*' => 'exists:categories,id'
        ]);

        // Update kategori
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // sync prerequisite
        $category->prerequisites()->sync($request->prerequisites ?? []);

        return redirect()
            ->route('kategori-pelatihan')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
