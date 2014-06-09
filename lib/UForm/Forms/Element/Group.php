<?php

namespace UForm\Forms\Element;

use UForm\Forms\Element

;

/**
 * Collection
 *
 * @author sghzal
 */
class Group extends Element{
    
    /**
     * @var \UForm\Forms\ElementInterface
     */
    protected $elements;

    public function __construct($name, $elements = null) {
        parent::__construct($name);
        
        if(is_array($elements)){
            foreach ($elements as $el){
                $this->elements[] = $el;
            }
        }else if(is_object ($elements)){
            $this->elements[] = $elements;
        }
        
    }
    
    public function addElement(\UForm\Forms\ElementInterface $element){
        $this->elements[] = $element;
    }
    
    public function render( $attributes , $values , $data , $prename = null ) {
        $render = "";
        
        foreach($this->elements as $v){
            $newPrename = $this->getName($prename) . "[" . $v->getName() . "]"; 
            $render .= $v->render( isset($attributes[$v->getName()]) ? $attributes[$v->getName()] : null , $values[$this->getName()] , $data, $newPrename);
        }
        
        return $render;
    }
    
}