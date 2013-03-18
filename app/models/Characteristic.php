<?php

class Characteristic extends BaseModel {

    /**
     * Collection is null since this is an embedded within Category
     *
     * @var string
     */
    protected $collection = null;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = array(
        'name'      => 'required',
        'type'     => 'required'
    );

    /**
     * Attributes that will be generated by FactoryMuff
     */
    public static $factory = array(
        'name' => 'string',
        'type' => 'int',
        'layout-pre' => '',
        'layout-pos' => '',
        'values' => '',
    );

    /**
     * When the values are set, explode string into array
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        if($key == 'values')
        {
            if(is_string($value))
            {
                $value = array_map('trim',explode(",",$value));
            }
        }

        parent::setAttribute($key, $value);
    }

    public function isValid()
    {
        if($this->type == 'option')
        {
            if(! is_array($this->values))
            {

                return false;
            }
        }

        return parent::isValid();
    }

    public function displayLayout( $value = "<span class='muted'>&ltvalor&gt</span>" )
    {
        $result = ($this->getAttribute('layout-pre')) ? $this->getAttribute('layout-pre')." " : "";
        $result .= $value;
        $result .= ($this->getAttribute('layout-pos')) ? " ".$this->getAttribute('layout-pos') : "";

        return $result;
    }

    public function getValuesStr()
    {
        if($this->type == 'option' && is_array($this->values))
            return implode(', ', $this->values);
        else
            return 'Qualquer';
    }

    public function getTypeStr()
    {
        switch ($this->type) {
            case 'int':
                return 'Numero';
                break;

            case 'float':
                return 'Numero decimal';
                break;

            case 'option':
                return 'Opções';
                break;
            
            default:
                return 'Livre';
                break;
        }
    }

    public function validate($value)
    {
        switch ($this->type) {
            case 'int':
                return is_numeric($value);
                break;

            case 'float':
                return is_numeric($value);
                break;

            case 'option':
                return in_array($value, $this->values);
                break;
            
            default:
                return true;
        }
    }
}
