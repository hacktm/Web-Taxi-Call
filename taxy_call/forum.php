<?php include('header.php');
      include('forum_menu.php');
      include('connect_db.php'); ?>
<table border="2" style="margin: auto;" class="table table-striped table-bordered table-condensed">
  <thead>
    <th>Name</th>
    <th>Report</th>
  </thead>
  <tbody>
    <?php 
      //if($con) echo 'Works';
      $select_reports = mysqli_query($con,"SELECT *FROM `reports`");
      while($row_reports = mysqli_fetch_array($select_reports)) {
        ?>
        <tr>
          <td><?php echo $row_reports['name_driver']; ?> </td>
          <td><?php echo $row_reports['report']; ?></td>
        </tr>
        <?php
      }
    ?>
  </tbody>
</table>
<?php include('footer.php'); ?>