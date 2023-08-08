<x-backend.layouts.master>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Blood Requests</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Blood Reqeusts</li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
        <x-utilities.form.errors/>
        <x-utilities.form.success/>
        <!-- form-group // -->

    </div>


    <div class="card mb-4">
        <div class="card-header">

            <div class="row">
                <div class="col-9">
                    <i class="fas fa-table me-1"></i>
                    Edit
                </div>
                
            </div>
        </div>
        <div class="card-body">
          
        <div class="row centered-form justify-content-center">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <div class="panel panel-primary">
                    
                    <div class="panel-body">
                      

                        <form method="POST" action="{{route('blood-update',$request->id)}}" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label class="control-label text-primary">Patient Name</label>
                                <input type="text" placeholder="Patient Name" name="patient_name" 
                                    id="NAME" class="form-control input-sm" value="{{old('patient_name',$request->patient_name)}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label text-primary">Need Unit Of Blood (bags)</label>
                                <input type="number"  name="blood_unit" id="BUNIT" class="form-control"
                                    placeholder="Insert No Of Unit" value="{{old('blood_unit',$request->blood_unit)}}">
                            </div>
                            <div class="form-group">
                                <label for="hosptName" class="control-label text-primary">Hospital Name</label>
                                <input type="text" class="form-control" name="hospital_name" id="hosptName"
                                    placeholder="Ex: Lab-8,Uttara" value="{{old('hospital_name',$request->hospital_name)}}" >
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="division" class="text-primary">Division:</label>
                                        <input type="text" name="division" id="division" class="form-control" 
                                            value="{{ old('division', $request->division) }}">
                                    </div>
                            
                                    <div class="form-group col-md-6 col-sm-6 ">
                                        <label for="district" class="text-primary">District:</label>
                            
                                        <input type="text" name="district" class="form-control" id="district"
                                            value="{{ old('district', $request->district) }}" >
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="thana">Thana:</label>
                                        <input type="text" name="thana" class="form-control" id="thana"
                                            value="{{ old('thana', $request->thana) }}" >
                                    </div>
                            
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="postOffice" class="text-primary">Post office:</label>
                            
                                        <input type="text" name="postOffice" class="form-control" id="postOffice"
                                            value="{{ old('postOffice', $request->postOffice) }}" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="postCode" class = "text-primary" >Post code:</label>
                                        <input type="text" value="{{ old('postCode', $request->postCode) }}"
                                            name="postCode" class="form-control" id="postCode" >
                                    </div>
                                </div>
                            
                            </div>

                            <div class="form-group">
                                <label class="control-label text-primary">When </label>
                                <input type="date" class="form-control "
                                    name="require_date" id="RDATE" value="{{$request->require_date}}" >
                            </div>

                            <div class="form-group">
                                <label class="control-label text-primary" for="contact-name">Contact Name</label>
                                <input type="text" placeholder="Contact Name" class="form-control input-sm"
                                    name="contact_name" id="contact-name" value="{{$request->contact_name}}" >
                            </div>

                            <div class="form-group">
                                <label class="control-label text-primary">Email ID</label>
                                <input type="email" placeholder="Contact Email" class="form-control input-sm"
                                    name="email" id="EMAIL" value="{{$request->email}}" >
                            </div>
                            <div class="form-group">
                                <label class="control-label text-primary">Contact No-1</label>
                                <input type="text" placeholder="Contact Number" class="form-control input-sm"
                                    name="phone" id="CON1" value="{{$request->phone}}" >
                            </div>
        
                            <div class="form-group">
                                <label class="control-label text-primary">Additional Information:</label>
                                <textarea  name="additional" id="CADDRESS" rows="5" style="resize:none;" class="form-control"
                                    placeholder="Additional info..." >{{$request->additional}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label text-primary">Reason For Blood</label>
                                <textarea  name="reason" id="REASON" rows="5" style="resize:none;" class="form-control"
                                    placeholder="Reason For Blood" id="REASON" >{{$request->reason}}</textarea>
                            </div>
                           


                            <div class="form-group">
                                <button class="btn btn-primary w-100" id="BTN" name="submit">
                                    Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</x-backend.layouts.master>
