<?php date_default_timezone_set("Europe/Paris");


$menu = "<center>

<a href=\"Fiche_Perso.php\">Fiche personnelle</a><br/>";
if (!($_SESSION['Admin'] == 2)) {
$menu = $menu."
<a href=\"Retrait.php\">Retrait</a><br/>
<hr>
<a href=\"Stocks.php\">Stocks</a>
<hr>

";
}else {

$menu = $menu."<hr><a href=\"Adm_Ajout_utilisateur.php\">Ajouter un utilisateur</a><br/><a href=\"Adm_Liste_utilisateurs.php\">Liste des utilisateurs</a><br/><hr><a href=\"Suppression_Admin.php\">Supprimer un utilisateur</a><br/><a href=\"Degrader_Admin.php\">Degrader un administrateur</a><hr>";
}

if ($_SESSION['Admin'] == 1) {

$menu = $menu."
<a href=\"Ajout_utilisateur.php\">Ajouter un utilisateur</a><br/>
<a href=\"Adm_Modif_user.php\">Modifier un utilisateur</a><br/>
<br/><hr><br/>
<a href=\"Adm_Ajouter_Produit.php\">Ajouter un nouveau produit</a><br/>
<a href=\"Adm_Modifier_Produit.php\">Modifier un produit existant</a><br/>

<a href=\"Consulter_Produit.php\">Consulter la fiche produit</a><br/>
";
$menu = $menu."<a href=\"Adm_Depot_Produit.php\">Depot d'un produit</a><br/>
<a href=\"Purge_Produit.php\">Purger les produits</a><br/>

<center>
<ul class=\"niveau1\">
  <li>
    Gestion des choix
    <ul class=\"niveau2\">

      <li><a href=\"Utilisations.php\">Utilisations</a></li>
      <li><a href=\"Risques.php\">Risques</a></li>
      <li><a href=\"Etats.php\">Etats</a></li>
	  <li><a href=\"PI.php\">Protections individuelles</a></li>
	  <li><a href=\"PC.php\">Protections communes</a></li>
	  <li><a href=\"Lieu.php\">Lieux</a></li>
	  <li><a href=\"Activite.php\">Activites</a></li>
	<li><a href=\"Emplacement.php\">Emplacements</a></li>
    </ul>
  </li>
</ul>
</center>
<hr>








<a href=\"Inventaire.php\">Inventaire des produits</a><br/>
<a href=\"Inventaire0.php\">Inventaire des produits vides</a><br/>
<a href=\"Adm_Liste_utilisateurs.php\">Liste des utilisateurs</a><br/>
<a href=\"Adm_Consulter_Retrait.php\">Consulter les retraits</a><br/>


";
}
$menu = $menu."</center>";
echo $menu;

?>