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

        function testUpdate()
        {
            //Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();
            $new_title = "The Hobbit";
            //Act
            $test_book->update($new_title);
            //Assert
            $this->assertEquals($new_title, $test_book->getTitle());
        }

        function testDelete()
        {
            //Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();
            $title2 = "The Hobbit";
            $test_book2 = new Book($title2);
            $test_book2->save();
            //Act
            $test_book->delete();
            //Assert
            $this->assertEquals([$test_book2], Book::getAll());
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

        function testFind()
        {
            // Arrange
            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();
            $title2 = "Return of the King";
            $test_book2 = new Book($title2);
            $test_book2->save();
            $id = $test_book2->getId();
            // Act
            $result = Book::find($id);
            // Assert
            $this->assertEquals($test_book2, $result);
        }

        function test_addAuthor()
        {
            //Arrange
            $title = "Good Omens";
            $test_book = new Book($title);
            $test_book->save();

            $name = "Terry Pratchett";
            $test_author = new Author($name);
            $test_author->save();
            //Act
            $test_book->addAuthor($test_author);
            //Assert
            $this->assertEquals([$test_author], $test_book->getAuthors());
        }

        function test_getAuthors()
        {
            //Arrange
            $title = "Good Omens";
            $test_book = new Book($title);
            $test_book->save();

            $name = "Terry Pratchett";
            $test_author = new Author($name);
            $test_author->save();
            $test_book->addAuthor($test_author);

            $name2 = "Neil Gaiman";
            $test_author2 = new Author($name2);
            $test_author2->save();
            $test_book->addAuthor($test_author2);
            //Act
            $result = $test_book->getAuthors();
            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }
    }
?>
