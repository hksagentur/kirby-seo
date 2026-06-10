<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($items as $item): ?>
        <url>
            <loc><?= $item->url() ?></loc>
            <priority><?= number_format($item->sitemapPriority(), 1) ?></priority>
            <lastmod><?= $item->sitemapModified('c') ?></lastmod>

            <?php foreach ($item->translations()->without($item->translation()->code()) as $translation) : ?>
                <xhtml:link <?= attr([
                    'rel' => 'alternate',
                    'hreflang' => $translation->code(),
                    'href' => $item->url($translation->code()),
                ]) ?>/>
            <?php endforeach ?>
        </url>
    <?php endforeach ?>
</urlset>
