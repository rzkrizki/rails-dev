<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><button class="btn btn-primary" onclick="openModal(0, `add`)">Add Your Task</i></button></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" id="tableDiv">

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>

<div class="modal fade" id="taskModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Task From</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="task_id" hidden>
                <div class="form-group">
                    <label>Date:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="date" data-target="#reservationdate" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Task</label>
                    <br>
                    <textarea name="mytask" id="mytask" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Priorty</label>
                    <input type="number" id="priority" class="form-control" />
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button onclick="check()" type="button" class="btn btn-primary btn-block">Save your task</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        load_tab();
    })

    function load_tab() {
        $("#tableDiv").empty();
        $.ajax({
            type: 'GET',
            url: "<?php echo base_url(); ?>todolist/get_todolist/",
            success: function(msg) {
                $("#tableDiv").html(msg);
            },
            error: function() {
                $("#tableDiv").html("Error");
            },
            fail: (function(status) {
                $("#tableDiv").html("Fail");
            }),
            beforeSend: function(d) {
                $("#tableDiv").html("<center id='spinner'><strong style='color: #777'>Please Wait...</strong></center>");
            }
        });
    }

    function openModal(id, type) {
        if(type == 'add'){
            console.log('add')
            $('#taskModal').modal('show');
        }else{
            console.log('edit')
            get_detail_data(id)
        }
    }

    function check() {
        var task_id = $('#task_id').val()
        var date = $('#date').val()
        var mytask =  $('#mytask').val()
        var priority = $('#priority').val()

        if(date != '' && mytask != '' && priority != ''){
            if(task_id == ''){
                save(0)
            }else{
                save(task_id)
            }
        }else{
            if(date == ''){
                get_error('Date is required')
            }else if(mytask == ''){
                get_error('Task is required')
            }else{
                get_error('Priority is required')
            }
        }
    }

    function save(task_id) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>todolist/save/",
            dataType: 'json',
            data: {
                "task_id": task_id,
                "date": $('#date').val(),
                "mytask": $('#mytask').val(),
                "priority": $('#priority').val()
            },
            success: function(response) {
                if (response.status == 'success') {
                    get_success(response.message)
                    reset_form();
                } else {
                    get_error(response.message)
                }
                $('#taskModal').modal('hide');
            },
            error: function(err) {
                get_error(err)
            },
            fail: (function() {
                get_error('Failed')
            })
        });
    }

    function update(id, type) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>todolist/update",
            dataType: 'json',
            data: {
                "id": id,
                "type": type
            },
            success: function(response) {
                if (response.status == 'success') {
                    get_success(response.message)
                } else {
                    get_error(response.message)
                }
            },
            error: function(err) {
                get_error(err)
            },
            fail: (function() {
                get_error('Failed')
            })
        });
    }

    function get_detail_data(id){

        reset_form();

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>todolist/get_detail_data",
            dataType: 'json',
            data: {
                "id": id
            },
            success: function(response) {
                if(response.status == 'success'){
                    append_data_to_table(response)
                    console.log(response)
                }else{
                    get_error(response.message)
                }
            },
            error: function(err) {
                get_error(err)
            },
            fail: (function() {
                get_error('Failed')
            })
        });
    }

    function reset_form(){
        $('#task_id').val('')
        $('#date').val('')
        $('#mytask').val('')
        $('#priority').val('')
    }

    function append_data_to_table(response){
        $('#task_id').val(response.results.id)
        $('#date').val(response.results.last_date)
        $('#mytask').val(response.results.mytask)
        $('#priority').val(response.results.priority)
        $('#taskModal').modal('show');
    }

    function confirmation(id) {
        Swal.fire({
            title: 'Do you want to save the changes?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: `Save`,
        }).then((result) => {
            if (result.isConfirmed) {
                remove(id)
            }
        })
    }

    function remove(id) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>todolist/delete",
            dataType: 'json',
            data: {
                "id": id
            },
            success: function(response) {
                get_success(response.message)
            },
            error: function(err) {
                get_error(err)
            },
            fail: (function() {
                get_error('Failed')
            })
        });
    }

    function get_success(message) {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: message,
            showConfirmButton: false,
            timer: 2000
        }).then((result) => {
            load_tab()
        })
    }

    function get_error(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        })
    }
</script>