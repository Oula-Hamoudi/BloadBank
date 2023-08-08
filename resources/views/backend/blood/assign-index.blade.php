<x-backend.layouts.master>


    <div class="container-fluid px-4">
        <h1 class="mt-4">Assign</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Dashboard
            </li>
            <li class="breadcrumb-item active">
                Blood donor
            </li>
            <li class="breadcrumb-item active">
                Assign
            </li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Request id: <mark class="fw-blood" style="color: brown;"> #{{$bloodRequest->request_no}} </mark>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <p class="alert alert-success">{{ session('message') }}</p>
                @endif
                <form action="{{route('donor-assign', $bloodRequest->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf   
                    {{-- @method('patch') --}}
        
                <table id="datatablesSimple">

                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Donor name</th>
                            <th>BL Group</th>
                            <th>Area</th>
                            <th>Post Code</th>
                            <th>Phone Number</th>
                            <th>Last Donated</th>
                            <th>Joined</th>


                        </tr>
                    </thead>
                    <tbody>
                      
                            @foreach ($donors as $donor)
                                <tr>
                                    <td><input type="checkbox" name="donor_ids[]" value={{ $donor->id }}></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $donor->name }}</td>
                                    <td>{{ $donor->blood_group }}</td>
                                    <td>{{ $donor->profile->district }}</td>
                                    <td>{{ $donor->postCode ?? 'N/A' }}</td>
                                    <td>{{$donor->profile->phone ?? '01198819121'}}</td>
                                    <td>{{
                                        
                                        $donor->last_donated ?? "Not Yet"
                                    }}</td>
                                    <td>{{ $donor->created_at->diffForHumans() }}</td>


                                </tr>
                            @endforeach


                    </tbody>

                </table>
                <button type="submit" class="btn w-100" style="background-color: burlywood"> Assign all</button>
                </form>
            </div>

        </div>
    </div>

</x-backend.layouts.master>
