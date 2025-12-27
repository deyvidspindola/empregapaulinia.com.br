<?php

namespace App\View\Composers;

use App\Models\SidebarMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $user = Auth::user();
        
        if (!$user) {
            $view->with('sidebarMenus', collect([]));
            return;
        }

        // Busca os menus que correspondem à role do usuário
        $menus = SidebarMenu::where('role', $user->role)
            ->orderBy('possition')
            ->get();

        $view->with('sidebarMenus', $menus);
    }
}

