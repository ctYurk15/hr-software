<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
</style>


User: {{$entry->employee->name}}
<br>
Date: {{ $entry->date->toDateString() }}

@if($entry->events && $entry->events->count() > 0)
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
        <tr>
            <th>Type</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($entry->events as $event)
            <tr>
                <td>{{ $event->type }}</td>
                <td>{{ $event->created_at->toTimeString() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>No events found for this tracker entry.</p>
@endif
