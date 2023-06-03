<?php declare(strict_types = 1);

namespace Spaceboy\Plugins\PatchEscposPhpPlugin;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;

/**
 * Class Plugin
 *
 * @copyright (c) 2023 Sportisimo s.r.o.
 * @author        Jiri Votocek
 * @since         2023-06-03
 */
final class Plugin implements PluginInterface, EventSubscriberInterface
{
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
}
