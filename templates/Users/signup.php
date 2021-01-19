<div class="clear"></div>
	<div class="banner">
        <div class="inner-banner">
            <div class="note">Inscription</div>
            <div class="site-map">
            Vous êtes :<a href="#">Accueil</a> &gt; Inscription
            </div>
        <div class="clear"></div>
	</div>
</div>



	<!-- Container -->
	<div class="wrapper">
		<div class="contact-row dark">
			<div class="msg-form column12">
				<h4>Inscription Médécin</h4>
				<div class="border"></div>
				<?= $this->Form->create($new_user, ['id' => 'contact-form']); ?>
                    <?= $this->Form->input('nom', array(
                        'placeholder' => 'Nom',
                        'type' => 'text',
                        'label' => 'Nom',
                        'id' => 'name',
                    )); ?>

                     <?= $this->Form->input('prenom', array(
                        'placeholder' => 'Prénom',
                        'type' => 'text',
                        'label' => 'Prénom',
                        'required',
                    )); ?>

                    <?= $this->Form->input('email', array(
                        'placeholder' => 'Email',
                        'type' => 'email',
                        'label' => 'Email',
                        'id' => 'mail',
                        'required',
                    )); ?>


                    <?= $this->Form->input('password', array(
                        'placeholder' => 'Mot de passe',
                        'type' => 'password',
                        'label' => 'Mot de Passe',
                        'required',
                    )); ?>

                    <?= $this->Form->control('password_verify', array(
                        'type' => 'password',
                        'placeholder' => 'Confirmer Mot de Passe*',
                        'label' => '',
                        'required',
                    )); ?>

                    <?= $this->Form->input('S\'inscrire', array(
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
