# <?= $site->llmsTitle()->value() . "\n" ?>

<?php if ($site->llmsDescription()->isNotEmpty()): ?>
> <?= $site->llmsDescription()->value() . "\n" ?>

<?php endif ?>
<?php if ($site->llmsDetails()->isNotEmpty()): ?>
<?= $site->llmsDetails()->value() . "\n" ?>

<?php endif ?>
<?php foreach ($site->llmsSections()->toStructure() as $section): ?>
## <?= $section->title()->value() . "\n" ?>

<?php foreach ($section->items()->toPages() as $item): ?>
<?php if ($item->llmsDescription()->isNotEmpty()): ?>
- [<?= $item->title()->value() ?>](<?= $item->url() ?>): <?= $item->llmsDescription()->value() . "\n" ?>
<?php else: ?>
- [<?= $item->title()->value() ?>](<?= $item->url() ?>)
<?php endif ?>
<?php endforeach ?>

<?php endforeach ?>
