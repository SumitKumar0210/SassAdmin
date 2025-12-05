let table = $('#room_bedtype_table1').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: closerReasonView,
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
                    data: 'color',
                    name: 'color'
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
                }
            ]
        });
        $('.closerReasonAdd').on('click',function(e){
            e.preventDefault();
            $('.closerReasonTitle').html('Add Closer Reason');
            $('.closerReasonUpdate').addClass('d-none');
            $('.closerReasonSubmit').removeClass('d-none');
            $('.needs-validation').removeClass('was-validated');
        })
            $('#closerReason_form').on('submit', function(e) {
            e.preventDefault();
            let id = $('#closer_reason_id').val();
            let name = $('#closer_reason').val();
            let color = $('#closer_reason_color').val();
            if (name == '' || color == '') {
                $('needs-validation').addClass('was-validated');
            } else {
                if ($('.closerReasonUpdate').is(':visible')) {
                closerReasonUpdate(id); // Trigger update function when update btn is active
                } else {
                    $.ajax({
                        url: closerReasonAdd,
                        type: "POST",
                        data: {
                            name:name,color:color
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#closerReason_form').removeClass('was-validated');
                                $('#closerReason_form')[0].reset();
                                $('#departmentModel').modal('hide');
                                toastSuccessAlert(response.success);
                                $('#room_bedtype_table1').DataTable().ajax.reload();
                            } else if(response.alreadyfound_error){
                                toastErrorAlert(response.alreadyfound_error);             
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
        function CloserReasonSwitch(id) {
            //  alert(id);
            $.ajax({
                url: closerReasonSwitch,
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
                    $('#room_bedtype_table1').DataTable().ajax.reload();
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

        function closerReasonEdit(id) {
            $.ajax({
                url: closerReasonGetData,
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
                        $('#closer_reason_id').val(id);
                        $('#closer_reason').val(getData.name);
                        $('#closer_reason_color').val(getData.color);
                        $('#closerReason').modal('show');
                        $('.closerReasonTitle').html('Edit Closer Reason');
                        $('.closerReasonSubmit').addClass('d-none');
                        $('.closerReasonUpdate').removeClass('d-none');
                    } else {
                        alert("error");
                    }
                }
            });
        }

        function closerReasonUpdate(id) {
            let name = $('#closer_reason').val();
            let color = $('#closer_reason_color').val();
            if (name == '' || color == '') {
                $('needs-validation').addClass('was-validated');
            } else {
                $.ajax({
                        url: closerReasonDataUpdate,
                        type: "POST",
                        data: {id:id,name:name,color:color
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#closerReason_form').removeClass('was-validated');
                                $('#closerReason_form')[0].reset();
                                $('#closerReason').modal('hide');
                                toastSuccessAlert(response.success);
                                $('#room_bedtype_table1').DataTable().ajax.reload();
                            } else if(response.alreadyfound_error){
                               toastErrorAlert(response.alreadyfound_error);              
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