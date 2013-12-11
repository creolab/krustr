<?php namespace Krustr\Services\Content;

use Krustr\Repositories\Interfaces\EntryRepositoryInterface;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;
use Krustr\Repositories\Interfaces\TermRepositoryInterface;
use Krustr\Services\Profiler;
use App, Config, Log, Redirect, Request, View;

/**
 * Find content entries based on route, and render matching view
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class Finder extends \Illuminate\Routing\Controller {

	/**
	 * Current content channel
	 * @var ChannelEntity
	 */
	protected $channel;

	/**
	 * Instance of entry repository
	 * @var EntryRepositoryInterface
	 */
	protected $entryRepository;

	/**
	 * Instance of channel repository
	 * @var ChannelRepositoryInterface
	 */
	protected $channelRepository;

	/**
	 * Instance of term repository
	 * @var TermRepositoryInterface
	 */
	protected $termRepository;

	/**
	 * Init public controller with dependencies
	 * @param  EntryRepositoryInterface    $entryRepository
	 * @param  ChannelRepositoryInterface  $channelRepository
	 * @return void
	 */
	public function __construct(EntryRepositoryInterface $entryRepository, ChannelRepositoryInterface $channelRepository, TermRepositoryInterface $termRepository)
	{
		// Dependecies
		$this->entryRepository   = $entryRepository;
		$this->channelRepository = $channelRepository;
		$this->termRepository    = $termRepository;

		// Resolve current channel
		$this->resolveChannel();
	}

	/**
	 * The home page
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
	 * Collection of entries in taxonomy by term
	 * @param  string $term
	 * @return View
	 */
	public function entryTaxonomyCollection($term)
	{
		Profiler::start('FINDER - ENTRY TAXONOMY COLLECTION');

		// First get taxonomy
		$taxonomy = app('krustr.taxonomies')->findBySlug(Request::segment(2));

		if ($taxonomy)
		{
			$term = $this->termRepository->findBySlug($term);

			if ($term)
			{
				$entries = $this->entryRepository->allPublishedByTerm($term->id, $this->channel->resource);
			}
			else
			{
				return App::abort(404);
			}

			View::share('term', $term);
		}
		else
		{
			return App::abort(404);
		}

		// Share content
		View::share('entries',    $entries);
		View::share('pagination', $this->entryRepository->pagination());
		View::share('taxonomy',   $taxonomy);

		// Views that we need to search for
		$views = array(
			$this->channel->name.'_'.$taxonomy->name_singular,
			$this->channel->name.'_taxonomy',
			$taxonomy->name_singular,
			'taxonomy_'.$taxonomy->name_singular,
			$this->channel->resource_singular.'_collection',
			$this->channel->resource,
			$this->channel->resource.'_collection',
			'taxonomy',
			'collection',
			'index',
		);

		Profiler::end('FINDER - ENTRY TAXONOMY COLLECTION');

		// The view
		return $this->render($views);
	}

	/**
	 * Try to resolve current content channel
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
		if (app('config')->get('krustr::debug')) Log::debug('[KRUST] [CONTENT FINDER] Loading view [' . $loadView . ']');

		// Share some data with the view
		View::share('template', $view);

		// Initialize the theme
		app('krustr.theme.bootstrap')->init();

		Profiler::end('FINDER - RENDER', $view);

		// Render view or abort
		if (View::exists($loadView)) return View::make($loadView);
		else                         return App::abort(404, 'View not found');
	}

}
