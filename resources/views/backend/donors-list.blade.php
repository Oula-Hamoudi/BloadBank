<x-backend.layouts.master>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Donors List</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Dashboard
            </li>
            <li class="breadcrumb-item active">
                Donors
            </li>
            <li class="breadcrumb-item active">
                Donors-list
            </li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                All DONORS
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>BL Group</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>District</th>
                            <th>Post code</th>
                            <th>Joined at</th>
                            <th>Status</th>
                            <th>Last donated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($donors as $donor)
                            <tr>
                                <td>{{$donor->name}}</td>
                                <td>{{$donor->blood_group}}</td>
                                <td>{{$donor->profile->gender}}</td>
                                <td>{{$donor->profile->dob}}</td>
                                <td>{{$donor->profile->district}}</td>
                                <td>{{$donor->profile->postCode}}</td>
                                <td>{{$donor->created_at}}</td>
                                <td>
                                    @if ($donor->status == Null)
                                    <span class="badge bg-success" > Active </span>
                                    @elseif ($donor->staus == 3)
                                    <span class="badge bg-danger" > Deactive </span>
                                    @else
                                    <span class="badge bg-warning" > Busy </span>

                                    @endif
                                </td>
                                <td>
                                   {{$donor->last_donated ?? 'Not yet'}}
                                </td>
                                <td class="d-flex">
 
                                    <a href="" title="view" class="btn btn-info btn-sm" style="color: white"><i
                                            class="fa-solid fa-eye"></i></a>



                                    <a href="" title="edit" class="btn btn-success btn-sm" style="margin-left: 3px"><i
                                            class="fas fa-pencil"></i></a>
                                    <form action="">
                                        <button type="submit" title="delete" class="btn btn-danger btn-sm"
                                            style="margin-left: 3px"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-backend.layouts.master>
