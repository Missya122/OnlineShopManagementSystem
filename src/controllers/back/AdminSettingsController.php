<?php
namespace Controllers{
    use Core\Context;
    use Core\Controller;
    use Core\Configuration;
    use Utils\Tools;

    class AdminSettingsController extends Controller
    {
        const TEMPLATE = "settings";

        public function __construct()
        {
            parent::__construct();
        }

        public function init()
        {
            parent::init();

            $this->template = self::TEMPLATE;
        }

        public function initVariables()
        {
            parent::initVariables();

            if(Tools::getValue('action') === 'settings') {
                $this->saveSettings();
            }
            
            if(Tools::getValue('action') === 'delete') {
                $key = Tools::getValue('key');
                Configuration::deleteValue($key);
            }

            $fields = Configuration::getAll();
            $fields = $this->prepareFields($fields);

            $this->appendVariables(['configuration' => $fields]);
        }

        public function prepareFields($fields)
        {
            $fieldsPrepared = [];

            foreach($fields as $field)
            {
                $fieldsPrepared[$field['key']] = $field['value'];
            }

            return $fieldsPrepared;
        }

        public function saveSettings()
        {
            foreach($_POST as $name => $value) {

                if($name === 'action' || $name === 'new_field_name' || $name === 'new_field_value') {
                    continue;
                }

                Configuration::saveValue($name, $value);
            }

    
            $new_field_name = Tools::getValue('new_field_name'); 
            $new_field_value = Tools::getValue('new_field_value');

            if($new_field_name && $new_field_value) {
                Configuration::saveValue($new_field_name, $new_field_value);
            }
            
        }
    }
}
