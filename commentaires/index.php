<?php

require ('connect.php');

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
    
   if (!empty($commentaire) && strlen($commentaire)<10)
    {  
        $valid = false ; 
        $erreurcommentaire = 'Trop court';
  }
  if($valid){
      $req = $bdd ->prepare ('INSERT INTO commentaires (pseudo, contenu) VALUES (:pseudo, :commentaire)');
      $req -> execute (array(':pseudo' =>$pseudo, ':commentaire'=>$commentaire));
      $req->closeCursor();

      unset($pseudo);
      unset($commentaire);

  }
}

//calculer le nombre déléments dans une chaine de caractères

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaire</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div id="content">
        
            <h1>Mon super article</h1>

                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore accusamus, odio totam eius nesciunt explicabo, animi debitis ullam eveniet non facere aut ipsum distinctio velit optio officiis sequi consequatur architecto.
                Consectetur excepturi officiis est expedita vitae recusandae quae aliquid sed accusamus dicta vel voluptatibus alias mollitia, ab provident reprehenderit obcaecati pariatur. Iusto voluptatibus consectetur quiaolorequuntur, repellendus molestias inventore magni ad ducimus aliquid sunt totam.
                Ullam fugiat error sed laudantium vitae fugit voluptatibus? Ducimus magni molestias odit velit! Voluptatem labuaerat ad possimus, velit sed iure est voluptas facere vitae temporibus?
                Quaerat suscipit ratione, ut quos, rem iusto modi quia cupiditate, reiciendis id enim consequatur nulla. Quasi saepe vel nemo eaque, repellat iusto quia laborum assumenda, sit minima laboriosam incidunt necessitatibus.</p>
            
        
        <div id="commentaire">
            <?php

         $req = $bdd -> prepare('SELECT * FROM commentaire ORDER BY id DESC');
         $req-> execute();
         while($data = $req->fetch()):?>
         
         <div class="com">
            <h4><?php echo $data['pseudo'];?></h4>

            <p><?php echo nl2br($data['contenu']);?></p>

            <div class="date"><?php echo date('d/m/Y', strtotime($data['date']));?></div>

            </div>
         <?php
         endwhile;
         ?>

        

        <form action="index.php" method="post">
    
            <fieldset>
                        
                <label for="pseudo">Pseudo :</label>
                <input type="text" name="pseudo" value="<?php if(isset($pseudo)) echo $pseudo;?>"/>
                <span class="error"><?php if(isset($erreurpseudo)) echo $erreurpseudo; ?></span>


                <label for="commentaire">Commentaires :</label>
                <textarea name="commentaire"><?php if(isset($commentaire)) echo $commentaire;?></textarea>
                <span class="error"><?php if(isset($erreurcommentaire)) echo $erreurcommentaire; ?></span>
                
                <input type="submit" value="envoyer">

            </fieldset>
                
                
                
        </form>


    </div>

</body>
</html>