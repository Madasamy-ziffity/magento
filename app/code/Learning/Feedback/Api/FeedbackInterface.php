<?php
namespace Learning\Feedback\Api;
 
 
interface FeedbackInterface
{
   
    /**
     * @return string
     */
    public function getData(int $pageId = null);
 
  
}