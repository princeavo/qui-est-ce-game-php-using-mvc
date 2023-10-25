<?php 
if(isset($_POST['envoyer'])){
    require_once './include/dbConnection.php';
    $stmt = $db->prepare("INSERT INTO anime (id, nom, genre, origine,cheveux, pelage, comportement,usageDeLaBoca,photo) VALUES (NULL,:nom,:genre,:origine,:cheveux,:pelage, :comportement,:usageDeLaBoca,:photo)");
    $stmt->bindParam(":nom",$_POST["nom"]);
    $stmt->bindParam(":genre",$_POST["genre"]);
    $stmt->bindParam(":origine",$_POST["origine"]);
    $stmt->bindParam(":cheveux",$_POST["cheveux"]);
    $stmt->bindParam(":pelage",$_POST["pelage"]);
    $stmt->bindParam(":comportement",$_POST["comportement"]);
    $stmt->bindParam(":usageDeLaBoca",$_POST["usageDeLaBoca"]);
    $stmt->bindParam(":photo",$_POST["photo"]);
    $stmt->execute();
    echo "réussie";
}
?>
<form action="" method="POST">
    <input name="nom" placeholder="Nom" >
    <input name="genre" placeholder="genre">
    <input name="origine" placeholder="origine" >
    <input name="cheveux" placeholder="cheveux" >
    <input name="pelage" placeholder="pelage" >
    <input name="comportement" placeholder="comportement" >
    <input name="usageDeLaBoca" placeholder="usageDeLaBoca" >
    <input name="photo" placeholder="photo" >
    <input type="submit" name="envoyer" value="envoyer">
</form>