@inject('request', 'Illuminate\Http\Request')
@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp

<html class="loading {{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme']}}"
lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
@if($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Play to earn games">
  <meta name="keywords" content="play to earn, nft, games, games for earning">
  <meta name="author" content="P2EGames">
  <meta name="og:image" content="@yield('og-image')">
  <meta name="og:image:width" content="600">
  <meta name="og:image:height" content="315">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title> P2E Games PH - @yield('title')</title>
  <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  {{-- Include core + vendor Styles --}}
  @include('panels/styles')
  <style>
      .brand-logo {
          position: absolute;
          top: 2rem;
          z-index: 1;
      }
  </style>
  @yield('style')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body style="background-color: #f8f8f8;">
<div id="app" class="h-100">
    <div class="container-fluid  h-100">
      <a href="{{ route('home.index') }}">
        <span class="brand-logo p-1 bg-dark rounded">
          <!-- Image logo code -->
          <img src="{{ asset('images/logo/logo.png') }}" class="img-fluid" alt="Brand logo">
          <!--/ Image logo code -->
        </span>
      </a>
      <div class="row h-100 justify-content-center">
          <div class="d-none d-lg-flex align-items-center p-5 col-lg-8">
              <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                  <img src="{{asset('images/login/login.svg')}}" alt="Login" class="img-fluid">
              </div>
          </div>
          @yield('content')
      </div>
    </div>
</div>
@include('panels/scripts')
</body>