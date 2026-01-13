@php
    $types = [
        'success' => 'Sucesso',
        'error'   => 'Erro',
        'info'    => 'Informação',
        'warning' => 'Atenção',
    ];
@endphp
@if(!session()->hasAny(array_keys($types)))
    @php
        return;
    @endphp
@endif

@foreach ($types as $type => $label)
    @if (session()->has($type))
        <div
            class="flash-message message-box {{ $type }}"
            id="message-box-{{ $type }}-{{ uniqid() }}"
            style="margin-bottom: 30px; animation: slideDown 0.4s ease-out;"
        >
            <p>{{ session($type) }}</p>

            <button
                type="button"
                class="close-btn"
                onclick="closeMessage(this.parentElement)"
                aria-label="Fechar mensagem"
            >
                ✕
            </button>
        </div>
    @endif
@endforeach      

<script>
    function closeMessage(element) {
        if (!element) return;

        element.style.animation = 'slideUp 0.3s ease-out';
        setTimeout(() => {
            if (element.parentNode) {
                element.remove();
            }
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.flash-message').forEach(box => {
            setTimeout(() => closeMessage(box), 5000);
        });
    });
</script>

<style>
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-20px);
    }
}

.message-box {
    position: relative;
    padding: 16px 20px;
    border-radius: 8px;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-size: 14px;
}

.message-box p {
    margin: 0;
    padding-right: 30px;
}

/* Tipos */
.message-box.success {
    border-left: 5px solid #28a745;
}

.message-box.error {
    border-left: 5px solid #dc3545;
}

.message-box.info {
    border-left: 5px solid #0dcaf0;
}

.message-box.warning {
    border-left: 5px solid #ffc107;
}

/* Botão fechar */
.close-btn {
    position: absolute;
    top: 10px;
    right: 12px;
    background: transparent;
    border: none;
    font-size: 16px;
    cursor: pointer;
    color: #555;
}

.close-btn:hover {
    color: #000;
}
</style>
