<?php 
namespace Learning\Feedback\Model\Api;
use Learning\Feedback\Api\FeedbackInterface;
use Learning\Feedback\Model\ResourceModel\Feedback\CollectionFactory;
 use Magento\Framework\Exception\LocalizedException;
class FeedbackRepository implements FeedbackInterface
{
    private $collectionFactory;
    private $dataInterfaceFactory;
    public function __construct(CollectionFactory $collectionFactory)
    {
       
        $this->collectionFactory = $collectionFactory;
    }
 
  
 
    /** * @return string */
    public function getData(int $pageId = null)
    {

        if ($pageId == null) {
            $pageId = 1;
        }

        try {

            $pageId = 1;
            $items = $this->collectionFactory->create()->setPageSize(5)->setCurPage($pageId);
            $feedback = [];
           
            foreach ($items as $item) {
                $data = $item->getData();
                switch ($data['status']) {
                    case null:
                        $data['status'] = 'Pending';
                        break;
                    case true:
                        $data['status'] = 'Accepted';
                        break;
                    case false:
                        $data['status'] = 'Declined';
                        break;
                }
    
                $feedback[] = $data;
            }

             return ["status" => true, "message" => "Feedback List", "data"=> $feedback];

        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
     
    }
 
   
}