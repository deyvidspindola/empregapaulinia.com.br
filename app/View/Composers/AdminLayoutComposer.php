<?php

namespace App\View\Composers;

use Illuminate\View\View;

class AdminLayoutComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Recupera title e subtitle passados pelo componente
        $title = $view->getData()['title'] ?? 'Dashboard';
        $subtitle = $view->getData()['subtitle'] ?? 'Painel Administrativo';

        $view->with([
            'title' => $title,
            'subtitle' => $subtitle,
        ]);
    }
}
