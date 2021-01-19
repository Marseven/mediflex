<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mediflex</title>

    <?= $this->Html->css(['style', 'zebra', 'dr-framework', 'revslider', 'jquery.bxslider', 'responsive' ]) ?>
    <link rel="stylesheet" type="text/css" href="/css/fullwidth.html" media="screen" />



    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Philosopher:400,700,400italic' rel='stylesheet' type='text/css'>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>


	<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<!-- html5.js for IE less than 9 -->
	<!-- css3-mediaqueries.js for IE less than 9 -->
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!--[if lt IE 9]>
 	<link rel="stylesheet" type="text/css" href="css/ie8-and-down.css" />
	<![endif]-->
</head>
<body>

	<!-- Start Header -->
	<header>

		<div class="subheader clearfix">
			<div class="inner-subheader">
				<div class="phone">+241 74 22 83 06</div>

				<div class="subheader2">
                    <?php if(!isset($user)):?><!--Vérifie si l'utilisateur est conneecté et afficher son profiel'-->
                        <ul>
                            <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">Connexion</a></li>
                            <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'signup']) ?>">Inscription</a></li>
                        </ul>
                    <?php endif;?>
				</div>
			</div>
		</div>

		<div class="row2">
            <div class="upper-header">

                <div class="logo">
                    <a href="#"><h3>Mediflex</h3></a>
                </div>
                <!-- Navigation -->
                <nav id="nav">
                    <ul id="navlist" class="sf-menu clearfix">
                        <li class="current"><a href="<?= $this->Url->build(['controller' => 'Mediflex', 'action' => 'index']) ?>">Accueil</a></li>
                        <?php if(isset($user)):?><!--Vérifie si l'utilisateur est conneecté et afficher son profiel'-->
                            <li><a href="#"><?= $user->nom ?></a>
                                <ul class="sub-menu">
                                    <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profil']) ?>">Profil</a></li>
                                    <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'paiements']) ?>">Liste des paiements</a></li>
                                </ul>
                            </li>
                        <?php endif;?>
                    </ul>
                </nav>
                <!-- Navigation -->
                <div class="clear"></div>
            </div>
            <!-- End Upper Header -->
       </div>
       <!-- End Row2 -->

	</header>
	<!-- End Header -->

    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

	<!-- Footer -->
	<footer>
	<div class="inner-footer dark">

		<div class="about column3">
			<h4>About Us</h4>
			<ul>
				<li><a href="#">Who We Are</a></li>
				<li><a href="#">What We Do</a></li>
				<li><a href="#">What We Offer</a></li>
				<li><a href="#">Our Mission</a></li>
				<li><a href="#">Our Vission</a></li>
			</ul>
		</div>

		<div class="service column3">
			<h4>Services</h4>
			<ul>
				<li><a href="#">Teeth Whitening</a></li>
				<li><a href="#">Crowns Dental Bridges</a></li>
				<li><a href="#">Oral Exam and X-Rays</a></li>
				<li><a href="#">Gastroscopic Services</a></li>
			</ul>
		</div>

		<div class="text-widget column3">
			<h4>Text Widget</h4>
			<p>Duis sed odio sit amet nibh vulputate cursusa sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae </p>
		</div>

		<div class="contact column3">
			<h4>Contact us</h4>
			<p>wecare@domain.com</p>
			<p>+38649 123 456 789 00</p>
			<p>Lorem ipsum address street no 24 b41</p>
		</div>
		<div class="clear"></div>
		<!-- End Contact -->
		<div id="back-to-top">
			<a href="#top">Back to Top</a>
		</div>
	</div>
	<!-- End inner Footer -->

	<div class="end-footer">
		<div class="lastdiv">
			<div class="copyright">
				© 2021 Mediflex, All Rights Reserved
			</div>

			<div class="f-socials">
				<a href="#"><img src="images/feed.png" alt=""></a>
				<a href="#"><img src="images/tweet.png" alt=""></a>
				<a href="#"><img src="images/fcb.png" alt=""></a>
				<a href="#"><img src="images/gplus.png" alt=""></a>
				<a href="#"><img src="images/pin.png" alt=""></a>
			</div>
		<div class="clear"></div>
		</div>
	</div>
	</footer>
    <?= $this->Html->script(['jquery.min', 'jquery.flexslider', 'jquery.superfish', 'script', 'jquery.bxslider', 'zebra_datepicker', 'core' ]) ?>
	<script type="text/javascript" charset="utf-8">
  		$(window).load(function() {
  		  $('.flexslider').flexslider();
  		});
	</script>
    <?= $this->fetch('script') ?>

</body>
</html>
