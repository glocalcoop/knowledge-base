<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://glocal.coop
 * @since      0.1.2
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/public/partials
 */
?>

<ul class="knowledge-base-list entries-list">

<?php echo wp_list_categories( $this->args ); ?>

</ul>
