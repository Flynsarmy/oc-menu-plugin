<?php namespace Flynsarmy\Menu\MenuItemTypes;

use URL;
use Flynsarmy\Menu\Models\MenuItem;
use Backend\Widgets\Form;
use RainLab\Blog\Models\Post;
use Flynsarmy\Menu\MenuItemTypes\ItemTypeBase;

/**
 * Rich Editor
 * Renders a rich content editor field.
 *
 * @package october\backend
 * @author Alexey Bobkov, Samuel Georges
 */
class BlogPost extends ItemTypeBase
{
	protected $posts = [];

	/**
	 * Add fields to the MenuItem form
	 *
	 * @param  Form   $form
	 *
	 * @return void
	 */
	public function formExtendFields(Form $form)
	{
		if ( !$this->posts )
		{
			$posts = Post::isPublished()->select('id', 'title', 'published_at')->orderBy('created_at', 'desc')->get();
			$options = [];
			foreach ( $posts as $post )
				$options[$post->id] = $post->published_at . ' -'.$post->title;

			asort($options);
			$this->posts = $options;
		}

		$form->addFields([
			'master_object_id' => [
				'label' => 'Blog Post',
				'comment' => 'Select the blog post you wish to link to.',
				'type' => 'dropdown',
				'options' => $this->posts,
				// 'attributes' => ['data-origin' => 'Flynsarmy\Menu\MenuItemTypes\ItemTypeBase'],
			],
		]);
	}

	/**
	 * Returns the URL for the master object of given ID
	 *
	 * @param  MenuItem  $item Master object iD
	 *
	 * @return string
	 */
	public function getUrl(MenuItem $item)
	{
		return URL::to(Post::find($item->master_object_id)->url);
	}

	/**
	 * Adds any validation rules to $item->rules array that are required
	 * by the ItemType's extended fields. If necessary, add custom messages
	 * to $item->customMessages.
	 *
	 * For example:
	 * $item->rules['master_object_id'] = 'required';
	 * $item->customMessages['master_object_id.required'] = 'The Blog Post field is required.';
	 *
	 *
	 * @param MenuItem $item
	 *
	 * @return void
	 */
	public function addValidationRules(MenuItem $item)
	{
		$item->rules['master_object_id'] = 'required';
		$item->customMessages['master_object_id.required'] = 'The Blog Post field is required.';
	}
}