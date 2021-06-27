<?php

namespace Controllers;

use Core\Context;
use Core\Controller;
use Core\Routing;
use Core\Image;

use Utils\Tools;
use Utils\DatabaseFields;

class AdminConfigController extends Controller
{
    const TEMPLATE = "config";
    const CONFIG_REQUEST_PARAM = "config";

    public $model_type = null;
    public $model = null;
    public $model_classname = null;

    public function __construct()
    {
        $request = Routing::parseCurrentRequest();
        $this->initModelFields($request);

        $action = Tools::getValue('action');

        if($action === 'delete') {
            $this->processDelete();
        }

        if($action === 'edit') {
            $this->processEdit();
        }
        
        if($action === 'save') {
            $this->processSave();
        }
        
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
            'type' => $this->model_type,
            'objects' => $this->getAllObjects(),
            'form' => [
                'id_object' => isset($this->object_id) ? $this->object_id : null,
                'fields' => $this->prepareFields()
            ]
        ]);
    }

    protected function initModelFields($request) {
        $this->model_type = $this->getConfigType($request);
        $this->model_classname = self::getConfigModelClass($this->model_type);

        if(!$this->model_type || !class_exists($this->model_classname)) {
            Tools::redirectAdmin();
        }

        $this->model = new $this->model_classname();
    }

    protected function getConfigType($request)
    {
        $index = array_search(self::CONFIG_REQUEST_PARAM, $request);
        
        if($index !== false) {
            return isset($request[$index + 1]) ? $request[$index + 1] : null; 
        }

        return null;
    }

    protected function getConfigModelClass($config_type) {
        $config_type = ucfirst($config_type);
    
        return "Model\\$config_type";
    }

    protected function processEdit() {
        $this->object_id = Tools::isSubmit('id') ? Tools::getValue('id') : null;

        $entity = $this->createEntity($this->object_id);
        $this->fieldValues = (array) $entity;
    }

    protected function processDelete() {
        $this->object_id = Tools::isSubmit('id') ? Tools::getValue('id') : null;

        $entity = new $this->model_classname($this->object_id);
        $entity->delete();

        unset($this->object_id);
    }

    protected function processSave() {
        $this->object_id = Tools::isSubmit('id') ? Tools::getValue('id') : null;
            
        $entity = $this->createEntity($this->object_id);
        $entity->save();

        $entity = $this->saveImageFields($entity);

        unset($this->object_id);
    }

    protected function prepareFields() {
        $fields = [];

        if($this->model) {
            $model_fields = $this->model::$fields;
            
            foreach($model_fields as $field) {
                $is_primary = $field['name'] === $this->model::$primary;
     
                $fields[] = [
                    'name' => $is_primary ? 'id' : $field['name'],
                    'displayname' => $is_primary ? 'id' : self::convertFieldName($field['name']),
                    'type' => self::convertFieldType($field['type']),
                    'size' => isset($field['size']) ? $field['size'] : null,
                    'is_image' => isset($field['is_image']) ? $field['is_image'] : false,
                    'is_primary' => $is_primary
                ];
            }

            if(isset($this->fieldValues)) {
                foreach($this->fieldValues as $key => $value) {
                    foreach($fields as &$field) {
                        if($field['name'] === $key) {
                            $field['value'] = $value;
                        }
                    }
                }
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

    protected function createEntity($id = null) {
       
        $entity = new $this->model_classname($id);
        $entity_fields = array_keys((array) $entity);
        
        foreach($entity_fields as $key) {

            if(!$this->isKeyImage($entity, $key)) {

                $value = Tools::getValue($key);

                

                if($value) {
                    $entity->$key = $value;
                }  
            }
        }

        return $entity;
    }

    protected function saveImageFields($entity)
    {
        $entity_fields = array_keys((array) $entity);

        foreach($entity_fields as $key) {
            if($this->isKeyImage($entity, $key)) {
                if(Image::imagesToUploadCount() > 0) {
                    $image = Image::getUploadedImage($key);

                    if(Image::isImageCorrect($image)) {
                        return;
                    }

                    $filename = $image['name'];
                    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    
                    $image_name = $this->getImageName($key, $entity);
                    $image_folder_dir = $entity::getImageDirectory();
    
                    Image::uploadImage($key, "{$image_folder_dir}/{$image_name}.{$file_ext}");
                    $entity->$key = "{$image_name}.{$file_ext}";
                }
            } 
        }

        $entity->save();
        return $entity;
    }

    protected function isKeyImage($entity, $key) {   
        foreach($entity::$fields as $field) {
            if($key === $field['name'] && isset($field['is_image']) && $field['is_image']) {
                return true;
            }
        }

        return false;
    }

    protected function getImageName($key, $entity) {
        $primary = $entity->{$entity::$primary} ? $entity->{$entity::$primary} : $entity->getPrimary();

        return "{$key}_{$primary}";
    }

    protected function getAllObjects() {
        global $DB;

        $result = $DB->getAllData($this->model::$table);
        $primary = $this->model::$primary;

        foreach($result as &$object) {
            foreach($object as $key => $value) {
                if($key === $primary) {
                    unset($object[$key]);
                    $object['id'] = $value;
                }
            }
        }

        return $result;
    }

}


