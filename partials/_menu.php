<?php
	$output = sprintf($settings['before_menu'], $this->id, $this->name, $this->id_attrib, $this->class_attrib, $this->short_desc);
	foreach ( $this->items()->getNested() as $item )
		$output .= $item->render($controller, $settings, 0, $item->getUrl(), $item->children->count());
	$output .= sprintf($settings['after_menu'], $this->id, $this->name, $this->id_attrib, $this->class_attrib, $this->short_desc);

	return $output;