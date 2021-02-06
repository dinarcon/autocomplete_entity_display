<?php

namespace Drupal\autocomplete_entity_display\Controller;

use Drupal\Core\Ajax\AfterCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for autocomplete_entity_display routes.
 */
class AutocompleteEntityDisplayController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function dataAjaxResponse($entity_type, $entity_id) {

    if (empty($entity_type) || empty($entity_id)) {
      return (new AjaxResponse())->addCommand(new RemoveCommand('#tag-description'));
    }

    try {
      $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);
      $description = '(no description)';

      if (!empty($entity->description->value)) {
        $description = strip_tags($entity->description->value);
      }

      $response = new AjaxResponse();

      $response->addCommand(new RemoveCommand(
        '#tag-description'
      ));
      $response->addCommand(new AfterCommand(
        '#edit-field-tags-wrapper',
        "<div id='tag-description'>Description: $description</div>"
      ));

      return $response;
    }
    catch (\Exception $exception) {
      return (new AjaxResponse())->addCommand(new RemoveCommand('#tag-description'));
    }
  }

}
