<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FastService
 *
 * @author selayair
 */
class CacheService extends SlowService {
    function __construct($letter) {
        $this->letter = $letter;
        $this->cache = new FastCache();
        $this->arr;
    }
            
    function getWidgets() {
        if ($this->cache->has($letter))
        {
            $widgets = $this->cache->get($letter);
        }
        else {
            $widgets = parent::getWidgets();
            $this->cache->set($letter,$widgets);
        }
        foreach ($widgets as $widget) {
            array_push($arr, $this->getWidget($widget->getId()));
        }
        if ($arr == null) throw new SlowServiceException();
        return $arr;
    }
    
    function getWidget($id) {
        if ($this->cache->has($id))
        {
            $widget = $this->cache->get($letter);
        }
        else {
            $widget = parent::getWidget($id);
            $this->cache->set($letter,$id);
        }        
        return $widget;
    }
    
}
