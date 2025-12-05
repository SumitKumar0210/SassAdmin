@extends('backend.layouts.main')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Manage Users & Permissions</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="float-end">
                            <button class="btn btn-primary px-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#userAdd"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                Add New User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        {{-- {{ dd(session()->all()) }} --}}

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-stripped">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach ($userdata as $users)
                                        <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$users->name}}</td>
                                        <td>{{$users->email}}</td>
                                        <td>{{$users->mobile}}</td>
                                        <td>
                                            <i class="ri-edit-line" data-bs-toggle="modal"
                                            data-bs-target="#permissionModel{{$users->id}}"></i>&nbsp;&nbsp;
                                            <i class="ri-delete-bin-line" onclick="deleteUser({{$users->id}})"></i>
                                            {{-- Model Body Start --}}
                                            <div class="modal fade" id="permissionModel{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="permissionModel{{$users->id}}"
                                            aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-toggle-wrapper  text-start dark-sign-up">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title bedTypeTitle">Add Room View</h4>
                                                                <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="" class="g-3 p-3 border rounded bg-light shadow-sm">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold" for="user_name{{$users->id}}">User Name</label>
                                                                            <input class="form-control" name="user_name" id="user_name{{$users->id}}" type="text" placeholder="Enter your name"
                                                                                value="{{$users->name}}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold" for="email{{$users->id}}">Email ID</label>
                                                                            <input class="form-control" name="email" id="email{{$users->id}}" type="email" placeholder="Enter your email"
                                                                                value="{{$users->email}}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold" for="mobile{{$users->id}}">Mobile</label>
                                                                            <input class="form-control" name="mobile" id="mobile{{$users->id}}" type="tel" placeholder="Enter your mobile number"
                                                                                value="{{$users->mobile}}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold" for="">Permissions</label><br>
                                                                            @php
                                                                                // Fetch the specific user's permissions
                                                                                $permissions = App\Models\User::find($users->id)->permission ?? '';
                                                                                $per = explode(",", $permissions); // Split the permissions into an array
                                                                            @endphp
                                                                        
                                                                            <div class="form-check">
                                                                                <input 
                                                                                    class="form-check-input" 
                                                                                    type="checkbox" 
                                                                                    name="permission{{$users->id}}[]" 
                                                                                    value="manage_rooms" 
                                                                                    id="manage_rooms{{$users->id}}"
                                                                                    {{ in_array('manage_rooms', $per) ? 'checked' : '' }}>
                                                                                <label class="form-check-label text-info" for="">Manage Rooms</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input 
                                                                                    class="form-check-input" 
                                                                                    type="checkbox" 
                                                                                    name="permission{{$users->id}}[]" 
                                                                                    value="manage_users" 
                                                                                    id="manage_users{{$users->id}}"
                                                                                    {{ in_array('manage_users', $per) ? 'checked' : '' }}>
                                                                                <label class="form-check-label text-info" for="">Manage Users</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                                                                    <button class="btn btn-primary" type="button" onclick="updateUsers({{$users->id}})">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- Model Body End --}}
                                        </td>
                                        </tr>
                                        @php
                                            $i++
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ---------------------------------------------------------- --}}
    <!-- User Add modal start -->
    <div class="modal fade" id="userAdd" tabindex="-1" role="dialog" aria-labelledby="userAdd"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper">
                        <div class="modal-header">
                            <h4 class="modal-title bedTypeTitle">Add New User</h4>
                            <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" id="add_new_user" class="row g-3 p-3 needs-validation" novalidate>
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" for="name_add">Name</label>
                                        <input class="form-control" name="name_add" id="name_add" type="text" placeholder="Enter your name" required>
                                        <div class="invalid-feedback">
                                            Enter Name
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" for="email_add">Email ID</label>
                                        <input class="form-control" name="email_add" id="email_add" type="email" placeholder="Enter your email" required>
                                        <div class="invalid-feedback">
                                            Enter a valid Email ID
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" for="mobile_add">Mobile</label>
                                        <input class="form-control" name="mobile_add" id="mobile_add" type="tel" placeholder="Enter your mobile number" required>
                                        <div class="invalid-feedback">
                                            Enter Mobile
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" for="password_add">Password</label>
                                        <input class="form-control" name="password_add" id="password_add" type="password" placeholder="Enter Password" required>
                                        <div class="invalid-feedback">
                                            Enter Password
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" for="cpassword_add">Confirm Password</label>
                                        <input class="form-control" name="cpassword_add" id="cpassword_add" type="password" placeholder="Enter Confirm Password" required>
                                        <div class="invalid-feedback">
                                            Enter Confirm Password
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" for="permission_add">Permissions</label><br>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permission_add[]" value="manage_rooms" id="manage_rooms">
                                            <label class="form-check-label text-info" for="manage_rooms">Manage Rooms</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permission_add[]" value="manage_users" id="manage_users">
                                            <label class="form-check-label text-info" for="manage_users">Manage Users</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    <!-- User Add modal end-->
    {{-- -------------------------------------------------------------------- --}}
@endsection
@section('extra-js')
<script>
function updateUsers(id) {
        let username = $('#user_name'+id).val();
        let email = $('#email'+id).val();
        let mobile = $('#mobile'+id).val();
        let permission = $('input[name="permission'+id+'[]"]:checked').map(function () {return $(this).val();}).get();
            $.ajax({
                url: '{{ route("permission.update_users") }}', // Define your route name
                type: 'POST',
                data: {
                    id: id,
                    username: username,
                    email: email,
                    mobile: mobile,
                    permission: permission,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                },
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include token in headers
                },
                success: function (response) {
                    alert(response.success); // Show success message
                    location.reload(); // Reload the page or perform any other action
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText); // Log error for debugging
                    alert('Something went wrong! Please try again.');
                }
            });
}

$('#add_new_user').on('submit', function(e) {
    e.preventDefault();
    // Trigger Bootstrap validation
    var form = $(this)[0];
    if (!form.checkValidity()) {
        // If the form is invalid, add Bootstrap 'was-validated' class to show feedback
        form.classList.add('was-validated');
        return; // Stop the form submission if validation fails
    }
    // Get form data
    let name = $('#name_add').val();
    let email = $('#email_add').val();
    let mobile = $('#mobile_add').val();
    let password = $('#password_add').val();
    let cpassword = $('#cpassword_add').val();
    let permission = $('input[name="permission_add[]"]:checked').map(function() {
        return $(this).val();
    }).get();
    // Check if passwords match
    if (password !== cpassword) {
        alert('Password not matched');
        $('#cpassword_add').focus();
        return;
    }
    $.ajax({
        url: "{{route('permission.addNewUser')}}",
        type: "POST",
        data: {
            name: name,
            email: email,
            mobile: mobile,
            password: password,
            permission: permission
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include token in headers
        },
        success: function(response) {
            alert(response.success); // Show success message
            location.reload(); // Reload the page or perform any other action
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); // Log error for debugging
            alert('Something went wrong! Please try again.');
        }
    });
});

function deleteUser(id){
    // Display the confirm box with a message
    const userResponse = confirm("Are you sure you want to proceed?");
    
    // Check the user's response
    if (userResponse) {
        // User clicked 'Ok'
        console.log("User clicked OK.");
        // You can add code to execute upon confirmation
        $.ajax({
            url:"{{route('permission.deleteUser')}}",
            type:"POST",
            data:{id:id},
            headers: { 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include token in headers
                     },
                     success: function (response) {
                            alert(response.success); // Show success message
                            location.reload(); // Reload the page or perform any other action
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText); // Log error for debugging
                            alert('Something went wrong! Please try again.');
                        }
        });
    } else {
        // User clicked 'Cancel'
        console.log("User clicked Cancel.");
        // Handle the cancel action
        $(this).close;
    }
}
</script>
@endsection
