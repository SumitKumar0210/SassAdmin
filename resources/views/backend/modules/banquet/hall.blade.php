@extends('backend.layouts.main')
@section('title','Banquet Hall')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6 p-0">
                    <h3>Hall</h3>
                </div>
                @if(in_array('Banquet Hall Add', (explode(',',auth()->user()->permission))))
                <div class="col-12 col-sm-6 p-0 text-end">
                     <button class="btn btn-primary btn-sm addNewHall" type="button" data-bs-toggle="modal" data-bs-target="#addHall"><i class="ri-add-line"></i> Add New Hall</button>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-lg-12 col-sm-12">
          <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="hover row-border stripe" id="hall_table">
                    <thead>
                      <tr>
                        <th>Hall Name</th>
                        <th>Capacity</th> 
                        <th>Area</th>
                        <th>Setup Time</th>
                        <th>Rate</th>
                        <th>No of Rooms</th>
                        <th>Features</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<!-- Create hall modal start-->
<div class="modal fade" id="addHall" tabindex="-1" aria-labelledby="addHallLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5 fw-semibold" id="addHallLabel">Create New Hall</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="hall_form" class="g-3 needs-validation" novalidate="">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <input type="hidden" id="hall_id">
              <label class="form-label" for="hallname">Hall Name</label>
              <input class="form-control" id="hallname" type="text" placeholder="Hall Name" style="background-image: none;" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label" for="capacity">Capacity</label>
              <input class="form-control" id="capacity" type="number" placeholder="Capacity" style="background-image: none;" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label" for="area">Area</label>
              <input class="form-control" id="area" type="text" placeholder="Area" style="background-image: none;" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label" for="setup-time">Setup Time</label>
              <input class="form-control" id="setup-time" type="text" placeholder="Setup Time" style="background-image: none;" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label" for="rate">Rate</label>
              <input class="form-control" id="rate" type="number" placeholder="Rate" style="background-image: none;" required>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label" for="no_of_rooms">No Of Complimentary Rooms</label>
              <input class="form-control" id="no_of_rooms" type="number" placeholder="No Of Complimentary Rooms" style="background-image: none;" required>
            </div>
            <div class="col-md-12 mb-3 main-icon-checkbox">
              <label class="form-label d-block" for="rooms">Features</label>
              <ul class="checkbox-wrapper mt-2">
                @foreach ($features as $item)
                  <li> 
                    <input class="form-check-input" id="checkbox-icon{{$item->id}}" type="checkbox" name="features[]" value="{{$item->id}}">
                    <label class="form-check-label" for="checkbox-icon{{$item->id}}"><i class="{{$item->icon}}"> </i><span>{{$item->name}} </span></label>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary hallSubmit">Create</button>
          <button type="button" class="btn btn-primary hallUpdate d-none" onclick="hallUpdate(document.getElementById('hall_id').value)">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Create hall modal end-->
@endsection
@section('extra-js')
<script>
  const hallAdd ="{{ route('hall.store') }}";
  const hallView ="{{ route('hall.view') }}";
  const hallSwitchStatus ="{{ route('hall.switch') }}";
  const hallGetData ="{{ route('hall.getData') }}";
  const hallDataUpdate ="{{ route('hall.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/banquet/hall.js')}}"></script>
@endsection