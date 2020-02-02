<?php
$servername = "localhost";
$username = "seakleang";
$password = "021044136";
$dbname = "Student_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check action
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'new':
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $phoneNumber = $_POST['phoneNumber'];
            $sql = "INSERT INTO Student_tb (first_name, last_name, phone_number) VALUE ('$firstName','$lastName','$phoneNumber');";
            $conn->query($sql);
        break;
        case 'update':
            $id = $_POST['id'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $phoneNumber = $_POST['phoneNumber'];
            $sql = "UPDATE Student_tb SET first_name='$firstName',last_name='$lastName',phone_number='$phoneNumber' WHERE id=$id;";
            $conn->query($sql);
        break;
        case 'delete':
            $id = $_POST['id'];
            $sql = "DELETE FROM Student_tb WHERE id=$id;";
            $conn->query($sql);
        break;
    }
}
header("localtion:#");

$sql = "SELECT * FROM Student_tb";
$result = $conn->query($sql);
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
    <title>Home</title>
</head>

<body>

    <table class="table text-center">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modalViewUser' value='new' onclick="checkAction('new')">Add New</button>
                </th>
            </tr>
        </thead>
        <tbody>

            <?php
            if ($result->num_rows > 0) {
                $rows = array();
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    array_push($rows, $row);
                    $id = $row["id"];
                    $firstName = $row["first_name"];
                    $lastName = $row["last_name"];
                    $phoneNumber = $row["phone_number"];
                    echo "<tr><th scope='row'>$id</th>";
                    echo "<td>$firstName</td>";
                    echo "<td>$lastName</td>";
                    echo "<td>$phoneNumber</td>";
                    echo "<td><button type='button' class='btn btn-info' data-toggle='modal' data-target='#modalViewUser' value='update' onclick='checkAction(\"update\",$id)'>View</button>
                <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modalDeleteUser' value='delete' onclick='checkAction(\"delete\",$id)'>Delete</button></td></tr>";
                }
            }
            ?>

        </tbody>
    </table>

    <!-- Modal Delete User -->
    <div class="modal fade" id="modalDeleteUser" tabindex="-1" role="dialog" aria-labelledby="modalDeleteUser" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteUser">Detele User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form id="formDelete" action="" method="post">
                        <button type="sumbit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View User -->
    <div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-labelledby="modalViewUser" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewUser">User Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formUpdate" action="" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" placeholder="Enter first name" name="firstName" id="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" placeholder="Enter last name" name="lastName" id="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="text" class="form-control" placeholder="Enter phone number" name="phoneNumber" id="phoneNumber" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnUpdate">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function checkAction(action, id) {
            console.log("Action: " + action);
            var form;
            var actionInput = "";
            var idInput = "";
            if (document.getElementById('action') == null) {
                actionInput = "<input type='hidden' id='action' name='action' value='" + action + "'></input>";
            } else {
                document.getElementById('action').setAttribute('value',action);
            }
            if (document.getElementById('studentID') == null) {
                idInput = "<input type='hidden' id='studentID' name='id' value='" + id + "'></input>";
            } else {
                document.getElementById('studentID').setAttribute('value',id);
            }
            switch (action) {
                case "new":
                    document.getElementById('btnUpdate').innerHTML = "Add New";
                    form = document.getElementById('formUpdate');
                    document.getElementById('firstName').setAttribute('value', '');
                    document.getElementById('lastName').setAttribute('value', '');
                    document.getElementById('phoneNumber').setAttribute('value', '');
                    break;
                case "update":
                    document.getElementById('btnUpdate').innerHTML = "Save changes";
                    form = document.getElementById('formUpdate');
                    form.innerHTML = form.innerHTML + idInput

                    var rows = JSON.parse('<?php echo json_encode($rows); ?>');
                    rows = Array.from(rows);
                    var i = 0;
                    while (rows[i]) {
                        if (rows[i]['id'] == id) {
                            document.getElementById('firstName').setAttribute('value', rows[i]['first_name']);
                            document.getElementById('lastName').setAttribute('value', rows[i]['last_name']);
                            document.getElementById('phoneNumber').setAttribute('value', rows[i]['phone_number']);
                            break;
                        }
                        i++;
                    }
                    break;
                case "delete":
                    form = document.getElementById('formDelete');
                    form.innerHTML = form.innerHTML + idInput;
                    break
            }
            form.innerHTML = form.innerHTML + actionInput;
        }
    </script>

</body>

</html>