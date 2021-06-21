<?php

    function getTree($name = 'root')
    {
        $conn = mysqli_connect("localhost","root","","mydb");
        $s = mysqli_query($conn,"SELECT * FROM member where name = '$name'");
        
        $r = mysqli_query($conn,"SELECT * FROM member");
        $aa=$s->fetch_assoc();

        $id=$aa['id'];

        function buildtree($src_arr, $parent_id, $tree = array())
            {
                foreach($src_arr as $idx => $row)
                {
                    if($row['parent_id'] == $parent_id)
                    {
                        foreach($row as $k => $v)
                            $tree[$row['id']][$k] = $v;
                        unset($src_arr[$idx]);
                        $tree[$row['id']]['children'] = buildtree($src_arr, $row['id']);
                    }
                }
                ksort($tree);
            return $tree;
        }
        
        $data = array();
        while($row = mysqli_fetch_assoc($r)) {
            $data[] = $row;
        }
        $row = array($data);
        $tree = buildtree($data,$id);
        
        return $tree;
    }
    $tree = getTree();
    echo json_encode($tree);
    

?>