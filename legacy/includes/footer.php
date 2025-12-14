<?php
if(isset($_POST['emailsubscibe']))
{
$subscriberemail=$_POST['subscriberemail'];
$sql ="SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
$query= $dbh -> prepare($sql);
$query-> bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<script>alert('Already Subscribed.');</script>";
}
else{
$sql="INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
$query = $dbh->prepare($sql);
$query->bindParam(':subscriberemail',$subscriberemail,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Subscribed successfully.');</script>";
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}
}
?>

<footer>
  <div class="footer-top">
    <div class="container">
      <div class="row">
      
        <div class="col-md-6">
          <h6>About Us</h6>
          <ul>

        
          <li><a href="page.php?type=aboutus">About Us</a></li>
            <li><a href="page.php?type=faqs">FAQs</a></li>
            <li><a href="page.php?type=privacy">Privacy</a></li>
          <li><a href="page.php?type=terms">Terms of use</a></li>
               <li><a href="admin/">Admin Login</a></li>
          </ul>
        </div>
  
        <div class="col-md-3 col-sm-6">
          <h6>Subscribe Newsletter</h6>
          <div class="newsletter-form">
            <form method="post">
              <div class="form-group">
                <input type="email" name="subscriberemail" class="form-control newsletter-input" required placeholder="Enter Email Address" />
              </div>
              <button type="submit" name="emailsubscibe" class="btn btn-block">Subscribe <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </form>
            <p class="subscribed-text">*We send great deals and latest auto news to our subscribed users very week.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-push-6 text-right">
          <div class="footer_widget">
            <p>Connect with Us:</p>
            <ul>
              <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6 col-md-pull-6">
          <p class="copy-right">Car Rental Portal.</p>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 15px; text-align: center;">
      <div class="modal-body" style="padding: 40px;">
        <div style="font-size: 80px; color: #4CAF50; margin-bottom: 20px;">😊</div>
        <h3 style="color: #333; margin-bottom: 15px;">Success!</h3>
        <p style="font-size: 18px; color: #666;">You have successfully registered</p>
        <button type="button" class="btn btn-success" data-dismiss="modal" style="margin-top: 20px; padding: 10px 40px; font-size: 16px;">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 15px; text-align: center;">
      <div class="modal-body" style="padding: 40px;">
        <div style="font-size: 80px; color: #f44336; margin-bottom: 20px;">😞</div>
        <h3 style="color: #333; margin-bottom: 15px;">Oops!</h3>
        <p style="font-size: 18px; color: #666;" id="errorMessage">An error occurred</p>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 20px; padding: 10px 40px; font-size: 16px;">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
<?php 
// Check both Laravel session and PHP session
$hasSuccess = (function_exists('session') && session('success_modal')) || (isset($_SESSION['success_modal']));
$hasError = (function_exists('session') && session('error_modal')) || (isset($_SESSION['error_modal']));
$errorMsg = '';
if ($hasError) {
    $errorMsg = function_exists('session') && session('error_modal') ? session('error_modal') : (isset($_SESSION['error_modal']) ? $_SESSION['error_modal'] : 'An error occurred');
}
?>

<?php if($hasSuccess): ?>
  $(document).ready(function() {
    console.log('Showing success modal');
    $('#successModal').modal('show');
  });
<?php 
  if(function_exists('session')) session()->forget('success_modal');
  if(isset($_SESSION['success_modal'])) unset($_SESSION['success_modal']); 
endif; 
?>

<?php if($hasError): ?>
  $(document).ready(function() {
    console.log('Showing error modal');
    $('#errorMessage').text('<?php echo addslashes($errorMsg); ?>');
    $('#errorModal').modal('show');
  });
<?php 
  if(function_exists('session')) session()->forget('error_modal');
  if(isset($_SESSION['error_modal'])) unset($_SESSION['error_modal']); 
endif; 
?>
</script>