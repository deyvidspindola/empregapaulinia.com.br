@props([
  'action'      => null
])
<form action="{{ $action ?? '#' }}" method="POST">
  @csrf
  @method('DELETE')
  <button type="submit">
    <span class="la la-trash"></span>
  </button>
</form>