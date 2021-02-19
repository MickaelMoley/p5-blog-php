<?php


namespace App\CoreBundle\Form;


class FormBase
{
    private $class;
    private $data;
    private $isSubmitted = false;
    private $newData;

    public function __construct($class, $data)
    {
        $this->class = $class;
        $this->data = $data;
        $this->newData = new $this->class;

    }

    public function init(){
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function handleRequest($request)
    {
        $data = $request->query->get('form');

        $objectProperties = (new \ReflectionObject(new $this->class))->getProperties();

        foreach ($objectProperties as $key => $property) {
            // On met la propriété en public pour pouvoir y accéder
            $property->setAccessible(true);
//            dump($property->getName(), $this->data[$key]);
            if(!is_null($data[$property->getName()]))
            {
                $this->data->{$property->getName()} = $data[$property->getName()];

            }

        }


        if($request->query->get('btn_submit') !== null)
        {
            $this->isSubmitted = true;
        }

    }
    public function createView()
    {
        return $this->data;
    }

    public function isSubmitted(): bool
    {
        if($this->isSubmitted)
        {
            return true;
        }
        else {
            return false;
        }
    }
}