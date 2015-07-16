<?php
/**
 * @file
 * RESTful Panels Display Resource class.
 */

class RestfulPanelsDisplay extends \RestfulBase implements \RestfulDataProviderInterface {

  /**
   * @inheritDoc
   */
  public function publicFieldsInfo() {
    $fields = array();
    $fields['did'] = array();
    $fields['layout'] = array();
    $fields['content'] = array();

    return $fields;
  }

  /**
   * @inheritDoc
   */
  public function index() {
    $result = db_select('panels_display', 'd')
      ->fields('d')
      ->execute();

    $return = array();
    foreach ($result as $row) {
      $return[] = array(
        'display_id' => $row->did,
        'layout' => $row->layout,
      );
    }

    return $return;
  }

  /**
   * @inheritDoc
   */
  public function view($id) {
    ctools_include('plugins', 'panels');
    $display = panels_load_display($id);

    /** @var RestfulPanelsStructuredRenderer $renderer */
    $renderer = panels_get_renderer_handler('structured', $display);

    $rendered = $renderer->render($display);
    return (array) $rendered;
  }


}
