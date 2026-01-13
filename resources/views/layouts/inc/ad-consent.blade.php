<div id="ad-consent-banner" style="
  position:fixed;left:16px;right:16px;bottom:16px;z-index:9999;
  background:#111827;color:#fff;border-radius:10px;padding:14px 16px;
  box-shadow:0 10px 30px rgba(0,0,0,.25);display:none;align-items:center;gap:12px;">
  <div style="flex:1;line-height:1.4">
    Usamos publicidade para manter o serviço gratuito. Você aceita ver anúncios?
    <a href="{{ route('polices') }}" target="_blank" style="color:#93c5fd">Saiba mais</a>.
  </div>
  <button id="ad-consent-accept" class="button ripple-effect" style="margin:0">Aceitar</button>
  <button id="ad-consent-decline" class="button gray ripple-effect" style="margin:0">Recusar</button>
</div>

@push('scripts')
<script>
(function(){
  const KEY = 'adConsent';
  const $b = document.getElementById('ad-consent-banner');
  const show = () => { if ($b) $b.style.display = 'flex'; };
  const hide = () => { if ($b) $b.remove(); };

  // Mostra se ainda não aceitou explicitamente
  const val = (localStorage.getItem(KEY) || '').toLowerCase();
  if (val !== 'true') show();

  // Aceitar
  document.getElementById('ad-consent-accept')?.addEventListener('click', function(){
    try { localStorage.setItem(KEY, 'true'); } catch(e){}
    window.dispatchEvent(new Event('adConsentAccepted'));
    hide();
  });

  // Recusar
  document.getElementById('ad-consent-decline')?.addEventListener('click', function(){
    try { localStorage.setItem(KEY, 'false'); } catch(e){}
    hide();
  });
})();
</script>
@endpush
