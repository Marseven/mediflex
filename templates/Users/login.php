<div class="clear"></div>
	<div class="banner">
        <div class="inner-banner">
            <div class="note">Connexion</div>
            <div class="site-map">
            Vous êtes :<a href="#">Accueil</a> &gt; Connexion
            </div>
        <div class="clear"></div>
	</div>
</div>


	<!-- Container -->
	<div class="wrapper">
		<div class="contact-row dark">
			<div class="msg-form column8">
				<h4>Espace Médécin</h4>
				<div class="border"></div>
				<form  id="contact-form" action="#">
                <?= $this->Form->create($user, ['url' => ['controller' => 'Users','action' => 'login'], 'id' => 'contact-form']); ?>

                    <?= $this->Form->input('email', array(
                        'placeholder' => 'Email',
                        'type' => 'email',
                        'label' => 'Email',
                        'id' => 'mail',
                    )); ?>


                    <?= $this->Form->input('password', array(
                        'placeholder' => 'Mot de passe',
                        'type' => 'password',
                        'label' => 'Mot de Passe',
                    )); ?>

                    <?= $this->Form->input('Connexion', array(
                        'id'    => 'submit_contact',
                        'type'  => 'submit',
                        'label' => ''
                    )); ?>
				</form>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- End Wrapper -->
