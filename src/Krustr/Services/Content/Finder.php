<?php namespace Krustr\Services\Content;

use Krustr\Repositories\Interfaces\EntryRepositoryInterface;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;
use App, Config, Redirect, Request, View;

/**
 * Find requested content and assign to a view
 *
 * @author Boris Strahija <boris@creolab.hr>
 */
class Finder extends \Illuminate\Routing\Controllers\Controller {

	/**
	 * Current content channel
	 *
	 * @var ChannelEntity
	 */
	protected $channel;

	/**
	 * Instance of entry repository
	 *
	 * @var EntryRepositoryInterface
	 */
	protected $entryRepository;

	/**
	 * Instance of channel repository
	 *
	 * @var ChannelRepositoryInterface
	 */
	protected $channelRepository;

	/**
	 * Init public controller with dependencies
	 *
	 * @param  EntryRepositoryInterface    $entryRepository
	 * @param  ChannelRepositoryInterface  $channelRepository
	 * @return void
	 */
	public function __construct(EntryRepositoryInterface $entryRepository, ChannelRepositoryInterface $channelRepository)
	{
		// Dependecies
		$this->entryRepository   = $entryRepository;
		$this->channelRepository = $channelRepository;

		// Resolve current channel
		$this->resolveChannel();
	}

	/**
	 * The home page
	 *
	 * @return View
	 */
	public function home()
	{
		// Get entry used for the home page
		$entry = $this->entryRepository->home();

		// Share with all views
		View::share('entry', $entry);

		return $this->render('index');
	}

	/**
	 * Single content entry
	 *
	 * @param  string $slug
	 * @param  string $channel
	 * @return View
	 */
	public function entry($slug = null)
	{
		// Find entry
		if ($this->channel) $entry = $this->entryRepository->findBySlug($slug, $this->channel->resource);
		else                $entry = $this->entryRepository->findBySlug($slug);

		// Abort if not found
		if ( ! $entry) \App::abort(404, 'Entry not found');

		// Share to view
		View::share('entry', $entry);

		// Views that we need to search for
		$views = array(
			$entry->slug, // contact.blade.php
			$this->channel->resource_singular . '.' . $entry->slug, // page.contact.blade.php
			$this->channel->resource_singular, // page.blade.php
			'entry',
			'index',
		);

		// The view
		return $this->render($views);
	}

	/**
	 * Collection of entries
	 *
	 * @param  string $channel
	 * @return View
	 */
	public function entryCollection()
	{
		// Get content
		$entries = $this->entryRepository->allInChannel($this->channel->resource);
		View::share('entries', $entries);

		// The view
		$view = 'theme::'.$this->channel->resource_singular.'.collection';
		if ( ! View::exists($view)) $view = 'theme::collection';
		if ( ! View::exists($view)) $view = 'theme::index';

		return View::make($view);
	}

	/**
	 * Try to resolve current content channel
	 *
	 * @param  string $channel
	 * @return mixed
	 */
	public function resolveChannel($channel = null)
	{
		if ( ! $channel) $channel = Request::segment(1);

		// Find and share channel
		$this->channel = $this->channelRepository->find($channel);

		// If channel is not found default to "Pages channel"
		if ( ! $this->channel)
		{
			$this->channel = $this->channelRepository->find('pages');
		}

		// Share with all views
		View::share('channel', $this->channel);

		return $this->channel;
	}

	/**
	 * Render a view
	 *
	 * @param  array  $view
	 * @param  array  $data
	 * @return View
	 */
	public function render($views = array(), $data = array())
	{
		if ( ! is_array($views)) $views = array($views);

		// View to load
		$loadView = null;

		// Cascade find
		foreach ($views as $view)
		{
			if (View::exists('theme::' . $view))
			{
				View::share('template',       $view);
				View::share('template_class', 'tpl-' . str_replace(",", "", $view));
				$loadView = 'theme::' . $view;
				break;
			}
		}

		// Render view or abort
		if (View::exists($loadView)) return View::make($loadView);
		else                         return App::abort(404, 'View not found');
	}

}
