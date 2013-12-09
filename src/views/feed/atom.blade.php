<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title>Krustr Feed</title>
	<subtitle>We need to pick this up from the settings</subtitle>
	<link href="{{ URL::current() }}" rel="self" />
	<updated>{{ Carbon\Carbon::now()->toRSSString() }}</updated>
	<author>
		<name>Boris Strahija</name>
		<uri>http://creolab.hr</uri>
	</author>
	<id>tag:www.krustr.net,2013:/feed.atom</id>
</feed>
