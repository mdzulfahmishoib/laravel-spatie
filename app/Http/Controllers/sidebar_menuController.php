<?php

namespace App\Http\Controllers;

use App\Models\sidebar_menu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class sidebar_menuController extends Controller implements HasMiddleware
{
    public static function middleware(): array 
    {
        return [
            new Middleware('permission:view_sidebar_menu', only: ['index']),
            new Middleware('permission:create_sidebar_menu', only: ['store']),
            new Middleware('permission:update_sidebar_menu', only: ['update']),
            new Middleware('permission:delete_sidebar_menu', only: ['destroy']),
        ];
    }

    public function index()
    {
        $menus = sidebar_menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return view('layouts.sidebar_menu', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:sidebar_menu,id',
            'order' => 'nullable|integer',
            'permission_name' => 'nullable|string|max:255',
            'is_header' => 'nullable|boolean',
            'header_text' => 'nullable|string|max:255',
        ]);

        $validated['is_header'] = $request->has('is_header'); // checkbox

        sidebar_menu::create($validated);

        return redirect()->route('sidebar_menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $menu = sidebar_menu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'icon' => 'nullable|string',
            'route_name' => 'nullable|string',
            'url' => 'nullable|string',
            'parent_id' => 'nullable|exists:sidebar_menu,id',
            'order' => 'nullable|integer',
            'permission_name' => 'nullable|string',
            'is_header' => 'nullable|boolean',
            'header_text' => 'nullable|string',
        ]);

        $validated['is_header'] = $request->has('is_header');
        $menu->update($validated);

        return back()->with('success', 'Menu berhasil diperbarui.');
    }

    protected function normalizeOrder($parentId = null)
    {
        $items = sidebar_menu::where('parent_id', $parentId)
            ->orderBy('order')
            ->get();

        foreach ($items as $index => $item) {
            $item->order = $index + 1;
            $item->save();
        }
    }



    public function reorder(Request $request)
    {
        $menu = sidebar_menu::findOrFail($request->id);
        $direction = $request->direction;

        // Ambil semua menu yang berada dalam parent yang sama (sibling)
        $menus = sidebar_menu::where('parent_id', $menu->parent_id)
            ->orderBy('order')
            ->get();

        $currentIndex = $menus->search(fn($m) => $m->id === $menu->id);
        $swapIndex = $direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;

        if ($swapIndex < 0 || $swapIndex >= $menus->count()) {
            return back();
        }

        $swapMenu = $menus[$swapIndex];

        // Tukar order
        [$menu->order, $swapMenu->order] = [$swapMenu->order, $menu->order];
        $menu->save();
        $swapMenu->save();

        // Normalisasi semua parent menu (parent_id NULL)
        $this->normalizeOrder(null);

        // Normalisasi semua child di setiap parent
        $allParents = sidebar_menu::whereNull('parent_id')->get();
        foreach ($allParents as $parent) {
            $this->normalizeOrder($parent->id);
        }

        return back();
    }


    public function destroy($id)
    {
        $menu = sidebar_menu::findOrFail($id);
        $menu->delete();

        return back()->with('success', 'Menu berhasil dihapus.');
    }

}



