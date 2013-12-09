<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title>Krustr Feed</title>
        <link>http://www.krustr.net</link>
        <atom:link href="{{ URL::current() }}" rel="self"></atom:link>
        <description>We need to pick this up from the settings</description>
        <language>en-us</language>
        <lastBuildDate>{{ Carbon\Carbon::now()->toRSSString() }}</lastBuildDate>
	</channel>
</rss>
