@include('layouts.admin.header')
@include('layouts.admin.css-links')

<body class="hold-transition sidebar-mini layout-fixed">
	
	@include('layouts.admin.menu')
	
	<div class="content-wrapper">
		@yield('content')
	</div>
	
	@include('layouts.admin.scripts')
	@include('layouts.admin.footer')
@include('layouts.admin.functions')
@include('layouts.admin.flash-message')


