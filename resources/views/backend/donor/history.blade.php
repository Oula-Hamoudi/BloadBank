<x-backend.layouts.master>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Blood Requests</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Dashboard
            </li>
            <li class="breadcrumb-item active">
                Donation History
            </li>
            
        </ol>
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
                    All Donation History under BDMS
                </div>
                <div>
                    <span style=" margin-left: 4px; cursor: pointer;" onclick="window.print()"><i class="fas fa-print me-1"></i>Print</span>
                </div>
           
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Gender</th>
                            <th>Hostpital name</th>
                            <th>Area</th>
                            <th>Post code</th>
                            <th>Reason</th>
                            <th>Donated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $request)
                            <tr>
                                <td>{{ $request->patient_name }}</td>
                                <td>{{ $request->gender }}</td>
                                <td>{{ $request->hospital_name }}</td>
                                <td>{{ $request->district }}</td>
                                <td>{{ $request->postCode }}</td>
                                <td>{{ Str::limit($request->reason, 15, '...') }}</td>
                                <td>{{$request->completed_at}}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-backend.layouts.master>
