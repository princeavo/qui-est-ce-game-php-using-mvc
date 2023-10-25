<section id="presentation">
    <h1>Qui est-ce ?</h1>
    <p><em>Je pense que cette partie peut être réservée pour une description <a href="./more/"> plus d'informations ici</a></em></p>
</section>
<section id="jouer">
    <h2>Veuillez sélectionner ici le mode du jeu</h2>
    <p>Vous avez deux choix de jeux : deviner une célébrité ou deviner un personnage de dessin animé</p>
    <form action="./jouer/"  method="POST">
        <div>
            <label for="celebre">Jouer avec les célébrités</label>
            <input type="radio" name="mode" value="celebre" id="celebre" checked>
        </div>
        <div>
            <label for="anime">Jouer avec les personnages animés</label>
            <input type="radio" name="mode" value="anime" id="anime">
        </div>
        <div>
            <input type="submit" name="commencer" value="jouer">
        </div>
    </form>
</section>