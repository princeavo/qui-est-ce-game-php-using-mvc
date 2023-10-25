<div id="conteneurScore">
    <div id="scoreDesJoueurs">
        <p id="felicitations">Félicitations <?=$_SESSION['nom']?></p>
        <p>Votre score est <span><?=$_SESSION['score']?></span></p>
        <p>La bonne réponse est<b> <?=$_SESSION['resultat']['nom']?></b></p>
        <div>Meilleur score pour le niveau <?=$_SESSION['niveau']?>: <?=$meilleurPourCeNiveau['sc']?></div>
        <div>Meilleur score pour le jeu <?=$meilleurPourLeJeu['sc']?> réalisé par <?=($meilleurPourLeJeu['nom'] == $_SESSION['nom'] ? "vous" : $meilleurPourLeJeu['nom']) ?></div>
        <div>Merci pour votre participation.Nous serons heureux de vous revoir!</div>
        <form id="rejouer" method="POST" action="">
            <input type="submit" name="rejouerAvecMemesParametres" value="Rejouer avec les mêmes paramètres">
            <input type="submit" name="rejouerCommeUnNouveau" value="Rejouer en changant les paramètres">
        </form>
    </div>
</div>
<!-- //Je vais revoir la condition du suflles au niveau de index.php de /jeu


SELECT nom,MAX(score) as sc FROM joueurs ORDER BY sc ASC LIMIT 1; //Meilleur score pour le jeu

SELECT MAX(score) as sc FROM joueurs WHERE niveau=3 ORDER BY sc ASC LIMIT 1; //meilleur score pour le niveau 3 -->