<div class="">
	<h2>Mobile screens</h2>
</div>
<ul class="nav nav-tabs">
	<li role="presentation" class="{{ activeFor('home') }}">
		<a href="{{route('blocks.index',['page'=>'home'])}}">Home</a></li>
	<li role="presentation" class="{{ activeFor('destination') }}">
		<a href="{{route('blocks.index',['page'=>'destination'])}}">Destination</a></li>
	<li role="presentation" class="{{ activeFor('screen') }}">
		<a href="{{route('screen.index')}}">Dynamic</a></li>
</ul>
