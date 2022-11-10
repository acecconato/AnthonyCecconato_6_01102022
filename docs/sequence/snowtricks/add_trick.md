```mermaid 
sequenceDiagram
    User ->>+Server: Add a trick request
    
    opt Is not logged in 
        Server -->> User: Redirect to the login page
    end
    
    Server -->>-User: Display the form

    User ->>+ User: Fill datas
    User ->>-Server: Send datas

    Server ->>+ Server: Verify datas sent

    opt There are errors
        Server -->> User: Show errors
    end

    Server ->> Database: Save the new trick
    Server -->> User: Success flash message
    Server -->>- User: Redirect to the trick
```
