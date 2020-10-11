# API Structure

[API Files](routes/api.php)

## Model

### `api/v1/models` (GET)
### `api/v1/models/{id?}` (GET)
### `api/v1/models/{id}` (POST)
### `api/v1/models/{id}` (DELETE)

| URL                    | Function             |
| ---------------------- | -------------------- |
| `api/v1/models`     | read |
| `api/v1/models/{id?}`     | read singly |
| `api/v1/models/{id}`     | create/update |
| `api/v1/models/{id}`     | delete |

#### Required role

`create_model` | `view_model` | `update_model` | `delete_model`.

#### Input Description

Look through the [controllers](app/Http/Controllers) for some pointers

#### Output Description

##### successful

```json
{
	"success": 1,
	"message": "",
	"model": {}
}
```

##### failed

```json
{
  "success": 0,
	"message": "something went wrong...try again"
}
```
