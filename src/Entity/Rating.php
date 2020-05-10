<?php

namespace Rating;

class Rating
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var int
	 */
	private $rate;


	/**
	 * @return int
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId ($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getRate ()
	{
		return $this->rate;
	}

	/**
	 * @param int $rate
	 */
	public function setRate ($rate)
	{
		$this->rate = $rate;
		return $rate;
	}
}
?>



