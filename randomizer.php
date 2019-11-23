<?php
    # Secret Santa (Fort Wayne Group) 2019

    # Checks against custom couples to prevent boring picks
    function boring($array) {
        $c1 = "Nick Barrow"; $c2 = "Laney Nulph";
        $c3 = ""; $c4 = "";
        foreach ($array as $santa => $bitch)
            if (($santa == $c1 && $bitch == $c2) || ($santa == $c2 && $bitch == $c1) ||
                ($santa == $c3 && $bitch == $c4) || ($santa == $c4 && $bitch == $c3)) {
                    echo "Couple detected!\nReshuffling hat...\n";
                    return 1;
            }
        return 0;
    }

    include "db.php";
    # Create array for santas
    # Call it santas_original as it will be copied later for picking
    $santas_original = array();
    # Select array of participants
    $result = $conn->query("SELECT full_name FROM ss_fw");
    # Push each user onto array of santas
    while ($r = $result->fetch_assoc())
        array_push($santas_original, $r['full_name']);
    # Shuffle santas for good measure
    shuffle($santas_original);
        
    do {
        # Copy array of santas as it will be modified while picking
        $santas = $santas_original;
        # Make array for finished pairs
        $pairs = array();
        # Shift off the first person to pick so they can't pick themselves
        $picking = array_shift($santas);
        # Save this for later. The person who picked first is assigned last
        $first  = $picking;
        # Loop until everyone has picked
        while(count($santas)) {
            # Choose a person from 'hat' at random
            $chosen = array_rand($santas);
            # Picker is assigned their choice
            $pairs[$picking] = $santas[$chosen];
            # The person chosen will be next to pick
            $picking = $santas[$chosen];
            # Remove chosen person from 'hat'
            array_splice($santas, $chosen, 1);
        }
        # Last person to pick gets the first person
        $pairs[$picking] = $first;
    # Do until no boring picks
    } while (boring($pairs) > 0);

    # Once all pairs have been made and no boring pairs are found
    # Update users in db with their partner
    $conn->query("LOCK TABLES ss_fw WRITE");
    foreach ($pairs as $santa => $bitch) {
        if ($sql = $conn->prepare("UPDATE ss_fw SET secret_bitch=? WHERE full_name=?")) {
            $sql->bind_param("ss", $bitch, $santa);
            $sql->execute();
        } else {
            echo "Nice you definitely fucked up pretty bad this time";
        }
    }
    $conn->query("UNLOCK TABLES");

    echo "Everyone has taken their pick!\n"
    # Uncomment next line to see pairs once finished.
    # print_r($pairs);
 ?>