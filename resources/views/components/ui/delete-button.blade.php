@props([
  'action' => null
])
<form action="{{ $action ?? '#' }}" method="POST">
  @csrf
  @method('DELETE')
  <button type="submit">
    <span class="la la-trash"></span>
  </button>
</form>

{{-- Preciso inserir um alerta de confirmação antes de deletar o item. --}}
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('form[action="{{ $action ?? '#' }}"]');
    deleteForms.forEach(function (form) {
      form.addEventListener('submit', function (event) {
        event.preventDefault();
        if (confirm('Tem certeza que deseja deletar este item? Esta ação não pode ser desfeita.')) {
          form.submit();
        }
      });
    });
  });
</script>
@endpush
