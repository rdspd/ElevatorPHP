<?php

declare(strict_types=1);

interface Printer {

    public function print( string $message ) : void;

    public function println( string $message ) : void;

}