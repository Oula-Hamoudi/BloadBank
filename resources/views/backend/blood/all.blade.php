<x-backend.layouts.master>

    <div class="container-fluid px-4">
        <h1 class="mt-4">All Blood Requests</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Dashboard
            </li>
            <li class="breadcrumb-item active">
                Blood Request
            </li>
            <li class="breadcrumb-item active">
                Approved
            </li>

        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Recent Requests (Approved)
            </div>
            <div class="card-body">
                <x-utilities.form.result />
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>BL Group</th>
                            <th>Area</th>
                            <th>Post Code</th>
                            <th>Unit</th>
                            <th>Request No</th>
                            <th>Requested at</th>
                            <th>Approved by</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($bloodRequests as $request)
                            <tr>
                                <td>{{ $request->patient_name }}</td>
                                <td>{{ $request->blood_group }}</td>
                                <td>{{ $request->district }}</td>
                                <td>{{ $request->postCode ?? 'N/A' }}</td>

                                <td>{{ $request->blood_unit }}</td>
                                <td>{{ $request->request_no }}</td>
                                <td>{{ $request->created_at->diffForHumans() }}</td>
                                <td>{{ $request->approvedBy->name }}</td>
                                <td>
                                    @if ($request->status == null)
                                        <span class="badge bg-info" style="color: aliceblue">Pending</span>
                                    @elseif($request->status == 1)
                                        <span class="badge bg-warning btn-sm" style="color: aliceblue">Assigned</span>
                                    @elseif($request->status == 2)
                                        <span class="badge" style="background-color: cadetblue"
                                            style="color: aliceblue">Taken</span>
                                    @elseif($request->status == 3)
                                        <span class="badge" style="background-color: rgb(4, 154, 7)"
                                            style="color: aliceblue">Donated</span>
                                    @elseif($request->status == 0)
                                        <span class="badge"
                                            style="background-color:fuchsia"style="color: aliceblue">Cancelled</span>
                                    @endif


                                </td>
                                <td>
                                    @if ($request->status == null)
                                        <a href="{{ route('request-assign', $request->id) }}" title="assign"
                                            class="btn btn-warning  w-100 ">Assign</a>
                                        <div class="d-flex">
                                            <a data-bs-toggle="modal" data-bs-target="#view{{ $request->id }}"
                                                title="view" class="btn btn-info btn-sm" style="color: white"><i
                                                    class="fa-solid fa-eye"></i></a>
                                            <div class="modal fade" id="view{{ $request->id }}" tabindex="-1"
                                                aria-labelledby="rejectLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rejectLabel">Other informations
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <span><b>Blood Group:</b>
                                                                    {{ $request->blood_group }}</span>
                                                                <span><b>Require date:</b>
                                                                    {{ $request->require_date }}</span>
                                                            </div>
                                                            <div class="row">
                                                                <span> <b> Contact Info:</b></span>
                                                                <table>
                                                                    <tr>
                                                                        <td>Patient Name</td>
                                                                        <td>:</td>
                                                                        <td>{{ $request->patient_name }}</td>
                                                                        <td>|</td>
                                                                        <td>Contact Name</td>
                                                                        <td>:</td>
                                                                        <td>{{ $request->contact_name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Contact Email</td>
                                                                        <td>:</td>
                                                                        <td colspan="4">{{ $request->email }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone 1</td>
                                                                        <td>:</td>
                                                                        <td>{{ $request->phone }}</td>
                                                                        <td>|</td>
                                                                        <td>Phone 2</td>
                                                                        <td>:</td>
                                                                        <td>{{ $request->phone2 }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="row">
                                                                <p> <b> Address:</b>
                                                                    {{ $request->hospital_name }},{{ $request->thana }},{{ $request->postOffice }},{{ $request->postCode }},{{ $request->district }},{{ $request->division }}
                                                                </p>
                                                            </div>
                                                            <div class="row">
                                                                <img class="img-fluid"
                                                                    src="{{ asset('storage/requests') . '/' . $request->official_report }}"
                                                                    alt="blood">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            <a href="{{ route('blood-edit', $request->id) }}" title="edit"
                                                class="btn btn-success btn-sm" style="margin-left: 3px"><i
                                                    class="fas fa-pencil"></i></a>

                                            <a href="{{ route('blood-reject', $request->id) }}" title="delete"
                                                class="btn btn-danger btn-sm" style="margin-left: 3px"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    @endif

                                    @if ($request->status >= 1)
                                        <a data-bs-toggle="modal" data-bs-target="#view{{ $request->id }}"
                                            title="view" class="btn btn-info btn-sm" style="color: white"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <div class="modal fade" id="view{{ $request->id }}" tabindex="-1"
                                            aria-labelledby="rejectLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectLabel">Other informations</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <span><b>Blood Group:</b>
                                                                {{ $request->blood_group }}</span>
                                                            <span><b>Require date:</b>
                                                                {{ $request->require_date }}</span>
                                                        </div>
                                                        <div class="row">
                                                            <span> <b> Contact Info:</b></span>
                                                            <table>
                                                                <tr>
                                                                    <td>Patient Name</td>
                                                                    <td>:</td>
                                                                    <td>{{ $request->patient_name }}</td>
                                                                    <td>|</td>
                                                                    <td>Contact Name</td>
                                                                    <td>:</td>
                                                                    <td>{{ $request->contact_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Contact Email</td>
                                                                    <td>:</td>
                                                                    <td colspan="4">{{ $request->email }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Phone 1</td>
                                                                    <td>:</td>
                                                                    <td>{{ $request->phone }}</td>
                                                                    <td>|</td>
                                                                    <td>Phone 2</td>
                                                                    <td>:</td>
                                                                    <td>{{ $request->phone2 }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        @if ($request->donor_id)
                                                            <div class="row">
                                                                <p> <b>Donated by: </b>
                                                                    {{ $request->donorId->name ?? '' }},at
                                                                    {{ $request->completed_at ?? '' }}</p>
                                                            </div>
                                                        @endif
                                                        @if ($request->not_donated_reason)
                                                        <div class="row">
                                                            <p> <b>Donar name: </b>
                                                                {{ $request->donorId->name ?? '' }},reason
                                                                {{ $request->not_donated_reason ?? '' }}</p>
                                                        </div>
                                                    @endif
                                                        <div class="row">
                                                            <p> <b> Address:</b>
                                                                {{ $request->hospital_name }},{{ $request->thana }},{{ $request->postOffice }},{{ $request->postCode }},{{ $request->district }},{{ $request->division }}
                                                            </p>
                                                        </div>
                                                        <div class="row">
                                                            <img class="img-fluid"
                                                                src="{{ asset('storage/requests') . '/' . $request->official_report }}"
                                                                alt="blood">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif



                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-backend.layouts.master>
