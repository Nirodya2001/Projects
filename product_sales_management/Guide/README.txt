STEP 01 : Open XAMPP and START Apache and MySQL.

STEP 02 : Open your web browser and type "localhost/phpmyadmin" in search engine.

STEP 03 : Create New Database as "sales_management".

STEP 04 : Run the Below SQL query in SQL prompt.


-- Create customers table
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20)
);

-- Create products table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock_level INT NOT NULL
);

-- Create sales_orders table
CREATE TABLE sales_orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_date DATE NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);


STEP 05 : Open new tab on your browser and type "http://localhost/product_sales_management/login.html"

STEP 06 : After typing the above url , you will see the login page of the Product Sales Management System.
	Then enter "admin" as username and "1234" as password.

STEP 07 : After login with above credentials, you can see the main page of your system. 
