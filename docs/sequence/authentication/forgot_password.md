```mermaid
sequenceDiagram
    User ->>+ Server: Forgot password request

    opt Is already logged in 
        Server -->> User: Redirect to the homepage
    end

    Server -->>- User: Display the forgot password form

    User -->>+ User: Fill datas
    User ->>- Server: Send datas

    Server ->>+ Server: Verify datas sent
    Server ->> Database: Verify datas sent

    opt The account doesn't exists
        Server -->> User: Returns a fake success message
    end

    Server -) Symfony Mailer: Send a mail containing a reset password link

    Server -->> User: Redirect to the login page
    Server -->>- User: Success flash message
```
