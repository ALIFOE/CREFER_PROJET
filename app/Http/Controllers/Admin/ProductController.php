<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'categorie' => 'required|string',
            'image' => 'required|image|max:2048',
            'en_stock' => 'required|boolean',
            'specifications' => 'nullable|array',
            'specifications.*' => 'string'
        ]);

        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $path = $file->store('images/products', 'public');
                
                if (!$path) {
                    return back()->withErrors(['image' => 'Impossible de sauvegarder l\'image. Vérifiez les permissions du dossier storage.']);
                }

                // S'assurer que le dossier existe
                $storage_path = storage_path('app/public/images/products');
                if (!file_exists($storage_path)) {
                    mkdir($storage_path, 0755, true);
                }

                // Vérifier que le fichier a bien été créé
                if (!Storage::disk('public')->exists($path)) {
                    return back()->withErrors(['image' => 'L\'image n\'a pas pu être sauvegardée correctement.']);
                }

                $validatedData['image'] = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Erreur lors de la sauvegarde de l\'image: ' . $e->getMessage()]);
            }
        }

        $product = Product::create($validatedData);
        
        // Vérification que l'image est accessible
        if ($product->image && !Storage::disk('public')->exists($product->image)) {
            return back()->withErrors(['image' => 'L\'image a été uploadée mais n\'est pas accessible. Vérifiez les permissions.']);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'categorie' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'en_stock' => 'required|boolean',
            'specifications' => 'nullable|array',
            'specifications.*' => 'string'
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('images/products', 'public');
            if (!$path || !Storage::disk('public')->exists($path)) {
                return back()->withErrors(['image' => 'L\'image n\'a pas pu être sauvegardée correctement.']);
            }
            $validatedData['image'] = $path;
        }

        $product->update($validatedData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        // Supprimer l'image si elle existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    public function show(Product $product)
    {
        $product->load(['orders.user']);
        return view('admin.products.show', compact('product'));
    }
}