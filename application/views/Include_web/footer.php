
<footer>
<div class="container">
  <div class="row">
    <div class="col-md-4">
       <img class="brand-logo-footer" src="<?php echo base_url(); ?>assets/images/logo.png"  alt="">
       <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div class="col-md-4">
      <h4 class="pb-3">Services</h4>
      <ul>
        <li>Demo link</li>
        <li>Demo link</li>
        <li>Demo link</li>
        <li>Demo link</li>
        <li>Demo link</li>
        <li>Demo link</li>
        <li>Demo link</li>
        <li>Demo link</li>
      </ul>
        </div>
    <div class="col-md-4">
      <h4 class="pb-3">Address</h4>
       <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
       <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
       <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
       <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
    </div>
  </div>
</div>
</footer>

<section class="bottom-footer">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p class="text-center">Design By Technothinksup Pvt. Ltd. </p>
      </div>
    </div>
  </div>
</section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>


    <script type="text/javascript">
      $(document).ready(function() {
        var url = window.location.href;
        var activePage = url;
        $('.nav-item').removeClass('active');
        // alert(activePage);
        $('.nav-link').each(function () {
          var linkPage = this.href;
          if (activePage == linkPage) {
              $(this).closest(".nav-item").addClass("active");
          }
        });
      });
    </script>

  </body>
</html>
