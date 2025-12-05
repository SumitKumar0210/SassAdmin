@extends('backend.layouts.main')
@section('title','Setting General Setting')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">General Setting</h3>
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

@endsection
@section('extra-js')
<script>
    const updateInvoiceGeneralSetting = "{{ route('general-setting-invoice.updateInvoice') }}";
    const resetInvoice = "{{ route('general-setting-invoice-reset.resetInvoiceNumber') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/general_setting.js')}}"></script>
@endsection
