<?php
error_reporting(-1);
ini_set('display_errors','On');
$db = new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

$sql ="SELECT COUNT(id) FROM testdata";
$statement = $db->query($sql);
$maxEntries = (int)$statement->fetchColumn();

$page = 1;
if(isset($_GET['page'])){
  $page = (int)$_GET['page'];
}


$limit=10;
$maxPages = (int)ceil($maxEntries/$limit);

$page = max(1,min($maxPages,$page));
$offset = ($page-1)*$limit;

$sql ="SELECT id,name,content FROM testdata LIMIT :offset,:limit";
$statement = $db->prepare($sql);
$statement->execute([
  'offset'=>$offset,
  'limit'=>$limit
]);

?>
<p>
  <?php for($pageNumber = 1;$pageNumber<=$maxPages;$pageNumber++):?>
    <a href="?page=<?= $pageNumber?>"><?= $pageNumber ?></a>
  <?php endfor;?>
</p>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Content</th>
    </tr>
  </thead>
  <tbody>
      <?php while ($row = $statement->fetch()):?>
        <tr>
          <td><?= $row['id'];?></td>
          <td><?= $row['name'];?></td>
          <td><?= $row['content'];?></td>
        </tr>
      <?php endwhile;?>
  </tbody>
</table>
