<div class="user-sidebar">
    <div class="sidebar-inner">
        <ul class="navigation">

            @foreach($sidebarMenus as $menu)
                <x-layouts.partails.sidebar-link
                    :route="$menu->route"
                    :icon="$menu->icon"
                    :label="$menu->label"
                />
            @endforeach

            <x-layouts.partails.sidebar-link
                route="alterar_senha"
                icon="la-lock"
                label="Alterar Senha"
            />

            <li><x-ui.logout icon="la-sign-out"/></li>

        </ul>
    </div>
</div>