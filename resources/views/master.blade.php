<html>
	<head>
		<title>Hardwire Community</title>
        <meta charset="utf-8" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
			}

            .member {
                display: inline-block;
                width: 200px;
                height: 215px;
                text-align: center;
            }

            .me {
                background-color: orange;
                color: white;
            }

            .teamspeak {
                outline: 2px solid darkgreen;
            }
		</style>

        <script>
            $(function() {
                $('.teamspeak').insertBefore($('.member')[0]);
                $('.me').insertBefore($('.member')[0]);
            });
        </script>
	</head>
	<body>
        <div><h1 style="text-align: center;">Hardwire Gaming Community</h1></div>
        <div style="float: right;">
        @if (Auth::check())
            <a href="{{ action('HomeController@logout') }}">Logout Now</a>
        @else
            <a href="{{ action('HomeController@login') }}"><img src="https://i.imgur.com/NH4K12B.png"></a>
        @endif
        </div>

        @forelse ($members as $user)
                <div class="member @if (Auth::check() && $user->id === Auth::user()->id) me @endif @if (isset($user->teamspeak) && in_array($user->teamspeak->teamspeak_id, $teamspeakIds)) teamspeak @endif">{{ $user->steam->name }} @if (!isset($user->teamspeak)) @endif <img src="{{ $user->steam->avatar }}"></div>
        @empty
            No users found!
        @endforelse

    </body>
</html>
