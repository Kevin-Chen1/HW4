<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <h1>Courses</h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Prefix</th>
      <th>Number</th>
      <th>Description</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
$servername = "localhost";
$username = "kevinche_User1";
$password = "I<3oklahoma";
$dbname = "kevinche_HW3DB";
    
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  switch ($_POST['saveType']) {
    case 'Add':
      $sqlAdd = "insert into course (prefix, number, description) value (?,?,?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("cici", $_POST['cpf'], $_POST['cnb'], $_POST['cdscr']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New course.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update course set prefix=?, number=?, description=?, where course_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("cicii", $_POST['cpf'], $_POST['cnb'], $_POST['cdscr'], $_POST['cid']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">Course edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from course where course_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("i", $_POST['cid']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">Course deleted.</div>';
      break;
  }
}
?>         
<?php
$sql = "SELECT course_id, prefix, number, description FROM course";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
          
          <tr>
            <td><?=$row["course_id"]?></td>
            <td><?=$row["prefix"]?></td>
            <td><?=$row["number"]?></td>
            <td><?=$row["description"]?></td>
            <td>
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editCourse<?=$row["course_id"]?>">
                Edit
              </button>
              <div class="modal fade" id="editCourse<?=$row["course_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCourse<?=$row["course_id"]?>Label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="editCourse<?=$row["course_id"]?>Label">Edit course</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="">
                        <div class="mb-3">
                          <label for="editCourse<?=$row["course_id"]?>Name" class="form-label">Course Name</label>
                          <input type="text" class="form-control" id="editCourse<?=$row["course_id"]?>Name" aria-describedby="editCourse<?=$row["course_id"]?>Help" name="cpf" value="<?=$row['prefix']?>">
                          <div id="editCourse<?=$row["course_id"]?>Help" class="form-text">Enter the Course's name.</div>
                          <label for="number" class="form-label">number</label>
                          <input type="text" class="form-control" id="pid" aria-describedby="courseHelp" name="cnb" value="<?=$row['number']?>">
                          <div id="nameHelp" class="form-text">Enter the number</div>
                          <label for="description" class="form-label">description</label>
                          <input type="text" class="form-control" id="did" aria-describedby="courseHelp" name="cdscr" value="<?=$row['description']?>">
                          <div id="nameHelp" class="form-text">Enter the description</div>
                        </div>
                        <input type="hidden" name="cid" value="<?=$row['course_id']?>">
                        <input type="hidden" name="saveType" value="Edit">
                        <input type="submit" class="btn btn-primary" value="Submit">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <form method="post" action="">
                <input type="hidden" name="cid" value="<?=$row["course_id"]?>" />
                <input type="hidden" name="saveType" value="Delete">
                <input type="submit" class="btn" onclick="return confirm('Are you sure?')" value="Delete">
              </form>
            </td>
          </tr>
          
<?php
  }
} else {
  echo "0 results";
}
$conn->close();
?>
          
        </tbody>
      </table>
      <br />
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourse">
        Add New
      </button>

      <!-- Modal -->
      <div class="modal fade" id="addCourse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCourseLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addCourseLabel">Add Course</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="prefix" class="form-label">prefix</label>
                  <input type="text" class="form-control" id="cpf" aria-describedby="courseHelp" name="cpf">
                  <div id="courseHelp" class="form-text">Enter the Course's name.</div>
                   <label for="number" class="form-label">number</label>
                   <input type="text" class="form-control" id="pid" aria-describedby="nameHelp" name="cnb">
                   <div id="nameHelp" class="form-text">Enter the course number</div>
                          <label for="description" class="form-label">description</label>
                          <input type="text" class="form-control" id="cdscr" aria-describedby="courseHelp" name="cdscr">
                          <div id="nameHelp" class="form-text">Enter the description</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
