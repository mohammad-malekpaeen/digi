<?php

namespace App\Dto;

use App\Contracts\Dto\BaseDtoContract;

class BaseDto implements BaseDtoContract {

	/**
	 * @var int|null
	 */
	protected ?int $id = null;

	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @param int|null $id
	 * @return $this
	 */
	public function setId(?int $id): static {
		$this->id = $id;
		return $this;
	}
}
