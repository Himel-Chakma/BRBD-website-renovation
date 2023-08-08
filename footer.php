<!-- Footer Section -->
<div class="container">
    <hr>
      <div class="row py-4">
        <div class="col-lg-4">
            <a href=""><img src="img/logo2.png" class="img-fluid" width="150"></a>
            <p class="my-4">Call us <br>
            <span class="text-primary fs-5 fw-bold">880163473737</span>
            </p>
            <p>
            58 Howard Street #2 San Francisco<br>contact@edumall.com
            </p>
            <p class="d-flex fs-5">
              <a href="" class="me-4 text-decoration-none text-reset"><i class="fa-brands fa-facebook-f" style="color: #1877F2;"></i></a>
              <a href="" class="me-4 text-decoration-none text-reset"><i class="fa-brands fa-youtube" style="color: #FF0000;"></i></a>
              <a href="" class="me-4 text-decoration-none text-reset"><i class="fa-brands fa-skype" style="color: #00AFF0;"></i></a>
              <a href="" class="me-4 text-decoration-none text-reset"><i class="fa-brands fa-linkedin-in" style="color: #0077B5;"></i></a>
            </p>
        </div>
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-4">
              <h5>About</h5>
              <ul class="nav d-flex flex-column mt-4">
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">About Us</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Courses</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Instructors</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Blogs</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Become an instructor</a>
                </li>
              </ul>
            </div>
            <div class="col-md-4">
              <h5>Links</h5>
              <ul class="nav d-flex flex-column mt-4">
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">About Us</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Courses</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Instructors</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Blogs</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Become an instructor</a>
                </li>
              </ul>
            </div>
            <div class="col-md-4">
              <h5>Support</h5>
              <ul class="nav d-flex flex-column mt-4">
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">About Us</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Courses</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Instructors</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Blogs</a>
                </li>
                <li class="nav-item mb-2">
                  <a href="" class="nav-link m-0 p-0">Become an instructor</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    <hr class="mb-0">
      <div class="d-flex flex-wrap justify-content-between text-center custom-media">
        <ul class="nav d-flex flex-row justify-content-center">
          <li class="py-3 pe-3">
            <a href="" class="text-decoration-none text-reset">Terms of us</a>
          </li>
          <li class="py-3">
            <a href="" class="text-decoration-none text-reset">Privacy Policy</a>
          </li>
        </ul>
        <div class="p-3 pe-0">Copyright &copy; 2023 All Rights Reserved by Md Alam Miah, Md Imtiaj, Himel Chakma</div>
      </div>
</div>
<script>
window.onscroll = function() {
	scrollFunction(), myFunction3()
};
function scrollFunction() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("sms").style.opacity = "1";
    document.getElementById("sms").style.bottom = "35px";
  } else {
    document.getElementById("sms").style.opacity = "0";
    document.getElementById("sms").style.bottom = "30px";
  }
}
var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;
function myFunction3() {
	if (window.pageYOffset >= sticky) {
		navbar.classList.add("sticky")
	} else {
		navbar.classList.remove("sticky");
	}
}
</script>