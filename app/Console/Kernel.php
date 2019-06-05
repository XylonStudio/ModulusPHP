<?php

namespace App\Console;

use GO\Scheduler as Schedule;
use Modulus\Console\ModulusCLI;
use Modulus\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * Start scheduler
   *
   * @param Schedule $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    //
  }

  /**
   * Boot the Modulus Developer Environment CLI
   *
   * @return \AtlantisPHP\Console\Application
   */
  public static function console()
  {
    return (
      ModulusCLI::boot()
                ->load(__DIR__ . DS . 'Commands')
    );
  }
}
