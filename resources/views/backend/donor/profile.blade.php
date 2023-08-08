<x-backend.layouts.master>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.min.css"
        integrity="sha512-Yn5Z4XxNnXXE8Y+h/H1fwG/2qax2MxG9GeUOWL6CYDCSp4rTFwUpOZ1PS6JOuZaPBawASndfrlWYx8RGKgILhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js"></script>
    @if (Session::has('message'))
        <script>
            $(document).ready(function() {
                Swal.fire(
                    'Success!',
                    'Successfully Updated!',
                    'success'
                )
            });
        </script>
        {{-- <p class="alert alert-info">{{ Session::get('message') }}</p> --}}
    @endif
    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }
    </style>

    <div class="container rounded bg-white mb-5">
        @foreach ($errors->all() as $error)
            <li class="alert alert-danger">{{ $error }}</li>
        @endforeach
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img id="profileImage" class="rounded-circle mt-5" width="150px"
                 
                    src="{{ asset('storage/users/profile/' . $user->profile->profile_image) }}">
                  
                   
                        
                    <div class="d-flex">
                        <h6>{{ $user->name }} <span class="badge bg-danger">{{ $user->blood_group }}</span></h6>
                    </div>


                    <span class="font-weight-bold">Age: {{ $user->age($user->profile->dob) }}</span>



                    <span class="font-weight-bold">Last Donated:
                        {{ \Carbon\Carbon::parse($user->last_donated)->format('d/m/Y') }}</span>

                    <span class="text-black-50">{{ $user->email }}</span>
                    <span> </span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <span class="fw-light text-decoration-underline m-2">Personal Information:</span>
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" value="{{ old('name', $user->name) }}" class="form-control"
                                id="name" name="name" required>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 mb-2">
                                <label for="father">Fathers' Name: <span class="lead fs-6">(optional)</span></label>
                                <input type="text" value="{{ old('father', $user->profile->father) }}"
                                    class="form-control" id="father" name="father">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="mother">Mothers' Name:<span class="lead fs-6">(optional)</span></label>
                                <input type="text" value="{{ old('mother', $user->profile->mother) }}"
                                    name="mother" class="form-control" id="mother">
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-6 mb-2">
                                <label for="gender">Gender</label>
                                <select id="gender" class="form-control" name="gender">
                                    <option selected>Choose...</option>
                                    <option value="Male" {{ $user->profile->gender === 'Male' ? 'Selected' : '' }}>
                                        Male</option>
                                    <option value="Female" {{ $user->profile->gender === 'Female' ? 'Selected' : '' }}>
                                        Female</option>
                                    <option value="Other" {{ $user->profile->gender === 'Other' ? 'Selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>
                        </div>

                        <span class="fw-light text-decoration-underline m-2">Present Address:</span>
                        <div class="row">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="division">Division:</label>
                                    <input type="text" name="division" id="division" class="form-control" required
                                        value="{{ old('division', $user->profile->division) }}">
                                </div>

                                <div class="form-group col-md-6 col-sm-6 ">
                                    <label for="district">District:</label>

                                    <input type="text" name="district" class="form-control" id="district"
                                        value="{{ old('district', $user->profile->district) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="thana">Thana:</label>
                                    <input type="text" name="thana" class="form-control" id="thana"
                                        value="{{ old('thana', $user->profile->thana) }}" required>
                                </div>

                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="postOffice">Post office:</label>

                                    <input type="text" name="postOffice" class="form-control" id="postOffice"
                                        value="{{ old('postOffice', $user->profile->postOffice) }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="">Post code:</label>
                                    <input type="text" value="{{ old('postCode', $user->profile->postCode) }}"
                                        name="postCode" class="form-control" id="postCode" required>
                                </div>
                            </div>

                        </div>
                        <span class="fw-light text-decoration-underline m-2"></span>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone"
                                    value="{{ old('phone', $user->profile->phone) }}" name="phone" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone2">Phone 2 <span class="lead fs-6">(optional)</span></label>
                                <input type="tel" class="form-control" id="phone2"
                                    value="{{ old('phone', $user->profile->phone2) }}" name="phone2">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email"
                                value="{{ old('email', $user->email) }}" name="email" required>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3">
                                <label for="formFile" class="form-label">Profile Image</label>
                                <input class="form-control" name="profile_image"
                                    value="{{ old('profile_image', $user->profile->profile_image) }}" type="file"
                                    id="formFile">
                            </div>
                        </div>

                        <div class="row">
                            <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                        </div>


                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">

                    <div class="d-flex justify-content-between align-items-center experience">
                        <span>Donation Status: </span>
                        @if (!$user->status == 3)
                            <a href=" {{ route('donationStatusChange') }} " class="btn btn-sm btn-success">Active</a>
                        @elseif($user->status == 3)
                            <a href=" {{ route('donationStatusChange') }} "
                                class="btn btn-sm btn-danger">Deactive</a>
                        @else
                            <span class="badge bg-warning">Busy</span>
                        @endif

                    </div>

                    <br>
                    <form action="{{ route('donation.update') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4 col-sm-12">
                                <label class="labels" for="totalDonated">Total Donated</label>
                                <input type="number" onkeyup="changeDateValue()" onchange="changeDateValue()"
                                    id="totalDonated" name="total_donated" class="form-control"
                                    placeholder="experience"
                                    value="{{ old('total_donated', $user->total_donated) }}">
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <label class="labels" for="lastDonated">Last Donated at</label>
                                <input type="date" class="form-control" id="lastDonated" name="last_donated"
                                    placeholder="additional details"
                                    value="{{ old('last_donated', $user->last_donated ) }}">
                            </div>
                        </div>
                        <div class="row">
                            <button class="btn btn-primary profile-button">Update</button>
                        </div>
                    </form>
                    <form action="{{ route('change.password') }}" method="POST">
                        @csrf
                        <p class="mt-3"> <b> Change Password</b></p>
                        <div class="row mb-3">
                            <div class="col-md-12 col-sm-12">
                                <label class="form-label">Old Password</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password"
                                    value="{{ old('new_password') }}">
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password"
                                    value="{{ old('confirm_password') }}">
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary profile-button">Change Password</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function changeDateValue() {
            document.getElementById('lastDonated').value = '';
        }
    </script>

</x-backend.layouts.master>
