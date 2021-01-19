<!-- Slider -->
<div class="slider" >
    <div class="flexslider">
        <ul class="slides">
            <li>
                <img src="/images/slider-img.jpg" />
            </li>
            <li>
                <img src="/images/slider-img.jpg" />
            </li>
        </ul>
    </div>


	<!-- Book Apointment -->
	<div class="book-form">
		<div class="inner-form">

		<h4>Payer Une Facture</h4>
		<form id="contact-form2" action="<?= $this->Url->build(['controller' => 'Users', 'action' => 'ebilling']) ?>">
			<div class="inputs">
				<input name="name" id="name" type="text" data-value="code_medecin">
				<input name="mail" id="mail" type="text" data-value="montant">
	        </div>

			<input id="submit_contact2" type="submit" value="Payer">
		</form>

		</div>
	</div>
	<!-- End Book Apointment -->
</div>
<!-- End SLider -->



	<!-- Container -->
	<div class="wrapper">


	</div>
	<!-- End Wrapper -->
