<div id="articles">

	<?php $article = array_shift($articles); ?>

	<div class="article">
		<h2 class="title"><a href="{{ URL::to_route('twocents: article', array($article->slug)) }}">{{ $article->title }}</a></h2>

		<div class="meta">
			By {{ $article->author->name }} on <span class="date">{{ date('j F, Y', strtotime($article->date)) }}</span>
		</div>

		<div class="body">
			{{ $article->intro }}
		</div>

		@if($article->more)
			{{ HTML::link_to_route('twocents: article', 'Read more', array($article->slug), array('class' => 'read-more')) }}
		@endif
	</div>

	<div class="spacer"></div>

	@foreach($articles as $article)

	<div class="article">
		<h3 class="title"><a href="{{ URL::to_route('twocents: article', array($article->slug)) }}">{{ $article->title }}</a></h3>

		<div class="meta">
			By {{ $article->author->name }} on <span class="date">{{ date('j F, Y', strtotime($article->date)) }}</span>
		</div>
	</div>

	@endforeach

</div>