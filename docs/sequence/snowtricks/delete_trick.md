```mermaid 
sequenceDiagram
    User ->>+ Server: Delete a trick request
    
    alt Is not logged in 
        Server -->> User: Redirect to the login page
    else
        Server ->>+ Database: Delete the trick
        Server -->>- User: Success message
    end
```
