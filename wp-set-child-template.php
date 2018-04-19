/**
 * Add a filter in functions.php that will set the page template to
 * [tempate].php if the current page is a child of [parent] with
 * the id [id].
 *
 * Replace all of the content within [brackets] with the appropriate information.
 */
add_filter( 'page_template', function ( $template ) use ( &$post ) {
  // Check if we have page which is a child of [parent], ID [pageID]
  if ( [pageID] !== $post->post_parent )
    return $template;

  // locate the series template
  $locate_template = locate_template( '[template].php' );

  // Check if our template was found, if not, bail
  if ( !$locate_template )
    return $template;

  return $locate_template;
});
