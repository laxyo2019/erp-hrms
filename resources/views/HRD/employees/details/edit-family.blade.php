<div>
<form action="{{route('update.familydetails', $family->id)}}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
   <div class="col-6 form-group">
		<label for="">Name</label>
		<input type="text" class="form-control" name="name"
		value="{{!empty($family->name) ? $family->name : ''}}">
		@error('name')
          <span class="text-danger" role="alert">
            <strong>* {{ $message }}</strong>
          </span>
      	@enderror
	</div>
    <div class="col-6 form-group">
		<label for="">Relation</label>
		<input type="text" class="form-control" name="relation"
		value="{{!empty($family->relation) ? $family->relation : ''}}">
		@error('relation')
          <span class="text-danger" role="alert">
            <strong>* {{ $message }}</strong>
          </span>
      	@enderror
	</div>
	<div class="col-6 form-group">
		<label for="">Aadhar ID</label>
		<input type="text" class="form-control" name="aadhar_id"
		value="{{!empty($family->aadhar_id)}}">
		@error('aadhar_id')
          <span class="text-danger" role="alert">
            <strong>* {{ $message }}</strong>
          </span>
      	@enderror
	</div>
    <div class="col-6 form-group">
    	<label for="">Upload Documents</label>
    	<input type="file" name="file_path" id="file_path" value="">
    	@error('file_path')
			<span class="text-danger" role="alert">
				<strong> {{ $message }}</strong>
			</span>
		@enderror
    </div>
</div>
<div class="col-12 form-group text-center"><br>
	<button class="btn btn-info btn-sm" style="width: 20%">Save</button>
	<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
</div>
<input type="hidden" id="form_type" value="familydetails">
</form>
</div>