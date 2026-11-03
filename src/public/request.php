<?php

// permet d'afficher les tableau de manière simple
function displayTable($lignes) {
    if (empty($lignes)) {
        echo '<p>Aucun résultat</p>';
        return;
    }

    echo '<table border="1" cellpadding="5"><tr>';
    foreach (array_keys($lignes[0]) as $colonne) {
        echo '<th>' . htmlspecialchars($colonne) . '</th>';
    }
    echo '</tr>';

    foreach ($lignes as $ligne) {
        echo '<tr>';
        foreach ($ligne as $valeur) {
            echo '<td>' . htmlspecialchars($valeur ?? '') . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
