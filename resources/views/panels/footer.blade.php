<!-- BEGIN: Footer-->
<footer class="footer footer-light {{($configData['footerType'] === 'footer-hidden') ? 'd-none':''}} {{$configData['footerType']}}">
  <p class="clearfix mb-0 text-center">
    <span class="float-md-center d-block d-md-inline-block mt-25">COPYRIGHT &copy;
      2022<a class="ms-25" href="{{ route('home.index') }}" target="_blank">P2E Games PH</a>
    </span>
    <!-- <span class="float-md-end d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span> -->
  </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->
