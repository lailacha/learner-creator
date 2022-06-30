<?php

?>
<table>
    
    <tbody>
    <h1>Mes suggestions</h1>
    <?php foreach ($courseManager as $course) : ?>
        <tr>
            <td><h3><?= $course->getName()?> </h3></td>
            <td><?= $course->getDescription()?> </td>
        </tr>
    <?php endforeach; ?>

    </tbody>

</table>



<style>

    td,th{
        padding: 0 10px;
    }
    .action{
        display: flex;
    }
    .action > a{
        margin: 0 10px;

    }
</style>