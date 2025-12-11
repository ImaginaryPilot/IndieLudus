<!DOCTYPE html>
<html>
<head>
    <title>Team {{ $team->name }}</title>
</head>
<body>
    <h1>{{ $team->name }}</h1>

    <a href="{{ route('players.create', ['league' => $team->league_id, 'team' => $team->id]) }}">
        <button type="button">Register Player</button>
    </a>

    <h2>Players</h2>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Player Name</th>
            </tr>
        </thead>

        <tbody>
            @foreach($players as $player)
            <tr>
                <td>{{ $player->name }}</td>

                <td>
                    <form action="{{ route('players.destroy', [
                            'league' => $league->id,
                            'team' => $team->id,
                            'player' => $player->id
                        ]) }}"
                        method="POST"
                        onsubmit="return confirm('Delete this player?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</body>
</html>
