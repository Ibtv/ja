<?php
namespace Shop\Model;
use Common\Shop\CommonModel;
class ShopModel extends CommonModel
{
	
	protected $_validate = array(
			
	);
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
		
	}
	
}

?>