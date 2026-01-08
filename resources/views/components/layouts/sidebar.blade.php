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

            <li><x-ui.logout icon="la-sign-out"/></li>

        </ul>
    </div>
</div>