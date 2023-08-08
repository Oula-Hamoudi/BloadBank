<x-backend.layouts.master>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Event History</h1>
        @if (session('message'))
            <p class="alert alert-success">{{ session('message') }}</p>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Events Uploaded By You
                </div>
                <div>
                    <span style=" margin-left: 4px; cursor: pointer;" onclick="window.print()"><i
                            class="fas fa-print me-1"></i>Print</span>
                </div>

            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Area</th>
                            <th>Organized By</th>
                            <th>Approved By</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $request)
                            <tr>
                                <td>{{ $request->title }}</td>
                                <td>{{ $request->area }}</td>
                                <td>{{ $request->organized_by }}</td>
                                <td>{{ $request->approvedBy->name   ?? 'Not yet!' }}</td>
                                <td>{{ $request->event_date }}</td>
                                <td>
                                    @if ($request->approved_by)
                                        <span class="badge bg-success">Live</span>
                                    @elseif ($request->declined_by)
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-backend.layouts.master>
