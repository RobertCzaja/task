# Database

To run this application first you must configure database connection which is located in ```config\db.php```. Used DBMS: MySQL.

Then you need to create there ```numbers``` table with following columns ```id (INT)```,```list (TEXT)``` and ```is_asc (TINYINT)```.

```sql
CREATE TABLE `numbers` (
  `id` int(11) NOT NULL,
  `list` text COLLATE utf8_polish_ci NOT NULL,
  `is_asc` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

ALTER TABLE `numbers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;
```

# Run application

To start server go to main project directory and execute Slim built in server:
```php -S localhost:8888```

# API Endpoints

``/add-numbers`` [POST]  

Allows to add numbers to database and checks if order of given numbers collection is in ascending order.  

##### Required JSON body payload structure
```js
{
    "numbers": [1,2,3,4,5]
}
```
Value of the numbers key must be array which contains only integers.
As a response will be returned following structure. On success (status code 200):
```js
{
    "isAscending": true
}
```
On structure error - eg. given in payload object doesn't contains ``numbers`` key (status code 400):
```js
{
    "errorMessage": "Missing key numbers"
}
```
------------------------
``/last-added`` [GET]

Returns last 10 ```numbers``` records which number collection, record id and ```isAscending``` order result. Eg. structure:

```js
[
    {
        "id": "1",
        "numbers": ["1","2","3"],
        "isAscending": true
    }
    ...
]
```
