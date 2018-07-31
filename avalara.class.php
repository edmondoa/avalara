<?php

include('C:/xampp/htdocs/3gstore/includes/new_avalara/models/address.class.php');
include('C:/xampp/htdocs/3gstore/includes/new_avalara/models/zip.class.php');
include('C:/xampp/htdocs/3gstore/includes/new_avalara/SOAP/');
class Avalara 
{
    protected $ez ='';
    protected $user ='khurram@3gstore.com';
    protected $pass ='8663Gstore!';
    protected $state;
    protected $zipcode;
    // Constants
    const ns      = 'http://eztaxasp.billsoft.com/eztaxwebservice';
    const wsdl    = 'http://eztaxasp.billsoft.com/EZTaxWebService/EZTaxWebService.svc?WSDL';
    const sslport = 'https://eztaxasp.billsoft.com/EZTaxWebService/EZTaxWebService.svc/SSL';

    public function __construct()
    {
        $soap_opts = array(
            'login'        => $user,
            'password'     => $pass,
            'soap_version' => SOAP_1_2,
            'trace'        => true, // Set to false for a production environment
            'classmap'     => $classmap
         );
         
         // The custom BillSoft headers
         $soap_headers = array(
            new SoapHeader($ns, 'UserName', $user),
            new SoapHeader($ns, 'Password', $pass)
         );
        try{
            $this->$ez = new SoapClient(wsdl, $soap_opts); // Create the SoapClient object
            $this->$ez->__setSoapHeaders($soap_headers);    // Set the custom headers
            $this->$ez->__setLocation($sslport);            // Set the custom SSL service location
            return $this->$ez;
        }catch(SoapFault $fault){
            print $fault->__toString();
            if ($soap_opts['trace']) {
               print $ez->__getLastRequestHeaders();
               print $ez->__getLastRequest();
               print $ez->__getLastResponseHeaders();
               print $ez->__getLastResponse();
            }
        }
    }

    public function CalcTaxesWithZipAddress()
    {
        $txn->BillToAddress = new ZipAddress;
        $txn->BillToAddress->CountryISO = "USA";
        $txn->BillToAddress->County = "Johnson";
        $txn->BillToAddress->Locality = "Overland Park";
        $txn->BillToAddress->State = "KS";
        $txn->BillToAddress->ZipCode = "66212";
        $result = $this->ez->CalcTaxesWithZipAddress(array('aTransaction' => $txn));
        print var_dump($result);
    }
}
