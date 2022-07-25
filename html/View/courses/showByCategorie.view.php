
<h1>Catégorie: <?php echo $categorie->getName(); ?></h1>
<p><?php echo $categorie->getDescription(); ?></p>

<h2>Liste des cours</h2>
<table class=" dataTable display bg-white p-2" style="width:100%">
     <thead>
     <tr>
         <th>Name</th>
     </tr>
     </thead>
     <tbody>
    <?php foreach ($courses as $course) : ?>
         <tr>
             <td class=""><?php echo $course->getName() ?>
             <td><a href="/show/course?id=<?php echo $course->getId() ?>">
             <button class="icon bg-black p-0 rounded-2 ml-a"><i class="fas fa-light fa-eye white"></i></a>
             </td>
         </tr>
    <?php endforeach; ?>
     </tbody>
 </table>