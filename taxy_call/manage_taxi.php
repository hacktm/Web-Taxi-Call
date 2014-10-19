<?php include('header.php');
if(!$_SESSION['logat'] == 1){header('location:  login_interface.php');}
      include('menu_admin_interface.php'); ?>
<style>
  body {
    background: -moz-linear-gradient(top,  rgba(0,0,0,0.15) 0%, rgba(0,0,0,0) 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0.15)), color-stop(100%,rgba(0,0,0,0))); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  rgba(0,0,0,0.15) 0%,rgba(0,0,0,0) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  rgba(0,0,0,0.15) 0%,rgba(0,0,0,0) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  rgba(0,0,0,0.15) 0%,rgba(0,0,0,0) 100%); /* IE10+ */
    background: linear-gradient(to bottom,  rgba(0,0,0,0.15) 0%,rgba(0,0,0,0) 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#26000000', endColorstr='#00000000',GradientType=0 ); /* IE6-9 */
  }
</style>
<table style="border: 2px solid black; margin:auto; text-align:center; box-shadow: 2px 3px 4px;" border="2">
</table>
<div id="nr_rows" data=""></div>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script>
  function update_row(row_index) {
    var row_info = new Object();
    row_info.update_row = 1;
    row_info.row_index = $('#driver_id'+row_index).text();
    row_info.driver_id = $('#driver_id'+row_index).text();
    row_info.company_id = $('#company_id'+row_index).text();
    row_info.driver_name = $('#driver_name'+row_index).text();
    row_info.phone = $('#phone'+row_index).text();
    row_info.indicative = $('#indicative'+row_index).text();
    row_info.car = $('#car'+row_index).text();
    row_info.total_km = $('#total_km'+row_index).text();
    row_info.total_money = $('#total_money'+row_index).text();
    row_info.username = $('#username'+row_index).text();
    row_info.password = $('#password'+row_index).text();
    $.post('ajax.php',row_info,function(data,status){
      alert(data);
      location.reload();
    });
  }
  function delete_row(row_index) {
    $.post('ajax.php',{
      delete_row : 1,
      row_index : $('#driver_id'+row_index).text()
    },function(data,status){
      alert(data);
      location.reload();
    });
  }
  function init() {
    $.post("ajax.php",{
        management_table : 1
      },function(data,status){
        $('table').html(data);
        $('#nr_rows').attr("data",$('table tbody tr').length);
      });
      window.setTimeout(function(){
        var nr_rows = $('#nr_rows').attr("data");
        for(i=1;i<=nr_rows;i++) {
          $('#update'+i).click(function(){
            //console.log(lastChar = $(this).attr('id').substr(id.length - 1));
            var id = $(this).attr('id');
            var id_array = id.split("");
            var value = id_array.length-1,j=value;
            /*while(typeof Number(id_array[j]) == 'Number') {
              console.log('Number');
              j--;
            }*/
            for(j=value;j>=0;j--) {
              if(!Number(id_array[j])&&Number(id_array[j])!='0') break;
            }
            value = id_array.length-j-1;
            var row_index = id.substr(id.length - value);
            //console.log(row_index);
            update_row(row_index);
          });
          $('#delete'+i).click(function(){
            //console.log(lastChar = $(this).attr('id').substr(id.length - 1));
            var id = $(this).attr('id');
            var id_array = id.split("");
            var value = id_array.length-1,j=value;
            for(j=value;j>=0;j--) {
              if(!Number(id_array[j])&&Number(id_array[j])!='0') break;
            }
            value = id_array.length-j-1;
            var row_index = id.substr(id.length - value);
            delete_row(row_index);
          });
        }
      },600);
  }
  $(document).ready(init);
</script>
<?php include('footer.php'); ?>