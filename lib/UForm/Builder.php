<?php

namespace UForm;


use UForm\Forms\Element;
use UForm\Forms\Group\Column;
use UForm\Forms\Group\Row;
use UForm\Forms\Group\Tab;
use UForm\Validation\Validator;

class Builder {

    protected $stack = [];
    protected $currentGroup = null;

    protected $classes;

    protected $useLabel = true;
    protected $usePlaceHolder = true;

    /**
     * @var Element|null
     */
    protected $lastElement = null;

    /**
     * @var Forms\Form
     */
    protected $form;

    function __construct()
    {
        $this->form = new Forms\Form();
        $this->currentGroup = $this->form;
    }

    /**
     * @return Forms\Form
     */
    public function getForm()
    {
        return $this->form;
    }



    protected function _add(Element $e){
        $this->currentGroup->addElement($e);
        $this->lastElement = $e;
    }



    ////////////
    // STRUCTURE


    protected function _stack(Element\Group $e){
        $this->stack[] = $this->currentGroup;
        $this->currentGroup = $e;
    }

    protected function _unstack(){
        if(count($this->stack) == 0){
            throw new \Exception("Group stack is empty, did you call close() too often ?");
        }
        $this->currentGroup = array_shift($this->stack);
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function close(){
        $this->_unstack();
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function row($name = null){
        $element = new Row($name);
        if(isset($this->classes["row"])){
            $element->addClass($this->classes["row"]);
        }

        $this->_add($element);
        $this->_stack($element);

        return  $this;
    }


    public function tab($name = null){
        $element = new Tab($name);
        if(isset($this->classes["tab"])){
            $element->addClass($this->classes["tab"]);
        }

        $this->_add($element);
        $this->_stack($element);

        return  $this;
    }

    //////////
    // UTILS

    /**
     * Get the last created element
     *
     * @return Element the latest element
     */
    public function last(){
        if(!$this->lastElement){
            throw new \Exception("No last element");
        }

        return $this->lastElement;
    }


    /**
     * Add a required validator
     * @param string $text the  message to pass to the validator
     * @return $this
     */
    public function required($text = null){
        if(null === $text){
            $text = "Field Required";
        }
        $this->last()->addRequiredValidator($text);
        return $this;
    }

    /**
     * @param callable|Validator $validator
     * @return $this
     * @throws Forms\Exception
     * @throws \Exception
     */
    public function validator($validator){
        $this->last()->addValidator($validator);
        return $this;
    }

    /**
     * @param callable|Filter $filter
     * @return $this
     * @throws \Exception
     */
    public function filter($filter){
        $this->last()->addFilter($filter);
        return $this;
    }



    ////////////
    // INPUTS

    protected function _makeInput(Element $element, $name, $hname){
        if($this->useLabel) {
            $element->setUserOption("label", $hname);
        }
        if($this->usePlaceHolder){
            $element->setAttribute("placeholder",$hname);
        }
    }

    /**
     * @param $name
     * @param $hname
     * @return $this
     */
    public function text($name, $hname){
        $element = new Element\Text($name);
        $this->_makeInput($element, $name, $hname);
        $this->_add($element);
        if(isset($this->classes["input-text"])){
            $element->addClass($this->classes["input-text"]);
        }
        return $this;
    }

    /**
     * @param $name
     * @param $hname
     * @return $this
     */
    public function password($name, $hname){
        $element = new Element\Password($name);
        $this->_makeInput($element, $name, $hname);
        $this->_add($element);
        if(isset($this->classes["input-text"])){
            $element->addClass($this->classes["input-text"]);
        }
        return $this;
    }

    /**
     * @param $name
     * @param $hname
     * @return $this
     */
    public function select($name, $hname, $values = null){
        $element = new Element\Select($name, $values);
        $element->validateOnSelfValues();
        if($this->useLabel) {
            $element->setUserOption("label", $hname);
        }
        $this->_add($element);
        return $this;
    }

}