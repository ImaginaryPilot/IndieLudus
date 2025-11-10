<!DOCTYPE html>
<html>
<head>
    <title>Create League</title>
</head>
<body>
    <h1>Create a League</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="/leagues">
        @csrf
        <label>League Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Year:</label>
        <input type="number" name="year" required><br><br>

        <label>Location:</label>
        <input type="text" name="location"><br><br>

        <button type="submit">Create League</button>
    </form>
</body>
</html>
