<?php

declare(strict_types=1);

require_once( "ConsolePrinter.php" );

class Elevator {

    public const int DEFAULT_LEVEL = 1;

    private string $name;

    private int $levels;

    private int $currentLevel;

    private bool $running = false;

    private ?Printer $printer;

    public function __construct( string $name, int $levels, int $currentLevel = 1, ?Printer $monitor = null ) {
        $this->name = $name;
        $this->levels = $levels;

        if( null !== $monitor ) {
            $this->printer = $monitor;
        }

        $this->logEvent( "Elevator called " . $name . " has been created with " . $levels . " levels, starting at Level " . $currentLevel . "." );

        if( $currentLevel > $levels || $currentLevel < 1 ) {
            /**
             *  The current level being served cannot go below or beyond the shaft!
             **/
            $this->currentLevel = self::DEFAULT_LEVEL;
            $this->logEvent( "!!! Invalid starting level found (" . $currentLevel . "), the elevator is reset to go to Level " . $this->currentLevel . "." );
        }
        else {
            $this->currentLevel = $currentLevel;
            $this->logEvent( "*** Valid starting level found (" . $currentLevel . "), the elevator is reset to go to Level " . $this->currentLevel . "." );
        }
    }

    public function getName(): string {
        return $this->name;
    }

    public function getLevels(): int {
        return $this->levels;
    }

    public function getCurrentLevel(): int {
        return $this->currentLevel;
    }

    public function run() : void {
        $this->running = true;

        $this->logEvent( "Elevator [" . $this->name . "] is started (currently at level " . $this->currentLevel . ")." );
    }

    public function stop() : void {
        $this->running = false;

        $this->logEvent( "Elevator [" . $this->name . "] is forced to stop (currently at level " . $this->currentLevel . ")." );
    }

    public function isRunning() : bool {
        $this->logEvent( "Elevator [" . $this->name . "] is currently running (currently at level " . $this->currentLevel . ")." );
        return $this->running;
    }

    public function __destruct() {
        if( $this->running ) {
            $this->running = false;
            $message = "Elevator [" . $this->name . "] is still running, will now automatically stop. (currently at level " . $this->currentLevel . ").";
        }
        else {
            $message = "Elevator [" . $this->name . "] is already stopped. (currently at level " . $this->currentLevel . ").";
        }

        $this->logEvent( $message );
    }

    private function logEvent( string $event, bool $newLine = true ) : void {
        if( null !== $this->printer ) {
            if( $newLine ) {
                $this->printer->println( $event );
            }
            else {
                $this->printer->print( $event );
            }
        }
    }

}

$elevatorNames = [ "Ella", "Elena", "Eta" ];
$elevatorLevels = [ 10, 8, 8 ];
$elevatorStartingLevels = [ 2, 3, 1 ];

$sizeOfElevatorNames = count( $elevatorNames );
$sizeOfElevatorLevels = count( $elevatorLevels );
$sizeOfElevatorStartingLevels = count( $elevatorStartingLevels );
if( $sizeOfElevatorNames != $sizeOfElevatorStartingLevels || $sizeOfElevatorNames != $sizeOfElevatorLevels || $sizeOfElevatorStartingLevels != $sizeOfElevatorLevels ) {
    throw new RuntimeException( "Incompatible arguments found, unable to proceed. Program will now terminate." );
}

$printer = new ConsolePrinter();
$elevators = [];
for( $i = 0; $i < $sizeOfElevatorNames; $i++ ) {
    $elevators[ $elevatorNames[ $i ] ] = new Elevator( $elevatorNames[ $i ], $elevatorLevels[ $i ], $elevatorStartingLevels[ $i ], $printer );
    $elevators[ $elevatorNames[ $i ] ]->run();
}