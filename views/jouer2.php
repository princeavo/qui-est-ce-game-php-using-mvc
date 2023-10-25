<div id='grille' style='padding-bottom: 0;'>
<?php foreach ($_SESSION["grille"] as $key=> $value):?>
    <div class="blocImage <?php if(isset($_SESSION['indicesCaches'])  && isset($_SESSION['indicesCaches'][$key+1])) {echo 'none';} ?>" >
        <a href="?position=<?=$key+1?>"><img src="../images/<?=$_SESSION['mode']?>/<?=$value['photo']?>" id="<?=$key+1?>"></a>
        <span style="<?php if(array_search($key,$_SESSION['tableauContenantBonIndices']) || $_SESSION['tableauContenantBonIndices'][0] === $key) echo 'font-weight:bolder;font-style:italic;font-family:Cambria';?>"><?=$value['nom']?></span>
    </div>
<?php endforeach; ?>
</div>
<div id="repondre">
    <form action="" method="POST" id="formDevinette">
        <!-- <label for="nom">Entrez le nom ici</label> -->
        <input type="text" name="nomDevinette" required placeholder="Nom">
        <input type="submit" name="deviner" value="Valider">
    </form>
    <form id="indiceDiv" class="<?php if(!isset($_POST['demanderIndice']) && !isset($demandeIndiceDeUser) && !isset($_POST['demanderEstCeVrai']) ) echo "none";?>" method="post">
        <?php
            if(isset($demandeIndiceDeUser) ){
                if($_SESSION['niveau'] == 1 || $_SESSION['niveau'] == 2 ){
                    if(!empty($_SESSION['resultat'][$demandeIndiceDeUser])){
                        echo  $_SESSION['resultat'][$demandeIndiceDeUser] ;
                    }else{
                        echo "Vide";
                    }
                }else{
                    require_once '../include/dbConnection.php';
                    $stmt = $db->prepare("SELECT DISTINCT $demandeIndiceDeUser ". " FROM " . $_SESSION['mode']);
                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                    foreach($results as $tableauResultatPossible){
                        foreach($tableauResultatPossible as $resultatPossible){
                            if(!empty($resultatPossible)):
                        ?>
                                <div class="radio">
                                    <input type="radio" name="estCeVrai" value="<?= $resultatPossible ?>" id="<?= $resultatPossible ?>">
                                    <label for="<?= $resultatPossible ?>"><?= $resultatPossible ?></label>
                                </div>
                        <?php
                            endif;
                        }   
                    }
                ?> <input type="submit" name="demanderEstCeVrai" value="Est-ce vrai?">
                <?php
                }  
            }else{
                require_once '../models/jouer/getFromTable.php';
                $resultats = getFromTable($_SESSION['mode'],1)[0];
                // var_dump($resultats);
                $keys = array_keys($resultats);
                // var_dump($keys);
                foreach ($keys as $key => $value) {
                    if($key!=0 && $key!=1 && $key!=8):
                    ?>
                        <?php $disabled = isset($_SESSION['indicesDemandes'][$value]) ? "disabled=disabled" : ""; ?>
                        <input type="submit" name="indice" value="<?=$value?>" <?=@$disabled?>  >
                    <?php endif;
                }
                ?>
                    <p style='position:relative;top:30px '><?=$reponseEstCeVrai ?? ' ' ?></p>
                    <?php if(!empty($messageIndiceNonChoisi)): ?>
                        <p style='position:relative;top:30px '><?=$messageIndiceNonChoisi ?></p>
                    <?php endif; ?>
                <?php
            } 
        ?>
    </form>
    <form method="POST" id="demanderIndice">
        <a href="../forgot">Quittez</a>
        <input type="submit" value="Indice" name="demanderIndice" >
    </form>
</div>