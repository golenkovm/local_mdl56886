<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * MDL56886 plugin lib
 *
 * @package     local_mdl56886
 * @author      Mikhail Golenkov <golenkovm@gmail.com>
 * @copyright   Catalyst IT
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_mdl56886_extend_navigation(global_navigation $navigation) {
    $class = get_class($navigation);

    switch($class) {
        case 'global_navigation':
            // Remove Calendar navigation element.
            $calendar = $navigation->find('calendar', navigation_node::TYPE_CUSTOM);
            if ($calendar) {
                $calendar->remove();
            }
            break;

        case 'global_navigation_for_ajax':
            local_mdl56886_replace_assign_icon($navigation);
            break;

        default:
            break;
    }
}

function local_mdl56886_replace_assign_icon($node) {
    $keys = $node->children->get_key_list();

    foreach ($keys as $key) {
        $childnode = $node->children->get($key);

        if ($childnode->children->count() > 0) {
            local_mdl56886_replace_assign_icon($childnode);
        }

        if ($childnode->action && $childnode->action->get_path() == '/mod/assign/view.php') {
            $childnode->icon = new pix_icon('i/invalid', '', 'moodle');
        }
    }

}
