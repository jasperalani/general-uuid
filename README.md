### GeneralUUID

###### Local UUID API Allocation System

Send a post request with requirements to the API and in response receive a generated UUID.
You can choose to save the generated UUID to a database for future reference.

This is meant to be used as a local UUID allocation system for your projects.

Receivable post body JSON format:
```
{
	"type": String,
	"length": Integer, (max 255)
	"save": Boolean
}
```
