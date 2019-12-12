<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("book/create");
$urlToDelete = url("book/delete");

?><h1>View all items</h1>

<p>
    <a href="<?=$urlToCreate?>">Create</a> |
    <a href="<?=$urlToDelete?>">Delete</a>
</p>

<?php if (!$items): ?>
    <p>There are no items to show.</p>
<?php
return;
endif;
?>

<table class="table">
    <tr>
        <th>Id</th>
        <th>Cover</th>
        <th>Author</th>
        <th>Title</th>
        <th>Genre</th>
        <!-- <th>ISBN</th> -->
        <th>Published</th>
        <th>Total Pages</th>
    </tr>
    <?php foreach ($items as $item): ?>
    <tr>
        <td>
            <a href="<?=url("book/update/{$item->id}");?>"><?=$item->id?></a>
        </td>
        <td><img width="180px" src="<?=$item->cover?>"></td>
        <td><?=$item->author?></td>
        <td><?=$item->title?></td>
        <td><?=$item->genre?></td>
        <!-- <td><?=$item->isbn?></td> -->
        <td><?=$item->published?></td>
        <td><?=$item->totalPages?></td>
    </tr>
    <?php endforeach;?>
</table>
