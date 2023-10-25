<?php 
error_reporting(0);
$partie = 1;
session_start();
if(isset($_POST["jouer"])){ //L'user vient d'entrer son nom pour jouer,il peut commencer le jeu
    extract($_POST);
    if(!empty($nom) && !empty($niveau)){
        $_SESSION['indicesCaches'] = null;
        $partie = 2;
        $_SESSION['score'] = 20;
        $_SESSION['niveau'] = $niveau;
        $_SESSION['nom'] = $nom;
        $_SESSION['indicesDemandes'] = null;
        $_SESSION['tableauContenantBonIndices'] = null;
        require_once '../models/jouer/getNomPhotos.php';
        $_SESSION["grille"] = getNomPhotos($_SESSION['mode']);

    }else{
        $erreur = "Veuillez remplir tous les champs";
    }
}else{
    if(isset($_POST['indice'])){
        $_SESSION['indice']= $_POST['indice'];
        $partie = 2;
        $demandeIndiceDeUser = $_POST['indice'];
        if($_SESSION['niveau'] == 1 || $_SESSION['niveau'] == 2 ){
            $_SESSION['indicesDemandes'][$_SESSION['indice']]= $_SESSION['indice'];
            $styleMessage="color:red";
            $message = "Vous avez consulté un(e) indice.Vous avez -". $_SESSION['niveau'];
            $_SESSION['score']-= $_SESSION['niveau'];
            if($_SESSION['score'] <= 0){
                $message = "Vous avez perdu le jeu .La bonne réponse était ".$_SESSION['resultat']['nom'];
                $partie = 3;
                $_SESSION['indicesCaches'] = null;
            }
        }
    
    }elseif(isset($_POST['demanderIndice'])){
        $partie = 2;
    }elseif(isset($_POST['demanderEstCeVrai'])){
        $partie = 2;
        if(!empty($_POST['estCeVrai'])){
            $_SESSION['indicesDemandes'][$_SESSION['indice']]= $_SESSION['indice'];
            if($_SESSION['resultat'][$_SESSION['indice']] == $_POST['estCeVrai'])
                $reponseEstCeVrai = "Oui c'est vrai";
            else
                $reponseEstCeVrai = "Non ce n'est pas vrai";
            $styleMessage="color:red";
            $message = "Indice consulté.Vous avez -". $_SESSION['niveau'];
            $_SESSION['score']-= $_SESSION['niveau'];
            if($_SESSION['score'] <= 0){
                $message = "Vous avez perdu le jeu .La bonne réponse était ".$_SESSION['resultat']['nom'];
                $partie = 3;
                $_SESSION['indicesCaches'] = null;
            }
        }else{
            $messageIndiceNonChoisi = "Veuiilez sélectionnez un indice";
        }
        
    }elseif(isset($_POST['deviner'])){
        $nomDevinette = htmlspecialchars($_POST['nomDevinette']);
        // var_dump($nomDevinette);
        // var_dump($_SESSION['resultat']['nom']);
        $nomDevinette = preg_replace("/\s+/"," ",$nomDevinette);
        if( strtolower(trim($nomDevinette)) == strtolower(trim(htmlspecialchars($_SESSION['resultat']['nom'])))){
            $partie = 3;
            require_once '../models/jouer/enregistrerJoueur.php';
            enregisterJoueur($_SESSION['nom'],$_SESSION['niveau'],$_SESSION['score']);
            $_SESSION['indicesCaches'] = null;
            require_once '../models/jouer/meilleurScoreNiveau.php';
            $meilleurPourCeNiveau =  meilleurScoreNiveau($_SESSION['niveau']);
            $meilleurPourLeJeu = meilleurScoreNiveau();
        }else{
            $partie = 2;
            $styleMessage="color:red";
            $message = "Mauvaise réponse.Vous avez -1";
            $_SESSION['score']--;
            if($_SESSION['score'] <= 0){
                $partie = 3;
                $message = "Vous avez perdu le jeu .La bonne réponse était ".$_SESSION['resultat']['nom'];
                $_SESSION['indicesCaches'] = null;
            }
        }
    }elseif(!empty($_POST['mode'])){//L'user a choisi le mode de jeu depuis l'acceuil,il lui faut maintenant entrer son nom avant de jouer
            $_SESSION['mode'] = htmlspecialchars($_POST['mode']);
        // header("location:../");
        //Ici on gère la partie de rejouer définie dans ../views/jouer3.php
    }elseif(isset($_POST['rejouerAvecMemesParametres'])){
        $_SESSION['indicesCaches'] = null;
        $_SESSION['score'] = 20;
        $_SESSION['indicesDemandes'] = null;
        $_SESSION['indice'] = null;
        $_SESSION['tableauContenantBonIndices'] = null;
        // $_SESSION['rejouer'] = true;
        // header("location:/exercice1/jouer/");
        $partie = 2;
    }elseif(isset($_POST['rejouerCommeUnNouveau'])){
        $_SESSION = null;
        session_destroy();
        header("location:../");
    }elseif(isset($_GET['position']) && !empty($_GET["position"]) && ($_GET['position'] == (int)$_GET['position'])){
        $_SESSION['indicesCaches'][(int)$_GET['position']] = (int)$_GET['position'];
        $partie = 2;
    }else{
        // if(isset($_SESSION['rejouer'])){
        //     unset($_SESSION['rejouer']);
        //     $partie =2;
        // }else{
        //     //On ne sait pas d'où vient l'user pour venir sur cette page.Ainsi on va l'envoyer sur la page d'acceuil
        //     header("location:../");
        // }
        header("location:../");
    }
}
$title = "Jouer";
$style = "<link href='/exercice1/css/footer.css' rel='stylesheet'>";
$style .= "\n<link href='/exercice1/css/style.css' rel='stylesheet'>";
require_once '../include/header.php';
?>
<section id="jeu">
    <?php
        if($partie == 1){ 
            require_once '../views/jouer1.php';
        }elseif($partie == 2){ 
        ?>   
            <p id="butDuJeu" >Devinez le personnage désigné par l'ordinateur. Qui est ce?</p>
            <p id="scoreP">Votre score : <?=@$_SESSION['score']?></p>
            <p id="information" style="<?php echo $styleMessage ?? " "; ?>" ><?=@$message?></p>
            <?php 
            if($_SESSION['niveau'] !=1){
                $_SESSION['tableauContenantBonIndices'][0] = null;
            }
                if( isset($_POST['rejouerAvecMemesParametres']) ||  (empty($_GET["position"]) && !isset($_POST['deviner']) && !isset($_POST['demanderIndice']) && !isset($_POST['indice']) && !isset($_POST['demanderEstCeVrai'])) ){
                    shuffle($_SESSION["grille"]);//Pour melanger les éléments du tableau
                    $randomId = random_int(1,count($_SESSION["grille"]));
                    
                    require_once '../models/jouer/getByIdFromTable.php';
                    $_SESSION['resultat'] = getByIdFromTable($_SESSION['mode'],$randomId);
                    if($_SESSION['niveau'] ==1){
                        require_once '../utils/createRandomIntArray.php';
                        for($i = 0;$i<=19;$i++){
                            $tableau[] = $i;
                        }
                        $_SESSION['tableauContenantBonIndices'] = createRandomIntArray(10,$tableau,$randomId-1); 
                    }
                }
                // var_dump($_SESSION['resultat']['nom']);
            require_once '../views/jouer2.php';
        }elseif($partie ==3){
            require_once '../views/jouer3.php';
        }
    ?>
</section>
<?php require_once '../include/footer.php';die();?>









































</section>
<?php
    require_once '../include/footer.php';
?>
            <div id="grille">
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>1.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>2.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>3.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>4.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>5.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>6.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>7.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>8.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>9.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>10.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>11.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>12.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>13.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>14.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>15.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>16.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>17.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>18.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>19.png">
                <span>Nom</span>
            </div>
            <div>
                <img src="../images/<?=$mode?>/<?=$mode?>20.png">
                <span>Nom</span>
            </div>
            <div id="repondre">
                <form action="" method="POST">
                    <label for="nom">Entrez le nom ici</label>
                    <input type="text" name="nomDevinette" required placeholder="Nom">
                    <input type="submit" name="deviner" value="Valider">
                </form>
                <div id="indiceDiv">
                    <span>Indice1</span>
                    <span>Indice1</span>
                    <span>Indice1</span>
                    <span>Indice1</span>
                    <span>Indice1</span>
                </div>
                <a href="../forgot">Abandonnez la partie</a>
                <form method="POST" id="demanderIndice">
                    <input type="submit" value="Demander d'indice" name="demanderIndice" >
                </form>
            </div>
        </div>
</section>
<?php
    require_once '../include/footer.php';
?>