<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
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
    }
?>
