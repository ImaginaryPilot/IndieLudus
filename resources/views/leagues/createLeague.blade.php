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

    <form method="POST" action="{{ route('leagues.store') }}">
        @csrf
        <label>League Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Year:</label>
        <input type="number" name="year" required><br><br>

        <h2>League Table Columns</h2>
        <div id="columns">
            <div class="column">
                <label>Column Name:</label>
                <input type="text" name="columns[0][name]" required>
                <label>Type:</label>
                <select name="columns[0][type]">
                    <option value="integer">Integer</option>
                    <option value="decimal">Decimal</option>
                    <option value="string">String</option>
                    <option value="computed">Computed</option>
                </select>
            </div>
        </div>

        <button type="button" onclick="addColumn()">Add Another Column</button><br><br>

        <h2>Select Ranking Column</h2>
        <p>This column determines how teams are ranked in the table.</p>

        <select name="ranking_column" id="ranking_column" required>
            <option value="">-- Select Column --</option>
        </select>

        <br><br>

        <button type="submit">Create League</button>
    </form>
</body>

<script>
let columnCount = 1;

function addColumn() {
    const container = document.getElementById('columns');
    const div = document.createElement('div');
    div.classList.add('column');
    div.innerHTML = `
        <label>Column Name:</label>
        <input type="text" name="columns[${columnCount}][name]" required>
        <label>Type:</label>
        <select name="columns[${columnCount}][type]">
            <option value="integer">Integer</option>
            <option value="decimal">Decimal</option>
            <option value="string">String</option>
            <option value="computed">Computed</option>
        </select>
    `;
    container.appendChild(div);
    columnCount++;
}


function updateRankingDropdown() {
    const dropdown = document.getElementById('ranking_column');
    dropdown.innerHTML = '<option value="">-- Select Column --</option>';

    for (let i = 0; i < columnCount; i++) {
        const input = document.querySelector(`input[name="columns[${i}][name]"]`);
        if (input && input.value.trim() !== "") {
            dropdown.innerHTML += `<option value="${i}">${input.value}</option>`;
        }
    }
}

// Update ranking dropdown when column names change
document.addEventListener('input', function(e) {
    if (e.target.name?.includes("columns") && e.target.name?.includes("[name]")) {
        updateRankingDropdown();
    }
});

</script>

</html>
