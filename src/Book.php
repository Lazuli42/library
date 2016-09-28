<?php

    class Book
    {
        private $id;
        private $name;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function save()
        {

        }

        function getAll()
        {

        }

        function deleteAll()
        {

        }
        
    }
?>
