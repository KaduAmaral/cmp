<?php

namespace CMP\Command;

use \CMP\Command\Command;

class CommandCollection {
   private $list = [];
   private $alias = [];

   public function add($name, Command $command) {
      $this->list[$name] = $command;
   }

   public function alias($name, $alias) {
      $this->alias[$alias] = $name;
   }

   public function get($name) {
      if (isset($this->list[$name]))
         return $this->list[$name];
      else if (isset($this->alias[$name]) && isset($this->list[$this->alias[$name]]))
         return $this->list[$this->alias[$name]];
      else
         return NULL;
   }

   public function dump() {

      $doc = 'CMP'.PHP_EOL;

      /*
      Usage:
      cmd.php build <app> [--prod]


      Options:
      -h --help     Show this screen.
      --version     Show version.
      --prod        Build prod
      */

      $commands = 'Usage:'.PHP_EOL;
      $options = 'Options:'.PHP_EOL;

      foreach ($this->list as $name => $command) {
         $commands .= "   cmd.php   {$name} " . $command->getOptionCollection()->buildCommand() . PHP_EOL;
         $options  .= '   '.implode('   '.PHP_EOL, $command->getOptionCollection()->dumpOptions()).PHP_EOL;
         //buildCommand
      }

      return $commands.PHP_EOL.$options;

   }
}