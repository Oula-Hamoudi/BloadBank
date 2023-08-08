<x-backend.layouts.master>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Blood Requests</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Dashboard
            </li>
            <li class="breadcrumb-item active">
                Blood Requests
            </li>
            <li class="breadcrumb-item active">
                Pending
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
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                All Requests
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
                            <th>Require Date</th>
                            <th>Requested at</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingRequests as $request)
                        <tr>

                            <td>{{ $request->patient_name }}</td>
                            <td>{{ $request->gender }}</td>
                            <td>{{ $request->hospital_name }}</td>
                            <td>{{ $request->district }}</td>
                            <td>{{ $request->postCode }}</td>
                            <td>{{ Str::limit($request->reason, 15, '...') }}</td>
                            <td>{{ $request->require_date }}</td>
                            <td>{{ $request->created_at }}</td>
                            <td>{{ $request->phone }}</td>
                            <td>
                                @if ($request->pivot->status == null)
                            <td><span align="center" class="badge bg-info"> Pending</span>
                                @elseif($request->pivot->status == 1)
                                <span class="badge bg-warning">Ongoing</span>
                                @elseif($request->pivot->status == 2)
                                <span class="badge bg-success"> Donated </span>
                                @endif
                            </td>

                            <td>

                                <a title="view" data-bs-toggle="modal" data-bs-target="#view{{ $request->id }}" title="view" class="btn btn-info btn-sm">View</a>
                                <div class="modal fade" id="view{{ $request->id }}" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewLabel">Req
                                                    No:{{ $request->request_no }}</h5>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p> <b>Requested at: {{ $request->created_at }} </b> </p>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6 d-flex flex-column">
                                                        <span><b>Patient Name:</b>
                                                            {{ $request->patient_name }}</span>
                                                        <span><b>Gender:</b> {{ $request->gender }}</span>
                                                        <span><b>Hospital:</b>{{ $request->hospital_name }}</span>
                                                        <span><b>Contact Name:</b>
                                                            {{ $request->contact_name }}</span>

                                                    </div>
                                                    <div class="col-md-6 d-flex flex-column">
                                                        <span><b>Blood Group:</b> <span class="badge bg-danger">{{ $request->blood_group }}</span>
                                                        </span>
                                                        <span><b>Blood Unit:</b> {{ $request->blood_unit }}</span>
                                                        <span><b>Require Date:</b>
                                                            {{ $request->require_date }}</span>
                                                        <span><b>Reason:</b>{{ $request->reason }}</span>

                                                    </div>

                                                </div>


                                                <div class="row">
                                                    <span><b>Contact Number:</b> {{ $request->phone }}</span>
                                                    <span><b>Contact Number2:</b>
                                                        {{ $request->phone2 ?? 'N/A' }}</span>
                                                    <p class="pb-0 mb-0"> <b> Email:</b> {{ $request->email }}</p>

                                                    <p class="pb-0 mb-0"> <b>
                                                            Address:</b>{{ $request->hospital_name }},{{ $request->thana }},{{ $request->postOffice }},{{ $request->postCode }},{{ $request->district }},{{ $request->division }}
                                                    </p>
                                                </div>
                                                @if ($request->pivot->status == 1)
                                                <a href="{{route('seekerprofile',$request->id)}}" class="btn btn-sm btn-outline-info">Download
                                                    Informations</a>
                                                @endif

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @if ($request->pivot->status == null)
                                <a href="{{ route('donor-req-accept', $request->id) }}" title="take" class="btn btn-success btn-sm">Accept</a>
                                @elseif($request->pivot->status == 1)
                                <a href="{{ route('donor-req-donated', $request->id) }}" title="Donated?" class="btn btn-success btn-sm">Donated?</a>
                                <button title="Not Donated?" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#notDonated{{ $request->id }}">Not
                                    Donated?</button>
                                <div class="modal fade" id="notDonated{{ $request->id }}" tabindex="-1" aria-labelledby="rejectLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectLabel">Not Donated Reason</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('donor-req-notdonated', $request->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Please mark a reason:</p>
                                                    @foreach ($reasons as $reason)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="{{ $reason->id}}" name="not_donated_reason" id="reason{{ $reason->id }}">
                                                        <label class="form-check-label" for="reason{{ $reason->id }}">
                                                            {{ $reason->name }}
                                                        </label>
                                                    </div>
                                                    @endforeach

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
