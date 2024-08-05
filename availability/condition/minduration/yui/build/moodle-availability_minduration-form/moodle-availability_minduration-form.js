YUI.add('moodle-availability_grouping-form', function (Y, NAME) {

    /**
     * JavaScript for form editing conditions.
     *
     * @module moodle-availability_minduration-form
     */
    M.availability_minduration = M.availability_minduration || {};

    /**
     * @class M.availability_minduration.form
     * @extends M.core_availability.plugin
     */
    M.availability_minduration.form = Y.Object(M.core_availability.plugin);

    M.availability_minduration.form.getNode = function(json) {
        // Create HTML structure.
        var strings = M.str.availability_minduration;
        var html = strings.title + ' <span class="availability-group">';

        html += '<label><span class="accesshide">' + strings.label_access +
            ' </span><select name="e" title="' + strings.label_access + '">' +
            '<option value="0">' + strings.requires_0min + '</option>' +
            '<option value="1">' + strings.requires_60min + '</option>' +
            '<option value="2">' + strings.requires_120min + '</option>' +
            '<option value="3">' + strings.requires_180min + '</option>' +
            '</select></label></span>';
        var node = Y.Node.create('<span>' + html + '</span>');

        // Set initial values.
        if (json.e !== undefined) {
            node.one('select[name=e]').set('value', '' + json.e);
        }

        // Add event handlers (first time only).
        if (!M.availability_minduration.form.addedEvents) {
            M.availability_minduration.form.addedEvents = true;
            var root = Y.one('.availability-field');
            root.delegate('change', function() {
                // Whichever dropdown changed, just update the form.
                M.core_availability.form.update();
            }, '.availability_minduration select');
        }

        return node;
    };

    M.availability_minduration.form.fillValue = function(value, node) {
        value.e = parseInt(node.one('select[name=e]').get('value'), 10);
    };

}, '@VERSION@', {"requires": ["base", "node", "event", "moodle-core_availability-form"]});
