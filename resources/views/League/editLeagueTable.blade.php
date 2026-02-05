<!DOCTYPE html>
<html>
<head>
    <title>Edit League Table</title>
</head>
<body>
    <h1>Edit League Table</h1>

    <form method="POST" action="{{ route('Table.update', $league) }}">
        @csrf

        <h3>Existing Columns</h3>
        <div id="columns-container">
            @foreach($columns as $col)
                <div class="column-row">
                    <input type="text" name="columns[{{ $col->id }}][name]" value="{{ $col->name }}" required>
                </div>
            @endforeach
        </div>

        <h3>Add New Column</h3>
        <div id="new-columns-container"></div>
        <button type="button" onclick="addNewColumn()">Add Column</button>

        <br><br>
        <button type="submit">Save Columns</button>
    </form>

    
</body>

<script>
let newCounter = 0;

function addNewColumn() {
    const container = document.getElementById('new-columns-container');
    const div = document.createElement('div');
    div.innerHTML = `<input type="text" name="columns[new][${newCounter}][name]" placeholder="Column Name" required>`;
    container.appendChild(div);
    newCounter++;
}
</script>

</html>