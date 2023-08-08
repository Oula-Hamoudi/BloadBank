<x-backend.layouts.master>

    <style>
        #txtarea {
            display: none;
        }
    </style>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Donors</li>
            <li class="breadcrumb-item active">Donor-Requests</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                NOT APPROVED DONORS
            </div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if ($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger text-center" role="alert">:message</div>')) !!}
            @endif
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>NID</th>
                            <th>BL Group</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Requested at</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pendingDonorsRequests as $request)
                            <tr>
                                <td>{{ $request->name }}</td>
                                <td>{{$request->nid_number}}</td>
                                <td>{{ $request->blood_group }}</td>
                                <td>{{ $request->profile->gender }}</td>
                                <td>{{ $request->profile->dob }}</td>
                                <td>{{ $request->created_at->diffForHumans()}}</td>
                                <td class="d-flex">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#view{{ $request->id }}" title="view"
                                        class="btn btn-info btn-sm" style="color: white"><i
                                            class="fa-solid fa-eye"></i></a>
                                                            {{-- view modal  --}}
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
                                                                <div class="col-md-6 d-flex flex-column">
                                                                    <span><b>Blood Group:</b> {{$request->blood_group}}</span>
                                                                    <span><b>Gender:</b> {{$request->profile->gender}}</span>
                                                                    
                                                                </div>
                                                                <div class="col-md-6 d-flex flex-column">
                                                                    <span><b>Age:</b> {{$request->age($request->profile->dob)}}</span>
                                                                    <span><b>NID:</b> {{$request->nid_number}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <span>Profile Image:</span>
                                                                    <img class="img-fluid" src="{{asset('storage/users/profile').'/'.$request->profile->profile_image}}" alt="Profile Image">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <span>NID Image:</span>
                                                                    <img class="img-fluid" src="{{asset('storage/users/nid').'/'.$request->profile->nid_image}}" alt="NID Image">
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="row">
                                                                <p class="pb-0 mb-0"> <b> Email:</b> {{$request->email}}</p>

                                                                <p class="pb-0 mb-0"> <b> Address:</b> {{$request->profile->thana}},{{$request->profile->postOffice}},{{$request->profile->postCode}},{{$request->profile->district}},{{$request->profile->division}}</p>
                                                            </div>
                                                            <a href="" class="btn btn-sm btn-outline-info">Download Informations</a>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                 
                                                    </div>
                                                </div>
                                            </div>

                    

 

                                    <a href="{{ route('donor-request-accept', $request->id) }}" title="approve"
                                        class="btn btn-success btn-sm" style="margin-left: 3px; margin-right: 3px;"><i
                                            class="fas fa-check"></i></a>
                                        
                                   <a data-bs-toggle="modal" data-bs-target="#decline{{ $request->id }}" 
                                     {{-- href="{{route('donor-request-decline' , $request->id)}}" --}}
                                      title="decline" class="btn btn-danger ml-1 btn-sm">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                </a>
                                {{-- decline modal  --}}
                                <div class="modal fade" id="decline{{ $request->id }}" tabindex="-1"
                                    aria-labelledby="rejectLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectLabel">Reason</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                           
                                                <form action="{{ route('donor-request-decline' , $request->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
        
                                                    <div class="modal-body">
                                                        <p>Please mark a reason:</p>
                                                        <div class="form-check">
                                                            <input onclick="hidetxt()" class="form-check-input" type="radio"
                                                                name="reason" id="exampleRadios1"
                                                                value="No certified documents">
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                No certified documents
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="form-check">
                                                            <input onclick="showtxt()" class="form-check-input" type="radio"
                                                                name="reason" id="others">
                                                            <label class="form-check-label" for="others">
                                                                Others
                                                            </label>
        
                                                        </div>
                                                        <textarea name="reason2" id="txtarea" cols="30" rows="2"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                         
                                     
                                        </div>
                                    </div>
                                </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function hidetxt() {
            document.getElementById("txtarea").style.display = "none";
            document.getElementById("txtarea").value='';
        }

        function showtxt() {
            document.getElementById("txtarea").style.display = "block";
            

        }
    </script>

</x-backend.layouts.master>
