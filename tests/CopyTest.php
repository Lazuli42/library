<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Copy.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Copy::deleteAll();
            Book::deleteAll();
        }

        function testGetNumberOfCopies()
        {
            // Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();

            $book_id = $test_book->getId();
            $test_copy = new Copy($book_id);
            $test_copy->save();

            $test_copy2 = new Copy($book_id);
            $test_copy2->save();

            // Act
            $result = $test_book->getNumberOfCopies();

            // Assert
            $this->assertEquals(2, $result);
        }

        function testCheckIn_Out()
        {
            // Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();

            $book_id = $test_book->getId();
            $checked_in = 1;
            $test_copy = new Copy($book_id, $checked_in);
            $test_copy->save();

            // Act
            $test_copy->checkIn_Out();

            // Assert
            $this->assertEquals(0, $test_copy->getCheckedIn());
        }

        function testAvailableCopies()
        {
            // Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();

            $book_id = $test_book->getId();
            $test_copy = new Copy($book_id);
            $test_copy->save();

            $test_copy2 = new Copy($book_id);
            $test_copy2->checkIn_Out();
            $test_copy2->save();


            // Act
            $result = $test_book->getAvailableCopies();

            // Assert
            $this->assertEquals(1, $result);
        }
    }
?>
