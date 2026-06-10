# robotstxt.org

User-agent: *
Allow: /
<?php foreach ($disallow as $path) : ?>
Disallow: <?= $path . "\n" ?>
<?php endforeach; ?>

<?php if (isset($sitemap)): ?>
Sitemap: <?= url($sitemap) . "\n" ?>
<?php endif; ?>
