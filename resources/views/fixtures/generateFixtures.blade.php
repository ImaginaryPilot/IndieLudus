<!DOCTYPE html>
<html>
<head>
    <title>Generate Fixtures</title>
</head>
<body>
    <h1>{{ $league->name }} Fixtures</h1>

    <form action="{{ route('fixtures.generate', $league->id) }}" method="POST">
        @csrf
        <label>Rounds per pair:</label>
        <input type="number" name="rounds" value="1" min="1">
        <button type="submit">Generate Fixtures</button>
    </form>

</body>
</html>
