<?php

    class Book
    {
        private $id;
        private $title;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }

        function addAuthor($new_author)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$new_author->getId()}, {$this->getId()});");
        }

        function getAuthors()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books
                JOIN authors_books ON (authors_books.book_id = books.id)
                JOIN authors ON (authors.id = authors_books.author_id)
                WHERE books.id = {$this->getId()};");
            $authors = array();
            foreach ($returned_authors as $author)
            {
                $id = $author['id'];
                $name = $author['name'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        function addCopy($new_copy)
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ({$this->getId()});");
        }

        function getCopies()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getId()};");
            $copies = array();
            foreach($returned_copies as $copy)
            {
                $book_id = $copy['book_id'];
                $checked_in = $copy['checked_in'];
                $id = $copy['id'];
                $new_copy = new Copy($book_id, $checked_in, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        function getNumberOfCopies()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getId()};");
            $number_of_copies = 0;
            foreach($returned_copies as $copy)
            {
                $number_of_copies++;
            }
            return $number_of_copies;
        }

        function getAvailableCopies()
        {
            $available_copies = 0;
            $copies = Copy::getAll();
            foreach($copies as $copy)
            {
                if ($copy->getCheckedIn() == 1 && $copy->getBookId() == $this->getId())
                {
                    $available_copies++;
                }
            }
            return $available_copies;
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();
            foreach ($returned_books as $book)
            {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach($books as $book)
            {
                $id = $book->getId();
                if ($id == $search_id)
                {
                    $found_book = $book;
                }
            }
            return $found_book;
        }
    }
?>
