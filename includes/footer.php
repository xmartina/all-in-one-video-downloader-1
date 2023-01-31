<footer class="app-footer">
  <div class="row">
    <div class="col-xs-12">
      <div class="footer-copyright">Copyright © <?php echo date('Y');?> <a href="http://www.viaviweb.com" target="_blank">Viaviweb.com</a>. All Rights Reserved.</div>
    </div>
  </div>
</footer>
</div>
</div>
<script type="text/javascript" src="assets/js/vendor.js"></script> 
<script type="text/javascript" src="assets/js/app.js"></script>

<script src="assets/js/notify.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- End -->
<script type="text/javascript" src="assets/duDialog-master/duDialog.min.js?v=<?=date('dmYhis')?>"></script>

<script src="assets/snackbar-master/snackbar.js"></script>

<script>
  $("#checkall").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script> 

<?php if(isset($_SESSION['msg'])){?>
  <script type="text/javascript">
    var _msg="<?php echo $client_lang[$_SESSION["msg"]]; ?>";
    Snackbar.show({text: _msg,msgClass:"<?=$_SESSION['class']?>"});
  </script>
  <?php unset($_SESSION['msg']);
  unset($_SESSION['class']);
}?>
<script type="text/javascript">
  $(document).ready(function(event) {

    $(document).on("click", ".enable_disable", function(e) {
      var _action;

      var _currentElement = $(this);
      var _id = $(this).data("id");
      var _table = $(this).data("table");
      var _column = $(this).data("column");

      var _for = $(this).prop("checked");
      if (_for == false) {
        _action = "disable";
      } else {
        _action = "enable";
      }

      $.ajax({
        type: 'post',
        url: 'processData.php',
        dataType: 'json',
        data: {id: _id, for_action: _action, table: _table, column: _column,'action':'toggle_status'},
        success: function(res) {
          Snackbar.show({text: res.msg,msgClass:res.class});
        }
      });
    });
  });
  function render_upload_image(input, target) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        target.attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  function isImage(filename) {
    var ext = getExtension(filename);
    switch (ext.toLowerCase()) {
      case 'jpg':
      case 'jpeg':
      case 'png':
      case 'gif':
      return true;
    }
    return false;
  }

  function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
  }

  $(".filter").on("change", function(e) {
    $("#filterForm *").filter(":input").each(function() {
      if ($(this).val() == '')
        $(this).prop("disabled", true);
    });
    $("#filterForm").submit();
  });
  $(document).on("click", ".btn_delete", function(e){

    e.preventDefault();

    var _ids=$(this).data("id");
    var _table=$(this).data("table");

    var confirmDlg = duDialog('Are you sure?', 'All data will be removed which belong to this!', {
      init: true,
      dark: false, 
      buttons: duDialog.OK_CANCEL,
      okText: 'Proceed',
      callbacks: {
        okClick: function(e) {
          $(".dlg-actions").find("button").attr("disabled",true);
          $(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{'id':_ids,'table':_table,'for_action':'delete','action':'multi_action'},
            success:function(res){
              location.reload();
            }
          });
        } 
      }
    });
    confirmDlg.show();
  });
  $(".toggle_btn_a").on("click",function(e){
    e.preventDefault();

    var _for=$(this).data("action");
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_video';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status_a','tbl_id':'id'},
      success:function(res){
        console.log(res);
        if(res.status=='1'){
         location.reload();
       }
     }
   });
  });
  $(document).on("click", ".actions", function(e) {
    e.preventDefault();

    var _ids = $.map($('.post_ids:checked'), function(c) {
      return c.value;
    });
    var _action = $(this).data("action");

    if (_ids != '') {

      var _table = $(this).data("table");

      if( typeof $(this).data("column") != 'undefined'){
        var _column = $(this).data("column");
      }
      else{
        var _column = '';
      }

      var confirmDlg = duDialog("Action: " + $(this).text(), "Do you really want to perform?", {
        init: true,
        buttons: duDialog.OK_CANCEL,
        okText: 'Proceed',
        callbacks: {
          okClick: function(e) {
            $(".dlg-actions").find("button").attr("disabled",true);
            $(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');

            $.ajax({
              type: 'post',
              url: 'processData.php',
              dataType: 'json',
              data: {id: _ids, for_action: _action, table: _table, 'action': 'multi_action','column': _column},
              success: function(res) {
                $('.notifyjs-corner').empty();
                if (res.status == '1') {
                  location.reload();
                }
                else{
                  Snackbar.show({text: res.msg});
                }
              }
            });

          } 
        }
      });
      confirmDlg.show();
    } else {
      Snackbar.show({text: 'Sorry no data selected!'});
    }
  });

  var totalItems = 0;

  $(document).on("click", "#checkall_input", function() {

    totalItems = 0;

    $("input[name='post_ids[]']").not(this).prop('checked', this.checked);
    $.each($("input[name='post_ids[]']:checked"), function() {
      totalItems = totalItems + 1;
    });

    if ($("input[name='post_ids[]']").prop("checked") == true) {
      $('.notifyjs-corner').empty();
      $.notify(
        'Total ' + totalItems + ' item checked', {
          position: "top center",
          className: 'success',
          clickToHide: false,
          autoHide: false
        }
        );
    } else if ($("input[name='post_ids[]']").prop("checked") == false) {
      totalItems = 0;
      $('.notifyjs-corner').empty();
    }
  });

  $(document).on("click", ".post_ids", function(e) {

    if ($(this).prop("checked") == true) {
      totalItems = totalItems + 1;
    } else if ($(this).prop("checked") == false) {
      totalItems = totalItems - 1;
    }

    if (totalItems == 0) {
      $('.notifyjs-corner').empty();
      exit();
    }

    $('.notifyjs-corner').empty();

    $.notify(
      'Total ' + totalItems + ' item checked', {
        position: "top center",
        className: 'success',
        clickToHide: false,
        autoHide: false
      }
      );
  });
</script>

</body>
</html>