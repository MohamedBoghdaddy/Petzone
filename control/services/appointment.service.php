<?php
  require_once("superController.php");
  require_once("../../model/appointment.model.php");
?>
<?php
class AppointmentsController extends SuperController{ //singleton
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

	public function addNewAppointment($appointment) 
  {  
    $sql = "insert into appointments(petOwner,EmployeeName,petname,aDate,price)
        values('$appointment->petOwner','$appointment->EmployeeName','$appointment->petname',
              '$appointment->aDate','$appointment->price')";
    $result = $this->db->query($sql);
    if($result)
    {
        header("location:../pages/AppointmentsManagement.php");
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
	}

	public function editAppointment($appointment)
    { 
        $sql = "update appointments set aDate='$appointment->aDate' where ID ='$appointment->ID'";
        $result = $this->db->query($sql);
        if($result)
        {
            header("location:../pages/AppointmentsManagement.php");
        }
        else
        {
            echo "Error: " . mysqli_error($conn);
        }
	}

  public function deleteAppointment($appointment)
  {
    $sql = "delete from appointments where ID = '$appointment->ID'";
    $result = $this->db->query($sql);
    if ($result) {
        header("location:../../view/pages/AppointmentsManagement.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
  }
  public function deleteAppointmentbyOwnerOrEmp($appointment)
  {
    $sql = "delete from appointments where petOwner = '$appointment->petOwner' or EmployeeName = '$appointment->EmployeeName'";
    $result = $this->db->query($sql);
    if ($result) {
        header("location:../../view/pages/AppointmentsManagement.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
  }
  public function deleteAppointmentbyPetname($appointment)
  {
    $sql = "delete from appointments where petname = '$appointment->petname'" ;
    $result = $this->db->query($sql);
    if ($result) {
        header("location:../../view/pages/AppointmentsManagement.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
  }

  public function getAppointments($getType)
  {
      $appointments = array();
      //fetch data from user and check if it exists in the database.
      //select data from database where Email and password match.
      $sql = "";
      if($getType == "all")
      {
          $sql = "select * from appointments order By aDate DESC";
      }
      if($getType == "employee")
      {
          $sql = "select * from appointments where EmployeeName = '". $_SESSION['Username'] ."' order By aDate DESC";
      }
      if($getType == "client")
      {
          $sql = "select * from appointments where petOwner = '". $_SESSION['Username'] ."' order By aDate DESC";
      }
      //executes the sql query and sends the query to the database server and returns a result set object with the matching rows.
      $result = $this->db->query($sql);
      //checking if the login credentials match using the session variables.
      $records=mysqli_fetch_all($result, MYSQLI_ASSOC);
      foreach($records as $r)
      {
          $a['ID'] = $r['ID'];
          $a['petOwner'] = $r['petOwner'];
          $a['EmployeeName'] = $r['EmployeeName'];
          $a['petname'] = $r['petname'];
          $a['aDate'] = $r['aDate'];
          $a['price'] = $r['price'];
          array_push($appointments, $a);
      }    
      return $appointments;
  }
  


}
?>
