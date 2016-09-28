<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
        }

        function testGetId()
        {
            //Arrange
            $name = "Gone with the Wind";
            $test_book = new Book($name);
            $test_book->save();
            //Act
            $result = $test_book->getId();
            //Assert
            $this->assertEquals($id, $result);
        }

        function testGetName()
        {
            //Arrange
            $name = "Gone with the Wind";
            $test_book = new Book($name);
            $test_book->save();
            //Act
            $result = $test_book->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        
    }
?>
