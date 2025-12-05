 let tariff_table = $('#tariff_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tariffView,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function(xhr, error, thrown) {
                    console.log(xhr.responseText);
                    alert('Error: ' + thrown);
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'tariffType',
                    name: 'tariffType'
                },
                {
                    data: 'roomTariff',
                    name: 'roomTariff'
                },
                {
                    data: 'extraPersonTariff',
                    name: 'extraPersonTariff'
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
        $('.tariff_add').click(function() {
            $('#tariffId').val('');
            $('#tariffType').val('');
            $('#roomTariff').val('');
            $('#extraPersonTariff').val('');
            $('.tariffTitle').html('Add Tariff');
            $('.needs-validation').removeClass('was-validated');
            $('.tariffSubmit').removeClass('d-none');
            $('.tariffUpdate').addClass('d-none');
        });

        $('#tariff_form').on('submit', function(e) {
            e.preventDefault();
            let id = $('#tariffId').val();
            let category = $('#roomnum_type').val();
            let tariffType = $('#tariffType').val();
            let roomTariff = $('#roomTariff').val();
            let extarPersonTariff = $('#extraPersonTariff').val();
            if (tariffType =='' || roomTariff =='' || extarPersonTariff =='') {
                $('needs-validation').addClass('was-validated');
            } else {
                if ($('.tariffUpdate').is(':visible')) {
                tariffUpdate(id); // Trigger update function when update btn is active
                } else {
                    $.ajax({
                        url: tariffAdd,
                        type: "POST",
                        data: {tariffType:tariffType,roomTariff:roomTariff,extarPersonTariff:extarPersonTariff,category:category},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#tariff_form').removeClass('was-validated');
                                $('#tariff_form')[0].reset();
                                $('#tariffModel').modal('hide');
                                $('.alert_msg').html(response.success);
                                var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                                toast.show();
                                $('#tariff_table').DataTable().ajax.reload();
                            } else if(response.alreadyfound){
                                $('.alert_msg_danger').html(response.alreadyfound);
                                var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                                toast.show();              
                            } else if(response.error_validation){
                                $('.alert_msg_danger').html(response.error_validation);
                                var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                                toast.show(); 
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

        function tariffSwitch(id) {
            //  alert(id);
            $.ajax({
                url: tariffSwitchStatus,
                type: "POST",
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('.alert_msg').html('Status Changed Successfully');
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();             
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

        function tariffEdit(id) {
            $.ajax({
                url: tariffGetData,
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
                        $('#tariffId').val(id);
                        $('#roomnum_type').val(getData.room_category_id);
                        $('#tariffType').val(getData.tariff_type);
                        $('#roomTariff').val(getData.room_tariff);
                        $('#extraPersonTariff').val(getData.extra_person_tariff);
                        $('#tariffModel').modal('show');
                        $('.tariffTitle').html('Edit tariff');
                        $('.tariffSubmit').addClass('d-none');
                        $('.tariffUpdate').removeClass('d-none');
                    } else {
                        alert("error");
                    }
                }
            });
        }

        function tariffUpdate(id) {
            let category = $('#roomnum_type').val();
            let tariffType = $('#tariffType').val();
            let roomTariff = $('#roomTariff').val();
            let extarPersonTariff = $('#extraPersonTariff').val();
            if (tariffType =='' || roomTariff =='' || extarPersonTariff =='') {
                $('needs-validation').addClass('was-validated');
            } else {
                $.ajax({
                        url: tariffDataUpdate,
                        type: "POST",
                        data: {id:id, tariffType:tariffType, roomTariff:roomTariff, extarPersonTariff:extarPersonTariff, category:category },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#tariff_form').removeClass('was-validated');
                                $('#tariff_form')[0].reset();
                                $('#tariffModel').modal('hide');
                                $('.alert_msg').html(response.success);
                                var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                                toast.show();
                                $('#tariff_table').DataTable().ajax.reload();
                            } else if(response.alreadyfound){
                                $('.alert_msg_danger').html(response.alreadyfound);
                                var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                                toast.show();              
                            } else if(response.error_validation){
                                $('.alert_msg_danger').html(response.error_validation);
                                var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                                toast.show(); 
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