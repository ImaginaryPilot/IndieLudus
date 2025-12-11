<!DOCTYPE html>
<html>
<head>
    <title>Create Team</title>
</head>
<body>
    <h1>Create a Team</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('teams.store', $league) }}">
        @csrf
        <label>Team Name:</label>
        <input type="text" name="name" required><br><br>

        <button type="submit">Create Team</button>
    </form>
</body>
</html>
