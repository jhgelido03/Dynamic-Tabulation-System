<?php

function select($conn){


    $sql = "SELECT * FROM candidates";

    $select = mysqli_query($conn,$sql);

    while ($row = mysqli_fetch_object($select)){
        echo "  
        <option value='".$row->candidate_name."'>".$row->candidate_name."</option>
    ";

      
    }

}