<?php

namespace Roots\Acorn\Console\Commands;

use Illuminate\Foundation\Console\VendorPublishCommand as FoundationVendorPublishCommand;
use Illuminate\Support\Str;

class VendorPublishCommand extends FoundationVendorPublishCommand
{
    /**
     * Publish the given item from and to the given location.
     *
     * @param  string  $from
     * @param  string  $to
     * @return void
     */
    protected function publishItem($from, $to)
    {
        if (Str::startsWith($to, $vendor_path = dirname(__DIR__, 5))) {
            $this->info("Cannot publish [{$from}] until Acorn is initialized.");

            if (! $this->confirm("Would you like to initialize Acorn right now?", true)) {
                throw new \Exception("Please run wp acorn acorn:init");
            }

            $this->call('acorn:init', ['--base' => $this->getLaravel()->basePath()]);
            $to = str_replace($vendor_path, $this->getLaravel()->basePath(), $to);
        }

        parent::publishItem($from, $to);
    }
}