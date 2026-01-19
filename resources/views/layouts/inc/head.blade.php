<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  @props(['title' => ''])
  <title>{{ config('app.name', 'Emprega Paulínia') }}{{ isset($title) && $title != '' ? ' - ' . $title : '' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">  <!-- Stylesheets -->
  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">

  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

  <!-- Responsive -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
  <!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->

  @include('layouts.inc.ad-consent')

  <!-- Google reCAPTCHA -->
  @if(config('services.recaptcha.site_key'))
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  @endif

  @if(env('APP_ENV') == 'production')
        {{-- AdSense --}}
        @if(setting('ads.network') === 'adsense' && setting('ads.adsense_client'))
            <script async
                src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ setting('ads.adsense_client') }}"
                crossorigin="anonymous"></script>
        @endif

        {{-- GAM --}}
        @if(setting('ads.network') === 'gam')
            <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
        @endif

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-YRDXBN8Z4N"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());

            gtag('config', 'G-YRDXBN8Z4N');
        </script>
    @endif  

</head>