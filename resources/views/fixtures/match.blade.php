<!DOCTYPE html>
<html>
<head>
    <title>Match Detail</title>
</head>
<body>
    <h1>{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h1>
    <p>League: {{ $league->name }} ({{ $league->year }})</p>
    <p>Gameweek: {{ $match->gameweek->number }}</p>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('fixtures.updateScore', [$league->id, $match->id]) }}" method="POST">
        @csrf
        <label>{{ $match->homeTeam->name }} score:</label>
        <input type="number" name="home_score" value="{{ $match->home_score ?? 0 }}" min="0">
        
        <label>{{ $match->awayTeam->name }} score:</label>
        <input type="number" name="away_score" value="{{ $match->away_score ?? 0 }}" min="0">
        
        <button type="submit">Update Score</button>
    </form>

    <p>Current Score: {{ $match->home_score ?? '-' }} - {{ $match->away_score ?? '-' }}</p>

    <a href="{{ route('fixtures.index', $league->id) }}">Back to Fixtures</a>

</body>
</html>
