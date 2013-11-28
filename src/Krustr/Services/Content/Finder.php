<?php namespace Krustr\Services\Content;

use Krustr\Repositories\Interfaces\EntryRepositoryInterface;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;
use Krustr\Services\Profiler;
use App, Config, Redirect, Request, View;

/**
 * Find requested content and assign to a view
 *
 * @author Boris Strahija <boris@creolab.hr>
 */
class Finder extends \Illuminate\Routing\Controller {

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
		Profiler::start('FINDER - HOME');

		// Get entry used for the home page
		$entry = $this->entryRepository->home();

		// Share with all views
		View::share('entry', $entry);

		Profiler::end('FINDER - HOME');

		return $this->render('index');
	}

	/**
	 * Single content entry
	 *
	 * @param  int|string $id
	 * @param  string     $channel
	 * @return View
	 */
	public function entry($id = null)
	{
		Profiler::start('FINDER - ENTRY');

		// Find entry by slug or ID
		if (is_numeric($id))
		{
			if ($this->channel) $entry = $this->entryRepository->findPublished((int) $id, $this->channel->resource);
			else                $entry = $this->entryRepository->findPublished((int) $id);
		}
		else
		{
			if ($this->channel) $entry = $this->entryRepository->findPublishedBySlug($id, $this->channel->resource);
			else                $entry = $this->entryRepository->findPublishedBySlug($id);
		}

		// Abort if not found
		if ( ! $entry) \App::abort(404, 'Entry not found');

		// Share to view
		View::share('entry', $entry);

		// Views that we need to search for
		$views = array(
			$entry->slug, // contact.blade.php
			$this->channel->resource . '_entry', // shop.entry.blade.php
			$this->channel->resource . '_' . $this->channel->resource_singular, // shop.product.blade.php
			$this->channel->resource_singular . '_' . $entry->slug, // page.contact.blade.php
			$this->channel->resource_singular, // page.blade.php
			'entry',
			'index',
		);

		Profiler::end('FINDER - ENTRY');

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
		Profiler::start('FINDER - ENTRY COLLECTION');

		// Get content
		$entries = $this->entryRepository->allPublishedInChannel($this->channel->resource);
		View::share('entries',    $entries);
		View::share('pagination', $this->entryRepository->pagination());

		// Views that we need to search for
		$views = array(
			$this->channel->resource_singular.'_collection',
			$this->channel->resource,
			$this->channel->resource.'_collection',
			'collection',
			'index',
		);

		Profiler::end('FINDER - ENTRY COLLECTION');

		// The view
		return $this->render($views);
	}

	/**
	 * Try to resolve current content channel
	 *
	 * @param  string $channel
	 * @return mixed
	 */
	public function resolveChannel($channel = null)
	{
		Profiler::start('FINDER - RESOLVE CHANNEL');

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

		Profiler::end('FINDER - RESOLVE CHANNEL');

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
		Profiler::start('FINDER - RENDER');

		if ( ! is_array($views)) $views = array($views);

		// View to load
		$loadView = null;

		// Cascade find
		foreach ($views as $view)
		{
			if (View::exists('theme::' . $view))
			{
				$loadView = 'theme::' . $view;
				break;
			}
		}

		// Share some data with the view
		View::share('template',       $view);
		View::share('template_class', 'tpl-' . str_replace(",", "", $view));

		Profiler::end('FINDER - RENDER', $view);

		// Render view or abort
		if (View::exists($loadView)) return View::make($loadView);
		else                         return App::abort(404, 'View not found');
	}

}
