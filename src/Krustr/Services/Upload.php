<?php namespace Krustr\Services;

use Config, Input, Response, Str;

class Upload {

	/**
	 * Initialize service with dependencies
	 */
	public function __construct()
	{

	}

	/**
	 * Fire the upload action
	 *
	 * @param  mixed  $input
	 * @param  string $path
	 * @param  array  $options
	 * @return array
	 */
	public function fire($input, $path, $options = array())
	{
		if ($input and $input instanceof \Symfony\Component\HttpFoundation\File\UploadedFile)
		{
			// Setup all paths and URL's
			$file         = $input;
			$movePath     = $path;
			$fileName     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
			$extension    = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
			$moveFileName = Str::slug($fileName) . '.' . $extension;
			$url          = url(array_get($options, 'tmp_url') . $moveFileName);

			// Move the uploaded file to the tmp path
			$file->move($movePath, $moveFileName);

			// And return response data
			return array(
				'path'          => $movePath.$moveFileName,
				'extension'     => $file->getClientOriginalExtension() ,
				'original_name' => $file->getClientOriginalName(),
				'size'          => $file->getClientSize(),
				'url'           => $url,
			);
		}
	}

}
