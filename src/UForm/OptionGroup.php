<?php
/**
 * @license see LICENSE
 */

namespace UForm;

trait OptionGroup
{

    protected $optionGroup = [];

    /**
     * Sets an option
     *
     * @param string $option name of the option
     * @param mixed $value value of the option
     * @return $this
     */
    public function setOption($option, $value)
    {
        $this->optionGroup[$option] = $value;
        return $this;
    }

    /**
     * Returns the value of an option if present
     *
     * You can specify a default value to return if the option does not exist
     *
     * @param string $option name of the option
     * @param mixed $defaultValue default value to return if option does not exist
     * @return mixed value of the option or the default value
     * @throws Exception
     */
    public function getOption($option, $defaultValue = null)
    {
        if (isset($this->optionGroup[$option])) {
            return $this->optionGroup[$option];
        }
        return $defaultValue;
    }

    /**
     * Set value of many options
     *
     * @param array $options list of the options ["optionName" => "value"]
     * @return $this
     * @throws Exception
     */
    public function addOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
        return $this;
    }

    /**
     * Resets the options and set the given options instead
     *
     * @param array|null $options array of the new options to set.
     * Can be null or an empty array to reset remove all options
     * @return $this
     * @throws Exception
     */
    public function setOptions($options)
    {
        $this->optionGroup = [];
        if (null !== $options) {
            return $this->addOptions($options);
        }
    }

    /**
     * Check if at least one of the given option exists
     * @return bool if at least one of the option exists
     */
    public function hasOneOption()
    {
        $args = func_get_args();
        foreach ($args as $optionName) {
            if (isset($this->optionGroup[$optionName])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if the option exists
     * @param string $option
     * @return bool
     */
    public function hasOption($option)
    {
        return array_key_exists($option, $this->optionGroup);
    }

    /**
     * Returns the options for the element
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->optionGroup;
    }
}
