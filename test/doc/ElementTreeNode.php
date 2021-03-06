<?php

namespace UForm\Doc;


class ElementTreeNode implements NodeContainer{

    protected $className;
    /**
     * @var ElementTreeNode[]
     */
    protected $nodes = [];

    /**
     * @var SemanticTypeInformation[]
     */
    protected $semTypes = null;

    protected $renderOptions = null;

    function __construct($className)
    {
        $this->className = $className;
    }

    public function getClassName(){
        return $this->className;
    }

    public function add($list){
        $parent = array_shift($list);

        if($parent != $this->getClassName()){
            $className = end($list);
            if(!$className){
                $className = $parent;
            }
            throw new \Exception("Invalid class $className. Not a subclass of " . $this->getClassName());
        }

        if(count($list) > 0){
            $element = reset($list);
            if(!isset($this->nodes[$element])){
                $this->nodes[$element] = new ElementTreeNode($element);
            }
            $this->nodes[$element]->add($list);
        }
    }


    /**
     * @return ElementTreeNode[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    public function hasChildren(){
        return count($this->nodes) > 0;
    }

    /**
     * @return SemanticTypeInformation[]
     */
    public function getSemanticTypes(){

        if(null === $this->semTypes){
            $reader = AnnotationReaderFactory::getDefault();
            $semTypes = [];

            // DEFAULT CLASS
            $annotations = $reader->getClassAnnotations($this->className);
            $foundTypes = $annotations->getAsArray("semanticType");

            foreach($foundTypes as $type){
                $semTypes[] = new SemanticTypeInformation($type, false, $this->className, $this->className);
            }

            // PARENT CLASSES
            foreach(class_parents($this->getClassName()) as $parentClass){
                $annotations = $reader->getClassAnnotations($parentClass);
                $foundTypes = $annotations->getAsArray("semanticType");
                foreach($foundTypes as $type){
                    $semTypes[] = new SemanticTypeInformation($type, true, $this->className, $parentClass);
                }
            }
            $this->semTypes = $semTypes;
        }

        return $this->semTypes;
    }

    public function getSelfSemanticTypes(){
        $found = [];
        foreach($this->getSemanticTypes() as $type){
            if(!$type->isDefinedInParent()){
                $found[] = $type;
            }
        }
        return $found;
    }

    /**
     * get the list of renderOption annotation
     * @return RenderOptionInformation[]
     */
    public function getRenderOptions(){

        if(null === $this->renderOptions){
            $reader = AnnotationReaderFactory::getDefault();
            $rOptions = [];

            // DEFAULT CLASS
            $annotations = $reader->getClassAnnotations($this->className);
            $foundOptions = $annotations->getAsArray("renderOption");

            foreach($foundOptions as $string){
                $rOptions[] = RenderOptionInformation::fromString($string);
            }

            // PARENT CLASSES
            foreach(class_parents($this->getClassName()) as $parentClass){
                $annotations = $reader->getClassAnnotations($parentClass);
                $foundOptions = $annotations->getAsArray("renderOption");
                foreach($foundOptions as $string){
                    $rOptions[] = RenderOptionInformation::fromString($string);
                }
            }
            $this->renderOptions = $rOptions;
        }

        return $this->renderOptions;

    }

    public function implementsDrawable(){
        $implements = class_implements($this->className);
        return in_array("UForm\Form\Element\Drawable", $implements);
    }

}
