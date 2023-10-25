    <form action="" method="POST" style="margin-bottom: 6%;" id="nomJoueurForm">
        <p style="color:red;"><?=$erreur??""?></p>
        <label>Veuillez entrez votre nom afin que nous vous identifions</label>
        <input type="text" name="nom" placeholder="Votre nom">
        <select name="niveau">
            <option value="1" >Niveau1</option>
            <option value="2">Niveau2</option>
            <option value="3" selected>Niveau3</option>
        </select>
        <input type="submit" value="Jouer" name="jouer">
    </form>