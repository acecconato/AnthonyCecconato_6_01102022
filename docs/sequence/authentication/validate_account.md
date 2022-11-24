```mermaid
sequenceDiagram
    User ->>+ User: Click on the validate account link
    User ->>- Server: Validate account request

    Server ->>+ Server: Check the token validity

    alt The token isn't valid
        Server -->> User: 401 Error 
    else
        Server ->> Database: Validate the account
    
        Server -->> User: Redirect to the login page
        Server -->>- User: Success flash message
    end
```
