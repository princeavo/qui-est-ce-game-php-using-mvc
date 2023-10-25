<?php
function createRandomIntArray (int $taille,array $aPartirDeCeTableau,int $contientCeNombre=0) : array{
    shuffle($aPartirDeCeTableau);
    for( $i = 0; $i < $taille;$i++){
        $tableau[] = $aPartirDeCeTableau[$i];
    }
    // for( $i = $nombreMinimalDansLeTableau ; $i <= $nombreMaximalDansLeTableau;$i++ ){
    //     $tableau[] = $i;
    // }
    // shuffle($tableau);
    if(!array_search($contientCeNombre,$tableau) && $tableau[0] != $contientCeNombre){
        $tableau[random_int(0,$taille)] = $contientCeNombre;
    }
    return $tableau;
}