<!DOCTYPE html>
<html>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 text-center mt-2">
            <h1>Stream Information</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-8 offset-md-2">
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Stream Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="m-0 input_form" id="form_action" role="form" action="" method="post">
                <div class="card-body row">
                  <div class="col-md-12 ">
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Enter Title Of Stream</label>
                        <input type="text" class="form-control form-control-sm" name="blog_name" id="blog_name" value="<?php if(isset($service_info)){ echo $service_info['blog_name']; } ?>" placeholder="Enter Stream Title " required>
                      </div>

                      <div class="form-group col-md-12">
                        <label>Enter Short Description </label>
                        <textarea class="form-control form-control-sm" name="blog_description" rows="3" cols="85"></textarea>
                      </div>

                      <div class="form-group col-md-6">
                      <label>Image</label>
                      <input type="file" class="form-control form-control-sm" name="manufacturer_img" id="manufacturer_img" class="form-control" id="exampleInputFile">
                    </div>
                  </div>
                </div>
                </div>
                <div class="card-footer row">
                  <div class="col-md-6">
                    <div class="custom-control custom-checkbox ml-2">
                      <input class="custom-control-input" type="checkbox" name="service_status" id="service_status" value="1" checked>
                      <label for="service_status" class="custom-control-label">Active</label>
                    </div>
                  </div>
                  <div class="col-md-6 text-right">
                    <?php if(isset($update)){ ?>
                      <button id="btn_update" type="submit" class="btn btn-primary">Update </button>
                    <?php } else{ ?>
                      <button id="btn_save" type="submit" class="btn btn-success px-4">Save</button>
                    <?php } ?>
                    <a href="<?php echo base_url() ?>User/service_list" class="btn btn-default ml-4">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>

<script type="text/javascript">
// Check Mobile Duplication..
  var blog_name1 = $('#blog_name').val();
  $('#blog_name').on('change',function(){
    var blog_name = $(this).val();
    $.ajax({
      url:'<?php echo base_url(); ?>User/check_duplication',
      type: 'POST',
      data: {"column_name":"blog_name",
             "column_val":blog_name,
             "table_name":"service"},
      context: this,
      success: function(result){
        if(result > 0){
          $('#blog_name').val(blog_name1);
          toastr.error(blog_name+' Exist.');
        }
      }
    });
  });
</script>
</body>
</html>
