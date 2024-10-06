<?php
$servername = "localhost"; // server name
$username = "root"; // username
$password = "MySQLServer10!"; // password
$dbname = "forschool"; // database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname); // connection string

// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>"; // Display connection success message

function FetchAll($tableName)
{
     global $conn; // Declare $conn as a global variable

     // SQL query to select all records from a specific table
     $sql = "SELECT * FROM $tableName"; // Use the provided table name
     $result = $conn->query($sql); // Execute the query

     if ($result->num_rows > 0) {
          // Fetch all results into an associative array
          $data = $result->fetch_all(MYSQLI_ASSOC);

          // Display the results using print_r() inside <pre> tags for better formatting
          echo "<pre>";
          print_r($data);
          echo "</pre>";
     } else {
          echo "No results found.";
     }
}

// Call the function with the name of the table you want to fetch data from
//FetchAll('users');


//////////////////////

function Fetch($tableName, $id)
{
     global $conn; // Declare $conn as a global variable

     // SQL query to select a single record from a specific table
     $sql = "SELECT * FROM $tableName WHERE School_ID = " . intval($id);
     $result = $conn->query($sql); // Execute the query

     if ($result->num_rows > 0) {
          // Fetch a single row as an associative array
          $data = $result->fetch_assoc();

          // Display the result using print_r() inside <pre> tags for better formatting
          echo "<pre>";
          print_r($data);
          echo "</pre>";
     } else {
          echo "No results found for ID: $id.";
     }
}

// Call the function with the name of the table and the ID of the record you want to fetch
//Fetch('schools', 1);

///////////////////////

function InsertData($ID, $Name, $location, $Principal)
{
     global $conn; // Declare $conn as a global variable

     // Prepare the SQL query
     $sql = "INSERT INTO schools (School_ID, School_Name, Location, School_Principal) VALUES (?, ?, ?, ?)";

     // Prepare the statement
     $stmt = $conn->prepare($sql);

     if ($stmt === false) {
          die("Prepare failed: " . $conn->error);
     }

     // Bind the parameters
     $stmt->bind_param('isss', $ID, $Name, $location, $Principal); // i: integer, s: string

     // Execute the statement
     if ($stmt->execute()) {
          echo "New school record created successfully<br>";
     } else {
          // Display error message if the query fails
          echo "Error: " . $stmt->error;
     }

     // Close the statement
     $stmt->close();
}


// Call the function with the data to be inserted
//InsertData(11, 'Emilio Aguinaldo College', 'Cavite, Dasma', 'Jexter Pogi');

///////////////////////////

function Update($userId, $newEmail)
{
     global $conn;

     // Prepare an SQL statement for updating a user's email by User_ID
     $sql = "UPDATE Users SET Email=? WHERE User_ID=?"; // Corrected SQL syntax

     // Initialize a statement
     $stmt = $conn->prepare($sql);

     if ($stmt === false) {
          die("Prepare failed: " . $conn->error);
     }

     // Bind parameters (s: string for newEmail, i: integer for userId)
     $stmt->bind_param("si", $newEmail, $userId);

     // Execute the statement
     if ($stmt->execute()) {
          // Check if any row was updated
          if ($stmt->affected_rows > 0) {
               echo "Record updated successfully"; // Success message
          } else {
               echo "No record found with User_ID: $userId"; // Message if no record was found
          }
     } else {
          // Display error message if the query fails
          echo "Error: " . $stmt->error;
     }

     // Close the statement
     $stmt->close();
}

// Call the function with the data to be update
//Update(1, 'updatedEmail@example.com');


///////////////


function DisplayTable($conn)
{
     // SQL query to select all users
     $sql = "SELECT User_ID, Name, Email, Role FROM Users";
     // Execute the query
     $result = $conn->query($sql);
     // Check if there are results
     if ($result->num_rows > 0) {
          // Start the HTML table
          echo "<table border='1'>
                 <tr>
                     <th>User ID</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Role</th>
                 </tr>";

          // Fetching results and rendering them in table rows
          while ($row = $result->fetch_assoc()) {
               echo "<tr>
                     <td>" . $row['User_ID'] . "</td>
                     <td>" . $row['Name'] . "</td>
                     <td>" . $row['Email'] . "</td>
                     <td>" . $row['Role'] . "</td>
                   </tr>";
          }

          // Close the table
          echo "</table>";
     } else {
          echo "No records found."; // Message if no users are present
     }
}

// Call the function to display users
//DisplayTable($conn);


// Close the connection after using it
$conn->close();
