<!DOCTYPE html>
<html>
<head>
    <title>{{ $league->name }}</title>
</head>
<body>
    <h1>{{ $league->name }} ({{ $league->year }})</h1>

    <a href="{{ route('MatchTemplate.show', $league) }}">
        <button type="button">Edit Match Template</button>
    </a>
    <a href="{{ route('Table.edit', $league) }}">
        <button type="button">Edit League Table</button>
    </a>
</body>
</html>