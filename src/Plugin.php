<?php declare(strict_types = 1);

namespace Spaceboy\Plugins\PatchEscposPhpPlugin;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;

/**
 * Plugin pro konkretni zmeny.
 *
 * @copyright (c) 2023 Sportisimo s.r.o.
 * @author        Jiri Votocek
 * @since         2023-06-03
 */
final class Plugin implements PluginInterface, EventSubscriberInterface
{
  /** @var string[] Seznam souboru JSON obsahujicich prikazy k jednotlivym zmenam. */
  // TODO: Vyresit dir (pouzit absolutni cestu?)
  private const REQUESTS = [
    __DIR__ . '/../files/vendor/mike42/escpos-php/src/Mike42/Escpos/Printer.json',
    //__DIR__ . '/files/vendor/mike42/escpos-php/src/Mike42/Escpos/GdEscposImage.json',
    //__DIR__ . '/files/vendor/mike42/escpos-php/src/Mike42/Escpos/EscposImage.json',
  ];

  /** @var Composer Composer. */
  private Composer $composer;

  /** @var IOInterface IO interface. */
  private IOInterface $io;

  /**
   * Zavola se pri "activate".
   *
   * @param Composer    $composer
   * @param IOInterface $io
   *
   * @return void
   */
  public function activate(
    Composer $composer,
    IOInterface $io,
  ): void
  {
    $this->composer = $composer;
    $this->io = $io;
    $this->io->write('activate');
  }

  /**
   * Zavola se pri "deactivate".
   *
   * @param Composer    $composer
   * @param IOInterface $io
   *
   * @return void
   */
  public function deactivate(
    Composer $composer,
    IOInterface $io,
  ): void
  {
    $this->io->write('deactivate');
  }

  /**
   * Zavola se pri odinstalovani pluginu.
   *
   * @param Composer    $composer
   * @param IOInterface $io
   *
   * @return void
   */
  public function uninstall(
    Composer $composer,
    IOInterface $io,
  ): void
  {
    $this->io->write('uninstall');
  }

  /** @inheritDoc */
  public static function getSubscribedEvents()
  {
    echo __METHOD__ . PHP_EOL;
    return [
      ScriptEvents::POST_INSTALL_CMD => 'onPostInstall',
      ScriptEvents::POST_UPDATE_CMD => 'onPostUpdate',
    ];
  }

  /**
   * Metoda volana po instalaci.
   *
   * @return void
   */
  public function onPostInstall(): void
  {
    if(!isset($this->io))
    {
      echo 'Something went wrong (onPostInstall).' . PHP_EOL;
    }
    $this->io->write(__METHOD__);

    // TODO: Po vytvoření balíčku univerzálního měniče souborů (nazvaného např. Patchwork(?))
    // TODO: místo tohohle kódu volat Patchwork::makeChanges($this->io, $this->composer(?), self::REQUESTS)
    // TODO: Možná přidat i název měněného balíčku?
    \Sportisimo\Ecommerce\StockAdmin\Changes\ChangeProvider::makeChanges($this->io, self::REQUESTS);
  }

  /**
   * Metoda volana po update.
   *
   * @return void
   */
  public function onPostUpdate(): void
  {
    if(!isset($this->io))
    {
      echo 'Something went wrong (onPostUpdate).' . PHP_EOL;
    }
    $this->io->write(__METHOD__);

    // TODO: Po vytvoření balíčku univerzálního měniče souborů (nazvaného např. Patchwork(?))
    // TODO: místo tohohle kódu volat Patchwork::makeChanges($this->io, $this->composer(?), self::REQUESTS).
    // TODO: Možná přidat i název měněného balíčku?
    \Sportisimo\Ecommerce\StockAdmin\Changes\ChangeProvider::makeChanges($this->io, self::REQUESTS);
  }
}
