<?php

namespace Blixter\Book\HTMLForm;

use Anax\HTMLForm\FormModel;
use Blixter\Book\Book;
use Psr\Container\ContainerInterface;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Details of the item",
            ],
            [
                "author" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "cover" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "published" => [
                    "type" => "date",
                    "validation" => ["not_empty"],
                ],

                "totalPages" => [
                    "type" => "number",
                    "validation" => ["not_empty"],
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
                    "checked" => [],
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Create item",
                    "callback" => [$this, "callbackSubmit"],
                ],
            ]
        );
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
        $book->author = $this->form->value("author");
        $book->title = $this->form->value("title");
        $book->cover = $this->form->value("cover");
        $book->genre = implode(", ", $this->form->value("genre"));
        $book->published = $this->form->value("published");
        $book->totalPages = $this->form->value("totalPages");
        $book->save();
        return true;
    }

    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("book")->send();
    }

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
