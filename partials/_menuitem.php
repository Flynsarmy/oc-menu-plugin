<?php
	$output = sprintf($settings['before_item'], $this->id, $this->id_attrib, $this->getClassAttrib($settings, $depth), $this->title_attrib);
	$output .= $url ?
			sprintf($settings['before_url_item_label'], $url, $this->id, $this->id_attrib, $this->getClassAttrib($settings, $depth), $depth, $this->title_attrib, $this->target_attrib) : //<a href="%1$s" title="%2$s" class="title" target="%7$s">
			sprintf($settings['before_nourl_item_label'], $this->id, $this->id_attrib, $this->getClassAttrib($settings, $depth), $depth, $this->title_attrib); //<span class="title">

		$output .= htmlspecialchars($this->label);

	$output .= $url ?
		sprintf($settings['after_url_item_label'], $url, $this->id, $this->id_attrib, $this->getClassAttrib($settings, $depth), $depth, $this->title_attrib) : //<a href="%1$s" title="%2$s" class="title">
		sprintf($settings['after_nourl_item_label'], $this->id, $this->id_attrib, $this->getClassAttrib($settings, $depth), $depth, $this->title_attrib); //<span class="title">

	if ( $child_count || $settings['always_show_before_after_children'] )
		$output .= sprintf($settings['before_children'], $url, $this->id, $this->id_attrib, $this->getClassAttrib($settings, $depth), $depth, $this->title_attrib);

		foreach ( $this->getChildren() as $child )
			$output .= $child->render($controller, $settings, ++$depth, $child->getUrl(), $child->children->count());

	if ( $child_count || $settings['always_show_before_after_children'] )
		$output .= sprintf($settings['after_children'], $url, $this->id, $this->id_attrib, $this->getClassAttrib($settings, $depth), $depth, $this->title_attrib);

	$output .= sprintf($settings['after_item'], $this->id, $this->id_attrib, $this->getClassAttrib($settings, $depth), $this->title_attrib);

	return $output;