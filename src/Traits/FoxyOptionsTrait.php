<?php

namespace RichTestani\ManFox;

trait FoxyOptionsTrait {

  protected $limit = 20;

  protected $offset = 20;

  protected $current_offset;

  protected $total_items;

  protected $total_pages;

  public function setOffset($offset)
  {
    $this->offset;
  }

  public function setLimit($limit)
  {
    $this->limit = $limit;
  }

  public function buildOptions()
  {
    $options = "?limit=".$this->limit."&offset=".$this->offset;
    return $options;
  }
}

 ?>
