<?php
	$output = sprintf($settings['before_item'], $this->id_attrib, $this->getClassAttrib($settings, $depth));
	$output .= $url ?
			sprintf($settings['before_url_item_label'], $url, $this->id_attrib, $this->class_attrib, $this->title_attrib) : //<a href="%1$s" title="%2$s" class="title">
			sprintf($settings['before_nourl_item_label'], $this->id_attrib, $this->class_attrib, $this->title_attrib); //<span class="title">

		$output .= htmlspecialchars($this->label);

	$output .= $url ?
		sprintf($settings['after_url_item_label'], $url, $this->id_attrib, $this->class_attrib, $this->title_attrib) : //<a href="%1$s" title="%2$s" class="title">
		sprintf($settings['after_nourl_item_label'], $this->id_attrib, $this->class_attrib, $this->title_attrib); //<span class="title">

	if ( $child_count || $settings['always_show_before_after_children'] )
		$output .= sprintf($settings['before_children']);

		foreach ( $this->getChildren() as $child )
			$output .= $child->render($settings, ++$depth, $child->getUrl(), $child->children->count());

	if ( $child_count || $settings['always_show_before_after_children'] )
		$output .= sprintf($settings['after_children']);

	return $output;