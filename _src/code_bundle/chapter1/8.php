<?php

class MessageQueue
{
    // upper case constant with underscores
    const MAX_MESSAGES = 100;

    // descriptive properties using camelCase
    private    $messageQueue            = array("one\ntwo");
    private    $currentMessageIndex    = -1;

    // setter method for $currentMessageIndex
    public setCurrentMessageIndex($currentMessageIndex)
    {
        $this->currentMessageIndex = (int)$currentMessageIndex;
    }

    // getter method for $currentMessageIndex
    public getCurrentMessageIndex()
    {
        return $this->currentMessageIndex;
    }

    // is<Attribute> method returns boolean
    public function isQueueFull()
    {
        return count($this->messageQueue) == self::MAX_MESSAGES;
    }
    
    // has<Attribute> method returns boolean
    public function hasMessages()
    {
        return (is_array($this->messageQueue) && count($this->messageQueue) > 0);
    }
    
    // descriptive take action method
    public function resetQueue()
    {
        $this->messageQueue = null;
    }
    
    // descriptive take action method
    public function convertMessagesToHtml()
    {
        // local copy of message queue
        $myMessages = $this->messageQueue;
        
        // $i is acceptable in a short for-loop
        for ($i = 0; $i < sizeof($myMessages); $i++) {
            $myMessages[$i] = nl2br($myMessages[$i]);
        }
        
        return $myMessages;
    }
    
    // ... additional methods to manage message queue ...
}

?>