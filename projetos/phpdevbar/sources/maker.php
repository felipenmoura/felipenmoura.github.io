<?php
    $db= new SQLite3('php_manual_en.sqlite');

    $sql = "select * from sqlite_master";
    $sql= "SELECT *
             FROM functions
            WHERE functions.name='file'";
    /*$sql = "select * from functions
        left join params
          on functions.name=params.function_name
        left join notes
         on functions.name=notes.function_name
    /*    left join seealso
         on functions.name=seealso.function_name * /
    where functions.name= 'explode'"; */

    $result = $db->query($sql);//->fetchArray(SQLITE3_ASSOC);

    $row = array();

    $i = 0;
    echo "<pre>";
    while($res = $result->fetchArray(SQLITE3_ASSOC))
    {
         print_r($res);
         /*
          if(!isset($res['user_id'])) continue;

          $row[$i]['user_id'] = $res['user_id'];
          $row[$i]['username'] = $res['username'];
          $row[$i]['opt_status'] = $res['opt_status'];

          $i++; 
        */
      }