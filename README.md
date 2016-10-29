# New Database search
The goal is to make the search more efficiency
There are many ways to make the search fast 

### Using indexs

- Using indexs will make the search more fast in the sql 
- The pictures shown how to index the table by the column name
 
![alt text](https://github.com/mohanad86/databasesearch/blob/master/img/indexs.jpg)

![alt text](https://github.com/mohanad86/databasesearch/blob/master/img/indexfulltext.jpg)

- There are commands can be excuted in the sql for this database for example

```sh
$ ALTER TABLE `product` ADD INDEX (`name`);
$ ALTER TABLE `product` ADD INDEX (`id`);
$ ALTER TABLE `product` ADD INDEX (`serial_number`);
$ ALTER TABLE `product` ADD INDEX (`production_date`);
```
### Using sql queries 
- Queries can be used to make the search faster by selecting the data for example
```sh 
$ $stmt = $db->prepare('SELECT * FROM product WHERE (serial_number LIKE ? OR name LIKE ?) ORDER BY production_date DESC LIMIT 10');
``` 

### Using errors checks 

```sh
$ if (!$stmt) die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
$ var_dump($products);
```

Modified by: Mohanad Aly 
