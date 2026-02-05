<!DOCTYPE html>
<html>
<head>
    <title>Match Template</title>
</head>
<body>
    <h1>Edit Match Template</h1>

    <form action="{{ route('MatchTemplate.update', $league) }}" method="POST">
        @csrf
        @method('PUT')

        <div id="stats-container">
            @foreach($stats as $index => $stat)
                <div class="stat-row">
                    <input type="text" name="stats[{{ $index }}][name]" value="{{ $stat['name'] }}" required>
                    <select name="stats[{{ $index }}][type]" required>
                        <option value="int" {{ $stat['type'] == 'int' ? 'selected' : '' }}>Integer</option>
                        <option value="decimal" {{ $stat['type'] == 'decimal' ? 'selected' : '' }}>Decimal</option>
                    </select>
                    <select name="stats[{{ $index }}][scope]" required>
                        <option value="team" {{ $stat['scope'] == 'team' ? 'selected' : '' }}>Team</option>
                        <option value="neutral" {{ $stat['scope'] == 'neutral' ? 'selected' : '' }}>Neutral</option>
                    </select>

                    <input type="radio" name="decider_stat_index" value="{{ $index }}" {{ ($template->decider_stat_index ?? 0) == $index ? 'checked' : '' }}>
                    <label>Decider</label>
                </div>
            @endforeach
        </div>

        <button type="button" onclick="addStat()">Add Stat</button>
        <br><br>

        <label for="decider_mode">Decider Mode:</label>
        <select name="decider_mode" id="decider_mode" required>
            <option value="higher" {{ ($template->decider_mode ?? 'higher') == 'higher' ? 'selected' : '' }}>Higher wins</option>
            <option value="lower" {{ ($template->decider_mode ?? 'higher') == 'lower' ? 'selected' : '' }}>Lower wins</option>
        </select>
        <br><br>
        
        <button type="submit">Save Template</button>
    </form>

</body>

<script>
let counter = {{ count($stats) }};

function addStat() {
    const container = document.getElementById('stats-container');
    const div = document.createElement('div');
    div.classList.add('stat-row');
    div.innerHTML = `
        <input type="text" name="stats[${counter}][name]" placeholder="Stat Name" required>
        <select name="stats[${counter}][type]" required>
            <option value="int">Integer</option>
            <option value="decimal">Decimal</option>
        </select>
        <select name="stats[${counter}][scope]" required>
            <option value="team">Team</option>
            <option value="neutral">Neutral</option>
        </select>
        <input type="radio" name="decider_stat_index" value="${counter}">
        <label>Decider</label>
    `;
    container.appendChild(div);
    counter++;
}
</script>

</html>