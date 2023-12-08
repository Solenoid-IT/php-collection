<?php



namespace Solenoid\Collection;



class SortKey
{
    const DIR_ASC  = 'asc';
    const DIR_DESC = 'desc';



    public string $column;
    public string $direction;



    # Returns [self]
    public function __construct (string $column, string $direction)
    {
        // (Getting the values)
        $this->column    = $column;
        $this->direction = $direction;
    }

    # Returns [SortKey]
    public static function create (string $column, string $direction)
    {
        // Returning the value
        return new SortKey( $column, $direction );
    }
}



?>