# PHP CRUD #
PHP CRUD - Create, Read, Update and Delete

## Description ##
Complete CRUD (Create, Read, Update & Delete) for MySQL in PHP (using OOP)

## How To ##

### Database Configuration ###

Edit config file in path "src/config.php" and put your database access data.

```php
<?php
    const DB_HOST = 'YOUR_DB_HOST'; // Your Database Host
    const DB_USER = 'YOUR_DB_USERNAME'; // Your Database User Name
    const DB_PASS = 'YOUR_DB_PASSWORD'; // Your Database Password
    const DB_NAME = 'YOUR_DB_NAME'; // Your Database Name
    const DB_CHARSET = 'UTF-8'; // Your Database Charset
```

### Database Connection ###

Use the following code to connect with your database

```php
<?php
include('src/php_crud.php');

$db = new Database();
$db->connect();
```

### Database Create ###

Create your database

```php
<?php
$db->createDb('phpcrud');
```

### Import File ###

Import a SQL file in your database

```php
<?php
$sqlFile = file_get_contents('src/example.sql');
$db->import($sqlFile);
```

Example SQL Data imported

```mysql
-- Create syntax for TABLE 'users'
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role_id` int(11),
  `create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update` timestamp NOT NULL,
  `active` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO users VALUES (NULL,'Username 1','username1@email.com',SHA1('password'),'first','last',1,NULL,NULL, TRUE);
INSERT INTO users VALUES (NULL,'Username 2','username2@email.com',MD5('password'),'','',NULL,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 3','username3@email.com',SHA1('password'),'','',NULL,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 4','username4@email.com',MD5('password'),'','',NULL,NULL,NULL, TRUE);
INSERT INTO users VALUES (NULL,'Username 5','username5@email.com',SHA1('password'),'','',NULL,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 6','username6@email.com',MD5('password'),'','',NULL,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 7','username7@email.com',SHA1('password'),'','',NULL,NULL,NULL, TRUE);
INSERT INTO users VALUES (NULL,'Username 8','username8@email.com',MD5('password'),'','',NULL,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 9','username9@email.com',SHA1('password'),'','',NULL,NULL,NULL, FALSE);
```

### Create Table ###

Create a table in a Database

```php
<?php
$db->create('test');
```

### Truncate Table ###

Truncate a table in a Database

```php
<?php
$db->truncate('test');
```

### Drop Table ###

Drop a table in a Database

```php
<?php
$db->drop('test');
```

### All Tables ###

Show all tables in a Database

```php
<?php
$db->tables();
$response = $db->getResponse();
print_r($response);
```

### Full Table ###

Show full table from a Database

```php
<?php
$db->sql('SELECT * FROM users');
$response = $db->getResponse();
foreach($response as $row){
    echo $row["username"]."<br />";
    echo $row["email"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
    echo $row["role_id"]."<br />";
    echo $row["create"]."<br />";
    echo $row["update"]."<br />";
    echo $row["active"]."<br />";
}
```

### Delete ###

Delete a Row in a Table

Use the following schema:
[Table name], [WHERE]

```php
<?php
$db->delete('posts','id=5');
$response = $db->getResponse();
echo $response[0]==TRUE ? 'TRUE' : 'FALSE';
```

### Insert ###

Insert a Row in a Table

Use the following schema:
[Table name], [INSERT]

```php
<?php
$title = $db->escapeString("Title 5");
$content = $db->escapeString("Lorem Ipsum");
$db->insert('posts',array('id'=>5,'title'=>$title,'slug'=>'title-5','content'=>$content,'category'=>'Category 5','keywords'=>'keyword 1 keyword 2','image'=>'image','create'=>date("Y-m-d H:i:s"),'update'=>NULL,'active'=>TRUE));
$response = $db->getResponse();
echo $response[0]==TRUE ? 'TRUE' : 'FALSE';
```

### Update ###

Update a Row in a Table

Use the following schema:
[Table name], [UPDATE Values], [WHERE]

```php
<?php
$db->update('posts',array('active'=>FALSE),'id=5 AND active=TRUE');
$response = $db->getResponse();
echo $response[0]==TRUE ? 'TRUE' : 'FALSE';
```

### Select ###

Select Rows in a Table

Use the following schema:
[Table name], [Column Names], [JOIN], [WHERE], [LIKE], [ORDER BY]

#### JOIN EXAMPLE ####

```php
<?php
$db->select('users','users.id,users.username,users.first_name,users.last_name,users.role_id,users.active,roles.id','roles ON users.role_id = roles.id','users.active=TRUE',NULL,'users.id DESC');
$response = $db->getResponse();
foreach($response as $row){
    echo $row["id"]."<br />";
    echo $row["username"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
    echo $row["role_id"]."<br />";
    echo $row["active"]."<br />";
    echo "-----------------<br><br>";
}
```

#### WHERE Example ####

```php
<?php
$db->select('users','id,username,email,first_name,last_name',NULL,'username="Username 1"',NULL,NULL);
$response = $db->getResponse();
foreach($response as $row){
    echo $row["id"]."<br />";
    echo $row["username"]."<br />";
    echo $row["email"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
}
```

#### LIKE Example ####

```php
<?php
$db->select('users','id,username,email,first_name,last_name',NULL,'email','"%@myemail.com"',NULL);
$response = $db->getResponse();
foreach($response as $row){
    echo $row["id"]."<br />";
    echo $row["username"]."<br />";
    echo $row["email"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
}
```

#### ORDER BY Example ####

```php
<?php
$db->select('users','id,username,email,first_name,last_name,role_id',NULL,'role_id=4',NULL,'id ASC');
$response = $db->getResponse();
foreach($response as $row){
    echo $row["id"]."<br />";
    echo $row["username"]."<br />";
    echo $row["email"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
    echo $row["role_id"]."<br />";
}
```

#### More Examples ####

```php
<?php
$db->select('users','id,username,email,first_name,last_name',NULL,'email','"%@email.com"','id ASC');
$response = $db->getResponse();
foreach($response as $row){
    echo $row["id"]."<br />";
    echo $row["username"]."<br />";
    echo $row["email"]."<br />";
    echo $row["first_name"]."<br />";
    echo $row["last_name"]."<br />";
}
```

### Get Last ID ###

Get the last ID in a Table

```php
<?php
$db->sql('SELECT MAX(id) FROM users');
$response = $db->getResponse();
echo $response[0]["MAX(id)"];
```

### Count IDs ###

Count the number of IDs in a Table

```php
<?php
$db->sql('SELECT COUNT(id) FROM users');
$response = $db->getResponse();
echo $response[0]["COUNT(id)"];
```

Other Example

```php
<?php
$db->sql('SELECT COUNT(id) FROM users WHERE active=FALSE AND role_id=4');
$response = $db->getResponse();
echo $response[0]["COUNT(id)"];
```


## Contributing to PHP CRUD ##
If you have a patch, or stumbled upon an issue with PHP CRUD, you can contribute this back to the code

## Copyright and License ##
This is free software, licensed under the [MIT License (MIT)](https://opensource.org/licenses/MIT).

## Credits & Contact ##
@Author: [Isi Roca](http://isiroca.com)
@Support: [Issues & Support](https://github.com/IsiRoca/PHP-CRUD/issues)