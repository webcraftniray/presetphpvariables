<?

/**
 * @package   PresetPHPVariables
 * @author    Ray Lawlor http://www.zoomodsplus.com
 * @copyright Copyright (C) 2013 zoomodsplus.com
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class PlgContentPresetphpvariables extends JPlugin {

    public function __construct(& $subject, $config) {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    /**
     * Plugin that replaces php 'style' variables in content with user set vaues site wide.
     *
     * @param   string   $context   The context of the content being passed to the plugin.
     * @param   mixed    &$article  An object with a "text" property to be processed.
     * @param   array    &$params   Additional parameters.
     * @param   integer  $page      Optional page number. Unused. Defaults to zero.
     *
     * @return  boolean	True on success.
     */
    public function onContentPrepare($context, &$article, &$params, $page = 0) {

        $data = json_decode($this->params->get('list_vars'));
        $text = $article->text;

        return $this->_switchReplace($article->text, $data);
    }

    /**
     * Switch and replace the preset variables with entered values.
     *
     * @param   string  &$text  The string to be searched.
     * @param   array   $data   The array of entered params.
     * @return  boolean  True on success.
     */
    protected function _switchReplace(&$text, $data) {
        
        $assoc = array();
        $i = 0;
        foreach ($data->variable as $variables) {
            $assoc[$variables] = $data->value[$i];
            $i++;
        }

        foreach ($assoc as $variable => $value) {

            $searchTerm = '$' . "$variable";

            //search the article/module text for the PHP 'style' variable
            //and replace it with the entered value.
            $text = str_replace($searchTerm, $value, $text);
        }
    }

}