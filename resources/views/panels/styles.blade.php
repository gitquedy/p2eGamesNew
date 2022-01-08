<!-- BEGIN: Vendor CSS-->
@if ($configData['direction'] === 'rtl' && isset($configData['direction']))
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors-rtl.min.css')) }}" />
@else
  <link rel="stylesheet" href="vendors/css/vendors.min.css"/>
@endif

<!-- Global Page Css -->
<link rel="stylesheet" href="{{ asset('vendors/css/animate/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/sweetalert2.min.css') }}">
<!-- Global Page Css -->
@yield('vendor-style')
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" href="css/core.css" />
<link rel="stylesheet" href="css/base/themes/dark-layout.css" />
<link rel="stylesheet" href="css/base/themes/bordered-layout.css" />
<link rel="stylesheet" href="css/base/themes/semi-dark-layout.css" />

@php $configData = Helper::applClasses(); @endphp

<!-- BEGIN: Page CSS-->
@if ($configData['mainLayoutType'] === 'horizontal')
  <link rel="stylesheet" href="css/base/core/menu/menu-types/horizontal-menu.css" />
@else
  <link rel="stylesheet" href="css/base/core/menu/menu-types/vertical-menu.css" />
@endif

{{-- Page Styles --}}
@yield('page-style')

<!-- laravel style -->
<link rel="stylesheet" href="css/overrides.css" />

<!-- BEGIN: Custom CSS-->

@if ($configData['direction'] === 'rtl' && isset($configData['direction']))
  <link rel="stylesheet" href="css-rtl/custom-rtl.css" />
  <link rel="stylesheet" href="css-rtl/style-rtl.css" />

@else
  {{-- user custom styles --}}
  <link rel="stylesheet" href="css/style.css" />
@endif
