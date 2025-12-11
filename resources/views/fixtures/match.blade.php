<!DOCTYPE html>
<html>
<head>
    <title>Match Detail</title>
</head>
<body>
    <h1>{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h1>
    <p>League: {{ $league->name }} ({{ $league->year }})</p>
    <p>Gameweek: {{ $match->gameweek->number }}</p>

    {{-- Optional: Add score input fields later --}}
    {{-- <p>Score: {{ $match->home_score ?? 0 }} - {{ $match->away_score ?? 0 }}</p> --}}

    <a href="{{ route('fixtures.index', $league->id) }}">Back to Fixtures</a>
</body>
</html>
