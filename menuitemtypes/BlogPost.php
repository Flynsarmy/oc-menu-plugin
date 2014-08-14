<?php namespace Flynsarmy\Menu\MenuItemTypes;

use URL;
use Flynsarmy\Menu\Models\MenuItem;
use Backend\Widgets\Form;
use RainLab\Blog\Models\Post;
use Flynsarmy\Menu\MenuItemTypes\ItemTypeBase;
use Flynsarmy\Menu\Models\Settings;
use Flynsarmy\Menu\Classes\DropDownHelper;
use System\Classes\ApplicationException;

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
	public function extendItemForm(Form $form)
	{
		if ( !$this->posts )
		{
			$posts = Post::isPublished()->select('id', 'title', 'published_at')->orderBy('created_at', 'desc')->get();
			$options = [];
			foreach ( $posts as $post )
				$options[$post->id] = date('M j Y H:i', strtotime($post->published_at)) . ' - '.$post->title;

			asort($options);
			$this->posts = $options;
		}

		$form->addFields([
			'master_object_id' => [
				'label' => 'Blog Post',
				'comment' => 'Select the blog post you wish to link to. Remember to set the Blog Posts Page option on the Menu Settings page!',
				'type' => 'dropdown',
				'options' => $this->posts,
				'tab' => 'Item',
			],
		], 'primary');
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
	public function extendItemModel(MenuItem $item)
	{
		$item->rules['master_object_id'] = 'required';
		$item->customMessages['master_object_id.required'] = 'The Blog Post field is required.';
	}

	/**
	 * Add fields to the MenuItem form
	 *
	 * @param  Form   $form
	 *
	 * @return void
	 */
	public function extendSettingsForm(Form $form)
	{
		$form->addFields([
			'blog_post_page' => [
				'tab' => 'Blog',
				'label' => 'Blog Post Page',
				'comment' => 'Select the page your blog posts are displayed on',
				'type' => 'dropdown',
				'options' => DropDownHelper::instance()->pages(),
			],
		], 'primary');
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
	public function extendSettingsModel(Settings $settings)
	{
		$item->rules['blog_post_page'] = 'required';
		$item->customMessages['blog_post_page.required'] = 'The Blog Post Page field is required.';
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
		$page_url = Settings::get('blog_post_page', 'blog/post');
		$post = Post::find($item->master_object_id);

		if ( !$post )
			throw new ApplicationException("Post not found.");

		return URL::to($page_url.'/'.$post->slug);
	}
}