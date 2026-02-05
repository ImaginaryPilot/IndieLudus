<!DOCTYPE html>
<html>
<head>
    <title>Leagues</title>
</head>
<body>
    <h1>Leagues</h1>
    <a href="{{ route('League.registerLeague') }}">
        <button type="button">Make League</button>
    </a>

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
            <tr onclick="window.location='{{ route('League.leagueDashboard', $league->id) }}' " style="cursor: pointer;">
                <td>{{ $league->id }}</td>
                <td>{{ $league->name }}</td>
                <td>{{ $league->year }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>