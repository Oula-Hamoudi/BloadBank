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
                value="{{ old('district', $user->profile->district) }}" >
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6 col-sm-6">
            <label for="thana">Thana:</label>
            <input type="text" name="thana" class="form-control" id="thana"
                value="{{ old('thana', $user->profile->thana) }}" >
        </div>

        <div class="form-group col-md-6 col-sm-6">
            <label for="postOffice">Post office:</label>

            <input type="text" name="postOffice" class="form-control" id="postOffice"
                value="{{ old('postOffice', $user->profile->postOffice) }}" >
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6 col-sm-6">
            <label for="">Post code:</label>
            <input type="text" value="{{ old('postCode', $user->profile->postCode) }}"
                name="postCode" class="form-control" id="postCode" >
        </div>
    </div>

</div>
