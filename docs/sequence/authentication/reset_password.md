```mermaid
sequenceDiagram
    User ->>+ User: Click on the reset password link
    User ->>- Server: Reset password request

    Server ->>+ Server: Check the token validity

    alt The token isn't valid
        Server -->> User: 401 Error 
    else
        Server -->>- User: Display the update password form
    end

    User ->>+ User: Fill datas
    User ->>- Server: Send datas

    Server ->>+ Server: Verify datas sent

    alt There are errors
        Server -->> User: Show errors
    else
        Server ->> Database: Update the account's password
    
        Server -->> User: Redirect to the login page
        Server -->>- User: Success flash message
    end
```
