<?php
namespace Custom\Widgets\investigations;

class ComplaintDetails extends \RightNow\Libraries\Widget\Base {
	public $ci_instance;
	
    function __construct($attrs) {
    	$this->ci_instance=&get_instance();
        parent::__construct($attrs);
    }

    function getData() {
       //All the data will come in a tabular column.
       $this->data['incident_details']=$this->getIncidentDetails();
	   $this->data['customer_details']=$this->getCustomerDetails();
	   $this->data['delivery_details']=$this->getDeliveryDetails();
	   $this->data['investigation_details']=$this->getInvestigationDetails();
        return parent::getData();

    }
	
	function getIncidentDetails(){
		//Show the Details of the parent incident.
		$i_id=getUrlParm('i_id'); 
		$parent_id=$this->ci_instance->model('custom/CustomerFeedbackSystem')->getParentIncidentId($i_id);
		$incident=$this->ci_instance->model('custom/CustomerFeedbackSystem')->investigationDetails($parent_id);
		//$this->d($incident->PrimaryContact->Phones);
		$displayParams=array();
		
		$displayParams['Complaint No']=$incident->LookupName;
		$displayParams['Subject']=$incident->Subject;
		$displayParams['Status']=$incident->StatusWithType->StatusType->LookupName;
		$displayParams['Source']=$incident->Source->LookupName;
		$displayParams['Assigned To']=$incident->AssignedTo->LookupName;
		$displayParams['Created On']=date("Y-m-d H:i A",$incident->CreatedTime);
		$displayParams['Severity']=$incident->Severity;
		$displayParams['Interface']=$incident->Interface->LookupName;
		
		
		return $displayParams;
	}

    function getInvestigationDetails(){
    	$displayParams=array();
		$i_id=getUrlParm('i_id'); 
		
		$incident=$this->ci_instance->model('custom/CustomerFeedbackSystem')->investigationDetails($i_id);
		$displayParams['Complaint No']=$incident->LookupName;
		$displayParams['Subject']=$incident->Subject;
		$displayParams['Status']=$incident->StatusWithType->StatusType->LookupName;
		$displayParams['Source']=$incident->Source->LookupName;
		$displayParams['Assigned To']=$incident->AssignedTo->LookupName;
		$displayParams['Created On']=date("Y-m-d H:i A",$incident->CreatedTime);
		$displayParams['Severity']=$incident->Severity;
		$displayParams['Interface']=$incident->Interface->LookupName;
		
		
		return $displayParams;
    }
	
	function getCustomerDetails(){
		$i_id=getUrlParm('i_id');
		$incident=$this->ci_instance->model('custom/CustomerFeedbackSystem')->investigationDetails($i_id);
		$customer=array();
		$customer['Name']=$incident->PrimaryContact->Name->First. " ".$incident->PrimaryContact->Name->Last;
		$customer['City']=$incident->PrimaryContact->Address->City;
		$customer['Country']=$incident->PrimaryContact->Address->Country;
		$customer['Zip']=$incident->PrimaryContact->Address->PostalCode;
		$customer['State']=$incident->PrimaryContact->Address->StateOrProvince;
		$customer['Street']=$incident->PrimaryContact->Address->Street;
		$customer['Organization']=$incident->Organization->LookupName;
		$customer['Member Since']=date("Y-m-d H:i A",$incident->CreatedTime);
		
		
		return $customer;
	}
	
	function getDeliveryDetails(){
		$i_id=getUrlParm('i_id');
		$delivery=$this->ci_instance->model('custom/CustomerFeedbackSystem')->getDeliveryInvestigationDetails($i_id);
		//$this->d($delivery);
		return $delivery;
		
	}
	
	
	function d($data){
		echo"<pre>";
		print_r($data);
		echo "</pre>";
	}
}