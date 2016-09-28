<?php
    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array ('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig', array('books' => Book::getAll(), 'authors' => Author::getAll()));
    });

    $app->get("/add_book", function() use ($app) {
        return $app['twig']->render('add-book.html.twig', array('books' => Book::getAll(), 'authors' => Author::getAll()));
    });

    $app->post("/new_book", function() use ($app) {
        $new_book = new Book($_POST['title']);
        $new_book->save();
        if ($_POST['new_author'] != '')
        {
            $new_author = new Author($_POST['new_author']);
            $new_author->save();
            $new_book->addAuthor($new_author);
        }
        if ($_POST['author_id'] != "0")
        {
            $author = Author::find($_POST['author_id']);
            $author->addBook($new_book);
        }
        return $app['twig']->render('home.html.twig', array('books' => Book::getAll(), 'authors' => Author::getAll()));
    });

    $app->get("/book/{id}", function($id) use ($app) {
            return $app['twig']->render('edit-book.html.twig', array('book' => Book::find($id), 'authors' => Author::getAll()));
    });

    $app->patch("/edited_book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->update($_POST['new_title']);
        if ($_POST['new_author'] != '')
        {
            $new_author = new Author($_POST['new_author']);
            $new_author->save();
            $book->addAuthor($new_author);
        }
        if ($_POST['author_id'] != "0")
        {
            $author = Author::find($_POST['author_id']);
            $author->addBook($book);
        }
        return $app['twig']->render('home.html.twig', array('books' => Book::getAll(), 'authors' => Author::getAll()));
    });

    return $app;
 ?>
