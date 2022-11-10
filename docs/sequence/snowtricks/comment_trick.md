```mermaid 
sequenceDiagram
    User ->>+ Server: Add a comment request
    
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

    Server ->> Database: Save the comment
    Server -->> User: Success flash message
    Server -->>- User: Redirect to the comment
```
