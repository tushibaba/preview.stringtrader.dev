	<?php
/**
 * Theme search bar across the header
 * Only show it on certain pages
 *
 * @author AppThemes
 * @package ClassiPress
 *
 */
?>

<?php if ( is_home() || is_search() || is_404() || is_tax( APP_TAX_CAT ) || is_singular( APP_POST_TYPE ) ) : ?>

	<div id="search-bar">

		<div class="searchblock_out">

			<div class="searchblock">

				<form action="<?php echo site_url('/'); ?>" method="get" id="searchform" class="form_search">

					<div class="searchfield">

						<input name="s" type="text" id="s" tabindex="1" class="editbox_search" style="width:<?php echo get_option('cp_search_field_width'); ?>" <?php if ( get_search_query() ) { echo 'value="'.trim(strip_tags(esc_attr(get_search_query()))).'"'; } else { ?> value="<?php _e('What are you looking for?',APP_TD); ?>" onFocus="if (this.value == '<?php _e('What are you looking for?',APP_TD); ?>') {this.value = '';}" onBlur="if (this.value == '') {this.value = '<?php _e('What are you looking for?',APP_TD); ?>';}" <?php } ?> />

					</div>

					<div class="searchbutcat">
 					<?php wp_dropdown_categories('show_option_all='.__('All Categories', APP_TD).'&hierarchical='.get_option('cp_cat_hierarchy').'&hide_empty='.get_option('cp_cat_hide_empty').'&depth='.get_option('cp_search_depth').'&show_count='.get_option('cp_cat_count').'&pad_counts='.get_option('cp_cat_count').'&orderby=name&title_li=&use_desc_for_title=1&tab_index=2&name=scat&selected='.cp_get_search_catid().'&class=searchbar&taxonomy='.APP_TAX_CAT); ?>
 					

					
						<button class="btn-topsearch" type="submit" tabindex="3" title="<?php _e('Search Ads', APP_TD); ?>" id="go" value="search" name="sa"><?php _e('Search Ads', APP_TD); ?></button>

					</div>

				</form>

			</div> <!-- /searchblock -->

		</div> <!-- /searchblock_out -->

	</div> <!-- /search-bar -->

<?php endif; ?>