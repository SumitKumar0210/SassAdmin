@extends('backend.layouts.main')
@section('main-container')
@section('title')
Reservation
@endsection
    <div class="page-body pb-1">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6 p-0">
                        <h3>Reservation</h3>
                    </div>
                    <div class="col-12 col-sm-6 p-0">
                        <div class="d-flex justify-content-end align-items-center">
                            <div class="d-flex mx-2">
                                <span class=" border rounded full-screen-icon" id="fullscreen"><i class="ri-fullscreen-fill"></i></span>
                                <span class=" border rounded full-screen-icon" id="normalscreen"><i class="ri-fullscreen-exit-fill"></i></span>
                            </div>
                            {{-- -------------view change function working from reservation-row-view.js------------------------- --}}
                            <div id="calender-view" class="btn-view border rounded active" ><i class="fa fa-calendar"></i></div>
                            <div id="row-view" class="btn-view border rounded mx-2" ><i class="ri-layout-grid-2-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            {{--------------------------------date calender-------------------------------------}}
            <div class="col-sm-12">
                <div class="reservation-head mb-2">
                    <div class="d-flex align-items-center">
                        <div>
                            <select class="form-select" aria-label=".form-select-sm example" id="selectDays"
                                onchange="reservationViewCount(this.value)">
                                <!-- <option value="7" {{ $getResViewCount == 7 ? 'selected' : '' }}>7 days</option>
                                <option value="14" {{ $getResViewCount == 14 ? 'selected' : '' }}>14 days</option>
                                <option value="28" {{ $getResViewCount == 28 ? 'selected' : '' }}>28 days</option> -->
                            </select>
                        </div>
                        <div class="ms-2">
                            {{-- <input class="form-control" id="search" type="text" placeholder="search ..."> --}}
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light" type="button"
                            onclick="loadreservationdata(0,2)">View
                            Today</button>
                        <div class="ms-2">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-light" type="button"
                                    onclick="loadreservationdata(14,1)" data-toggle="tooltip" data-placement="top" title="Shift Previous 14 Days"><span>&#8920;</span></button>
                                <button class="btn btn-light" type="button"
                                    onclick="loadreservationdata(7,1)" data-toggle="tooltip" data-placement="top" title="Shift Previous 7 Days"><span>&#8810;</span></button>
                                <button class="btn btn-light" type="button"
                                    onclick="loadreservationdata(1,1)" data-toggle="tooltip" data-placement="top" title="Shift Previous 1 Day"><span>&#60;</span></button>
                                <button class="btn btn-light" type="button">
                                    <div class="input-group date_change_class flatpicker-calender" style="width:120px;">
                                        <span class="me-2"><i class="icofont icofont-ui-calendar"></i></span>
                                        <input class="form-control p-0 border-0" id="datetime-local" type="date"
                                            value="2023-05-03" onchange="dateChange()">
                                    </div>
                                </button>
                                <button class="btn btn-light" type="button"
                                    onclick="loadreservationdata(1)" data-toggle="tooltip" data-placement="top" title="Shift Next 1 Day"><span>&#62;</span></button>
                                <button class="btn btn-light" type="button"
                                    onclick="loadreservationdata(7)" data-toggle="tooltip" data-placement="top" title="Shift Next 7 Days"><span>&#8811;</span></button>
                                <button class="btn btn-light" type="button"
                                    onclick="loadreservationdata(14)" data-toggle="tooltip" data-placement="top" title="Shift Next 14 Days"><span>&#8921;</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light" type="button" data-bs-toggle="modal"
                            data-bs-target="#roomCloser"><span class="btn-icon"><i class="ri-indeterminate-circle-line"></i></span> Room Closure</button>
                        <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal"
                            data-bs-target="#reservation" onclick="clearReservation()"><span class="btn-icon"><i class="icon-plus me-1" style="font-size: 10px;"></i></span>
                            Reservation</button>
                    </div>
                </div>
            </div>
            <div id="calendar-div" class="row content mb-5" style="display:block;">    
                <div class="append_reservation_data">
                    <!----------------Reservation Data Calander View Appended Here Using Ajax----------------------->
                </div>
            </div>
                    {{----------------------------- row view start ------------------------------------------}}
            <div id="row-div" class="row content">
               <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="d-block d-sm-flex justify-content-between border-bottom pb-2">
                            <div>
                                <h3>Rooms</h3>
                            </div>
                            <div id="reportrange" class="date-range border border-radius-4 px-3 py-2"><i class="fa fa-calendar"></i>&nbsp;<span></span></div>
                        </div>
                        
                        <div class="d-block d-sm-none my-3">
                        <select class="form-select form-select-sm " id="room-status" required="">
                            <option select value="all">All</option>
                            <option value="vacant">Vacant </option>
                            <option value="occupied">Occupied </option>
                            <option value="cleaning">Cleaning</option>
                            <option value="block">Block</option>
                            <option value="maintainaince">Maintainaince</option>
                        </select>
                        </div>
                        <div class="legend d-none d-sm-flex justify-content-center mt-4 mb-4 ">
                        <div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="allRoom()">
                            <div class="all-room w-40  bg-success border-radius-4"></div>
                            <h5>All</h5>
                        </div>
                        <div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="vacantRoom()">
                            <div class="vacant-room w-40  bg-info border-radius-4"></div>
                            <h5>Vacant</h5>
                        </div>
                        <div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="occupiedRoom()">
                            <div class="occupied-room w-40  bg-warning border-radius-4"></div>
                            <h5>Occupied</h5>
                        </div>
                        <div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="cleaningRoom()">
                            <div class="cleaning-room w-40  bg-primary border-radius-4"></div>
                            <h5>Cleaning</h5>
                        </div>
                        <div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="blockRoom()">
                            <div class="block-room w-40  bg-danger border-radius-4"></div>
                            <h5>Block</h5>
                        </div>
                        <div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="maintainainceRoom()">
                            <div class="maintain-room w-40  bg-secondary border-radius-4"></div>
                            <h5>Maintainaince</h5>
                        </div>
                        </div>
                        <div class="grid-number d-flex scroll-div mb-2">
                            <div class=" d-block ">101</div>
                            <div class=" d-block ">102</div>
                        </div>
                        <div class="chart-container room-view  d-flex py-2 mb-4 scroll-div" style="height:518px; width:100%;">
                            <div class="up-grids position-absolute" style="top: 144px;left: 30px;font-size: 20px;">
                                <i class="icon-angle-up"></i>
                            </div>
                            <div class="down-grids position-absolute" style="bottom: 10px; left: 30px;font-size: 20px;">
                                <i class="icon-angle-down"></i>
                            </div>
                            <div class="text-center  grid-date">
                                <div class=" fulldate  my-2 border-radius-4 grid-rowss"> Mon <br>
                                <strong>01</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Tue <br>
                                <strong>02</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Wed <br>
                                <strong>03</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Thu <br>
                                <strong>04</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Fri <br>
                                <strong>05</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Sat <br>
                                <strong>06</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Sun <br>
                                <strong>07</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Mon <br>
                                <strong>08</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Tue <br>
                                <strong>09</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Wed <br>
                                <strong>10</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Thu <br>
                                <strong>11</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Fri <br>
                                <strong>12</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Sat <br>
                                <strong>13</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Sun <br>
                                <strong>14</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Mon <br>
                                <strong>15</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Tue <br>
                                <strong>16</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Wed <br>
                                <strong>17</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Thu <br>
                                <strong>18</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Fri <br>
                                <strong>19</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Sat <br>
                                <strong>20</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Sun <br>
                                <strong>21</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Mon <br>
                                <strong>22</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Tue <br>
                                <strong>23</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Wed <br>
                                <strong>24</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Thu <br>
                                <strong>25</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Fri <br>
                                <strong>26</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Sat <br>
                                <strong>27</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Sun <br>
                                <strong>28</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Mon <br>
                                <strong>29</strong>
                                <br>Jan
                                </div>
                                <div class=" fulldate  my-2 border-radius-4  grid-rowss"> Tue <br>
                                <strong>30</strong>
                                <br>Jan
                                </div>
                            </div>
                            <div class="grid-div">
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="maintain">
                                        <div class="w-40 h-40 bg-secondary d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="grid-row d-flex py-2 border-top">
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="all">
                                        <div class="w-40 h-40 bg-success d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="all">
                                    <div class="w-40 h-40 bg-success d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="vacant">
                                    <div class="bg-info w-40 h-40 d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="occupied">
                                    <div class="w-40 h-40 bg-warning d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="cleaning">
                                    <div class="w-40 h-40 bg-primary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="block">
                                    <div class="w-40 h-40 bg-danger d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    <div class="maintain">
                                    <div class="w-40 h-40 bg-secondary d-block border-radius-4"></div>
                                    </div>
                                </div>
                                <div class="w-40 h-40 m-2 grid">
                                    {{-- <div class="maintain">
                                        <div class="w-40 h-40 bg-secondary d-block border-radius-4 onhover-dropdown">
                                            <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
          {{---------------------------------------------- row view end ---------------------------------------------------}}
    </div>
        <!-- Container-fluid Ends-->
        {{-- ----------------extra div for data append and use somewhere in code--------------- --}}
        <div class="reload_reservation_duration" style="display:none;"></div>
        <div class="extra_data" style="display:none;"></div>
        <div class="get_reservationid" style="display:none;"></div>
        <div class="currdates_data" style="display:none;"></div>
        <div class="currDisplay_data" style="display:none;"></div>
        <div class="guest_room_id" style="display:none;"></div>
        <div class="guest_length_data" style="display:none;"></div>
        <div class="amount_during_checkout" style="display:none;"></div>
        <div class="checkin_dt" style="display:none;"></div>
        <div class="checkout_dt" style="display:none;"></div>
        <div class="outstanding_amount" style="display:none;"></div>
    {{-- </div> --}}
    <!-- Room closure modal start -->
    <div class="modal fade" id="roomCloser" tabindex="-1" role="dialog" aria-labelledby="roomCloser" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title">Room Closure</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="" id="room_closure">
                    <div class="modal-body">
                       
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="roomnum_closure">Room</label>
                                <select class="form-select form-select-sm" id="roomnum_closure" oninput="validateField('#roomnum_closure','select','.roomnum_closure_class')">
                                    <option value="">Select</option>
                                    @foreach ($roomCategoryNumber as $roomCategory)
                                    <optgroup class="text-muted" label="{{ $roomCategory['name'] }} Room">
                                        @foreach ($roomCategory['rooms'] as $room)
                                            <option value="{{ $room['room_number'] }}">{{ $room['room_number'] }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                                </select>
                                <div class="roomnum_closure_class">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="start-date">Start Date</label>
                                    <div
                                        class="input-group flatpicker-calender border px-2 d-flex align-items-center border-radius-4">
                                        <span class="text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                        <input class="form-control form-control-sm border-0" id="startdate_closure"
                                            type="date" value="2023-05-03">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="end-date">End Date</label>
                                    <div
                                        class="input-group flatpicker-calender border px-2 d-flex align-items-center border-radius-4">
                                        <span class="text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                        <input class="form-control form-control-sm border-0" id="enddate_closure"
                                            type="date" value="2023-05-03">
                                    </div>
                                </div>
                            </div>
                            <label class="form-label" for="reason_closure">Reason For Closure</label>
                            <select class="form-select form-select-sm" id="reason_closure" oninput="validateField('#reason_closure','select','.reason_closure_class')">
                                <option value="">Select</option>
                                <option value="Cleaning">Cleaning</option>
                                <option value="Maintainance">Maintainance</option>
                                <option value="Hold">Hold</option>
                            </select>
                            <div class="reason_closure_class mb-3">
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
    <!-- Room closure modal end-->
    <!-- Include the addReservation Model content here , reservation modal start -->
    @include('backend.modules.models.addReservationModel')
    <!-- reservation modal end -->

    </div>

    <!-- customer status modal start -->
    <div class="modal fade" id="customerStatus" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h4 class="modal-title customerstatus_reservationid"></h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- ------------------------------ modal body appended here using jquery through function getReservationidValue()----------------- --}}
                </div>
                <div class="modal-footer border-0 ">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel
                        Reservation</button>
                    <button class="btn btn-muted border" type="button">View Reservation</button>
                    <button class="btn btn-warning" type="button">Confirmed</button>
                </div>
            </div>
        </div>
    </div>
    <!-- customer status modal end -->
    <!-- Include the editReservation Model content here -->
    @include('backend.modules.models.editReservationModel')
    <!-- customer Drag status modal start -->
    <div class="modal fade" id="changeReservation" tabindex="-1" role="dialog" aria-labelledby="roomCloser"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header  border-0">
                        <h4 class="modal-title">Change Reservation</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding-top: 0px;">
                        {{-- -------------------popup appended here from custom.js on drag and drop----------------------------- --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- customer status modal end -->
    @endsection
    @section('extra-js')
    <script src="{{asset('backend/assets/js/custom/reservation-row-view.js')}}"></script>
    <script>
        //used for route url in ajax call on custom.js page
        
        const getRservationandRoomDetails = "{{ route('reservation.getRservationandRoomDetails') }}";
        const getResDetails = "{{ route('backend.getReservation_Details') }}";
        const getResDetails2 = "{{ route('backend.getReservationDetails') }}";
        const reservationRoomDetailData = "{{ route('reservation.getRservationRoomDatas') }}";
        const reservationDetailData = "{{ route('reservation.getRservationDatas') }}";
        const reservationRoomDetailsUrl = "{{ route('backend.getRservationRoomDetails') }}";
        const reservatiionRommNumberUpdate = "{{ route('reservation.reservationRoomNumUpdate') }}";
        const reservatiionAdd = "{{ route('reservation.add_reservation') }}";
        const reservationCountView = "{{ route('reservation.reservationCountView') }}";
        const reservationPaymentSubmit = "{{ route('reservation.reservationPayment') }}";
        const submitroomguestData = "{{ route('reservation.submitroomguestData') }}";
        const roomguestnoteData = "{{ route('reservation.roomguestnoteData') }}";
        const getActivityLogData = "{{ route('reservation.getActivityLogDetails') }}";
        const checkinProcess = "{{ route('reservation.roomcheckIn') }}";
        const checkoutProcess = "{{ route('reservation.roomcheckOut') }}";
        const getRoomTypeDataUrl = "{{ route('room.getRoomTypeData') }}";
        const getOccupancyUrl = "{{ route('room.getOccupancyData') }}";
        const reservatiionEditAdd = "{{ route('reservation.edit_add_reservation') }}";
        const getRoomTypeDataEditUrl = "{{ route('room.getRoomTypeEditData') }}";
        const getOccupancyEditUrl = "{{ route('room.getOccupancyEditData') }}";
        const editReservationUpdate = "{{ route('reservation.editReservationUpdate') }}";
        const getRoomcategory = "{{ route('room.getRoomCategory') }}";
        const updateroomguestData = "{{ route('reservation.updateroomguestData') }}";
        const res_confirm_status = "{{ route('reservation.res_confirm_status') }}";
        const roomBalanceFetch = "{{ route('room.roomBalanceFetch') }}";
        const roomTypeDetails = "{{ route('roomtype.checkRoomType') }}";
        const guestCheckout = "{{route('reservation.guestCheckout')}}";
        const roomstatusupdate = "{{route('room.roomstatusupdate')}}";
        const manageroomclose = "{{route('room.manageroomclose')}}";
        const getDetailsWithPhone = "{{route('reservation.getDetailsWithPhone')}}";
        const addDataUsingPhone = "{{route('reservation.addDataUsingPhone')}}";
        const updateDiscountEdit = "{{route('reservation.updateDiscountEdit')}}";
        const paymentInvoiceStatus = "{{route('invoice.invoice_status')}}";   
    </script>
    <script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        loadreservationdata();
    });

let datesArray = []; // Global variable to store dates 
function loadreservationdata(x = 0, y = 0) {
    let currdates = $('.currdates_data').html(); // Get currdates from a hidden input field or other source
    let setdate = $('#datetime-local').val();
    let output = '';
    $.ajax({
        url: "{{ route('backend.reservationdata') }}",
        method: "POST",
        data: {
            days: x,
            y: y,
            currdates: currdates,
            refdate: setdate,
        },
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
      //   console.log(data);
            let roomcCategoryNum = data.roomcCategoryNum;
            let getResViewCount = data.getResViewCount;
            let roomNumbers = data.roomnumber;
            let roomEachData = data.roomeachDetail;
            x = getResViewCount;
            const newCurrdates = data.currdates; // Access currdates from the response and use it as needed 
            $('.currdates_data').html(newCurrdates); // Update the hidden input field with the new currdates value
            $('.currDisplay_data').html(data.currrDisplay); // Update the hidden input field with the new currrDisplay value
            let currDisplaydates = $('.currDisplay_data').html(); // Use .text() to get the value of the hidden input field
            $('#datetime-local').val(currDisplaydates); // Set the value of the input field
            datesArray = data.dates; // Store dates in the global variable for findDateByIndex().
            output +=`
            <div class="col-sm-12">
                <div class="reservation">
                    <div class="table-responsive overflow-hidden">
                        <table class="table table-bordered draggableTable" id="daysTable">
                            <thead>
                                <tr>
                                    <th class="text-start">
                                    </th>`;
                                          $.each(data.dates, function(key, value) {
                                output += `<th class="text-center">`;
                                               //check if current date is found in calender then mark red that current date.
                                            if (value.full_date == value.today) {
                                output += `<span class="d-block text-danger" >Today</span>
                                                    <span class="d-block text-danger">${value.date}</span>`;
                                            } else {
                                output += `<span class="d-block">${value.day}</span>
                                                    <span class="d-block">${value.date}</span>`;
                                            }
                                output += `<span class="d-block">${value.month}</span></th>`;
                                          });
                                output += `</tr>
                            </thead>
                            <tbody>`;
                                    roomcCategoryNum.forEach(function(room_category) {
                                output +=` <tr class="room-title">
                                                               <td colspan="${data.dates.length + 1}" class="fw-bold p-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="txt-primary toggle-section me-1"
                                                                            data-section="${room_category.name}-room"><i class="icofont icofont-caret-down expand-icon toggle-section"></i>
                                                                        </span>${room_category.name} Room
                                                                    </div>
                                                                </td>
                                                            </tr>`;
                                        room_category.rooms.forEach(function(cate_rooms){
                                output += `<tr class="${room_category.name}-room">
                                                                    <td>${cate_rooms.room_number}</td>`;
                                                                        for (let j = 0; j < data.dates.length; j++) {
                                output += `<td class="cell calcHeightWidth remove-res-space" data-key="${cate_rooms.id}" data-j="${j}"></td>`;
                                                                        }
                                output += `</tr>`;
                                        });
                                output += `<tr class="${room_category.name}-room unallocated-room">
                                                                  <td>Unallocated</td>`;
                                                                    for (let i = 0; i < data.dates.length; i++) {
                                output += `<td class="cell calcHeightWidth remove-res-space" data-key="unallocated-${room_category.id}" data-j="${i}"></td>`;
                                                                    }
                                output += `</tr>`;
                                    });
                                output +=` </tbody>
                        </table>
                    </div>
                </div>
            </div>`;
         $('.append_reservation_data').html(output);
            processReservationData(data.reservation);// Process reservation data

// -------------------------------------row view data append to row-view-class div----------------------------------------------

            let output_row_view = '<div class="text-center grid-date">';
                    // Render the dates
                    $.each(data.dates, function (key, value) {
                        output_row_view += `<div class="fulldate my-2 border-radius-4 grid-rowss">
                            ${value.day} <br> <strong>${value.date}</strong><br> ${value.month}
                        </div>`;
                    });
                output_row_view += `</div><div class="grid-div">`;
                    // Loop through each date and room
                    $.each(data.dates, function (key, value) {
                output_row_view += `<div class="grid-row d-flex py-2 border-top">`;
                        $.each(roomEachData, function (roomKey, roomNum) {
                            let roomClass = '';
                            let statusClass = '';
                            let display_mode;
                            if (roomNum.room_status === 'vacant') {
                                // Apply "vacant" styles without checking dates
                                roomClass = 'vacant';
                                statusClass = 'bg-success'; // Green for vacant
                                display_mode = 'd-none';
                            } else {
                                // Check the dates for other statuses
                                $.each(roomNum.room_dates, function (dateKey, date) {
                                    if (date === value.full_date) {
                                        // Determine classes based on room_status using if-else
                                        if (roomNum.room_status === 'occupied') {
                                            roomClass = 'occupied';
                                            statusClass = 'bg-warning'; // Yellow for occupied
                                            display_mode = '';
                                        } else if (roomNum.room_status === 'maintainance') {
                                            roomClass = 'maintain';
                                            statusClass = 'bg-secondary'; // Grey for maintenance
                                            display_mode = '';
                                        } else if (roomNum.room_status === 'block') {
                                            roomClass = 'block';
                                            statusClass = 'bg-danger'; // Red for blocked
                                            display_mode = '';
                                        } else {
                                            roomClass = 'all';
                                            statusClass = 'bg-info'; // Default color
                                            display_mode = '';
                                        }
                                    }
                                });
                                if(roomClass == ''){
                                    roomClass = 'vacant';
                                    statusClass = 'bg-success'; // Green for vacant
                                }
                            }
                            // Render the room
                output_row_view += `<div class="w-40 h-40 m-2 grid">
                                    <div class="${roomClass}">
                                <!--<div class="w-40 h-40 ${statusClass} d-block border-radius-4">
                                    ${roomNum.room_number}
                                    </div> -->
                                    <div class="w-40 h-40 ${statusClass} d-block border-radius-4 onhover-dropdown">
                                    <div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark  `+display_mode+`" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <h4 class="modal-title">Reservation LH24115678475 Sidhart</h4>
                                                <button class="btn px-0 customer-d-close">
                                                <i class="icon-close"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable">
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Primary Contact</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0">
                                                        <p class="mb-0">Guest Email</p>
                                                        <p class="mb-0 ">example@info.com</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">+91 1122 334 455</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="px-0 py-2">
                                                        <h4>Reservation Details</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" class="p-0">
                                                        <p class="mb-0">Stay </p>
                                                        <p class="mb-0 ">1 Night</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0">Arrival Time </p>
                                                        <p class="mb-0 ">04:30 PM</p>
                                                        </td>
                                                        <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-0 py-2">
                                                        <p class="mb-0">Room Reservation </p>
                                                        <p class="mb-0  text-danger">Unallocated </p>
                                                        </td>
                                                        <td class="py-2">
                                                        <p class="mb-0 ">Guest</p>
                                                        <p class="mb-0 ">5</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                    <p class="mb-1 fw-bold">Paid</p>
                                                    <p class="mb-0">Reservation Total</p>
                                                    <p class="mb-0">0.00</p>
                                                    <p class="mt-2 mb-0">Total Outstanding</p>
                                                    <p class="mb-0">0.00</p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-2">
                                                <button class="btn btn-danger customer-d-close" type="button" id="">Cancel Reservation</button>
                                                <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                                <button class="btn btn-warning" type="button">Confirmed</button>
                                            </div>
                                    </div>
                         </div>
                                </div>
                            </div>`;
                        });

                output_row_view += `</div>`;
                    });
                output_row_view += `</div>`;
                $('.row-view-class').html(output_row_view); //append to html row-view-class class



// -----------------------------------------------------------------------------------

        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + error);
        }
    });
// function selectGridCells() {
//                  // Process the first 20 rows (index 0 to 19)
//                  $('.grid-div .grid-row').slice(0, 20).each(function () {
//                      var gridCells = $(this).find(".grid");
//                         gridCells.html('Techie');
//                    // Apply 'left-grid' and 'top-grid' to the first 20 cells
//                     gridCells.slice(0, 20).find(".grid-detals").addClass('left-grid top-grid');

//                    // Apply 'right-grid' and 'top-grid' to the next 20 cells (21st to 40th)
//                     gridCells.slice(20, 40).find(".grid-detals").addClass('right-grid top-grid');
//                  });

//                  // Process rows 21 to 30
//                  $('.grid-div .grid-row').slice(20, 30).each(function () {
//                     var gridCells = $(this).find(".grid");

//                    // Apply 'left-grid' and 'bottom-grid' to the first 20 cells
//                     gridCells.slice(0, 20).find(".grid-detals").addClass('left-grid bottom-grid');

//                      // Apply 'right-grid' and 'bottom-grid' to the next 20 cells
//                      gridCells.slice(20, 40).find(".grid-detals").addClass('right-grid bottom-grid');
//                  });
//                  }

                //  selectGridCells();
                //  $('.grid').mouseover(function () {
                //  $('.customer-details').show();
                //  });
}

function processReservationData(reservations) {
    var myvalue = document.getElementsByClassName('calcHeightWidth');
    let totalWidth = myvalue[0].offsetWidth;
    let idCounter = 1; // Initialize a counter
    let ref_date = $('#datetime-local').val();
    let dateParts = ref_date.split('-');
        ref_date = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
    $.each(reservations, function(key, value) {
        let checkin_date = value['checkin'];
        let checkout_date = value['checkout'];
        let roomtype = value['room_type'];
        let getroomCategory = value['room_category_id'];
        let checkin_dateObject = new Date(checkin_date); // Convert to Date object
        let checkout_dateObject = new Date(checkout_date); // Convert to Date object
        let checkin_day = checkin_dateObject.getDate(); // Extract the day
        let checkout_day = checkout_dateObject.getDate(); // Extract the day
        let checkin_month = checkin_dateObject.toLocaleString('default', {month: 'short'});
        let checkout_month = checkout_dateObject.toLocaleString('default', {month: 'short'});
        let chechin_formattedMonth = checkin_month.charAt(0).toUpperCase() + checkin_month.slice(1).toLowerCase(); // Extract the month name
        let chechout_formattedMonth = checkout_month.charAt(0).toUpperCase() + checkout_month.slice(1).toLowerCase(); // Extract the month name
        let checkin_formattedDay = String(checkin_day).padStart(2,'0'); // Convert to string with leading zero if needed
        let checkout_formattedDay = String(checkout_day).padStart(2,'0'); // Convert to string with leading zero if needed
        let checkin_targetDate = checkin_formattedDay;
        let checkout_targetDate = checkout_formattedDay;
        let res_status = value['status'];
        let startDate_ur = new Date(checkin_date);
        let endDate_ur = new Date(checkout_date);
        let timeDiff_ur = endDate_ur - startDate_ur; // Calculate the difference in milliseconds.
        let diffInDays_ur = timeDiff_ur / (1000 * 60 * 60 * 24); // Convert the difference to days.
        let calculateMarginLeft = 0;
        let calTotalWidth = 0;
        calculateMarginLeft = (totalWidth/2);
        calTotalWidth = parseInt(totalWidth) * parseInt(diffInDays_ur);
        if (res_status === 'reserved') {
            let cellIndices = findCellIndicesByDate(datesArray, checkin_targetDate,chechin_formattedMonth, checkout_targetDate, chechout_formattedMonth);
            if (Array.isArray(cellIndices) && cellIndices.length >= 0) {
                cellIndices.forEach(index => {
                    if (index !== -1) {
                        $('td[data-key="unallocated-' + getroomCategory + '"][data-j="' + index + '"]').append(`
                                <div class="booked-details draggable" draggable="true" id="${idCounter}" style="margin-left:`+calculateMarginLeft+`px; width:`+calTotalWidth+`px">
                                    <span class="bg-dark py-2 px-1 bookedbysearch onhover-dropdown" onclick="reserved_search_arr('${value['reservation_id']}')"onmouseleave="hideAltHoverElement()">
                                        <i class="icon-search "></i>
                                        <div class="border bg-white rounded p-2 px-3 text-dark customer-details onhover-show-div res_hover_element d-none" style="width:700px;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4>Reservation ${value['reservation_id']} ${value['primary_name']}</h4>
                                                <button class="btn px-0 customer-d-close" onclick="hideAltHoverElement()"><i class="icon-close"></i></button>
                                            </div>
                                            <div class="container-fluid gx-0 mt-2">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h4 class="mb-2">Primary Contact</h4>
                                                            <div class="container-fluid gx-0">
                                                                <div class="row">
                                                                    <div class="col-md-3 mb-3 mb-lg-0">
                                                                        <p class="mb-0">Guest Email</p>
                                                                        <p class="mb-0 res_g_email ">eeeeeee</p>
                                                                    </div>
                                                                    <div class="col-md-4 mb-3 mb-lg-0"></div>
                                                                    <div class="col-md-5 mb-3 mb-lg-0">
                                                                        <div>
                                                                            <p class="mb-0 ">Phone Number</p>
                                                                            <p class="mb-0 res_g_mobile ">mmmmmmm</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <h4 class=" mb-2 mt-2">Reservation Details</h4>
                                                            <div class="container-fluid gx-0">
                                                                <div class="row">
                                                                    <div class="col-md-3 mb-3 mb-lg-0">
                                                                        <p class="mb-0">Stay </p>
                                                                        <p class="mb-0 ">${diffInDays_ur} Night</p>
                                                                    </div>
                                                                    <div class="col-md-4 mb-3 mb-lg-0">
                                                                        <p class="mb-0">Arrival Time </p>
                                                                        <p class="mb-0 res_g_arrivaltime ">11:00 AM</p>
                                                                    </div>
                                                                    <div class="col-md-5 mb-3 mb-lg-0">
                                                                        <p class="mb-0 ">Source of reservation</p>
                                                                        <p class="mb-0 ">By Hotel</p>
                                                                    </div>
                                                                    <div class="container-fluid  mt-1">
                                                                        <div class="row ">
                                                                            <div class="col-md-4 mb-3 mb-lg-0">
                                                                                <p class="mb-0">Room Reservation </p>
                                                                                <p class="mb-0  text-danger">${value['dropped_row'] !='' ? value['dropped_row'] :'UnAllocated' }</p>
                                                                            </div>
                                                                            <div class="col-md-3 "></div>
                                                                            <div class="col-md-5 mb-3 mb-lg-0">
                                                                                <p class="mb-0 ">Guest</p>
                                                                                <p class="mb-0 ">1</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="rounded border p-3 bg-light text-muted">
                                                            <p class="mb-1 fw-bold">Paid</p>
                                                            <p class="mb-0">Reservation Total</p>
                                                            <p class="mb-0 res_g_reservation_total">0.00</p>
                                                            <p class="mt-2 mb-0">Total Outstanding</p>
                                                            <p class="mb-0 res_g_outstanding">0.00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-1">
                                              <!--  <button class="btn btn-danger customer-d-close" type="button" id="" onclick="hideAltHoverElement()">Close</button> -->
                                                <button class="btn btn-muted border mx-2" type="button" onclick="edit_reservation(${value['id']},'${value['reservation_id']}')">View Reservation</button>
                                              <!--  <button class="btn btn-warning" type="button" onclick="confirm_res(${value['id']})">Confirmed</button> -->
                                            </div>
                                        </div> 
                                    </span>
                                    <span class="edit_res ps-1 text-truncate me-1" onclick="edit_reservation(${value['id']},'${value['reservation_id']}')">${value['primary_name']}(${value['reservation_id']})</span><span class="reservationid_drag" style="display:none">${value['id']}</span>
                                </div>
                                `);
                        idCounter++; // Increment the counter for the next ID   
                    }
                });
            }
        } else if (res_status === 'alloted') {
            let droppedkey = value['dropped_row'];
            let dropped_checkin_date = value['dropped_checkin_date'];
            let startdate1 = value['checkin'];
            let enddate1 = value['checkout'];
            let startDate = new Date(startdate1);
            let endDate = new Date(enddate1);
            let timeDiff = endDate - startDate; // Calculate the difference in milliseconds.
            let diffInDays = timeDiff / (1000 * 60 * 60 * 24); // Convert the difference to days.
            let ns = '';
            if(ref_date > value['checkin']){
                ns = ref_date;
                let startDate_ur1 = new Date(ref_date);
                let endDate_ur1 = new Date(value['checkout']);
                let timeDiff_ur1 = endDate_ur1 - startDate_ur1; // Calculate the difference in milliseconds.
                let diffInDays_ur = timeDiff_ur1 / (1000 * 60 * 60 * 24);
                calTotalWidth = parseInt(totalWidth) * parseInt(Math.round(diffInDays_ur))+calculateMarginLeft;
                calculateMarginLeft=0;
            }else{
                ns =  value['checkin'];
            }
            const alloted_cellIndices = findAllotedCellIndices(datesArray, ns, value['checkout']);
            $('td[data-key="' + droppedkey + '"][data-j="' + alloted_cellIndices + '"]').append(`
                <div class="booked-details_alt draggable" draggable="true" id="${idCounter}" style="margin-left:`+calculateMarginLeft+`px; width:`+calTotalWidth+`px; margin-right: 2px;">
                    <span class="bg-dark py-2 px-1 bookedbysearch  onhover-dropdown"  onclick="alotted_search_arr('${value['reservation_id']}')"onmouseleave="hideAltHoverElement()"><i class="icon-search "></i> 
                        <div class=" border bg-white rounded p-2 px-3 text-dark customer-details onhover-show-div alt_hover_element d-none" style="width:700px;">
                            <div class="d-flex justify-content-between align-items-center ">
                                <h4 >Reservation. ${value['reservation_id']} ${value['primary_name']}</h4>
                                <button class="btn px-0 customer-d-close" onclick="hideAltHoverElement()"><i class="icon-close"></i></button>
                            </div>
                            <div class="container-fluid gx-0 mt-2">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class=" mb-2">Primary Contact</h4>
                                        <div class="container-fluid gx-0">
                                            <div class="row">
                                                <div class="col-md-3 mb-3 mb-lg-0">
                                                    <p class="mb-0">Guest Email</p>
                                                    <p class="mb-0 alt_g_email">eeeeeeee</p>
                                                </div>
                                                <div class="col-md-4 mb-3 mb-lg-0"></div>
                                                <div class="col-md-5 mb-3 mb-lg-0">
                                                    <div class="">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 alt_g_mobile">mmmmmm</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class=" mb-2 mt-2">Reservation Details</h4>
                                        <div class="container-fluid gx-0">
                                            <div class="row">
                                                <div class="col-md-3 mb-3 mb-lg-0">
                                                    <p class="mb-0">Stay </p>
                                                    <p class="mb-0 ">${diffInDays} Night</p>
                                                </div>
                                                <div class="col-md-4 mb-3 mb-lg-0">
                                                    <p class="mb-0">Arrival Time </p>
                                                    <p class="mb-0 alt_g_arrivaltime">10:00 AM</p>
                                                </div>
                                                <div class="col-md-5 mb-3 mb-lg-0">
                                                    <p class="mb-0 ">Source of reservation</p>
                                                    <p class="mb-0 ">By Hotel</p>
                                                </div>
                                                <div class="container-fluid  mt-1">
                                                    <div class="row ">
                                                        <div class="col-md-4 mb-3 mb-lg-0">
                                                            <p class="mb-0">Room Reservation </p>
                                                            <p class="mb-0  text-danger">${value['dropped_row']}</p>
                                                        </div>
                                                        <div class="col-md-3 "></div>
                                                        <div class="col-md-5 mb-3 mb-lg-0">
                                                            <p class="mb-0 ">Guest</p>
                                                            <p class="mb-0 ">1</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="rounded border p-3 bg-light text-muted">
                                            <p class="mb-1 fw-bold">Paid</p>
                                            <p class="mb-0">Reservation Total</p>
                                            <p class="mb-0 alt_g_reservation_total">0.00</p>
                                            <p class="mt-2 mb-0">Total Outstanding</p>
                                            <p class="mb-0 alt_g_outstanding">0.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-1">
                              <!--  <button class="btn btn-danger customer-d-close" type="button" id="" onclick="hideAltHoverElement()">Close</button> -->
                                <button class="btn btn-muted border mx-2" type="button" onclick="edit_reservation(${value['id']},'${value['reservation_id']}')">View Reservation</button>
                              <!--  <button class="btn btn-warning" type="button" onclick="confirm_res(${value['id']})" ${value['res_confirm_status'] === 'Confirmed' ? 'disabled' : ''}>Confirmed</button> -->
                            </div>

                        </div> 
                    </span>
                    <span class="edit_res ps-1 text-truncate ms-1 me-1" onclick="edit_reservation(${value['id']},'${value['reservation_id']}')">${value['primary_name']}(${value['reservation_id']})</span><span class="reservationid_drag" style="display:none">${value['id']}</span>
                </div>`);
            idCounter++; // Increment the counter for the next ID

            } else if (res_status === 'checkout') {
            let droppedkey = value['dropped_row'];
            let categoryID = value['room_category_id'];
            let new_droppedkey;
            // Ensure droppedkey is a valid number
            if (droppedkey != '') {
                new_droppedkey = droppedkey;
            } else {
                new_droppedkey = 'unallocated-'+ categoryID;
            }
            let dropped_checkin_date = value['dropped_checkin_date'];
            let startdate1 = value['checkin'];
            let enddate1 = value['checkout'];
            let startDate = new Date(startdate1);
            let endDate = new Date(enddate1);
            let timeDiff = endDate - startDate; // Calculate the difference in milliseconds
            let diffInDays = timeDiff / (1000 * 60 * 60 * 24); // Convert the difference to days
            let ns = '';
            if (ref_date > value['checkin']) {
                ns = ref_date;
                let startDate_ur1 = new Date(ref_date);
                let endDate_ur1 = new Date(value['checkout']);
                let timeDiff_ur1 = endDate_ur1 - startDate_ur1; // Calculate the difference in milliseconds
                let diffInDays_ur = timeDiff_ur1 / (1000 * 60 * 60 * 24);
                calTotalWidth = parseInt(totalWidth) * parseInt(Math.round(diffInDays_ur)) + calculateMarginLeft;
                calculateMarginLeft = 0;
            } else {
                ns = value['checkin'];
            }
            const alloted_cellIndices = findAllotedCellIndices(datesArray, ns, value['checkout']);
            $('td[data-key="' + new_droppedkey + '"][data-j="' + alloted_cellIndices + '"]').append(`
                <div class="booked-details_checkout nodraggable" draggable="false" id="${idCounter}" style="margin-left:` + calculateMarginLeft + `px; width:` + calTotalWidth + `px">
                    <span class="bg-dark py-2 px-1 bookedbysearch  onhover-dropdown"  onclick="alotted_search_arr('${value['reservation_id']}')" onmouseleave="hideAltHoverElement()"><i class="icon-search "></i> 
                        <div class=" border bg-white rounded p-2 px-3 text-dark customer-details onhover-show-div alt_hover_element d-none" style="width:700px;">
                            <div class="d-flex justify-content-between align-items-center ">
                                <h4 >Reservation. ${value['reservation_id']} ${value['primary_name']}</h4>
                                <button class="btn px-0 customer-d-close" onclick="hideAltHoverElement()"><i class="icon-close"></i></button>
                            </div>
                            <div class="container-fluid gx-0 mt-2">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class=" mb-2">Primary Contact</h4>
                                        <div class="container-fluid gx-0">
                                            <div class="row">
                                                <div class="col-md-3 mb-3 mb-lg-0">
                                                    <p class="mb-0">Guest Email</p>
                                                    <p class="mb-0 alt_g_email">eeeeeeee</p>
                                                </div>
                                                <div class="col-md-4 mb-3 mb-lg-0"></div>
                                                <div class="col-md-5 mb-3 mb-lg-0">
                                                    <div class="">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 alt_g_mobile">mmmmmm</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class=" mb-2 mt-2">Reservation Details</h4>
                                        <div class="container-fluid gx-0">
                                            <div class="row">
                                                <div class="col-md-3 mb-3 mb-lg-0">
                                                    <p class="mb-0">Stay </p>
                                                    <p class="mb-0 ">${diffInDays} Night</p>
                                                </div>
                                                <div class="col-md-4 mb-3 mb-lg-0">
                                                    <p class="mb-0">Arrival Time </p>
                                                    <p class="mb-0 alt_g_arrivaltime">10:00 AM</p>
                                                </div>
                                                <div class="col-md-5 mb-3 mb-lg-0">
                                                    <p class="mb-0 ">Source of reservation</p>
                                                    <p class="mb-0 ">By Hotel</p>
                                                </div>
                                                <div class="container-fluid  mt-1">
                                                    <div class="row ">
                                                        <div class="col-md-4 mb-3 mb-lg-0">
                                                            <p class="mb-0">Room Reservation </p>
                                                            <p class="mb-0  text-danger">${value['dropped_row']}</p>
                                                        </div>
                                                        <div class="col-md-3 "></div>
                                                        <div class="col-md-5 mb-3 mb-lg-0">
                                                            <p class="mb-0 ">Guest</p>
                                                            <p class="mb-0 ">1</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="rounded border p-3 bg-light text-muted checkout_amt_dtl">
                                            <p class="mb-1 fw-bold">Paid</p>
                                            <p class="mb-0">Reservation Total</p>
                                            <p class="mb-0">0.00</p>
                                            <p class="mt-2 mb-0">Total Outstanding</p>
                                            <p class="mb-0">0.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-1">
                              <!--  <button class="btn btn-danger customer-d-close" type="button" id="" onclick="hideAltHoverElement()">Close</button> -->
                                <button class="btn btn-muted border mx-2" type="button" onclick="edit_reservation(${value['id']},'${value['reservation_id']}')">View Reservation</button>
                               <!-- <button class="btn btn-warning" type="button">Confirmed</button> -->
                            </div>
                        </div> 
                    </span>
                    <span class="edit_res ps-1 text-truncate me-1" onclick="edit_reservation(${value['id']},'${value['reservation_id']}')">${value['primary_name']}(${value['reservation_id']})</span><span class="reservationid_drag" style="display:none">${value['id']}</span>
                </div>`);
            idCounter++; // Increment the counter for the next ID
        }
    });
    //cDetailsposition(); // Call the function to position the customer details popup hover
    //hoverBottomRow(); // Call the function to position the customer details popup hover right down corner
    initDraggable(); // Call the function to initialize draggable functionality
    check_room_closure(); // Call the function to check room closure data
}

function check_room_closure() {
    $.ajax({
        url: "{{ route('room.getRoomclosuredata') }}",
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                let closureData = response.data;
                var myvalue = document.getElementsByClassName('calcHeightWidth');
                let totalWidth = myvalue[0].offsetWidth;
                let ref_date = $('#datetime-local').val();
                let dateParts = ref_date.split('-');
                    ref_date = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                    closureData.forEach(function(value) {0
                    let close_room = value['room_number'];
                    let startDate_ur = new Date(value['start_date']);
                    let endDate_ur = new Date(value['end_date']);
                    let timeDiff_ur = endDate_ur - startDate_ur; // Calculate the difference in milliseconds.
                    let diffInDays_ur = timeDiff_ur / (1000 * 60 * 60 * 24); // Convert the difference to days.
                    let calculateMarginLeft = 0;
                    let calTotalWidth = 0;
                    calculateMarginLeft = totalWidth/2;
                    calTotalWidth = parseInt(totalWidth) * parseInt(diffInDays_ur);
                    let ns = '';
                    if (ref_date > value['start_date']) {
                        ns = ref_date;
                        let startDate_ur1 = new Date(ref_date);
                        let endDate_ur1 = new Date(value['end_date']);
                        let timeDiff_ur1 = endDate_ur1 - startDate_ur1; 
                        let diffInDays_ur = timeDiff_ur1 / (1000 * 60 * 60 * 24);
                        calTotalWidth = parseInt(totalWidth) * parseInt(Math.round(diffInDays_ur)) + calculateMarginLeft;
                        calculateMarginLeft = 0;
                    } else {
                        ns = value['start_date'];
                    }
                    const alloted_cellIndices1 = findAllotedCellIndices(datesArray,ns, value['end_date']);
                    let set_bg=0;
                    let area_name='';
                    if(set_bg == 0){
                        area_name= value['reason_closure'];
                        set_bg++;
                    }else{
                        area_name='';
                    }
                    $('td[data-key="' + close_room + '"][data-j="' + alloted_cellIndices1 + '"]').append(`
                        <div class="text-center d-flex bg-danger" style="margin-left: ${calculateMarginLeft}px; width: ${calTotalWidth}px; padding: 6px; cursor:pointer;" 
                            onclick="checkRoomClose('${close_room}', '${value['start_date']}', '${value['end_date']}')">
                            <span class="text-truncate text-white text-center">
                                ${area_name}
                            </span>
                        </div>
                    `);
                });
            } else {
                alert("Error: Could not retrieve room closure data.");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
}

        
$('#room_closure').on("submit", function(event) {
    event.preventDefault();
    let roomnum_closureValid = validateField("#roomnum_closure","select",".roomnum_closure_class");
    let reason_closureValid = validateField("#reason_closure","select",".reason_closure_class");
    if(roomnum_closureValid == true && reason_closureValid == true){
        let room_num = $('#roomnum_closure').val();
        let start_date = $('#startdate_closure').val();
        let convertedstart_date = convertDate(start_date);
        let end_date = $('#enddate_closure').val();
        let reason_closure = $('#reason_closure').val();
        let convertedend_date = convertDate(end_date);
        let desc = $('#desc_closure').val();
        $.ajax({
            url: "{{ route('backend.add_roomClosure') }}",
            method: "POST",
            data: {
                room_num: room_num,
                start_date: convertedstart_date,
                end_date: convertedend_date,
                reason_closure: reason_closure,
                desc: desc
            },
            success: function(data) {
                if(data.roomalready_close){
                    Swal.fire({ icon: "warning", title: "Already closed on these days!" });
                }else if(data.roomalready_reserve){
                    Swal.fire({ icon: "warning", title: "Already reserved on these days!" });
                } else {
                    $("#roomCloser").modal("hide");
                    let reload_reservation_duration = $('.reload_reservation_duration').html();
                    loadreservationdata(reload_reservation_duration, 2);
                }
            },
            error: function() {
                Swal.fire({ icon: "error", title: "An error occurred while submitting room closure." });
            }
        });
    }
});


function reservation_detail(x, y) {
    $(".resbox").removeClass('d-none').show();
}

function editresModelClose() {
  //  console.log('Modal close function called'); // Check if this log appears in web view
    // $('.booked-details').removeClass('d-none');
    // $('.booked-details_alt').removeClass('d-none');
    // $('.booked-details_checkout').removeClass('d-none');
    $('#EditReservation').modal('hide');
}
// Bind the function to the Close button
$('button[onclick="editresModelClose()"]').on('click', editresModelClose);
function reservationViewCount(x) {
    $.ajax({
        url: reservationCountView,
        method: "POST",
        data: {
            days: x,
        },
        success: function(data) {
            loadreservationdata(x, 2); //y=2 is for view count from current date
            window.location.reload(); // Properly reload the page
        }
    });
}

function dateChange(){
    loadreservationdata(99,0);
}
//Bootsrtap tool tip for day shift
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
</script>
{{-- // ---Edit reservation all append data are in reservation.js---- --}}
{{-- <script src="{{url('backend/assets/js/custom/reservation.js')}}"></script> --}}
@endsection
