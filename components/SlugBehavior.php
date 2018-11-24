<?php 

namespace app\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use dosamigos\transliterator\TransliteratorHelper;

/**
 * @author Sherzod Usmonov
 */
class SlugBehavior extends Behavior
{
	public $input_attribute;
	public $output_attribute;
	public $translate = true;


	public function events()
	{
		return [
			ActiveRecord::EVENT_BEFORE_VALIDATE => 'getSlug'
		];
	}

	public function getSlug( $event )
	{
		if ( empty( $this->owner->{$this->output_attribute} ) ) 
		{
			$attribute = $this->generateSlug( $this->owner->{$this->input_attribute} );

			$this->owner->{$this->output_attribute} = $attribute;
		} 
		else 
		{
			$attribute = $this->generateSlug( $this->owner->{$this->output_attribute} );

			$this->owner->{$this->output_attribute} = $attribute;
		}
	}

	private function generateSlug( $slug )
	{
		$slug = $this->slugify( $slug );
		
		if ( $this->checkUniqueSlug( $slug ) ) 
		{
			return $slug;
		} 
		else 
		{
			for ( $suffix = 2; !$this->checkUniqueSlug( $new_slug = $slug . '-' . $suffix ); $suffix++ ) {}

			return $new_slug;
		}
	}

	private function slugify( $slug )
	{
		if ( $this->translate ) {
			return Inflector::slug( TransliteratorHelper::process( $slug ), '-', true );
		} else {
			return $this->slug( $slug, '-', true );
		}
	}

	private function slug( $string, $replacement = '-', $lowercase = true )
	{
		$string = preg_replace( '/[^\p{L}\p{Nd}]+/u', $replacement, $string );

		$string = trim( $string, $replacement );

		return $lowercase ? strtolower( $string ) : $string;
	}

	private function checkUniqueSlug( $slug )
	{
		$pk = $this->owner->primaryKey();
		$pk = $pk[0];

		$condition = $this->output_attribute . ' = :output_attribute';
		$params = [ ':output_attribute' => $slug ];

		if ( !$this->owner->isNewRecord ) 
		{
			$condition .= ' AND ' . $pk . ' != :pk';
			$params[':pk'] = $this->owner->{$pk};
		}

		return !$this->owner->find()
			->where( $condition, $params )
			->one();
	}

}

?>