### Entities and Their Attributes:

1. User

-   Attributes:

        id (Primary Key): A unique identifier for each user.

        name: The name of the user.

        email: The email address of the user.

        password (hashed): A securely hashed version of the user's password.

        created_at: Timestamp indicating when the user account was created.

        updated_at: Timestamp indicating when the user account was last updated.

-   Relationships:

        Each user can have multiple shopping carts (one-to-many relationship).

2. Cart

-   Attributes:

          id (Primary Key): A unique identifier for each cart.

          user_id (Foreign Key): A reference to the user who owns the cart.

          is_active: A flag indicating whether the cart is active or not.

-   Relationships:

          Each cart belongs to one user (many-to-one relationship).

          Each cart can contain multiple cart items (one-to-many relationship).

3. CartItem

-   Attributes:

          id (Primary Key): A unique identifier for each cart item.

          cart_id (Foreign Key): A reference to the cart to which the item belongs.

          product_id (Foreign Key): A reference to the product associated with the cart item.

          quantity: The quantity of the product in the cart.

-   Relationships:

          Each cart item belongs to one cart (many-to-one relationship).

          Each cart item is associated with one product (many-to-one relationship).

4. Product

-   Attributes:

          id (Primary Key): A unique identifier for each product.

          name: The name of the product.

          description: A description of the product.

          price: The price of the product.

-   Relationships:

          Each product can be associated with multiple cart items (one-to-many relationship).

### ER Diagram:

```
+-------------------+           +-------------------+
|      users        |           |     products      |
+-------------------+           +-------------------+
| id (PK)           |           | id (PK)           |
| name              |           | title             |
| email             |           | description       |
| email_verified_at |           | image_url         |
| password          |           | price             |
| remember_token    |           +-------------------+
| created_at        |
| updated_at        |
+-------------------+

    |                             |            |
    | has many                    | has many   |
    |                             |            |
    v                             v            v

+-------------------+ has  many +-------------------+
|       carts       |---------->|    cart_items     |
+-------------------+           +-------------------+
| id (PK)           |           | id (PK)           |
| user_id (FK)      |           | cart_id (FK)      |
| is_active         |           | product_id (FK)   |
| created_at        |           | quantity          |
| updated_at        |           | created_at        |
|                   |           | updated_at        |
+-------------------+           +-------------------+


```
