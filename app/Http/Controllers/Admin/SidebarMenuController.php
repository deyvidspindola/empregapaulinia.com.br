<?php

namespace App\Http\Controllers\Admin;

use App\Models\SidebarMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SidebarMenuController extends Controller
{
    
    public function __construct(
        protected SidebarMenu $sidebarMenu
    ) {}

    public function index()
    {
        $menus = $this->sidebarMenu->paginate(5);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $formConfig = [
            'method' => 'POST',
            'action' => route('admin.menus.store'),
        ];
        return view('admin.menus.form', compact('formConfig'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'active' => $request->has('active') ? true : false,
        ]);

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'role' => 'required|string|max:255',
            'position' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        $validated['active'] = $request->has('active') ? true : false;

        $this->sidebarMenu->create($validated);
        return redirect()->route('admin.menus.index')->with('success', 'Menu criado com sucesso.');
    }

    public function edit(SidebarMenu $menu)
    {
        $formConfig = [
            'method' => 'PUT',
            'action' => route('admin.menus.update', $menu),
        ];        
        return view('admin.menus.form', compact('menu', 'formConfig'));
    }

    public function update(Request $request, SidebarMenu $menu)
    {            
        // Se for requisição AJAX (atualização do status)
        if ($request->ajax() || $request->wantsJson()) {
            $validated = $request->validate([
                'active' => 'required|boolean',
            ]);
            
            $menu->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Status do menu atualizado com sucesso.'
            ]);
        }
        
        $request->merge([
            'active' => $request->has('active') ? true : false,
        ]);

        // Atualização completa do menu
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'role' => 'required|string|max:255',
            'position' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);
        
        $menu->update($validated);
        return redirect()->route('admin.menus.index')->with('success', 'Menu atualizado com sucesso.');
    }
}
