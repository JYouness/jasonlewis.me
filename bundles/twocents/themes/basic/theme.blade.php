<!DOCTYPE html>
<html>

	<head>
		<title>{{ $title }} &ndash; Ramblings from the Land Down Under</title>

		{{ TwoCents\Theme::style('css/theme.css') }}
	</head>

	<body onload="prettyPrint()">
		
		<div id="container">

			<div id="header">
				<h1><a href="{{ URL::to_route('twocents: home') }}">Jason<span>Lewis</span></a></h1>

				<ul>
					<li>{{ HTML::link_to_route('twocents: page', 'Two Cents', array('code/twocents')) }}</li>
				</ul>
			</div>

			<div id="main">

				{{ $content }}

			</div>

			<div id="sidebar">

				{{ isset($sidebar) ? $sidebar : null }}

				<div class="section">
					<h2>About Two Cents</h2>

					<p>
						Two Cents is a Git based blogging engine bundle for the Laravel framework.
					</p>
				</div>

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