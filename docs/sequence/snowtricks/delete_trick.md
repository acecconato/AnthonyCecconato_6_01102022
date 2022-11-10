```mermaid 
sequenceDiagram
    User ->>+Server: Delete a trick request
    
    opt Is not logged in 
        Server -->> User: Redirect to the login page
    end
    
    opt Is not the owner or an admin
        Server -->> User: 403 error
    end
    
    Server ->>+ Database: Delete the trick
    Server -->>- User: Success message
```
