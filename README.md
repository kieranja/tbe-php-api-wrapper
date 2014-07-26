Taleo Business Edition (TBE) PHP API Wrapper
===================

The TBE PHP API wrapper allows you to retrieve data from Taleo.

## Requirements

You should have PHP 5.4+ and cURL 7.19+.

<small>**Note**: I have not tested this using older versions, but it may still work.</small>

## Installation

Upload `Api.php` and `Error.php` into a directory of your choice and then require `Api.php` on the page you wish to use the API wrapper.

```
require_once 'taleo/Api.php';
```

## Configuration

You will need the following information from Taleo:

1. **Company code**&mdash; The company code is provided by Taleo when signing up.
2. **Username**&mdash; The username of the user that will be connecting via the API. This user must be created within the Taleo Business Edition GUI and must have administrative privileges.
3. **Password**&mdash; The password of the user above.
4. **Service URL**&mdash; The service URL can be found in the API documentation, but is, at the time of this writing, `https://tbe.taleo.net/MANAGER/dispatcher/api/v1/serviceUrl/`

### Easy Method

To pass in your parameters during instantiation:

```
$Taleo = new RyanSechrest\Taleo\Api(
	'COMPANYCODE',
	'username',
	'password',
	'https://tbe.taleo.net/MANAGER/dispatcher/api/v1/serviceUrl'
);
```

### Alternate Method

To set your parameters individually:

```
$Taleo = new Taleo\Api();
$Taleo->set_company_code('COMPANY');
$Taleo->set_username('username');
$Taleo->set_password('password');
$Taleo->set_service_url('https://tbe.taleo.net/MANAGER/dispatcher/api/v1/serviceUrl');
```

## Authentication

### Easy Method

To login to Taleo:

```
$Taleo->login();
```

To logout of Taleo:

```
$Taleo->logout();
```

<small>**Important**: You should always logout, because you only get 20 authentication tokens. If you login 20 times without logging out, all subsequent logins will fail. It takes 4 hours for an authentication token to expire, which means you could be locked out for up to 4 hours.</small>

### Advanced Method

If you need to make multiple requests, but are unable to pass the object around, you can extract an existing authentication token, save it, and then manually set it again.

To get your authentication token:

```
$auth_token = $Taleo->get_auth_token();
```

To set your authentication token:

```
$Taleo->set_auth_token($auth_token);
```

You can also fetch a new authentication token or release an old one:

```
$auth_token = $Taleo->fetch_auth_token();
$Taleo->release_auth_token($auth_token);
```

## End Point

This is automatically obtained and managed for you, but if you need to get or set your end point manually, you can do so:

```
$host_url = $Taleo->get_host_url();
$Taleo->set_host_url($host_url);
```

<small>**Note**: By temporarily storing your end point, you can save one additional request, but keep in mind that, while unlikely, the end point could change any time.</small>

## Debugging

If you want to see what is being returned, you can pass a variable through the `debug` method, which will print out its contents:

```
$Taleo->debug($some_var);
```

## Error Handling

If there are errors in a response, you can retrieve them:

```
$errors = $Taleo->get_errors();
```

You will receive an array of `Error` objects:

```
Array
(
    [0] => RyanSechrest\Taleo\Error Object
        (
            [code:RyanSechrest\Taleo\Error:private] => 404
            [detail:RyanSechrest\Taleo\Error:private] => Requested requisition : 1 is not available
            [message:RyanSechrest\Taleo\Error:private] => Requested requisition : 1 is not available
            [request:RyanSechrest\Taleo\Error:private] => Array
                (
                    [path] => object/requisition/1
                    [host] => https://ch.tbe.taleo.net/CH00/ats/api/v1/
                    [url] => https://ch.tbe.taleo.net/CH00/ats/api/v1/object/requisition/1
                    [cookie] => Array
                        (
                            [authToken] => webapi00000000000000000000
                        )

                    [http_header] => Array
                        (
                            [Content-Type] => application/json
                        )

                    [return_transfer] => 1
                )

            [type:RyanSechrest\Taleo\Error:private] => internal
        )

)
```

The following methods can be used to retrieve the corresponding `Error` values:

```
foreach($errors as $Error) {
    echo $Error->get_code();
    echo $Error->get_detail();
    echo $Error->get_message();
    echo $Error->get_request();
    echo $Error->get_type();
}
```

Whenever a method returns `false`, you can check this array to see why it failed.

## Examples

Below are examples of calls and a skeleton of each of their returns, but know that every method is documented using PHPDoc within the corresponding class, where you can learn about all the parameters, whether they are optional or required, what each method returns, etc.

### 1. Get entities

Gives you an array of all the entities in Taleo, including their meta data and properties.

#### Request

```
$result = $Taleo->get_entities();
```

#### Result

```
Array
(
    [0] => stdClass Object
        (
            [field] => value
        )
    [1] => stdClass Object
        (
            [field] => value
        )
)
```

### 2. Get entity

Gives you the meta data and properties of an entity.

#### Request

```
$result = $Taleo->get_entity('requisition');
```

#### Result

```
stdClass Object
(
    [field] => value
)
```

### 3. Get entity code

Gives you the entity code from an entity, e.g., if you provided it with 'requisition', it might return 'REQU'.

#### Request

```
$result = $Taleo->get_entity_code('requisition');
```

#### Result

```
REQU
```

### 4. Get entity custom fields

Gives you an array of custom fields of an entity.

#### Request

```
$result = $Taleo->get_entity_custom_fields('requisition');
```

#### Result

```
Array
(
    [0] => stdClass Object
        (
            [field] => value
        )
    [1] => stdClass Object
        (
            [field] => value
        )
)
```

### 5. Get entity field

Gives you meta data and properties of a specific field of an entity.

#### Request

```
$result = $Taleo->get_entity_field('requisition', 'numOpen');
```

#### Result

```
stdClass Object
(
    [field] => value
)
```

### 6. Get entity field values

Gives you all possible values for a picklist field, for example.

#### Request

```
$result = $Taleo->get_entity_field_values('requisition', 'department');
```

#### Result

```
Array
(
    [0] => stdClass Object
        (
            [field] => value
        )
    [1] => stdClass Object
        (
            [field] => value
        )
)
```

### 7. Get entity fields

Gives you both standard and custom fields of an entity.

#### Request

```
$result = $Taleo->get_entity_fields('requisition');
```

#### Result

```
Array
(
    [0] => stdClass Object
        (
            [field] => value
        )
    [1] => stdClass Object
        (
            [field] => value
        )
)
```

### 8. Get entity label

Gives you the entity label from an entity, e.g., if you provided it with 'requisition', it might return 'REQU'.

#### Request

```
$result = $Taleo->get_entity_label('requisition');
```

#### Result

```
REQU
```

### 9. Get entity standard fields

Gives you an array of built-in fields of an entity.

#### Request

```
$result = $Taleo->get_entity_standard_fields('requisition');
```

#### Result

```
Array
(
    [0] => stdClass Object
        (
            [field] => value
        )
    [1] => stdClass Object
        (
            [field] => value
        )
)
```

### 10. Get record

Gives you the data of a specific record.

#### Request

```
$result = $Taleo->get_record('requisition', 123);
```

#### Result

```
stdClass Object
(
    [field] => value
)
```

### 11. Get records

Gives you either all records (up to the limit) or lets you search and filter for specific records.

#### Request

Get all requisitions from a specific career website.

```
$query = array(
	'cws' => 1
);

$result = $Taleo->get_records('requisition', $query);
```

#### Result

```
stdClass Object
(
    [pagination] => stdClass Object
        (
            [total] => 123
            [self] => https://ch.tbe.taleo.net/CH0/ats/api/v1/object/requisition/search?searchId=12345&start=1&limit=200&digicode=ABCDEFGHIJKLMNOPQRSTUVWXYZ
        )

    [searchResults] => Array
        (
            [0] => stdClass Object
                (
                    [requisition] => stdClass Object
                        (
                            [field] => value
                        )
                )
        )
)
```

### 12. Get related record

When retrieving requisitions, for example, there may be users attached to that requisition. Those are specific, related records that can be retrieved with this method.

#### Request

```
$result = $Taleo->get_related_record('requisition', 123, 'candidate');
```

#### Result

```
Array
(
    [0] => stdClass Object
        (
            [candidate] => stdClass Object
                (
                    [field] => value
                )
        )
)
```

### 13. Get related records

When retrieving requisitions, for example, there may be users, candidates, career websites, etc, attached to that requisition. All related records can be retrieved with this method or you can provide an array of related entitites whose records to retrieve.

#### Request

```
$related_entity_names = array(
	'candidate',
	'user'
);

$result = $Taleo->get_related_records('requisition', 123, $related_entity_names);
```

#### Result

```
Array
(
    [candidate] => Array
        (
            [0] => stdClass Object
                (
                    [candidate] => stdClass Object
                        (
                            [field] => value
                        )
                )
        )
     [user] => Array
        (
            [0] => stdClass Object
                (
                    [user] => stdClass Object
                        (
                            [field] => value
                        )
                )
        )
)
```

## Custom Requests

In some cases, you may need to perform custom requests. You can do so by calling the `make_request` method. It accepts an array with the following keys:

* **url**&mdash; Complete URL to make request, i.e., `http://host/some/path`
* **host**&mdash; Host URL to use for making request, i.e., `http://host/`
* **path**&mdash; Specific path to append to host URL, i.e., `some/path`
* **query**&mdash; Array of query variables in form of `name => value`
* **cookie**&mdash; Array of cookies to set in form of `name => value`
* **http_header**&mdash; Array of headers to set in form of `name => value`
* **method**&mdash; Request method to use, i.e., `POST`, `GET`, `DELETE` etc.

All fields are optional, meaning that if omitted, the API wrapper will try and use a sensible default.

#### Request

```
$request = array(
	'path' => 'object/requisition/search',
	'host' => 'https://ch.tbe.taleo.net/CH0/ats/api/v1/',
	'query' => array(
		'cws' => 1
	)
);

$result = $Taleo->make_request($request);
```

#### Result

```
stdClass Object
(
    [response] => stdClass Object
        (
            [pagination] => stdClass Object
                (
                    [total] => 123
                    [self] => https://ch.tbe.taleo.net/CH0/ats/api/v1/object/requisition/search?searchId=12345&start=1&limit=200&digicode=ABCDEFGHIJKLMNOPQRSTUVWXYZ
                )

            [searchResults] => Array
                (
                    [0] => stdClass Object
                        (
                            [requisition] => stdClass Object
                                (
                                    [field] => value
                                )
                        )
                )
        )
    [status] => stdClass Object
        (
            [detail] => stdClass Object
                (
                )

            [success] => 1
        )
)
```