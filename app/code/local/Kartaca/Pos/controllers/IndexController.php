<?php
class Kartaca_Pos_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/pos?id=15 
    	 *  or
    	 * http://site.com/pos/id/15 	
    	 */
    	/* 
        $pos_id = $this->getRequest()->getParam('id');

        if($pos_id != null && $pos_id != '')	{
                $pos = Mage::getModel('pos/pos')->load($pos_id)->getData();
        } else {
                $pos = null;
        }
        */

        /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($pos == null) {
                $resource = Mage::getSingleton('core/resource');
                $read= $resource->getConnection('core_read');
                $posTable = $resource->getTableName('pos');

                $select = $read->select()
                   ->from($posTable,array('pos_id','title','content','status'))
                   ->where('status',1)
                   ->order('created_time DESC') ;

                $pos = $read->fetchRow($select);
        }
        Mage::register('pos', $pos);
        */

        $this->loadLayout();
        $this->renderLayout();
    }
}