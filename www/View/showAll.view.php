<?php

?>
<table>
    
    <tbody>
    <h1>Mes suggestions</h1>
    <?php if (isset($courseManager)) : ?>
     <?php foreach ($courseManager as $course) : ?>
        <tr>
            <td><h3><?= $course->getName()?>  </h3></td>
            <td><?= $course->getCourseReduce($course->getDescription()) ?>   </td>
        </tr>
       
    <?php endforeach; ?> 
    <?php endif; ?>
    <?php if (!isset($courseManager)) : ?>
        
        <p> Vous n'avez pas de préférences</p>
       
        

    <?php endif; ?>

    

    </tbody>

</table>
<table>
    
    <tbody>
    <h1>Mes favoris</h1>
    <?php if (isset($displayCourse)) : ?>
        <?php foreach ($displayCourse as $courseFav) : ?>
        <tr>
            <td><h3><?= $courseFav->getName()  ?>  </h3></td>
            <td><?= $courseFav->getCourseReduce($courseFav->getDescription()) ?>   </td>
        </tr>
       
    <?php endforeach; ?>        

    <?php endif; ?>
    <?php if (!isset($displayCourse)) : ?>
        
        <p> Vous n'avez pas de favoris</p>
       
        

    <?php endif; ?>
     

    

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