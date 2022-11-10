```mermaid 
sequenceDiagram
    User ->>+ Server: Update a user request
    
    opt Is not logged in 
        Server -->> User: Redirect to the login page
    end

    opt Is not an admin
        Server -->> User: 403 error
    end
    
    Server ->>+ Database: Update the selected user

    Server -->>- User: Success flash message
```
