<form method="POST" action="{{ route('logout') }}">
    @csrf
    <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
        @if(isset($icon))
            <i class="la {{ $icon }}"></i>
        @endif
        {{ __('Log Out') }}
    </a>
</form>