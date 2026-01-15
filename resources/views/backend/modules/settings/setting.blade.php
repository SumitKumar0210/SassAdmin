@extends('backend.layouts.main')
@section('title','Setting')
@section('main-container')
<div class="page-body">
    
    <!-- Container-fluid starts-->
    <div class="container-fluid py-3">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                <div class="col-xl-2 box-col-6">
                    @include('backend.layouts.sidebar_setting')
                </div>
                <div class="col-xl-10 col-md-12 box-col-12">
                    <div class="tab-content tabs-links">
                        <div class="tab-pane fade active show " id="pills-genral-setting" role="tabpanel" aria-labelledby="pills-genral-setting-tab">
                            <div class="card">
                                <div class="container-fluid">
                                    <form method="POST" id="hotlr_setting_form">
                                        <div class="row gy-3 p-4 mt-0">
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_name">Name <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_name" type="text" placeholder="Name" value="{{$hotlr[0]->name}}" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_gst">GST <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_gst" type="text" placeholder="GST" maxlength="15" value="{{$hotlr[0]->gst}}" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_email">Email </label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_email" type="text" placeholder="Email" value="{{$hotlr[0]->email}}" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_contact">Contact Number </label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_contact" type="number" placeholder="Contact Number" value="{{$hotlr[0]->mobile}}" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_address">Address </label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_address" type="text" placeholder="Address" value="{{$hotlr[0]->address}}" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_city">City </label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_city" type="text" placeholder="City" value="{{$hotlr[0]->city}}" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_state">State </label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_state" type="text" placeholder="State" value="{{$hotlr[0]->state}}" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_zipcode">Zip Code </label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_zipcode" type="number" placeholder="Zip code" value="{{$hotlr[0]->pincode}}" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_country">Country </label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_country" type="text" placeholder="Country" value="{{$hotlr[0]->country}}" required>
                                            </div>
                                            
                                            <div class="col-md-6 ">
                                                <label class="form-label" for="setting_hotlr_website">Website</label>
                                                <input class="form-control form-control-sm" id="setting_hotlr_website" type="text" placeholder="Site url" value="{{$hotlr[0]->website}}">
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <div class="">
                                                    <label class="form-label" for="hotlr-upload-logo">Upload logo </label>
                                                    <input class="form-control" type="file" aria-label="file example" id="hotlr-upload-logo" accept="image/*">
                                                </div>
                                                <div class="theme-logo">
                                                    <div id="logo-img"><img alt="" src="{{ asset('backend/'.$hotlr[0]->logo.'')}}" style="width: 150px; max-height: 60px; object-fit: contain;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-end">
                                                <button type="submit" class="btn btn-primary"> Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="fade tab-pane" id="pills-social-media" role="tabpanel" aria-labelledby="pills-social-media-tab">
                            <div class="card">
                                <div class="container-fluid">
                                    <form method="POST" id="hotlr_einvoice_form">
                                        <div class="row gy-3 p-4 mt-0">
                                            <div class="col-md-6">
                                                <label class="form-label" for="hotlr_einvoice_email">Email <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="hotlr_einvoice_email" type="text" placeholder="Enter Email" value="{{$hotlr[0]->einvoice_email}}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="hotlr_einvoice_username">Username <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="hotlr_einvoice_username" type="text" placeholder="Enter Username" value="{{$hotlr[0]->einvoice_username}}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="hotlr_einvoice_password">Password <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="hotlr_einvoice_password" type="password" placeholder="Enter Password" value="{{$hotlr[0]->einvoice_password}}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="hotlr_einvoice_ipaddress">IP Address <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="hotlr_einvoice_ipaddress" type="text" placeholder="Enter IP Address" value="{{$hotlr[0]->einvoice_ipaddress}}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="hotlr_einvoice_clientid">Client Id <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="hotlr_einvoice_clientid" type="text" placeholder="Enter Client Id" value="{{$hotlr[0]->einvoice_clientid}}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="hotlr_einvoice_clientsecret">Client Secret <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="hotlr_einvoice_clientsecret" type="text" placeholder="Enter Client Secret" value="{{$hotlr[0]->einvoice_clientsecret}}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="hotlr_einvoice_gst">GST <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" id="hotlr_einvoice_gst" type="text" placeholder="Enter Client Secret" maxlength="15" value="{{$hotlr[0]->einvoice_gst}}" required>
                                            </div>
                                            <div class="col-md-12 text-end">
                                                <button type="submit" class="btn btn-primary "> Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="fade tab-pane" id="pills-theme-setup" role="tabpanel" aria-labelledby="pills-theme-setup-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card height-equal">
                                            <div class="card-header card-no-border pb-0">
                                                <h3>Audit Time Setting</h3>
                                            </div>
                                            <div class="card-body">
                                                <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                                    <div class="col-4">
                                                        <label class="form-label" for="audit_start_general_setting">Start Time</label>
                                                        <input class="form-control" id="audit_start_general_setting" type="time" required="" onchange="chkTime()" value="{{$hotlr[0]->audit_start}}">
                                                        <div class="invalid-feedback">Please enter start time </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="audit_end_general_setting">End Time</label>
                                                        <input class="form-control" id="audit_end_general_setting" type="time"required="" onchange="chkTime()" value="{{$hotlr[0]->audit_end}}">
                                                        <div class="invalid-feedback">Please enter end time </div>
                                                    </div>
                                                    <div class="col-4 d-none">
                                                        <label class="form-label" for="audit_duration_general_setting">Duration</label>
                                                        <input class="form-control" id="audit_duration_general_setting_view" type="text" readonly>
                                                        <input class="form-control" id="audit_duration_general_setting" type="hidden" value="{{$hotlr[0]->duration}}" >
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-primary mt-4" type="button" onclick="updateAuditTime()">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card height-equal">
                                            <div class="card-header card-no-border pb-0">
                                                <h3>Invoice Setting</h3>
                                            </div>
                                            <div class="card-body">
                                                <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                                    <div class="col-4">
                                                        <label class="form-label" for="invoice_prefix_general_setting">Prefix</label>
                                                        <input class="form-control" id="invoice_prefix_general_setting" type="text" placeholder="Prefix" required="" value="{{$prefix}}">
                                                        <div class="invalid-feedback">Please enter prefix </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="invoice_suffix_general_setting">Suffix Length</label>
                                                        <input class="form-control" id="invoice_suffix_general_setting" type="number" placeholder="Enter Suffix Length" required="" value="{{$suffix_length}}">
                                                        <div class="invalid-feedback">Please enter suffix length </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-primary mt-4" type="button" onclick="updateInvoiceSettingDetail()">Submit</button>
                                                    </div>
                                                </form>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="f-m-light mt-1">Reset Button will Reset the Invoice Number</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-primary mt-4" type="button" onclick="resetInvoiceNumber()">Reset Invoice</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fade tab-pane" id="pills-theme-setup-sound" role="tabpanel" aria-labelledby="pills-theme-setup-sound-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card height-equal">
                                            <div class="card-header card-no-border pb-0">
                                                <h3>Add Item Sound Setting</h3>
                                            </div>
                                            <div class="card-body">
                                                <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="" method="POST" id="hotlr_add_item_sound_form">
                                                    <div class="col-4">
                                                        <audio controls>
                                                            <source src="{{ asset('backend/uploads/tone/'.$hotlr[0]->item_add.'')}}" type="audio/mpeg">
                                                            <source src="{{ asset('backend/uploads/tone/'.$hotlr[0]->item_add.'')}}" type="audio/ogg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="hotlr-upload-item-add">Upload Item Add Sound </label>
                                                        <input class="form-control" type="file" aria-label="file example" id="hotlr-upload-item-add" accept="audio/*">
                                                        <div class="invalid-feedback">Please enter end time </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-primary mt-4" type="submit">Update</button>
                                                        <button class="btn btn-danger mt-4" type="button" onclick="resetMuteSound(`add_item`,`reset`)">Reset</button>
                                                        <button class="btn btn-dark mt-4" type="button" onclick="resetMuteSound(`add_item`,`mute`)">@if($hotlr[0]->add_item_status == 1)Mute @else Unmute @endif</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card height-equal">
                                            <div class="card-header card-no-border pb-0">
                                                <h3>Notification Sound Setting</h3>
                                            </div>
                                            <div class="card-body">
                                                <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="" method="POST" id="hotlr_notification_sound_form">
                                                    <div class="col-4">
                                                        <audio controls>
                                                            <source src="{{ asset('backend/uploads/tone/'.$hotlr[0]->notification.'')}}" type="audio/mpeg">
                                                            <source src="{{ asset('backend/uploads/tone/'.$hotlr[0]->notification.'')}}" type="audio/ogg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="hotlr-upload-notification-sound">Upload Notification Sound </label>
                                                        <input class="form-control" type="file" aria-label="file example" id="hotlr-upload-notification-sound" accept="audio/*">
                                                        <div class="invalid-feedback">Please enter suffix length </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-primary mt-4" type="submit">Update</button>
                                                        <button class="btn btn-danger mt-4" type="button" onclick="resetMuteSound(`notification`,`reset`)">Reset</button>
                                                        <button class="btn btn-dark mt-4" type="button" onclick="resetMuteSound(`notification``mute`)">@if($hotlr[0]->notification_status == 1)Mute @else Unmute @endif</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fade tab-pane" id="pills-theme-setup-time" role="tabpanel" aria-labelledby="pills-theme-setup-time-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card height-equal">
                                            <div class="card-header card-no-border pb-0">
                                                <h3>Add Time Setting</h3>
                                            </div>
                                            <div class="card-body">
                                                @php
                                                    $timezone_identifiers = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                                @endphp
                                                <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="" method="POST" id="hotlr_add_time_form">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label" for="general_setting_timezone">Select Zone</label>
                                                        <select class="form-select form-select-sm" id="general_setting_timezone" onChange="checkTimeZone(this.value)">
                                                            <option value="">Select</option>
                                                            @foreach($timezone_identifiers as $identifier)
                                                            <option value="{{$identifier}}">{{$identifier}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="timezone_class"></div>
                                                    </div>
                                                    <div class="col-2 time-setting d-none">
                                                        <label> Checkout Format </label>
                                                    </div>
                                                    <div class="col-10 time-setting d-none">
                                                        <label class="form-label"> 24 Hours</label>
                                                        <div class="form-check form-switch form-check-inline">
                                                            <input class="form-check-input" id="general_setting_time_slot" type="checkbox" role="switch">
                                                        </div> <label class="form-label"> Fixed Time </label>
                                                    </div>
                                                    <div class="col-6 mb-3 time-setting-slot d-none">
                                                        <label class="form-label" for="general_setting_checkout_time">Checkout Time</label>
                                                        <input class="form-control" id="general_setting_checkout_time" type="time" placeholder="Enter Checkout Time">
                                                    </div>
                                                    <div class="col-md-6 mb-3 time-setting-slot d-none">
                                                        <label class="form-label" for="general_setting_checkout_buffer">Checkout Time Buffer Hours</label>
                                                        <select class="form-select form-select-sm" id="general_setting_checkout_buffer">
                                                            <option value="">Select Hour</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                        </select>
                                                        <div class="general_setting_checkout_buffer_class"></div>
                                                    </div>
                                                    <div class="col-6 mb-3 time-setting-slot d-none">
                                                        <label class="form-label" for="general_setting_checkin_time">Checkin Time</label>
                                                        <input class="form-control" id="general_setting_checkin_time" type="time" placeholder="Enter Checkout Time">
                                                    </div>
                                                    <div class="col-2 time-setting-slot d-none">
                                                        <label class="form-label"> Early Checkin </label>
                                                        <div class="flex-grow-1 icon-state switch-outline">
                                                            <label class="form-label"> No </label>
                                                            <label class="switch mb-0">
                                                                <input type="checkbox" id="general_setting_early_checkin"><span class="switch-state bg-success"></span>
                                                            </label>
                                                            <label class="form-label"> Yes </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3 general_setting_early_checkin_para d-none">
                                                        <label class="form-label" for="general_setting_early_checkin_buffer">Early Checkin Buffer</label>
                                                        <select class="form-select form-select-sm" id="general_setting_early_checkin_buffer">
                                                            <option value="">Select Hour</option>
                                                            <option value="2">-2</option>
                                                            <option value="3">-3</option>
                                                            <option value="4">-4</option>
                                                        </select>
                                                        <div class="general_setting_early_checkin_buffer_class"></div>
                                                    </div>
                                                    <div class="col-12 time-setting">
                                                        <button class="btn btn-primary" type="submit">Update</button>
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
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
@section('extra-js')
<script>
    const settingAdd = "{{ route('setting.store') }}";
    const settingAddSound = "{{ route('setting.addSound') }}";
    const settingAddEinvoice = "{{ route('setting.storeEInvoice') }}";
    const updateInvoiceGeneralSetting = "{{ route('general-setting-invoice.updateInvoice') }}";
    const resetInvoice = "{{ route('general-setting-invoice-reset.resetInvoiceNumber') }}";
    const updateAuditSetting = "{{ route('audit-setting-update') }}";
    const settingTimeConfiguration = "{{ route('setting.storeTimeConfiguration') }}";
    const settingTimeConfigurationResetMute = "{{ route('setting.soundUpdateResetMute') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/setting.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/setting/general_setting.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/setting/audit.js')}}"></script>
@endsection