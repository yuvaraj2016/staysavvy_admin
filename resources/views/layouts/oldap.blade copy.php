
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sparkle Kids') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('modules/bootstrap-social/bootstrap-social.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- General CSS Files -->
    {{-- <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/jquery-selectric/selectric.css') }}">

    <link rel="stylesheet" href="{{ asset('modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');

    </script>
    <!-- /END GA -->
</head>



<body class="layout-3">

    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar" style="border:0px solid red!important; margin-top:-7px!important;">
                <a href="index.html" class="navbar-brand">Ecommerce Admin</a>


            </nav>
        </div>
        <div class="clearfix" style="clear:both; padding-top:50px;"></div>



     


     
        <nav class="navbar navbar-expand-sm navbar-light bg-faded">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          
          <!-- Brand -->
          <a class="navbar-brand" href="#"></a>
          
          <!-- Links -->
          <div class="collapse navbar-collapse" id="nav-content">   
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link nav-link-lg nav-link-user"
                  href="{{ route('item.index') }}">Items</a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link nav-link-lg nav-link-user"
                  href="{{ route('item_variant.index') }}">Item Variants</a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link nav-link-lg nav-link-user"
                  href="{{ route('stock_master.index') }}">Stock Master</a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link nav-link-lg nav-link-user"
                  href="{{ route('supplier.index') }}">Suppliers</a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link nav-link-lg nav-link-user"
                  href="{{ route('vendor.index') }}">Vendors</a>
          </li>

          <li class="nav-item dropdown">
              <a class="nav-link nav-link-lg nav-link-user nav-link dropdown-toggle"
                  href="{{ route('product_cat.index') }}" data-toggle="dropdown">Configurations</a>
              <ul class="dropdown-menu open">
                  <li><a class="nav-link" href="{{ route('product_cat.index') }}">Product Category</a></li>
                  <li><a class="nav-link" href="{{ route('product_sub_cat.index') }}">Product Sub Category</a></li>
                  <li><a class="nav-link" href="{{ route('supplier_cat.index') }}">Supplier Category</a></li>
                  <li><a class="nav-link" href="{{ route('vendor_cat.index') }}">Vendor Category</a></li>
                  <li><a class="nav-link" href="{{ route('status.index') }}">Status</a></li>
                 
              </ul>
          </li>

           {{-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" id="Preview" href="{{ route('product_cat.index') }}" role="button" aria-haspopup="true" aria-expanded="false">
            Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="Preview">
            <a class="dropdown-item" href="{{ route('product_cat.index') }}">Product Category</a>
            <a class="dropdown-item" href="{{ route('product_sub_cat.index') }}">Product Sub Category</a>
            
            </div>
            </li> --}}
       
          </ul>
          </div>
          </nav>
        {{-- <nav class="navbar navbar-expand-md bg-dark navbar-dark ml-auto">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">

                <ul class="navbar-nav" style="height:auto!important;">
                     <li class="dropdown">
                        <a class="nav-link nav-link-lg nav-link-user"
                            href="{{ route('item.index') }}">Items</a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link nav-link-lg nav-link-user"
                            href="{{ route('item_variant.index') }}">Item Variants</a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link nav-link-lg nav-link-user"
                            href="{{ route('stock_master.index') }}">Stock Master</a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link nav-link-lg nav-link-user"
                            href="{{ route('supplier.index') }}">Suppliers</a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link nav-link-lg nav-link-user"
                            href="{{ route('supplier.index') }}">Vendors</a>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link nav-link-lg nav-link-user nav-link has-dropdown"
                            href="{{ route('product_cat.index') }}" data-toggle="dropdown">Configurations</a>
                        <ul class="dropdown-menu open">
                            <li><a class="nav-link" href="{{ route('product_cat.index') }}">Product Category</a></li>
                            <li><a class="nav-link" href="{{ route('product_sub_cat.index') }}">Product Sub Category</a></li>
                        </ul>
                    </li>

                     <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" data-toggle="dropdown" id="Preview" href="{{ route('product_cat.index') }}" role="button" aria-haspopup="true" aria-expanded="false">
                      Dropdown
                      </a>
                      <div class="dropdown-menu" aria-labelledby="Preview">
                      <a class="dropdown-item" href="{{ route('product_cat.index') }}">Product Category</a>
                      <a class="dropdown-item" href="{{ route('product_sub_cat.index') }}">Product Sub Category</a>
                      
                      </div>
                      </li>

                </ul>
            </div>
        </nav> --}}


    </div>



    <div class="container-fluid" style="padding-top:100px;">
        @yield('content')
    </div>
    <footer class="main-footer">
        <div class="footer-left">
            Copyright &copy; 2020 <div class="bullet"></div> Developed By <a href="http://hridhamtech.com/">Hridham
                Technologies</a>
        </div>
        <div class="footer-right">

        </div>
    </footer>

    <!-- General JS Scripts -->
    <script src="{{ asset('modules/jquery.min.js') }}"></script>
    <script src="{{ asset('modules/popper.js') }}"></script>
    <script src="{{ asset('modules/tooltip.js') }}"></script>
    <script src="{{ asset('modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('modules/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
    <script
        src="{{ asset('modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}">
    </script>
    <script src="{{ asset('modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>





</body>



</html>

<script>
$(function () {
        // Remove Search if user Resets Form or hits Escape!
		$('body, .navbar-collapse form[role="search"] button[type="reset"]').on('click keyup', function(event) {
			console.log(event.currentTarget);
			if (event.which == 27 && $('.navbar-collapse form[role="search"]').hasClass('active') ||
				$(event.currentTarget).attr('type') == 'reset') {
				closeSearch();
			}
		});

		function closeSearch() {
            var $form = $('.navbar-collapse form[role="search"].active')
    		$form.find('input').val('');
			$form.removeClass('active');
		}

		// Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
		$(document).on('click', '.navbar-collapse form[role="search"]:not(.active) button[type="submit"]', function(event) {
			event.preventDefault();
			var $form = $(this).closest('form'),
				$input = $form.find('input');
			$form.addClass('active');
			$input.focus();

		});
		// ONLY FOR DEMO // Please use $('form').submit(function(event)) to track from submission
		// if your form is ajax remember to call `closeSearch()` to close the search container
		$(document).on('click', '.navbar-collapse form[role="search"].active button[type="submit"]', function(event) {
			event.preventDefault();
			var $form = $(this).closest('form'),
				$input = $form.find('input');
			$('#showSearchTerm').text($input.val());
            closeSearch()
		});
    });
</script>