<?php

class View {

	function generate($content_view, $template_view, $data = null){

		if( is_array($data) ){
			extract($data);
		}

		include 'app/views/'.$template_view;
	}
}
