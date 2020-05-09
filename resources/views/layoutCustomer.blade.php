
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
	<meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <base href="{{ asset('/customerInterface/')}}">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="{{ asset('customerInterface/css/grid.css ')}}">
	<link rel="stylesheet" href="{{ asset('customerInterface/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('customerInterface/css/rd-mailform.css') }}">
    <script src="{{ asset('customerInterface/js/validate.js') }}"></script>
    <script src="{{ asset('customerInterface/js/jquery.js') }}"></script>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>

</head>

<body>
<div class="page">
	<!--==============================HEADER==============================-->
	<header>
		<section class="parallax parallax01">
			<div class="top-panel">
				<div class="container">
					<div class="brand">
						<h1 class="brand_name"><a href="./">astoria</a></h1>
						<p class="brand_slogan">restaurant</p>
					</div>
				</div>
			</div>
			<div class="container">
				<h2>Discover the New Way to Love Food</h2>
				<p><em>Best Service, Best Food &amp; best Atmosphere!</em></p>
				<div class="row">
					<div class="preffix_4 grid_4">
						<!-- RD Mailform -->
						<form class='rd-mailform' method="post" action="{{ route('booking.store') }}" onsubmit="return validateBooking()">
                            @csrf
							<!-- RD Mailform Type -->
							<input type="hidden" name="form-type" value="contact"/>
							<!-- END RD Mailform Type -->
							<fieldset>
								<label data-add-placeholder>
									<input type="text" name="name" placeholder="Full name" required>
								</label>

                                <label data-add-placeholder data-add-icon>
									<input type="date" name="date" id="date"  required >
                                </label>

                                <label data-add-placeholder data-add-icon>
                                    <input type="time" name="time" id="time" min="08:00" max="21:00" required>
                                </label>
								<label data-add-placeholder>
									<input type="email"  name="email" placeholder="E-mail"  required>
								</label>

								<label data-add-placeholder>
									<input type="phone" id="phone"  name="phone" placeholder="Phone"  required>
								</label>

								<div class="mfControls btn-group">
									<button class="btn" type="submit">Booking Now</button>
								</div>
								<div class="mfInfo"></div>
							</fieldset>
							<p class="text-center"><small>Vivamus diam enim, cursus sed urna eu, lobortis lobortis tellus at, tempor nisl. </small></p>
						</form>
						<!-- END RD Mailform -->

					</div>
				</div>
			</div>
		</section>
	</header>

	<!--==============================CONTENT==============================-->
	<main>
		<section class="well center">
			<div class="container">
				<h2>About Our Restaurant</h2>
				<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				<div class="row iconed-list">
					<div class="grid_4">
						<div class="icon fa-coffee"></div>
						<h3>Local Menus</h3>
						<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
					</div>
					<div class="grid_4">
						<div class="icon fa-glass icon__bg-2"></div>
						<h3>Daily Specials</h3>
						<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
					</div>
					<div class="grid_4">
						<div class="icon fa-cutlery icon__bg-3"></div>
						<h3>Private Dining</h3>
						<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
					</div>
				</div>
			</div>
		</section>
		<section class="well well__02 bg-2 shadow">
			<div class="container">
				<div class="row">
					<div class="grid_5">
						<div class="img"><img src="{{ asset('customerInterface/images/img01.jpg')}}" alt=""></div>
					</div>
					<div class="grid_7 offset01">
						<h2>Using only high quality ingredients</h2>
						<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.</p>
					</div>
				</div>
			</div>
		</section>
		<section class="well well__03">
			<div class="container">
				<h2>Our Benefits</h2>
				<div class="row">
					<div class="grid_6">
						<div class="iconed-box">
							<div class="icon fa-comments-o"></div>
							<h4>Lorem ipsum dolor quis</h4>
							<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
						</div>
					</div>
					<div class="grid_6">
						<div class="iconed-box">
							<div class="icon fa-book"></div>
							<h4>Eiusmod tempor incididunt</h4>
							<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="grid_6">
						<div class="iconed-box">
							<div class="icon fa-group"></div>
							<h4>Sit amet conse ctetur</h4>
							<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
						</div>
					</div>
					<div class="grid_6">
						<div class="iconed-box">
							<div class="icon fa-heart-o"></div>
							<h4>Adipisicing elit sed do</h4>
							<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="parallax parallax02 shadow">
			<div class="container">
				<div class="row">
					<div class="preffix_1 grid_10">
						<blockquote>
							<q>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</q>
							<div class="img img__circle"><img src="{{ asset('customerInterface/images/img02.jpg')}}" alt=""></div>
							<h5><cite>Olivia Grosh</cite></h5>
							<p>Lorem ipsum dolor sit amet conse ctetu</p>
						</blockquote>
					</div>
				</div>
			</div>
		</section>

		<section class="well">
			<div class="container">
				<h2>Whats Hot?</h2>
				<div class="row">
					<div class="grid_6 left">
						<h4>Adipisicing elit sed do</h4>
						<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
					</div>
					<div class="grid_6 left">
						<h4>Eusmod tempor incididunt </h4>
						<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
					</div>
				</div>
				<div class="row offset02">
					<div class="grid_6 left">
						<h4>Velit esse cillum dolore </h4>
						<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
					</div>
					<div class="grid_6 left">
						<h4>Fugiat nulla pariatu</h4>
						<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="well well__04 bg-3">
			<div class="container">
			<h2>Ensuring 100% guest satisfaction<br> on every visit</h2>
			<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure doloю</p>
			<a href="#" class="btn">Get a Quotes</a>
			</div>
		</section>
	</main>

	<!--==============================FOOTER==============================-->
	<footer>
		<div class="container">
			<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitatio.</p>
			<div class="footer-brand">
				<div class="footer-brand_name"><a href="#">astoria</a></div>
				<p class="footer-brand_slogan">restaurant</p>
			</div>
			<p class="copyright">
				© <span id="copyright-year"></span>. All Rights Reserved
				<!-- {%FOOTER_LINK} -->
			</p>
		</div>
	</footer>
</div>

<script src="{{ asset('customerInterface/js/script.js') }}"></script>
</body>
</html>
