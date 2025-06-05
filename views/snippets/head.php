<?php /** @var \Kirby\Cms\App $kirby */ ?>
<?php /** @var \Kirby\Cms\Page $page */ ?>

<?php $currentTranslation = $page->translation('current') ?>
<?php $defaultTranslation = $page->translation('default') ?>

<?php
    $alternativeTranslations = $page->translations()->not(
        $currentTranslation,
        $defaultTranslation,
    )->filter(fn ($translation) => $translation->exists())
?>

<?php if ($page->canonical()->isNotEmpty()) : ?>
    <link rel="canonical" href="<?= $page->canonical()->html() ?>">
<?php endif ?>

<?php foreach ($alternativeTranslations as $translation) : ?>
    <meta name="alternate" href="<?= $page->urlForLanguage($translation->language()->code()) ?>" hreflang="<?= $translation->language()->code() ?>">
<?php endforeach ?>

<?php if ($alternativeTranslations->isNotEmpty()) : ?>
    <meta name="alternate" href="<?= $page->urlForLanguage($defaultTranslation->code()) ?>" hreflang="x-default">
<?php endif ?>

<?php if ($page->metaDescription()->isNotEmpty()) : ?>
    <meta name="description" content="<?= $page->metaDescription()->html() ?>">
<?php endif ?>

<?php if ($currentTranslation) : ?>
    <meta property="og:locale" content="<?= $currentTranslation->language()->locale(LC_ALL) ?>">
<?php endif ?>

<?php foreach ($alternativeTranslations as $translation) : ?>
    <meta property="og:locale:alternate" content="<?= $translation->language()->locale(LC_ALL) ?>">
<?php endforeach ?>

<?php if ($page->ogSiteName()->isNotEmpty()) : ?>
    <meta property="og:site_name" content="<?= $page->ogSiteName()->html() ?>">
<?php endif ?>

<?php if ($page->ogTitle()->isNotEmpty()) : ?>
    <meta property="og:title" content="<?= $page->ogTitle()->html() ?>">
<?php endif ?>

<?php if ($page->ogDescription()->isNotEmpty()) : ?>
    <meta property="og:description" content="<?= $page->ogDescription()->html() ?>">
<?php endif ?>

<?php if ($image = $page->ogImage()) : ?>
    <meta property="og:image" content="<?= $image->url() ?>">
    <meta property="og:image:width" content="<?= $image->width() ?>">
    <meta property="og:image:height" content="<?= $image->height() ?>">
    <meta property="og:image:alt" content="<?= $image->alt()->html() ?>">
<?php endif ?>

<?php if ($page->robots()->isNotEmpty()) : ?>
    <meta name="robots" content="<?= $page->robots()->html() ?>">
<?php endif ?>
