<?php

/**
 * Content template for archive items.
 *
 * @package foliobr
 */

if (!isset($args['archive_type'])) {
  return;
}

$archive_type = $args['archive_type'];

if ($archive_type === 'realisations') {
  get_template_part('template-parts/realisations/content', 'archive-realisations');
} elseif ($archive_type === 'competences') { ?>
<?php get_template_part('template-parts/competences/content', 'archive-competences');
}
