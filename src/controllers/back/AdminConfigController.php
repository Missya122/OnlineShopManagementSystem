<?php

namespace Controllers;

use Core\Context;
use Core\Controller;
use Core\Routing;

use Utils\Tools;
use Utils\DatabaseFields;

class AdminConfigController extends Controller
{
    const TEMPLATE = "config";
    const CONFIG_REQUEST_PARAM = "config";

    public $model = null;
    public $model_classname = null;

    public function __construct()
    {
        $request = Routing::parseCurrentRequest();
        
        $config_type = $this->getConfigType($request);
        $config_model_classname = self::getConfigModelClass($config_type);
        
        if(!$config_type || !class_exists($config_model_classname)) {
            Tools::redirectAdmin();
        }

        // add id loading here and add it to form
        $this->model_classname = $config_model_classname;
        $this->model = new $config_model_classname();

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
        
        $this->appendVariables([
            'form' => [
                'fields' => $this->prepareFields()
            ]
        ]);
    } 

    protected function getConfigType($request)
    {
        $position = array_search(self::CONFIG_REQUEST_PARAM, $request);
        
        if($position !== false) {
            return isset($request[$position + 1]) ? $request[$position + 1] : null; 
        }

        return null;
    }

    protected function getConfigModelClass($config_type) {
        $config_type = ucfirst($config_type);
    
        return "Model\\$config_type";
    }

    protected function prepareFields() {
        $fields = [];

        if($this->model) {
            $model_fields = $this->model::$fields;
            
            foreach($model_fields as $field) {
                $fields[] = [
                    'type' => self::convertFieldType($field['type']),
                    'name' => self::convertFieldName($field['name']),
                    'size' => isset($field['size']) ? $field['size'] : null 
                ];
            }
        }

        return $fields;
    }

    protected function convertFieldType($type) {
        switch($type) {
            case DatabaseFields::FIELD_DATETIME:
                return 'date';
                break;
            case DatabaseFields::FIELD_DECIMAL:
                return 'number';
                break;
            case DatabaseFields::FIELD_INT:
                return 'number';
                break;
            case DatabaseFields::FIELD_STRING:
                return 'text';
                break;
            default:
                return null;
            break;
        }

        return null;
    }

    protected function convertFieldName($name) {
        return str_replace('_', ' ', $name);
    }
}


