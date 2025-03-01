<?php

declare(strict_types=1);

require_once( "Printer.php" );

class ConsolePrinter
    implements Printer {

    public function print( string $data ) : void {
        echo $data;
    }

    public function println( string $data ) : void {
        echo $data, PHP_EOL;
    }

}