# Bilmo

## Installation du projet 

```sh
    git clone git://github.com/MyrrdinAlsa/Bilmo.git
```

```sh
    composer install
```


## Modèle de Conceptuel de Données
<!-- [![](https://mermaid.ink/img/pako:eNqNUstSwzAM_BWPjkzboRxzYIbH8ANw9EXYamtI7CDLQOn037GTtilNB_DJWW3k3ZU2YIIlqMDUGOO9wyVjM32_UtqrfKxjMuKCV0-32veYqR15URrms9mFhun0WsNld1UpEvekloNNZse6nMw7njoQnxm93bfLD-_5mx4rJwo7v1QeGxpAoU9RlqJh1xZZQ2VRB5TcxpkjukWhh8BNrtwx5Q97I0PVZRdvCb04WffodvBYRBU7Y0XUoKsH9CXmdDjUFEfMNjf5CGx_MXXyYp_tXynswEXgs_iJwL2YVfBjLlqmGH9m8uXashQjrjnkdAyG5IXP59dN-Z9mRkPdwgQayrNzNq9n10WDrCj_C1W-WuRXDdoXHiYJj2tvoBJONIHUlsnvthmqBdaRtt933eVe?type=png)](https://mermaid.live/edit#pako:eNqNUstSwzAM_BWPjkzboRxzYIbH8ANw9EXYamtI7CDLQOn037GTtilNB_DJWW3k3ZU2YIIlqMDUGOO9wyVjM32_UtqrfKxjMuKCV0-32veYqR15URrms9mFhun0WsNld1UpEvekloNNZse6nMw7njoQnxm93bfLD-_5mx4rJwo7v1QeGxpAoU9RlqJh1xZZQ2VRB5TcxpkjukWhh8BNrtwx5Q97I0PVZRdvCb04WffodvBYRBU7Y0XUoKsH9CXmdDjUFEfMNjf5CGx_MXXyYp_tXynswEXgs_iJwL2YVfBjLlqmGH9m8uXashQjrjnkdAyG5IXP59dN-Z9mRkPdwgQayrNzNq9n10WDrCj_C1W-WuRXDdoXHiYJj2tvoBJONIHUlsnvthmqBdaRtt933eVe) -->
```mermaid
classDiagram-v2 
    direction TB

    client "1..*"-->"0..*" user
    product "1..0,1"--> "0..*" brand
    class product{
        string name
        text description
        float price
        dateFormat CreatedAt
        int quantity
    }

    class user{
        string email
        json roles
        string password
        string name
    }

    class client{
        string name
        string forname
        string email
        string phone
        string adress
        int zipcode
        string city
        string country
    }

    class brand{
        string name
        string description
    }
```