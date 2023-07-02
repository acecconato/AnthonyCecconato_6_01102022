# Snowtricks - Openclassrooms

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/cfef3bae6d71495ea654547ffcf7a6e8)](https://app.codacy.com/gh/acecconato/AnthonyCecconato_6_01102022/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)
![phpstan level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen.svg?style=flat)

## Installation

```
git clone https://github.com/acecconato/AnthonyCecconato_6_01102022.git && cd AnthonyCecconato_6_01102022 && cp .env .env.local
```
Open the .env.local file and set the content as you need. The default .env file uses MySQL and [Mail Dev](https://github.com/maildev/maildev).

Then install the dependencies: `composer install && npm install`

Create the database: `php bin/console d:d:c`

Execute migration to generate database schema: `php bin/console d:m:m`

Now, you can generate the dummy content with: `php bin/console doctrine:fixtures:load`

At this step, you can start the application with: `symfony serve && npm run dev`

**Demo account:**

- Email: demo@demo.fr
- Password: demo

## Documentation

### Use cases  

- [Snowtricks](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/usecase/snowtricks.png)
- [Authentication](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/usecase/authentication.png) 

### Class

- [Main](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/class/main.md)

### Sequences

**Authentication**
- [Login](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/authentication/login.md)
- [Register](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/authentication/register.md)
- [Validate account](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/authentication/validate_account.md)
- [Forgot password](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/authentication/forgot_password.md)
- [Reset password](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/authentication/reset_password.md)

**Snowtricks**

- [Add trick](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/snowtricks/add_trick.md)
- [Update trick](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/snowtricks/update_trick.md)
- [Delete trick](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/snowtricks/delete_trick.md)
- [Comment trick](https://github.com/acecconato/AnthonyCecconato_6_01102022/blob/main/docs/sequence/snowtricks/comment_trick.md)
