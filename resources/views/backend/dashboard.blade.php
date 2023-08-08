<x-backend.layouts.master>

    @if ($ongoing)
        <marquee width="max-width:250px" style="background-color: bisque"> <a href="{{route('donor-blood-reqs')}}">!!You have a ongoing donation activity!!</a> </marquee>
    @endif


    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        @if (auth()->user()->isAdmin() ||
            auth()->user()->isSuperAdmin())
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <p>Blood request Pending</p>
                            <span>{{$bloodRequests ?? "No requests"}}</span>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{route('request.notApproved')}}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            <p>Donor Signup Request</p>
                            <span>{{$signupRequests}}</span>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{route('donor-request')}}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            <p class="text-center my-0 fw-bold">{{ date('Y-m-d') }}</p>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Total Donors</td>
                                        <td>:</td>
                                        <td>{{$totalDonors}}</td>
                                    </tr>
                                    <tr>
                                        <td>Available Donors</td>
                                        <td>:</td>
                                        <td>{{$availableDonors}}</td>
                                    </tr>
                                    <tr>
                                        <td>Blood Seekers</td>
                                        <td>:</td>
                                        <td>{{$bloodRequests}}</td>
                                    </tr>


                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        @endif





    </div>


    <script src="{{asset('backend/js/bootstrap.bundle.min')}}" crossorigin="anonymous"></script>



</x-backend.layouts.master>
