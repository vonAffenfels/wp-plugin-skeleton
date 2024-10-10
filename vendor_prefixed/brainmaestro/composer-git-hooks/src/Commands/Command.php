<?php

namespace WPPluginSkeleton_Vendor\BrainMaestro\GitHooks\Commands;

use WPPluginSkeleton_Vendor\BrainMaestro\GitHooks\Hook;
use WPPluginSkeleton_Vendor\Symfony\Component\Console\Command\Command as SymfonyCommand;
use WPPluginSkeleton_Vendor\Symfony\Component\Console\Input\InputInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\Console\Output\OutputInterface;
/** @internal */
abstract class Command extends SymfonyCommand
{
    private $output;
    protected $dir;
    protected $composerDir;
    protected $hooks;
    protected $gitDir;
    protected $lockDir;
    protected $global;
    protected $lockFile;
    protected abstract function init(InputInterface $input);
    protected abstract function command();
    protected final function execute(InputInterface $input, OutputInterface $output) : int
    {
        $this->output = $output;
        $this->gitDir = $input->getOption('git-dir') ?: git_dir();
        $this->lockDir = $input->getOption('lock-dir');
        $this->global = $input->getOption('global');
        $this->dir = \trim($this->global && $this->gitDir === git_dir() ? \dirname(global_hook_dir()) : $this->gitDir);
        if ($this->global) {
            if (empty($this->dir)) {
                $this->global_dir_fallback();
            }
        }
        if ($this->gitDir === \false) {
            $output->writeln('Git is not initialized. Skip setting hooks...');
            return SymfonyCommand::SUCCESS;
        }
        $this->lockFile = (null !== $this->lockDir ? $this->lockDir . '/' : '') . Hook::LOCK_FILE;
        $dir = $this->global ? $this->dir : \getcwd();
        $this->hooks = Hook::getValidHooks($dir);
        $this->init($input);
        $this->command();
        return SymfonyCommand::SUCCESS;
    }
    protected function global_dir_fallback()
    {
    }
    protected function info($info)
    {
        $info = \str_replace('[', '<info>', $info);
        $info = \str_replace(']', '</info>', $info);
        $this->output->writeln($info);
    }
    protected function debug($debug)
    {
        $debug = \str_replace('[', '<comment>', $debug);
        $debug = \str_replace(']', '</comment>', $debug);
        $this->output->writeln($debug, OutputInterface::VERBOSITY_VERBOSE);
    }
    protected function error($error)
    {
        $this->output->writeln("<fg=red>{$error}</>");
    }
}
