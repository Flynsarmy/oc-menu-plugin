<?php
	$output = sprintf($settings['before_menu'], $this->id, $this->name, $this->short_desc);
	foreach ( $this->items()->getNested() as $item )
		$output .= $item->render($settings, 0, $item->getUrl(), $item->children->count());
	$output .= sprintf($settings['after_menu'], $this->id, $this->name, $this->short_desc);

	return $output;