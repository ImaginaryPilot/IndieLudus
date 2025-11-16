<!DOCTYPE html>
<html>
<head>
    <title>League {{$league->name}}</title>
</head>
<body>
    <h1>{{$league->name}} ({{$league->year}})</h1>

    <a href="{{ route('createTeam', $league)}}">
        <button type="button">Make Team</button>
    </a>

    @foreach($teams as $team)
        <form action="{{ route('destroyTeam', ['league' => $league->id, 'team' => $team->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete {{ $team->name }}</button>
        </form>
    @endforeach

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>

        <tbody>
            @foreach($teams as $team)
            <tr>
                <td>{{ $team->id }}</td>
                <td>{{ $team->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
