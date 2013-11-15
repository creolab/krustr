<?php namespace Krustr\Repositories\Interfaces;

interface ChannelRepositoryInterface {

	public function all();
	public function find($id);
	public function field($channelId, $name);

}
