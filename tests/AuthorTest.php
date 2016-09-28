<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";


    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function testGetId()
        {
            //Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name, $id = 1);
            //Act
            $result = $test_author->getId();
            //Assert
            $this->assertEquals($id, $result);
        }

        function testGetName()
        {
            //Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);
            $test_author->save();
            //Act
            $result = $test_author->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function testSave()
        {
            // Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);

            // Act
            $test_author->save();

            // Assert
            $this->assertEquals([$test_author], Author::getAll());
        }

        function testUpdate()
        {
            //Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);
            $test_author->save();
            $new_name = "JRR Tolkien";
            //Act
            $test_author->update($new_name);
            //Assert
            $this->assertEquals($new_name, $test_author->getName());
        }

        function testDelete()
        {
            //Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);
            $test_author->save();
            $name2 = "JRR Tolkien";
            $test_author2 = new Author($name2);
            $test_author2->save();
            //Act
            $test_author->delete();
            //Assert
            $this->assertEquals([$test_author2], Author::getAll());
        }

        function testGetAll()
        {
            // Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);
            $test_author->save();
            $name2 = "JRR Tolkien";
            $test_author2 = new Author($name2);
            $test_author2->save();

            // Act
            $result = Author::getAll();

            // Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testDeleteAll()
        {
            // Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);
            $test_author->save();
            $name2 = "JRR Tolkien";
            $test_author2 = new Author($name2);
            $test_author2->save();

            // Act
            Author::deleteAll();

            // Assert
            $this->assertEquals([], Author::getAll());
        }

        function testFind()
        {
            // Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);
            $test_author->save();
            $name2 = "JRR Tolkien";
            $test_author2 = new Author($name2);
            $test_author2->save();
            $id = $test_author2->getId();
            // Act
            $result = Author::find($id);
            // Assert
            $this->assertEquals($test_author2, $result);
        }

        function test_addBook()
        {
            // Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);
            $test_author->save();

            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();

            // Act
            $test_author->addBook($test_book);

            // Assert
            $this->assertEquals([$test_book], $test_author->getBooks());
        }

        function test_getBooks()
        {
            // Arrange
            $name = "Margaret Mitchell";
            $test_author = new Author($name);
            $test_author->save();


            $title = "Gone with the Wind";
            $test_book = new Book($title);
            $test_book->save();
            $test_author->addBook($test_book);

            $title2 = "Lost Laysen";
            $test_book2 = new Book($title2);
            $test_book2->save();
            $test_author->addBook($test_book2);

            // Act
            $result = $test_author->getBooks();

            // Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }
    }
?>
