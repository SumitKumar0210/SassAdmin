 let department_table = $('#department_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: departmentView,
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
        $('.department_add').click(function() {
            $('#departmentId').val('');
            $('#department_name').val('');
            $('.departmentTitle').html('Add department');
            $('.needs-validation').removeClass('was-validated');
            $('.departmentSubmit').removeClass('d-none');
            $('.departmentUpdate').addClass('d-none');
        });
        $('#department_form').on('submit', function(e) {
            e.preventDefault();
            let id = $('#departmentId').val();
            let name = $('#department_name').val();
            if (name == '') {
                $('needs-validation').addClass('was-validated');
            } else {
                if ($('.departmentUpdate').is(':visible')) {
                departmentUpdate(id); // Trigger update function when update btn is active
                } else {
                    $.ajax({
                        url: departmentAdd,
                        type: "POST",
                        data: {
                            name:name
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#department_form').removeClass('was-validated');
                                $('#department_form')[0].reset();
                                $('#departmentModel').modal('hide');
                                toastSuccessAlert(response.success);
                                $('#department_table').DataTable().ajax.reload();
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
        function departmentSwitch(id) {
            //  alert(id);
            $.ajax({
                url: departmentSwitchStatus,
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
                    $('#department_table').DataTable().ajax.reload();
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

        function departmentEdit(id) {
            $.ajax({
                url: departmentGetData,
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
                        $('#departmentId').val(id);
                        $('#department_name').val(getData.name);
                        $('#departmentModel').modal('show');
                        $('.departmentTitle').html('Edit department');
                        $('.departmentSubmit').addClass('d-none');
                        $('.departmentUpdate').removeClass('d-none');
                    } else {
                        alert("error");
                    }
                }
            });
        }

        function departmentUpdate(id) {
            let name = $('#department_name').val();
            if (name == '' ) {
                $('needs-validation').addClass('was-validated');
            } else {
               $.ajax({
                        url: departmentDataUpdate,
                        type: "POST",
                        data: {id:id,name:name
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#department_form').removeClass('was-validated');
                                $('#department_form')[0].reset();
                                $('#departmentModel').modal('hide');
                                toastSuccessAlert(response.success);
                                $('#department_table').DataTable().ajax.reload();
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