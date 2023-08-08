
<x-frontend.layouts.master>


    <div class="container-fluid mt-4 mb-4" style="max-width: 700px">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <legend class="fw-bold">Sign Up!</legend>
                </div>


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
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <span class="fw-light text-decoration-underline m-2">Personal Information:</span>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" value="{{ old('name') }}" class="form-control" id="name" name="name"
                            required>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="father">Fathers' Name: <span class="lead fs-6">(optional)</span></label>
                            <input type="text" value="{{ old('father') }}" class="form-control" id="father"
                                name="father">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mother">Mothers' Name:<span class="lead fs-6">(optional)</span></label>
                            <input type="text" value="{{ old('mother') }}" name="mother" class="form-control"
                                id="mother">
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="dob">Date of birth:</label>
                            <input type="date" value="{{ old('dob') }}" class="form-control" name="dob" id="dob"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="gender">Gender</label>
                            <select id="gender" class="form-control" name="gender">
                                <option selected>Choose...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bl">Blood Group</label>
                            <select id="bl" class="form-control" name="blood_group" required>
                                <option selected>Select one..</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nid">NID Number:</label>
                            <input required type="number" value="{{ old('nid_number') }}" class="form-control"
                                name="nid_number" id="nid" required>
                        </div>

                    </div>
                    <span class="fw-light text-decoration-underline m-2">Present Address:</span>
                    <x-utilities.form.address2/>

                    <span class="fw-light text-decoration-underline m-2"></span>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" value="{{ old('phone') }}" name="phone"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ old('email') }}" name="email"
                            required>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="confirmPassword">Confirm Password:</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="confirmPassword" required>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="form-group">
                            <div class="form-check justify-content-center">
                                <input class="form-check-input" name="terms" checked type="checkbox" value="agree"
                                    id="invalidCheck2" required>
                                <label class="form-check-label" for="invalidCheck2">
                                    I Agree to <a href="{{route('terms')}}">terms and conditions</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <button type="submit" class="btn btn-primary mt-2 w-100">Sign Up</button>
                    </div>


                </form>
            </div>




        </div>
    </div>


</x-frontend.layouts.master>
