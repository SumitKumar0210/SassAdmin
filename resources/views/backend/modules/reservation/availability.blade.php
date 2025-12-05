@extends('backend.layouts.main')
@section('title','Reservation Availability')
@section('main-container') 
 <div class="page-body">
    <div class="container-fluid">
    <div class="page-title">
        <div class="row">
        <div class="col-12 col-sm-6 p-0">
            <h3>Availability</h3>
        </div>
        <div class="col-12 col-sm-6 p-0">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">                                       
                <svg class="stroke-icon">
                    <use href="backend/assets/svg/icon-sprite.svg#breadcrumb-home"></use>
                </svg></a></li>
            <li class="breadcrumb-item active"> Availability</li>
            </ol>
        </div>
        </div>
    </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="mb-3 border border-radius-4 py-2 px-3">
                    <div class="d-flex align-items-center">
                        <h5>Filters</h5>
                        <div class="ms-3">
                            <select class="selectpicker" multiple data-actions-box="true" title="All Rooms Selected">
                                <option>Single Room</option>
                                <option>Double Standard Room</option>
                                <option>Triple Standard Room</option>
                                <option>Suite</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-sm-12">
                <div class="availability">
                    <div class="table-responsive position-relative">
                        <table class="table table-bordered border-radius-4">
                        <thead>
                            <tr>
                                <th scope="col" class="text-start fixed-column">
                                    <div class="d-flex align-items-center py-1 px-2 border border-radius-4">
                                        <span class="me-2 text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                        <div class="form-group flatpicker-calender date_change_class">
                                            <input class="form-control form-control-sm p-0 border-0" id="availability" type="date" placeholder="Select date range" value="" style="width:200px;">
                                        </div>
                                    </div>
                                </th>
                                <th scope="col" class="text-center"><span>WED</span><span class="d-block h5 mb-0">20</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>THU</span><span class="d-block h5 mb-0">21</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>FRI</span><span class="d-block h5 mb-0">22</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>SAT</span><span class="d-block h5 mb-0">23</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>SUN</span><span class="d-block h5 mb-0">24</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>MON</span><span class="d-block h5 mb-0">25</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>TUE</span><span class="d-block h5 mb-0">26</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>WED</span><span class="d-block h5 mb-0">27</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>THU</span><span class="d-block h5 mb-0">28</span><span class="d-block">Nov 2024</span></th>
                                <th scope="col" class="text-center"><span>FRI</span><span class="d-block h5 mb-0">29</span><span class="d-block">Nov 2024</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fixed-column">Single Room</td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">25</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-danger text-dark">0</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-danger text-dark">0</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td class="alert-light-danger text-dark text-center">
                                     <div >
                                        <h5> MARKED <br>ZERO</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                               
                            </tr>
                            <tr>
                                <td class="fixed-column">Double Standard Room</td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">25</h5>
                                    </div>
                                </td>
                                <td  class="alert-light-danger text-dark text-center">
                                    <div>
                                        <h5> MARKED <br>ZERO</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-danger text-dark">0</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-danger text-dark">0</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="room-capacity">
                                        <h5 class="border p-2 border-radius-4 alert-light-success text-dark">15</h5>
                                    </div>
                                </td>
                               
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
<script>
$(document).ready(function () {
    $('.selectpicker').selectpicker();
});
</script>