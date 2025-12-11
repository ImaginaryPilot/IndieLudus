<!DOCTYPE html>
<html>
<head>
    <title>League {{ $league->name }}</title>
</head>
<body>
    <h1>{{ $league->name }} ({{ $league->year }})</h1>

    <a href="{{ route('teams.create', $league) }}">
        <button type="button">Make Team</button>
    </a> 

    <div>
        @foreach($teams as $team)
            <form action="{{ route('teams.destroy', ['league' => $league->id, 'team' => $team->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete {{$team->name}}</button>
            </form>
        @endforeach
    </div>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                {{-- Render column headers from $columns --}}
                @foreach($columns as $column)
                    <th>{{ $column->name }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach($teams as $team)
                <tr onclick="window.location='{{ route('teams.show', ['league' => $league->id, 'team' => $team->id]) }}'" style="cursor:pointer;">
                    @php
                        // $rowsByTeam was prepared in controller: array team_id => data array
                        $data = $rowsByTeam[$team->id] ?? [];
                    @endphp

                    @foreach($columns as $column)
                        @php
                            // Prefer value stored in row JSON; fallback to team->name only for team_name column if needed
                            $val = $data[$column->key_name] ?? null;

                            if ($val === null && $column->key_name === 'team_name') {
                                // If team_name column exists but row wasn't populated, fall back to team->name
                                $val = $team->name;
                            }
                        @endphp

                        <td>{{ $val }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
