<?php

namespace Blixter\Book\HTMLForm;

use Anax\HTMLForm\FormModel;
use Blixter\Book\Book;
use Psr\Container\ContainerInterface;

/**
 * Form to update an item.
 */
class UpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $book = $this->getItemDetails($id);
        $checkedGenres = explode(", ", $book->genre);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $book->id,
                ],
                "author" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $book->author,
                ],

                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $book->title,
                ],

                "cover" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $book->cover,
                ],

                "published" => [
                    "type" => "date",
                    "validation" => ["not_empty"],
                    "value" => $book->published,
                ],

                "totalPages" => [
                    "type" => "number",
                    "validation" => ["not_empty"],
                    "value" => $book->totalPages,
                ],

                "genre" => [
                    "type" => "checkbox-multiple",
                    "label" => "Select one or more genre:",
                    "values" => [
                        "Mystery",
                        "Sci-fi",
                        "Drama",
                        "Fantasy",
                        "Thriller",
                        "Horror",
                        "Crime",
                        "Action",
                        "Biography",
                        "Humor",
                    ],
                    "checked" => $checkedGenres,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"],
                ],

                "reset" => [
                    "type" => "reset",
                ],
            ]
        );
    }

    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Book
     */
    public function getItemDetails($id): object
    {
        $book = new Book();
        $book->setDb($this->di->get("dbqb"));
        $book->find("id", $id);
        return $book;
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit(): bool
    {

        $book = new Book();
        $book->setDb($this->di->get("dbqb"));
        $book->find("id", $this->form->value("id"));
        $book->author = $this->form->value("author");
        $book->title = $this->form->value("title");
        $book->cover = $this->form->value("cover");
        $book->genre = implode(", ", $this->form->value("genre"));
        $book->published = $this->form->value("published");
        $book->totalPages = $this->form->value("totalPages");
        $book->save();
        return true;
    }

    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("book")->send();
    //     //$this->di->get("response")->redirect("book/update/{$book->id}");
    // }

    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
