<?php

class Order extends \Eloquent {
	protected $fillable = array();

	public function user()
	{
		return $this->belongsTo('User');
	}
}