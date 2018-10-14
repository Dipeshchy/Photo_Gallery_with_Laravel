<!DOCTYPE html>
<html>
<head>
	<title>PhotoShow</title>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/css/foundation.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/js/foundation.js"></script>
</head>
<body>
	@include('includes.topbar')
	<br>
	<div class="grid-container">
		@include('includes.messages')
		@yield('content')
	</div>
</body>
</html>