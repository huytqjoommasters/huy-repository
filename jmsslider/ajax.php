<?php
	$action = $_GET['action'];

	if ($action == 'addLayer') {
		$id_slider  = $_POST['id_slider'];
		$data_type  = $_POST['data_type'];
		$data_title = $_POST['data_title'];

		$a_layer = array(
			'title'           => $data_title,
			'class_surffix'   => '',
			'start_moving'    => '100',
			'stop_moving'     => '200',
			'layer_fixed'     => '1',
			'data_x'          => '500',
			'data_y'          => '1000',
			'width'           => '200',
			'height'          => '300',
			'transition_in'   => 'fade',
			'transition_out'  => 'fade',
			'ease_in'         => 'easeInCubi',
			'ease_out'        => 'easeOutExp',
			'step'            => '0',
			'data_special'    => 'none'
		);

		echo $add_layer = json_encode($a_layer);
	}
?>