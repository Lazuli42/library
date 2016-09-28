<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
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
            $title = "Gone with the Wind";
            $test_book = new Book($title, $id = 1);
            //Act
            $result = $test_book->getId();
            //Assert
            $this->assertEquals($id, $result);
        }

        function testGetTitle()
        {
            //Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();
            //Act
            $result = $test_book->getTitle();
            //Assert
            $this->assertEquals($title, $result);
        }

        function testSave()
        {
            // Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);

            // Act
            $test_book->save();

            // Assert
            $this->assertEquals([$test_book], Book::getAll());
        }

        function testGetAll()
        {
            // Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();
            $title2 = "Return of the King";
            $test_book2 = new Book($title2);
            $test_book2->save();

            // Act
            $result = Book::getAll();

            // Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testDeleteAll()
        {
            // Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();
            $title2 = "Return of the King";
            $test_book2 = new Book($title2);
            $test_book2->save();

            // Act
            Book::deleteAll();

            // Assert
            $this->assertEquals([], Book::getAll());
        }
    }
?>
