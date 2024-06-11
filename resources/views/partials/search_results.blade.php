<table class="table">
    <thead>
        <tr>
            <th scope="col">Card ID</th>
            <th scope="col">Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>