<?php
/**
 * our api controller, to feed the orm database. neeed an api key.
 * 
 */
class Api extends ApiController{
	
	public function readBeanAction(){
		
	}	
	
	/**
	 * add some tags in the page. return the modified page object.
	 */
	public function bindTagsInPageAction(){
		$pageId = $this->getValidParam( 'page-id', new Ui_Validator_Pattern(array(
			"pattern"=>"/^[0-9]+$/"
		)));
		
		$page = R::load('page', $pageId);
			
		if( $page->id == 0 )
			$this->response->throwError( "'page-id' value does not correspond to a valid object in db'" );	
		
		# get parametrized tags		
		$tags = $this->getValidParam( 'tags', new Ui_Validator_Iterator( array( 'validator'=>new Ui_Validator(array(
			"maxLength" => 160,
			"minLength" => 3
		)))));

		# store / create tags from candidates
		foreach ( $tags as $candidate )
			$page->sharedTag[] = $this->_getTagBean( $candidate );
	
		# save relationships
		R::store( $page );

		# load other stuff page related (veen properties loqded before...)
		$page->sharedMessage;
		$page->sharedTag;

		# full output of the page object
		$this->response->page = $page->recursiveExport() ;
	}
	
	/**
	 * retrieve a tag if exists, otherwise try to store it. We don't use
	 * R::tag( $page, array('topsecret','mi6') );
	 * because it erase existing tags. @todo?
	 */
	protected function _getTagBean( $candidate ){
		$tag =	R::findOne('tag',' content = :content', array( "content" => $candidate) );
		if( !empty( $tag ) )
			return $tag;
		$tag = R::dispense( 'tag' );
		$tag->content = $candidate;
		$id = R::store($tag);
		return $tag;
	}

	public function writeMessageInPageAction(){
		
		
		$content = $this->getValidParam( 'content',new Ui_Validator(array(
			"maxLength" => 160,
			"minLength" => 3
		)));

		$this->response->hello = true;
	}

	public function getValidParam( $property, Ui_Validator $validator ){
		$validator->field = $property;
		$content = $this->getParam( $property, $validator );		
		if( $content === null )
			$this->response->throwError( "'{$property}' value was not found'" );
		else if ( $content == false )
			$this->response->throwError( $validator->getPlainMessages() );
		return $content;
	}
	
}
?>
