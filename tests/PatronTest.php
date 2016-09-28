<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Patron.php";
    require_once "src/Copy.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
            Copy::deleteAll();
        }

        function testGetId()
        {
            //Arrange
            $name = "Billy Bookborrower";
            $test_patron = new Patron($name, $id = 1);
            //Act
            $result = $test_patron->getId();
            //Assert
            $this->assertEquals($id, $result);
        }

        function testGetName()
        {
            //Arrange
            $name = "Billy Bookborrower";
            $test_patron = new Patron($name);
            $test_patron->save();
            //Act
            $result = $test_patron->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Billy Bookborrower";
            $test_patron = new Patron($name);
            //Act
            $test_patron->save();
            //Assert
            $this->assertEquals($test_patron, Patron::getAll());
        }

        function testUpdate()
        {
            //Arrange
            $name = "Billy Bookborrower";
            $test_patron = new Patron($name);
            $test_patron->save();
            $new_name = "Otis Overduebooks";
            //Act
            $test_patron->update($new_name);
            //Assert
            $this->assertEquals($new_name, $test_patron->getName());
        }

        function testDelete()
        {
            //Arrange
            $name = "Billy Bookborrower";
            $test_patron = new Patron($name);
            $test_patron->save();
            $name2 = "Otis Overduebooks";
            $test_patron2 = new Patron($name2);
            $test_patron2->save();
            //Act
            $test_patron->delete();
            //Assert
            $this->assertEquals([$test_patron], Patron::getAll());
        }

        function testGetAll()
        {
            //Arrange
            $name = "Billy Bookborrower";
            $test_patron = new Patron($name);
            $test_patron->save();
            $name2 = "Otis Overduebooks";
            $test_patron2 = new Patron($name2);
            $test_patron2->save();
            //Act
            $result = Patron::getAll();
            //Assert
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }


        function testDeleteAll()
        {
            //Arrange
            $name = "Billy Bookborrower";
            $test_patron = new Patron($name);
            $test_patron->save();
            $name2 = "Otis Overduebooks";
            $test_patron2 = new Patron($name2);
            $test_patron2->save();
            //Act
            Patron::deleteAll();
            //Assert
            $this->assertEquals([], Author::getAll());
        }
    }
?>
