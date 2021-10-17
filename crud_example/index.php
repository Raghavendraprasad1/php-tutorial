<?php
session_start(); // to show the error and success message
include('db_config.php');
?>
<!DOCTYPE html>
<html>
<head style="margin-top: 20px;">
    <meta charset="utf-8">
    <title>CRUD example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- datatable plugin -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- font-awesome plugin  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
    // code to fetch data from table and list it to datatable 
    $sql = "SELECT * FROM customer";
    $result = $conn->query($sql);
    ?>
    <div class="row">
        <div class="col-sm-12 mt-1" style="background-color: grey; height: 50px;">
            <h3 style="margin-top: 6px; margin-left: 35%;">Manage Customer Records</h3>
            <a title='Add Customer' style="float: right; width:10%;" href='./add.php?action=add' class='btn btn-primary mt-2'>Add Customer</a>
        </div>
        <!-- code to show error message -->
        <?php if (!empty($_SESSION['error'])) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Warning!</strong>
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['error']);
        } ?>

        <!-- code to show success message  -->
        <?php if (!empty($_SESSION['success'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong>
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['success']);
        } ?>
        <div class="col-sm-12 mt-5">
            <table id="example" class="display" style="width:98%; padding-top: 5px;">
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Action</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Image </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $i=1;
                        while ($row = $result->fetch_assoc()) {

                            $action = "";
                            
                            $action .= "<a  title='Edit Customer' href='./add.php?action=edit&id=" . base64_encode($row['id']) . "' class='btn btn-warning '  >Edit</a> ";

                            if ($row['status'] == 1) {
                                $action .= "<a  title='Click to Deactivate' href='./statusChange.php?v=0&id=" . base64_encode($row['id']) . "' class='btn btn-success '  ><i class='fa fa-lightbulb-o' aria-hidden='true'></i></a> ";
                            } else if ($row['status'] == 0) {
                                $action .= "<a  title='Click to Activate' href='./statusChange.php?v=1&id=" . base64_encode($row['id']) . "' class='btn btn-secondary '  ><i class='fa fa-lightbulb-o' aria-hidden='true'    ></i></a> ";
                            }
                            $action .= " <a data-id='" . $row['id'] . "' title='Delete Customer' href='#' class='btn btn-danger delete-custom' >Delete</a>";

                            $image= '<img width="100px" src="./images/'. $row['image'] .'" alt="">';

                            echo "<tr>
                            <td>" . $i++ . "</td>
                            <td>" . $action . "</td>
                            
                            <td>" . $row['firstname'] . "</td>
                            <td>" . $row['lastname'] . "</td>
                            <td>" . $row['phone'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $image . "</td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>


<script>
        $(document).ready(function() {
            $('#example').DataTable();
        });

        $(document).on("click", ".delete-custom", function() {
            var id = $(this).data('id');
            var result = confirm("are you sure? You want to delete customer");

            if (result) {
                window.location.href = "customer_delete.php?id=" + id;
            }
        });
    </script>