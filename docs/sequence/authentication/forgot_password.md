```mermaid
sequenceDiagram
    User ->>+ Server: Forgot password request

    alt Is logged in 
        Server -->> User: Redirect to the homepage
    else Is not logged in
        Server -->>- User: Display the forgot password form
    end

    User -->>+ User: Fill datas
    User ->>- Server: Send datas

    Server ->>+ Server: Verify datas sent
    Server ->> Database: Verify datas sent

    opt The account is found
        Server -) Symfony Mailer: Send a mail containing a reset password link
    end

    Server -->> User: Redirect to the login page
    Server -->>- User: Success flash message
```
