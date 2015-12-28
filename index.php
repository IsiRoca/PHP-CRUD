<?php
/**
* PHP CRUD (Create Read Update Delete)
*
* PHP version 5.0
*
* @author     Isi Roca
* @category   PHP & Databases
* @copyright  Copyright (C) 2015 Isi Roca
* @link       http://isiroca.com
* @since      File available since Release 1.0.0
* @license    https://opensource.org/licenses/MIT  The MIT License (MIT)
* @see        https://github.com/IsiRoca/PHP-CRUD/issues
*
*/

// Include PHP CRUD
include('src/crud.php');

// Connect with your Database
$db = new Database();
$db->connect();


// Import External SQL File
echo "Import External SQL File";
echo "<br />------------------<br />";
$sqlFile = file_get_contents('src/example.sql');
$db->import($sqlFile);
$response = $db->getResponse();
echo $response[0]==TRUE ? 'TRUE' : 'FALSE';
echo "<br/><br/>";


$db->disconnect();
$db->connect();


// Get all Tables in your Database
echo "Get all Tables in your Database";
echo "<br />------------------<br />";
$db->tables();
$response = $db->getResponse();
for ($x=0;$x<count($response); $x++) {
    echo $response[$x]."<br/>";
}
echo "<br/><br/>";


// Get Full Table
echo "Get Full Table";
echo "<br />------------------<br />";
$db->sql('SELECT * FROM users');
$response = $db->getResponse();
foreach($response as $row){
    echo $row["username"]."<br />";
    echo $row["email"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
}
echo "<br/><br/>";


// Get Last ID
echo "Get Last ID";
echo "<br />------------------<br />";
$db->sql('SELECT MAX(id) FROM users');
$response = $db->getResponse();
echo $response[0]["MAX(id)"];
echo "<br/><br/>";


// Count IDs
echo "Count IDs";
echo "<br />------------------<br />";
$db->sql('SELECT COUNT(id) FROM posts');
$response = $db->getResponse();
echo $response[0]["COUNT(id)"];
echo "<br/><br/>";


// Select Row Table
echo "Select Row Table";
echo "<br />------------------<br />";
// [Table name], [Column Names], [JOIN], [WHERE], [LIKE], [ORDER BY]
$db->select('users','id,username,email,first_name,last_name',NULL,'username="Username 1"',NULL,NULL);
$response = $db->getResponse();
foreach($response as $row){
    echo $row["id"]."<br />";
    echo $row["username"]."<br />";
    echo $row["email"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
}
echo "<br/><br/>";


// Join Tables
echo "Join Tables";
echo "<br />------------------<br />";
// [Table name], [Column Names], [JOIN], [WHERE], [LIKE], [ORDER BY]
$db->select('users','users.id,users.username,users.first_name,users.last_name,users.role_id,users.active,roles.id','roles ON users.role_id = roles.id','users.active=TRUE',NULL,'users.id DESC');
$response = $db->getResponse();
foreach($response as $row){
    echo $row["id"]."<br />";
    echo $row["username"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
    echo $row["role_id"]."<br />";
    echo $row["active"]."<br />";
    echo "- - - - - <br><br>";
}
echo "<br/><br/>";


// Delete Rows
echo "Delete Rows";
echo "<br />------------------<br />";
// [Table name], [WHERE]
$db->delete('posts','id=5');
$response = $db->getResponse();
echo $response[0]==TRUE ? 'TRUE' : 'FALSE';
echo "<br/><br/>";


// Insert Rows
echo "Insert Rows";
echo "<br />------------------<br />";
$title = $db->escapeString("Title 5"); // Escape String
$content = $db->escapeString("Lorem Ipsum"); // Escape String
$db->insert('posts',array('id'=>5,'title'=>$title,'slug'=>'title-5','content'=>$content,'category'=>'Category 5','keywords'=>'keyword 1 keyword 2','image'=>'image','create'=>date("Y-m-d H:i:s"),'update'=>NULL,'active'=>TRUE));
$response = $db->getResponse();
echo $response[0]==TRUE ? 'TRUE' : 'FALSE';
echo "<br/><br/>";


// Update Rows
echo "Update Rows";
echo "<br />------------------<br />";
// [Table name], [UPDATE Values], [WHERE]
$db->update('posts',array('active'=>FALSE),'id=5 AND active=TRUE');
$response = $db->getResponse();
echo $response[0]==TRUE ? 'TRUE' : 'FALSE';
echo "<br/><br/>";
