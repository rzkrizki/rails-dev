<?php if (!empty($results)) { ?>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Task</th>
                <th>Priorty Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($results as $row) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date("d M Y", strtotime($row->last_date));  ?></td>
                    <td><?= $row->mytask ?></td>
                    <td><span class="badge badge-info"><?= $row->priority ?></span></td>
                    <td nowrap>
                        <?php if($row->is_done == 0){ ?>
                            <button class="btn btn-success" data-toggle="tooltip" title="Tandai sudah selesai" onclick="update(` <?= $row->id ?>`)"><i class="fa fa-check"></i></button>
                        <?php }else{ ?>
                            <button class="btn btn-success" data-toggle="tooltip" title="Sudah ditandai selesai" disabled><i class="fa fa-check"></i></button>
                        <?php } ?>
                        <button class="btn btn-warning text-bold text-white" data-toggle="tooltip" title="Edit task">Edit</button>
                        <button class="btn btn-danger text-bold" data-toggle="tooltip" title="Delete task" onclick="remove(` <?= $row->id ?>`)">Delete</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else {
    echo "<h6 class='text-center text-muted'>Data Not Found</h6>";
} ?>

<script>
$(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
  });
</script>