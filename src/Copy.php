<?php
    class Copy
    {
        private $id;
        private $book_id;
        private $checked_in;

        function __construct($book_id, $checked_in=1, $id=null)
        {
            $this->book_id = $book_id;
            $this->checked_in = $checked_in;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getBookId()
        {
            return $this->book_id;
        }

        function getCheckedIn()
        {
            return $this->checked_in;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id, checked_in) VALUES ('{$this->getBookId()}', {$this->getCheckedIn()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function checkIn_Out()
        {
            if ($this->checked_in == 1)
            {
                $this->checked_in = 0;
            }
            elseif ($this->checked_in == 0)
            {
                $this->checked_in = 1;
            }
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();
            foreach ($returned_copies as $copy)
            {
                $book_id = $copy['book_id'];
                $checked_in = $copy['checked_in'];
                $new_copy = new Copy($book_id, $checked_in);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies;");
        }
    }
 ?>
