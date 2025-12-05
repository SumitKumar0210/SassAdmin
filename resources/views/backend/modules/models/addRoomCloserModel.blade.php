<div class="modal fade" id="roomCloser" tabindex="-1" role="dialog" aria-labelledby="roomCloser" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title">Room Closure</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="room_closure">
                    <div class="modal-body">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="roomnum_closure">Room</label>
                            <select class="form-select form-select-sm mb-3" onchange="getRoomCategory(this.value)">
                                <option value="">Select</option>
                                @foreach ($roomDetails as $roomCategory)
                                    <option value="{{ $roomCategory['id'] }}">{{ $roomCategory['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="room-closure-room-list d-none">
                                <ul class="checkbox-wrapper room-closure-room-list-item"></ul>
                            </div>
                            <div class="roomnum_closure_class"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" for="start-date">Start Date</label>
                                <div
                                    class="input-group flatpicker-calender border px-2 d-flex align-items-center border-radius-4">
                                    <span class="text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                    <input class="form-control form-control-sm border-0" id="startdate_closure"
                                        type="date" value="2023-05-03">
                                </div>
                            </div>
                            <div class="col-md-6 d-none">
                                <label class="form-label" for="end-date">End Date</label>
                                <div
                                    class="input-group flatpicker-calender border px-2 d-flex align-items-center border-radius-4">
                                    <span class="text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                    <input class="form-control form-control-sm border-0" id="enddate_closure"
                                        type="date" value="2023-05-03">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="reason_closure">Reason For Closure</label>
                            <select class="form-select form-select-sm" id="reason_closure" oninput="validateField('#reason_closure','select','.reason_closure_class')">
                                <option value="">Select</option>
                                @foreach($closerReasons as $reason)
                                    <option value="{{$reason['id']}}">{{$reason['name']}}</option>
                                @endforeach
                            </select>
                            <div class="reason_closure_class mb-3"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="Description">Description</label>
                                <textarea class="form-control form-control-sm" id="desc_closure" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between flex-nowrap">
                        <button class="btn btn-outline-secondary w-50" type="button"
                            data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary w-50" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>