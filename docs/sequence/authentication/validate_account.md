```mermaid
sequenceDiagram
    User -->>+ User: Click on the validate account link
    User ->>- Server: Validate account request

    Server ->>+ Server: Check the token validity

    opt The token isn't valid
        Server -->> User: 401 Error 
    end

    Server ->> Database: Validate the account

    Server -->> User: Redirect to the login page
    Server -->>- User: Success flash message
```
