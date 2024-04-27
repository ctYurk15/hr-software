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

    .form-container {
        margin-top: 20px;
        padding: 20px;
        background-color: #f8f9fa;
        border: 1px solid #ccc;
    }

    .event-form {
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .form-field {
        margin-right: 20px; /* Adjust spacing as needed */
    }

    .form-field label {
        display: block;
    }

    .event-form button {
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    .event-form button:hover {
        background-color: #0056b3;
    }
</style>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
                @if($entry != null)
                    {{$entry->employee->name}}: {{ $entry->date->toDateString() }}
                @else
                    {{ $date }}
                @endif
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @if($entry != null && $entry->events && $entry->events->count() > 0)
                <table border="1" cellspacing="0" cellpadding="10">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Time</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($entry->events as $event)
                        <tr class="entry-event-container" data-event-id="{{$event->id}}">
                            <td>{{ $event->type }}</td>
                            <td>{{ $event->created_at->toTimeString() }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm deleteEventBtn">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No events found for this tracker entry.</p>
            @endif
            <br>
            <div class="form-container">
                <h2>Add New Event</h2>
                <form action="" method="POST" class="event-form" id="newEventForm">
                    <!--@csrf-->
                    <div class="form-field">
                        <div class="label-container">
                            <label for="user_id">User:</label>
                        </div>
                        <select name="user_id" id="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    @if($entry != null && $entry->employee_id == $user->id) selected @endif
                                >{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-field">
                        <div class="label-container">
                            <label for="date">Date:</label>
                        </div>
                        <input type="date" name="date" required value="{{$entry != null ? $entry->date->toDateString() : $date}}">
                    </div>

                    <div class="form-field">
                        <div class="label-container">
                            <label for="time">Time:</label>
                        </div>
                        <input type="time" name="time" required>
                    </div>

                    <div class="form-field">
                        <div class="label-container">
                            <label for="type">Event Type:</label>
                        </div>
                        <select name="type" id="type" required>
                            <option value="start">Start</option>
                            <option value="end">End</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <button type="submit">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
