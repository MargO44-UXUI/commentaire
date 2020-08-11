<?php

require('connect.php');

if(!empty($_POST))
{
  $pseudo = strip_tags($_POST['pseudo']);
  $commentaire = strip_tags($_POST['commentaire']);
  $valid = true;
  
  if(empty($pseudo))
  {
    $valid = false;
    $erreurpseudo = 'Indiquez un pseudo';
  }
  
  if(empty($commentaire))
  {
    $valid = false;
    $erreurcommentaire = 'Indiquez un commentaire';
  }
  
  if(!empty($commentaire) && strlen($commentaire)<10)
  {
    $valid = false;
    $erreurcommentaire = 'Trop court';
  }
  
  if($valid)
  {
    $req = $bdd->prepare('INSERT INTO commentaires (pseudo,contenu) VALUES (:pseudo,:commentaire)');
    $req->execute(array(':pseudo'=>$pseudo, ':commentaire'=>$commentaire));
    $req->closeCursor();
    
    unset($pseudo);
    unset($commentaire);
  }
}

?>

<!DOCTYPE html>
<html>
  <meta charset="UTF-8">
  <head>
    <link rel="stylesheet" href="style.css" />
    <title></title>
  </head>
  <body>
    <div id="content">
      
      <h1>Mon super article</h1>
      
      <p>
        Magna pellentesque urna mus aenean adipiscing tristique nunc! Sociis, dis nisi ac? Integer ridiculus, duis scelerisque elementum! Nascetur integer! Tincidunt. Parturient magna dolor cursus, ridiculus tortor, turpis vel tincidunt mattis, sit tortor eros, augue in natoque lectus sagittis, cursus penatibus scelerisque habitasse. Vel! Lacus penatibus? Lacus in cursus in! Elit! Nec auctor! Scelerisque augue, phasellus lundium! Ut pulvinar nec ac augue pulvinar ac, magna massa urna! Est. Vel magna lorem? Odio hac proin pellentesque lectus rhoncus, nec tortor placerat, nunc, lacus et vel mattis, aliquam dictumst est parturient mid tortor natoque porttitor! Elementum cursus etiam ac cursus urna proin odio! Adipiscing elementum sagittis tristique! Nisi etiam quis etiam penatibus, tempor adipiscing? Natoque cras augue magna amet duis auctor enim ultricies.
        
      </p>
      
      <div id="commentaires">
        
        <?php
        
        $req = $bdd->prepare('SELECT * FROM commentaire ORDER BY id DESC');
        $req->execute();
        while($data = $req->fetch()):?>
        
        <div class="com">
          
          <h4><?php echo $data['pseudo'];?></h4>
          
          <p><?php echo nl2br($data['contenu']);?></p>
          
          <div class="date"><?php echo date('d/m/Y', strtotime($data['date']));?></div>
          
        </div>
        
        <?php
        endwhile;
        ?>
        
      </div>
      
      <form action="index.php" method="post">
        
        <fieldset>
          
          <label for="pseudo">Pseudo:</label>
          <input type="text" name="pseudo" value="<?php if(isset($pseudo)) echo $pseudo;?>" />
          <span class="error"><?php if(isset($erreurpseudo)) echo $erreurpseudo;?></span>
          
          <label for="commentaire">Commentaire:</label>
          <textarea name="commentaire"><?php if(isset($commentaire)) echo $commentaire;?></textarea>
          <span class="error"><?php if(isset($erreurcommentaire)) echo $erreurcommentaire;?></span>
          
          <input type="submit" value="Envoyer" />
          
        </fieldset>
        
      </form>
      
    </div>
  </body>
</html>
