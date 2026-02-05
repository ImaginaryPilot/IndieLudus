<!DOCTYPE html>
<html>
<head>
    <title>Register League</title>
</head>
<body>
    <h1>Register a League</h1>

    <form method="POST" action="{{ route('League.storeLeague') }}">
        @csrf
        <label>League Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Year:</label>
        <input type="number" name="year" required><br><br>

        <button type="submit">Create League</button>
    </form>
</body>
</html>