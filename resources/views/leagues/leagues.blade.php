<!DOCTYPE html>
<html>
<head>
    <title>Leagues</title>
</head>
<body>
    <h1>Leagues</h1>
    <a href="{{ route('leagues.create') }}">
        <button type="button">Make League</button>
    </a>

    <form action="{{ route('leagues.destroy') }}" method="POST">
        @csrf
        @method('DELETE')

        <select name="league_id">
            @foreach($leagues as $league)
                <option value="{{ $league->id }}">{{ $league->name }} ({{ $league->year }})</option>
            @endforeach
        </select>

        <button type="submit">Delete League</button>
    </form>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Year</th>
            </tr>
        </thead>

        <tbody>
            @foreach($leagues as $league)
            <tr onclick="window.location='{{ route('leagues.viewLeague', $league->id) }}' " style="cursor: pointer;">
                <td>{{ $league->id }}</td>
                <td>{{ $league->name }}</td>
                <td>{{ $league->year }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
