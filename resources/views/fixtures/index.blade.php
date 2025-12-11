<!DOCTYPE html>
<html>
<head>
    <title>Fixtures</title>
</head>
<body>
    <h1>{{ $league->name }} Fixtures</h1>

    @if($gameweekNumber)
        <h2>Gameweek {{ $gameweekNumber }}</h2>
    @endif

    @foreach($gameweeks as $gameweek)
        <h3>Gameweek {{ $gameweek->number }}</h3>
        <ul>
            @foreach($gameweek->matches as $match)
                <li>{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</li>
            @endforeach
        </ul>
    @endforeach

</body>
</html>
