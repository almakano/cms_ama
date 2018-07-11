<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	<url>
		<loc>https://<?php echo $_SERVER['HTTP_HOST'] ?>/</loc>
		<lastmod><?php echo date_format(time(), '%Y-%m-%d') ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
	<?php if(!empty($list)) foreach ($list as $i) { ?>
	<url>
		<?php if(!empty($i['url'])) { ?><loc>https://<?php echo $i['url'] ?>/</loc><?php } ?>
		<?php if(!empty($i['url'])) { ?><lastmod><?php echo date_format($i['date'], '%Y-%m-%d') ?></lastmod><?php } ?>
		<changefreq>daily</changefreq>
		<priority>0.5</priority>
	</url>
	<?php } ?>
</urlset>