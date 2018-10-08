<?php
// Declaration du tableau contenant les mois de l'année 
$months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="assets/css/style.css"/>
        <title>TPP9</title>
    </head>
    <body>
        <nav class="navbar navbar-dark bg-dark">
            <h1>TP Partie 9</h1>
            <a href="http://exephpp9/">Index</a>
            <a href="indexCorrection.php/">Correction</a>
        </nav>
        <div class="container col-10">
            <div class="form-group">
                <form action="index.php" method="post">
                    <label for="month">Mois : </label>
                    <!-- Liste déroulante mois -->
                    <select class="custom-select custom-select-sm col-3" name="month" id="month">
                        <?php
                        $indice = 1;
                        // pour chaque mois récup données depuis select  
                        foreach ($months as $month) {
                            ?>
                            <option value="<?= $indice++; ?>"><?= $month; ?></option>
                        <?php } ?>
                    </select>
                    <!-- Liste Déroulante année -->
                    <label for="years">Années : </label>
                    <select class="custom-select custom-select-sm col-3" name="years" id="years">
                        <option selected disabled>Années</option>
                        <?php
                        for ($year = 1950; $year <= 2050; $year++) {
                            ?>
                            <option <?php
                            // si aucun choix afficher l'année en cours
                            if (empty($_POST['years']) && ($year == date('Y'))) {
                                echo 'selected';
                                // si selectioné affichage de la date
                            } elseif (!empty($_POST['years']) && $_POST['years'] == $year) {
                                echo 'selected';
                            }
                            ?> value="<?= $year ?>"><?= $year; ?></option>
                                <?php
                            }
                            ?>
                    </select>
                    <!-- Button de confirmation -->
                    <input type="submit" class="btn btn-secondary btn-sm"/>
                </form>
            </div>
            <?php
            // verification si le mois e l'année ne sont pas vide
            if (isset($_POST['month']) && isset($_POST['years'])) {
                // 'cal_days_in_month' permet de retourner le nombres de jours dans un mois pour une années spécifique et un calendrier
                // post[month] et post[year] permet de récupérer les données envoyer depuis les selectes
                $calendar = cal_days_in_month(CAL_GREGORIAN, $_POST['month'], $_POST['years']);
                // tableau des jours de la semaine.
                $daysOfWeek = ['LUNDI', 'MARDI', 'MERCREDI', 'JEUDI', 'VENDREDI', 'SAMEDI', 'DIMANCHE'];
                // le premier jour du mois.
                $day1 = date('w', mktime(0, 0, 0, $_POST['month'], 1, $_POST['years']));
                // le dernier jour du mois.
                $day2 = date('w', mktime(0, 0, 0, $_POST['month'], $calendar, $_POST['years']));
                // différence des jours restant dans la dernière semaine.
                $differenceInWeek = 7 - $day2;
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <?php if (isset($_POST['month']) && isset($_POST['years'])) { ?>
                            <h2><?= $months[$_POST['month'] - 1] . ' ' . $_POST['years']; ?></h2>
                        <?php } ?>
                        <!-- Pour chaque value de l'array $dayweeks create une cologne -->
                        <thead class="thead-dark">
                            <?php foreach ($daysOfWeek as $weeks) { ?>
                            <th class="col-lg-1"><?= $weeks; ?></th>
                            <?php } ?>
                        </thead>
                        <?php
                        // modification du premier jour de la semaine
                        // dimanche est le premier jour par default avec date()
                        if ($day1 == 0) {
                            $day1 = 7;
                        }
                        $days = 1;
                        // cration des jours dans le tableaux
                        for ($i = 1; $i <= $calendar + ($day1 - 1); $i++) {
                            if ($i % 7 == 1) {
                                ?>
                                <tr> 
                                    <?php
                                }
                                if ($i >= $day1) {
                                    ?>
                                    <td><?php
                                        echo $days;
                                        $days++;
                                        ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td></td>
                                    <?php
                                }
                            }
                            // Calcul des derniers jours du mois si vide.
                            for ($a = 1; $a <= $differenceInWeek; $a++) {
                                if ($a < $calendar && $day2 != 0) {
                                    ?>
                                    <td></td>
                                    <?php
                                }
                            }
                        }
                        ?>
                </table>
            </div>
        </div>
    </body>
</html>
