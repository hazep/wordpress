<div class="row">

	<div class="col-md-6">
		<div class="submit_container_header"><?php _e('DETAILS DU BIEN :','wpestate');?></div>
		<label class="label-title">Nombre de pièces :</label>
		<div class="col-md-12 radio-submit">
			<label for="room-111">1</label>
			<input type="radio" id="room-111" name="room" value="1">
			<label for="room-2">2</label>
			<input type="radio" id="room-2" name="room" value="2">
			<label for="room-3">3</label>
			<input type="radio" id="room-3" name="room" value="3">
			<label for="room-4">4</label>
			<input type="radio" id="room-4" name="room" value="4">
			<label for="room-5">5</label>
			<input type="radio" id="room-5" name="room" value="5">
			<label for="room-6">6+</label>
			<input type="radio" id="room-6" name="room" value="6">
		</div>
		<label class="label-title">Nombre de chambres :</label>
		<div class="col-md-12 radio-submit">
			<label for="bedroom-1">1</label>
			<input type="radio" id="bedroom-1" name="bedroom" value="1">
			<label for="bedroom-2">2</label>
			<input type="radio" id="bedroom-2" name="bedroom" value="2">
			<label for="bedroom-3">3</label>
			<input type="radio" id="bedroom-3" name="bedroom" value="3">
			<label for="bedroom-4">4</label>
			<input type="radio" id="bedroom-4" name="bedroom" value="4">
			<label for="bedroom-5">5</label>
			<input type="radio" id="bedroom-5" name="bedroom" value="5">
			<label for="bedroom-6">6+</label>
			<input type="radio" id="bedroom-6" name="bedroom" value="6">
		</div>
		<div class="col-md-12 marg_t">
			<label class="label-title">Superficie de :</label>
			<div class="form-group input-group">
				<input type="text" id="property_price" class="form-control no-margin" size="40" name="property_price" value="<?php print $property_price;?>">
				<div class="input-group-addon">m<sup>2</sup></div>
			</div>
		</div>
		<div class="col-md-12 marg_t">
			<label class="label-title">Superficie de séjour :</label>
			<div class="form-group input-group">
				<input type="text" id="property_price" class="form-control no-margin" size="40" name="property_price" value="<?php print $property_price;?>">
				<div class="input-group-addon">m<sup>2</sup></div>
			</div>
		</div>
		<div class="col-md-12 marg_t">
			<div class="row">
				<label class="label-title pull-left">Espace extérieur :</label>
				<div class="col-sm-5 col-md-12 col-lg-4 marg_t">
					<div class="form-group input-group">
						<input type="text" id="property_price" class="form-control no-margin" size="40" name="property_price" value="<?php print $property_price;?>">
						<div class="input-group-addon">m<sup>2</sup></div>
					</div>
				</div>
				<div class="col-xs-12 col-lg-8 col-md-12">
					<ul class="property-submit-list">
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12 marg_t">
			<div class="row">
				<label class="label-title pull-left">Stationnement :</label>
				<div class="col-sm-5 col-md-12 col-lg-4 marg_t">
					<input type="text" id="property_price" class="form-control no-margin" size="40" name="property_price" value="<?php print $property_price;?>">
				</div>
				<div class="col-xs-12 col-lg-8 col-md-12">
					<ul class="property-submit-list">
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12 marg_t">
			<label class="label-title">Cave :</label>
			<ul class="property-submit-list">
				<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
				<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
			</ul>
		</div>
		<div class="col-md-12 marg_t">
			<label class="label-title">Descripion :</label>
			<textarea class="form-control"></textarea>
		</div>
	</div>
	<div class="col-md-6">
		<div class="submit_container_header"><?php _e('AUTRES INFORMATIONS IMPORTANTES :','wpestate');?></div>
		<label class="label-title">Salle de bain :</label>
		<div class="col-md-12 radio-submit">
			<label for="room-0">0</label>
			<input type="radio" id="room-0" name="room" value="0">
			<label for="room-1">1</label>
			<input type="radio" id="room-1" name="room" value="1">
			<label for="room-2">2</label>
			<input type="radio" id="room-2" name="room" value="2">
			<label for="room-3">3</label>
			<input type="radio" id="room-3" name="room" value="3">
			<label for="room-4">4</label>
			<input type="radio" id="room-4" name="room" value="4">
			<label for="room-5">5</label>
			<input type="radio" id="room-5" name="room" value="5">
			<label for="room-6">6+</label>
			<input type="radio" id="room-6" name="room" value="6">
		</div>
		<label class="label-title">WC :</label>
		<div class="col-md-12 radio-submit">
			<label for="room-1">1</label>
			<input type="radio" id="room-1" name="room" value="1">
			<label for="room-2">2</label>
			<input type="radio" id="room-2" name="room" value="2">
			<label for="room-3">3</label>
			<input type="radio" id="room-3" name="room" value="3">
			<label for="room-4">4</label>
			<input type="radio" id="room-4" name="room" value="4">
			<label for="room-5">5</label>
			<input type="radio" id="room-5" name="room" value="5">
			<label for="room-6">6+</label>
			<input type="radio" id="room-6" name="room" value="6">
		</div>
		<label class="label-title">Chauffage :</label>
		<div class="col-md-12">
			<ul class="property-submit-list">
				<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
				<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
				<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
				<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
				<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
			</ul>
		</div>
		<div class="col-md-12 marg_t">
			<div class="row">
				<div class="col-md-4">
					<label class="label-title">Etage :</label>
					<input type="text" class="form-control" name="prop_action_property">
				</div>
				<div class="col-md-8">
					<label class="label-title">Ascenseur :</label>
					<ul class="property-submit-list">
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12 marg_t">
			<label class="label-title">Charge de copropriétés :</label>
			<div class="row">
				<div class="col-md-4">
					<input type="text" class="form-control" name="prop_action_property">
				</div>
				<div class="col-md-8">
					<ul class="property-submit-list">
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
						<li><input type="radio" name="prop_action_propery" value="test" id="test"><label for="test>">AUCUN</label></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

</div>