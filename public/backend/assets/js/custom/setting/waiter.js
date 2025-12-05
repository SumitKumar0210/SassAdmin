 let waiter_table = $('#waiter_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: waiterView,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function(xhr, error, thrown) {
                    console.log(xhr.responseText);
                    alert('Error: ' + thrown);
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $('.waiter_add').click(function() {
            $('#waiterId').val('');
            $('#waiter_name').val('');
            $('#waiter_mobile').val('');
            $('.waiterTitle').html('Add Waiter');
            $('.needs-validation').removeClass('was-validated');
            $('.waiterSubmit').removeClass('d-none');
            $('.waiterUpdate').addClass('d-none');
        });
        $('#waiter_form').on('submit', function(e) {
            e.preventDefault();
            let id = $('#waiterId').val();
            let name = $('#waiter_name').val();
            let mobile = $('#waiter_mobile').val();
            if (name == '' || mobile == '' ) {
                $('needs-validation').addClass('was-validated');
            } else {
                if ($('.waiterUpdate').is(':visible')) {
                waiterUpdate(id); // Trigger update function when update btn is active
                } else {
                    $.ajax({
                        url: waiterAdd,
                        type: "POST",
                        data: {
                            name:name,mobile:mobile
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#waiter_form').removeClass('was-validated');
                                $('#waiter_form')[0].reset();
                                $('#waiterModel').modal('hide');
                                toastSuccessAlert(response.success);
                                $('#waiter_table').DataTable().ajax.reload();
                            } else if(response.alreadyfound){
                                toastErrorAlert(response.alreadyfound);             
                            } else if(response.error_validation){
                                toastWarningAlert(response.error_validation);    
                            } else{             
                            alert("Error");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert("An error occurred: " + error);
                        }
                    });
                }
            }
        });
        function waiterSwitch(id) {
            //  alert(id);
            $.ajax({
                url: waiterSwitchStatus,
                type: "POST",
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        toastSuccessAlert(response.success);
                    $('#room_bedtype_table').DataTable().ajax.reload();
                    } else {
                        alert("Error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }

        function waiterEdit(id) {
            $.ajax({
                url: waiterGetData,
                type: "POST",
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        let getData = response.data[0];
                        $('#waiterId').val(id);
                        $('#waiter_name').val(getData.name);
                        $('#waiter_mobile').val(getData.mobile);
                        $('#waiterModel').modal('show');
                        $('.waiterTitle').html('Edit Waiter');
                        $('.waiterSubmit').addClass('d-none');
                        $('.waiterUpdate').removeClass('d-none');
                    } else {
                        alert("error");
                    }
                }
            });
        }

        function waiterUpdate(id) {
            let name = $('#waiter_name').val();
            let mobile = $('#waiter_mobile').val();
            if (name == '' || mobile == '' ) {
                $('needs-validation').addClass('was-validated');
            } else {
               $.ajax({
                        url: waiterDataUpdate,
                        type: "POST",
                        data: {id:id,name:name,mobile:mobile
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#waiter_form').removeClass('was-validated');
                                $('#waiter_form')[0].reset();
                                $('#waiterModel').modal('hide');
                                toastSuccessAlert(response.success);
                                $('#waiter_table').DataTable().ajax.reload();
                            } else if(response.alreadyfound){
                               toastErrorAlert(response.alreadyfound);              
                            } else if(response.error_validation){
                               toastWarningAlert(response.error_validation);  
                            } else{             
                            alert("Error");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert("An error occurred: " + error);
                        }
                    });
            }
        }