(function ($, window, Drupal, drupalSettings) {

  Drupal.AjaxCommands.prototype.customAjaxCommand  = function (ajax, response, status) {
    // Do something.
  }

  Drupal.behaviors.autocomplete_entity_display = {
    attach: function (context, settings) {
      $('#edit-field-tags-target-id', context).on('autocompleteselect', function (event, ui) {
        const value = ui.item.value;
        // Extract number for value. Example: Blue (7).
        const match = value.match(/(?<=\()\d+(?=\))/);
        if (match) {
          const entityId = match.pop();
          const entityType = 'taxonomy_term';

          Drupal.ajax({url: `/autocomplete-entity-display/${entityType}/${entityId}`}).execute();
        }
      });
    }
  };

})(jQuery, window, Drupal, drupalSettings);
