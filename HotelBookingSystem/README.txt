STEP 01 : Open XAMPP and START Apache and MySQL.

STEP 02 : Open your web browser and type "localhost/phpmyadmin" in search engine.

STEP 03 : Create New Database as "hotel_booking".

STEP 04 : Run the Below SQL query in SQL prompt.


-- Rooms Table
CREATE TABLE Rooms (
    RoomID INT AUTO_INCREMENT PRIMARY KEY,
    RoomNumber VARCHAR(10) NOT NULL,
    RoomType VARCHAR(50) NOT NULL,
    PricePerNight DECIMAL(10, 2) NOT NULL
);

-- Guests Table
CREATE TABLE Guests (
    GuestID INT AUTO_INCREMENT PRIMARY KEY,
    GuestName VARCHAR(100) NOT NULL,
    ContactInfo VARCHAR(100),
    Email VARCHAR(100) NOT NULL
);

-- Bookings Table
CREATE TABLE Bookings (
    BookingID INT AUTO_INCREMENT PRIMARY KEY,
    GuestID INT,
    RoomID INT,
    CheckInDate DATE,
    CheckOutDate DATE,
    FOREIGN KEY (GuestID) REFERENCES Guests(GuestID),
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID)
);

-- Users Table
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL -- Password will be hashed for security
);

INSERT INTO Users (Username, Password) VALUES ('admin', '$2y$10$xlXkiAU65QLW5FiwSu9U8uP7sqN8ba7YwQ7N6zVBMGMZCdiPo9c76');



STEP 05 : Open new tab on your browser and type "http://localhost/HotelBookingSystem/login.php"

STEP 06 : After typing the above url , you will see the login page of the Hotel Booking System.
	Then enter "admin" as username and "1234" as password.

STEP 07 : After login with above credentials, you can see the main page of your system. 
