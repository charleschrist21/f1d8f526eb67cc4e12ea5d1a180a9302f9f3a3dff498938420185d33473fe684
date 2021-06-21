<?php

function getChildren($parent) {
    $conn = mysqli_connect("localhost","root","","mydb");
    $s = mysqli_query($conn,"SELECT * FROM member where name = '$parent'");
    $aa=$s->fetch_assoc();
    $id=$aa['id'];
    
    
    $query = "SELECT * FROM member WHERE parent_id = $parent";
    $result = mysqli_query($conn,$query);
    $children = array();
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        $children[$i] = array();
        $children[$i]['name'] = $row['name'];
        $children[$i]['children'] = getChildren($row['id']);
    $i++;
    }
return $children;
}

json_encode(getChildren(1));
?>