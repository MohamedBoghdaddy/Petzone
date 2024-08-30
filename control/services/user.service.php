<?php
  require_once("superController.php");
  require_once("../../model/user.model.php");
  include_once "patient.service.php";
  include_once "appointment.service.php";

  ?>
<?php
class UsersController extends SuperController{ //singleton
  private static $instance;
  private function __construct()
  {
    $this->db = $this->connect();
  }
  public static function getInstance()
  {
      if (self::$instance === null) {
          self::$instance = new self();
      }
      return self::$instance;
  }

  ///////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

	public function addNewUser($user) 
  {  
    $sql="insert into users(firstname,lastname,Username,Email,password,accountType) 
        values('$user->firstname','$user->lastname','$user->Username',
                '$user->Email','$user->password','$user->accountType')";

    $result=$this->db->query($sql);    
    if($result)
    {
      if(isset($_SESSION['ID']))
      {
        header("location:../pages/userManagement.php");
      }
      else
      {
        header("location:../forms/login.php");
      }
    }
    else
    {
      echo "Error: " . mysqli_error($conn);
    }
	}

  public function login($user) 
  {
      //select data from database where Email and password match.
      $sql = "select * from users where Username='$user->Username' and password='$user->password'";
      //executes the sql query and sends the query to the database server and returns a result set object with the matching rows.
      //$db = $this->connect();
      $result = $this->db->query($sql);
      //checking if the login credentials match using the session variables.
      if($row=mysqli_fetch_array($result)){
          $_SESSION['ID'] = $row['ID'];
          $_SESSION['firstname'] = $row['firstname'];
          $_SESSION['lastname'] = $row['lastname'];
          $_SESSION['Username']=$row['Username'];
          $_SESSION['Email'] = $row['Email'];
          $_SESSION['password'] = $row['password'];
          $_SESSION['accountType'] = $row['accountType'];
          header("location:../pages/home.php");
      }
      else
      {
        echo '<script>alert("Invalid Credentials")</script>'; 
        echo "Error: ";
      }
  }

	public function editmyUser($user) 
  {
    $sql = "update users set firstname='$user->firstname',
            lastname='$user->lastname',Email='$user->Email',
            password='$user->password' where ID =" . $_SESSION['ID'];
    $result = $this->db->query($sql);
    if ($result) 
    {
      $_SESSION['firstname'] = $user->firstname;
      $_SESSION['lastname'] = $user->lastname;
      $_SESSION['Email'] = $user->Email;
      $_SESSION['password'] = $user->password;
      header("location:../pages/userManagement.php");
    } 
    else 
    {
      echo "Error: " . mysqli_error($conn);
    }
	}
	
	public function editUser($user)
  {
    $sql = "update users set firstname='$user->firstname',lastname='$user->lastname'
            ,Email='$user->Email',password='$user->password' where ID ='$user->ID'" ;
    $result = $this->db->query($sql);
    if ($result) 
    {
      header("location:../pages/userManagement.php");
    } 
    else 
    {
      echo "Error: " . mysqli_error($conn);
    }
	}

  public function deleteMyUser($user)
  {
    $ID = $_SESSION['ID'];
    $sql = "delete from users where ID = '$ID'";
    $result = $this->db->query($sql);
    if ($result) 
    {
      $patientsService = PatientsController::getInstance();
      $appointmentsService = AppointmentsController::getInstance();

      $patient = new Patient("-1",$_SESSION['Username'],"","","","");
      $patientsService->deletePatientByAddedBy($patient);

      $appointment = new Appointment("-1",$_SESSION['Username'],$_SESSION['Username'],"","","");
      $appointmentsService->deleteAppointmentbyOwnerOrEmp($appointment);


      header("location:../../control/functions/signout.php");
    } 
    else 
    {
        echo "Error: " . mysqli_error($conn);
    }
  }

  public function deleteUser($user)
  {
    $sql = "delete from users where ID = '$user->ID'";
    $result = $this->db->query($sql);
    if ($result) 
    {
        $patientsService = PatientsController::getInstance();
        $appointmentsService = AppointmentsController::getInstance();

        $patient = new Patient("-1",$user->Username,"","","","");
        $patientsService->deletePatientByAddedBy($patient);

        $appointment = new Appointment("-1",$user->Username,$user->Username,"","","");
        $appointmentsService->deleteAppointmentbyOwnerOrEmp($appointment);
        if($user->ID == $_SESSION['ID']) // if not current user is deleted
        {
            header("location:../../control/functions/signout.php");
        }
        else
        {
            header("location:../../view/pages/userManagement.php");
        }
    } 
    else 
    {
        echo "Error: " . mysqli_error($conn);
    }
  }

  public function getUsers($getType)
  {
      $users = array();
      //fetch data from user and check if it exists in the database.
      
      //select data from database where Email and password match.
      $sql = "";
      if($getType =="client")
      {
        $sql = "select * from users where accountType='Client'";
      }
      if($getType =="employee")
      {
        $sql = "select * from users where accountType='Employee'";
      }
      if($getType =="employee_client")
      {
        $sql = "select * from users where accountType='Employee' or accountType='Client'";
      }
      //executes the sql query and sends the query to the database server and returns a result set object with the matching rows.
      $result = $this->db->query($sql);
      
      //checking if the login credentials match using the session variables.
      $records=mysqli_fetch_all($result, MYSQLI_ASSOC);
      foreach($records as $r)
      {
      
          $a['ID'] = $r['ID'];
          $a['firstname'] = $r['firstname'];
          $a['lastname'] = $r['lastname'];
          $a['Username']=$r['Username'];
          $a['Email'] = $r['Email'];
          $a['password'] = $r['password'];
      
          $a['accountType'] = $r['accountType'];
          array_push($users, $a);
      }    
      return $users;
  }

  public function signout($user)
  {
    session_destroy();
    header("location:../../view/pages/home.php");
  }
}
?>
