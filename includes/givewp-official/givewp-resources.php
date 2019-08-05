<?php

// includes/givewp-official/givewp-resources

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Collection of external resource links for Give Donations.
 *   Note: This is the central place where to set/ change these links. They are
 *   then managed for displaying and using via ddw_tbex_get_resource_url().
 *
 * @since 1.0.0
 *
 * @see ddw_tbex_get_resource_url() in toolbar-extras/includes/functions-global.php
 *
 * @return array $givewp_links Array of external resource links.
 */
function ddw_tbexgive_resources_givewp() {

	$givewp_links = array(

		/** Official */
		'url_docs'             => 'https://givewp.com/documentation/',
		'url_docs_developer'   => 'https://givewp.com/documentation/developers/',
		'url_snippet_library'  => 'https://github.com/impress-org/give-snippet-library',
		'url_tutorials'        => 'https://givewp.com/documentation/core/give-101/',
		'url_support_contact'  => 'https://givewp.com/support/',
		'url_github_issues'    => 'https://github.com/impress-org/give/issues',
		'url_blog'             => 'https://givewp.com/blog/',
		'url_videos'           => 'https://www.youtube.com/channel/UCyyvEqgKPNsErzGrrULPmeQ/videos',
		'url_myaccount'        => 'https://givewp.com/my-account/',

		/** Community */
		'url_fb_group'         => 'https://www.facebook.com/groups/givewp/',
		'url_translations'     => 'https://translate.wordpress.org/projects/wp-plugins/give/',
		'url_nonprofit_101'    => 'https://givewp.com/nonprofit-101/',
		'url_giving_tuesday'   => 'https://givewp.com/giving-tuesday/',
		'url_give_stories'     => 'https://givewp.com/give-stories/',

	);  // end of array

	return $givewp_links;

}  // end function
