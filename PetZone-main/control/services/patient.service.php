<?php
  require_once("superController.php");
  require_once("../../model/patient.model.php");
  include_once "appointment.service.php";

?>
<?php
class PatientsController extends SuperController{ //singleton
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

	public function addNewPatient($patient) 
  {  
    $sql = "insert into patients(addedBy,petname,species,age,weight)
        values('$patient->addedBy','$patient->petname','$patient->species','
                $patient->age','$patient->weight')";
    $result=$this->db->query($sql);    
    if($result)
    {
        header("location:../pages/patientsManagement.php");
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
	}

	public function editPatient($patient) 
  {
    $sql = "update patients set petname='$patient->petname',species='$patient->species',
            age='$patient->age',weight='$patient->weight' where ID ='$patient->ID'";
    $result=$this->db->query($sql);  
    if($result)
    {
        header("location:../pages/patientsManagement.php");
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
	}

  public function deletePatient($patient)
  {
    $sql = "delete from patients where ID = '$patient->ID'";
    $result=$this->db->query($sql);  
    if ($result) 
    {
        $appointmentsService = AppointmentsController::getInstance();
        $appointment = new Appointment("-1","","",$patient->petname,"","");
        $appointmentsService->deleteAppointmentbyPetname($appointment);

        header("location:../../view/pages/patientsManagement.php");
    } 
    else 
    {
        echo "Error: " . mysqli_error($conn);
    }
  }
  public function deletePatientByAddedBy($patient)
  {
    $sql = "delete from patients where addedBy = '$patient->addedBy'";
    $result=$this->db->query($sql);  
    if ($result) 
    {
        $appointmentsService = AppointmentsController::getInstance();
        $appointment = new Appointment("-1","","",$patient->petname,"","");
        $appointmentsService->deleteAppointmentbyPetname($appointment);
        header("location:../../view/pages/patientsManagement.php");
    } 
    else 
    {
        echo "Error: " . mysqli_error($conn);
    }
  }
  
  public function getPatients($getType)
  {
      $patients = array();
      //fetch data from user and check if it exists in the database.
      
      //select data from database where Email and password match.
      $sql = "";
      if($getType =="all")
      {
          $sql = "select * from patients";
      }
      if($getType =="my")
      {
          $sql = "select * from patients where addedBy = '".$_SESSION['Username']."'";
      }
      //executes the sql query and sends the query to the database server and returns a result set object with the matching rows.
      $result=$this->db->query($sql);  
      //checking if the login credentials match using the session variables.
      $records=mysqli_fetch_all($result, MYSQLI_ASSOC);
      foreach($records as $r)
      {
          $a['ID'] = $r['ID'];
          $a['addedBy'] = $r['addedBy'];
          $a['petname'] = $r['petname'];
          $a['species']=$r['species'];
          $a['age'] = $r['age'];
          $a['weight'] = $r['weight'];
  
          array_push($patients, $a);
      }  
      return $patients;
  }
}
?>
