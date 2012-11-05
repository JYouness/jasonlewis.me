<!DOCTYPE html>
<html>

	<head>
		<title>{{ $title }} &ndash; Two Cents</title>

		{{ TwoCents\Theme::style('css/theme.css') }}
	</head>

	<body onload="prettyPrint()">
		
		<div id="container">

			<div id="header">
				<h1><a href="{{ URL::to_route('twocents: home') }}">Jason<span>Lewis</span></a></h1>

				<ul>
					<li>{{ HTML::link_to_route('twocents: page', 'Contribute', array('contribute')) }}</li>
				</ul>
			</div>

			@if(isset($sidebar))
			<div id="sidebar">

				{{ $sidebar }}
			</div>
			@endif

			<div id="main">

				{{ $content }}

			</div>

			<div id="footer">
				Copyright &copy; 2012 Jason Lewis

				<p>
					Powered by {{ HTML::link('http://jasonlewis.me/code/twocents', 'Two Cents') }}
				</p>
			</div>

		</div>

		{{ TwoCents\Theme::script('js/prettify.js') }}
	</body>
</html>