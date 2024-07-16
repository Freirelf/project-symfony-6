<?php

namespace App\Service;

class RemoveIfen
{
  public function removeIfen(string $string): string
  {
    return str_replace(search:'-', replace:' ', subject:$string);
  }
}