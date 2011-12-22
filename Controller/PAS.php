<?php
namespace Cybernox\AmazonWebServicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use \AmazonPAS;

class PAS extends Controller
{
    /**
     * public function indexAction(Request $request)
     * 
     * Demonstration interface for Amazon Product Advertising API
     *
     * @version         1.0
     * 
     * @author          Antoine Durieux
     * 
     * @return          array
     * 
     * @Route("/amazon/pas", name="AmazonWebServicesBundle_pas_index")
     * @Template("CybernoxAmazonWebServicesBundle:PAS:index.html.twig")
     */ 
    public function indexAction(Request $request)
    {
        
        if($request->getMethod()=='POST')
        {
            
        // ---------------------------------------------------------------------
        // 1. Load the ProductAdvertisingApi
        // ---------------------------------------------------------------------
            $pas = $this->get('aws_pas');
            $pas->set_locale(AmazonPAS::LOCALE_FRANCE);

        // ---------------------------------------------------------------------
        // 2. Example of the search API
        // ---------------------------------------------------------------------
            $searchKeyword = $request->request->get('searchKeyword','');
            if($searchKeyword != '')
            {
                $responseSearch = $pas->item_search($searchKeyword);
                $statusSearch = json_encode(self::report_status($responseSearch));
                $responseSearch = json_encode($responseSearch);
            }
            else
            {
                $responseSearch = '';
                $statusSearch = '';
            }

        // ---------------------------------------------------------------------
        // 3. Example of a cart creation
        // ---------------------------------------------------------------------
            $orderReference = $request->request->get('orderReference','');
            if($orderReference)
            {
                $responseOrder = $pas->cart_create(array(),
                                  array(
                                    'Item.1.ASIN' => $orderReference,
                                    'Item.1.Quantity' => 1
                                    )
                                  );
                $statusOrder = json_encode(self::report_status($responseOrder));
                $purchaseUrl=$responseOrder->body->Cart->PurchaseURL;
                $responseOrder = json_encode($responseOrder);
            }
            else
            {
                $responseOrder = '';
                $statusOrder = '';
                $purchaseUrl= '';
            }
        }
        else
        {
            $orderReference = 'B002J9HO90';
            $searchKeyword = 'cocotte minute';
            
            $responseSearch = '';
            $statusSearch = '';
            
            $responseOrder = '';
            $statusOrder = '';
            $purchaseUrl= '';
        }
        
        // ---------------------------------------------------------------------
        // 4. Render
        // ---------------------------------------------------------------------
        return array(
            'searchKeyword' => $searchKeyword,
            'orderReference' => $orderReference,
            
            'responseSearch' => $responseSearch,
            'statusSearch' => $statusSearch,
            
            'responseOrder' => $responseOrder,
            'statusOrder' => $statusOrder,
            'purchaseUrl' => $purchaseUrl,
        );
    }
    
    public static function report_status($response) 
    {
          $rc = '';
          $rc .=  "Ok='".$response->isOK()."' ";
          $rc .=  "Error='".isset($response->body->Error)."' ";
          
          //Verify a successful request
          if(isset($response->body->Cart))
          {
              foreach($response->body->Cart->Request->Error as $error)
              {
                    $rc .=  "Error code: " . $error->Code . "\r\n";
                    $rc .=  $error->Message . "\r\n";
                    $rc .=  "\r\n";
              }
              
          }
          return $rc;
    }
    

}

