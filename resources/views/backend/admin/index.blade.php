<x-backend.layouts.master>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.min.css"
        integrity="sha512-Yn5Z4XxNnXXE8Y+h/H1fwG/2qax2MxG9GeUOWL6CYDCSp4rTFwUpOZ1PS6JOuZaPBawASndfrlWYx8RGKgILhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js"></script>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Admin Privellages</h1>


        <div class="card mb-4">
            <div class="card-header">

                <div class="row">
                    <div class="col-9">
                        <i class="fas fa-table me-1"></i>
                        Users list
                    </div>

                </div>
            </div>
            @if (session('message'))
                <script>
                    $(document).ready(function() {
                        Swal.fire(
                            'Success!',
                            'Successfully Updated!',
                            'success'
                        )
                    });
                </script>
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
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Joined</th>
                            <th>Donations</th>
                            <th>Approved_by</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->total_donated }}</td>
                                <td>{{ $user->approvedBy->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role_id == 2)
                                        <span class="badge bg-success">Admin</span>
                                    @endif
                                    @if ($user->role_id == 3)
                                        <span class="badge bg-primary">Donor</span>
                                    @endif
                                    @if ($user->role_id == 1)
                                        <span class="badge bg-warning">SuperAdmin</span>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    @if ($user->role_id == 2)
                                        <a href="{{route('makesuperadmin',$user->id)}}" role="button" class="btn btn-sm btn-primary"
                                            title="make user super admin">Make Super Admin</a>
                                        <a href="{{route('removeadmin',$user->id)}}" role="button" class="btn btn-sm btn-danger"
                                            title="remove from admin">Remove admin</a>
                                    @endif
                                    @if ($user->role_id == 3)
                                        <a href="{{route('makeadmin',$user->id)}}" role="button" class="btn btn-sm btn-primary"
                                            title="make user admin">Make Admin</a>
                                    @endif
                                    @if ($user->role_id == 1)
                                        <a href="{{route('removesuperadmin',$user->id)}}" role="button" class="btn btn-sm btn-danger"
                                            title="remove from super admin">Remove super admin</a>
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
