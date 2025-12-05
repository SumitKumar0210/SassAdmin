@extends('backend.layouts.main')
@section('main-container')
<div class="page-body">
    <!-- Container-fluid starts-->
    <!-- Container-fluid starts-->
        <div class="container-fluid my-5">
            <div class="email-wrap bookmark-wrap">
                <div class="row">
                    <div class="col-xl-3 box-col-6">
                    <div class="email-app-sidebar tabs-links p-3">
                        <ul class="nav main-menu side-nav-links" role="tablist">
                            <li class="mb-3"><a class="btn-light active" id="pills-created-profile-tab" data-bs-toggle="pill" href="#pills-created-profile" role="tab" aria-controls="pills-created-profile" aria-selected="true"><span class="title text-capitalize">Profile</span></a></li>
                            <li><a class="show btn-light" id="pills-change-pass-tab" data-bs-toggle="pill" href="#pills-change-pass" role="tab" aria-controls="pills-change-pass" aria-selected="false"><span class="title text-capitalize">Change Password</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-12 box-col-12">
                        <div class="tab-content ">
                            <div class="tab-pane fade active show" id="pills-created-profile" role="tabpanel" aria-labelledby="pills-created-profile-tab">
                                <div class="container-fluide tabs-links p-3">
                                    <div class="row p-3 mt-3">
                                        <div class="col-md-2">
                                            <div class="user-profile-image">
                                                <div id="preview"><img alt="" src="backend/assets/images/user/2.png" class="rounded-circle border p-1"></div>
                                                <div class="icon-wrapper profile-img-icon border"><i class="ri-camera-line"></i></div>
                                                <input class="updateimg rounded-circle border p-1" type="file" name="img" onchange="readURL(this,0)" id="imageUpload" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row gy-3">
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="first-name">First Name </label>
                                                    <input class="form-control form-control-sm" id="first-name" type="text" placeholder="First Name" >
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="last-name">Last Name </label>
                                                    <input class="form-control form-control-sm" id="last-name" type="text" placeholder="Last Name" >
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="last-name">User Name </label>
                                                    <input class="form-control form-control-sm" id="last-name" type="text" placeholder="User Name" >
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="last-name">Designation</label>
                                                    <select class="form-select form-select-sm">
                                                        <option selected="">Super Admin</option>
                                                        <option>Hotel Manager</option>
                                                        <option>Front Desk</option>
                                                        <option>Reservation Agent</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="last-name">Country </label>
                                                    <input class="form-control form-control-sm" id="Country" type="text" placeholder="Country" >
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="state">State </label>
                                                    <input class="form-control form-control-sm" id="state" type="text" placeholder="State" >
                                                </div>
                                                <div class="col-md-6 ">
                                                <label class="form-label" for="city">City </label>
                                                    <input class="form-control form-control-sm" id="city" type="text" placeholder="City" >
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="email">Email </label>
                                                    <input class="form-control form-control-sm" id="email" type="text" placeholder="Email" >
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="Contact Number">Contact Number </label>
                                                    <input class="form-control form-control-sm" id="Contact Number" type="number" placeholder="Contact Number" >
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label class="form-label" for="last-name">Status </label>
                                                    <select class="form-select form-select-sm">
                                                        <option selected="">Active</option>
                                                        <option>In-active</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label" for="Address">Address</label>
                                                    <textarea class="form-control form-control-sm" id="Address" rows="3"></textarea>
                                                </div>
                                                <div class="col-md-12 text-end">
                                                    <button type="submit" class="btn btn-primary "> Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fade tab-pane" id="pills-change-pass" role="tabpanel" aria-labelledby="pills-change-pass-tab">
                                <div class="container-fluide ">
                                    <div class="row">
                                        <div class="col-md-6 tabs-links p-4 mx-3">
                                            <div class="row gy-3">
                                                <div class="col-md-12 ">
                                                    <label class="form-label" for="first-name">Old Password </label>
                                                    <input class="form-control form-control-sm" id="first-name" type="password" placeholder="Old Password" >
                                                </div>
                                                <div class="col-md-12 ">
                                                    <label class="form-label" for="last-name">New Password </label>
                                                    <input class="form-control form-control-sm" id="last-name" type="password" placeholder="New Password " >
                                                </div>
                                                <div class="col-md-12 ">
                                                    <label class="form-label" for="last-name">Confirm New Password </label>
                                                    <input class="form-control form-control-sm" id="last-name" type="password" placeholder="Confirm New Password" >
                                                </div>
                                                <div class="col-md-12 text-end">
                                                    <button type="submit" class="btn btn-primary "> Save</button>
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
    <!-- Container-fluid end-->
</div>
@endsection