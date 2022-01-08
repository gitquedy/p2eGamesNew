<!-- BEGIN: Vendor JS-->
<script src="vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="vendors/js/ui/jquery.sticky.js"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="js/core/app-menu.js"></script>
<script src="js/core/app.js"></script>
<script src="js/app.js"></script>

<!-- custome scripts file for user -->
<script src="js/core/scripts.js"></script>

@if($configData['blankPage'] === false)
<script src="js/scripts/customizer.js"></script>
@endif
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
