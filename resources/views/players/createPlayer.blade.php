<!DOCTYPE html>
<html>
<head>
    <title>Create Player</title>
</head>
<body>
    <h1>Register a Player</h1>


    <form action="{{ route('players.store', [$league, $team]) }}" method="POST">
        @csrf
        <label>Player Name:</label>
        <input type="text" name="name" required>
        <button type="submit">Add Player</button>
    </form>
</body>
</html>
