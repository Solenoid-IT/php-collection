<?php



namespace Solenoid\Collection;



class Collection
{
    const SORT_ASC  = 'asc';
    const SORT_DESC = 'desc';



    private array $records;



    # Returns [self]
    public function __construct (array $records)
    {
        // (Getting the value)
        $this->records = $records;
    }

    # Returns [Collection]
    public static function create (array $records)
    {
        // Returning the value
        return new Collection( $records );
    }



    # Returns [int]
    public function count ()
    {
        // Returning the value
        return count( $this->records );
    }



    # Returns [Collection]
    public function filter (callable $condition)
    {
        // Returning the value
        return Collection::create( array_values( array_filter( $this->records, $condition ) ) );
    }



    # Returns [assoc]
    public static function group_record (array $record, array $keys, array $group = [])
    {
        // (Getting the values)
        $k = $keys[0];
        $v = $record[ $k ];



        if ( count( $keys ) > 1 )
        {// (There are more keys)
            // (Getting the value)
            $group[ $v ] = self::group_record( $record, array_splice( $keys, 1 ), $group[ $v ] ?? [] );
        }
        else
        {// (There is a single key)
            // (Appending the value)
            $group[ $v ][] = $record;
        }



        // Returning the value
        return $group;
    }



    # Returns [assoc]
    public function group (array $keys)
    {
        // (Setting the value)
        $groups = [];

        foreach ($this->records as $record)
        {// Processing each entry
            // (Getting the value)
            $groups = self::group_record( $record, $keys, $groups );
        }



        // Returning the value
        return $groups;
    }

    # Returns [self]
    public function sort (array $keys)
    {
        // (Sorting the array)
        usort
        (
            $this->records,
            function ( $a, $b ) use ($keys)
            {
                foreach ($keys as $sort_key)
                {// Processing each entry
                    if ( $a[ $sort_key->column ] < $b[ $sort_key->column ] )
                    {// Match OK
                        // Returning the value
                        return $sort_key->direction === SortKey::DIR_ASC ? -1 : +1;
                    }
                    else
                    if ( $a[ $sort_key->column ] > $b[ $sort_key->column ] )
                    {// Match OK
                        // Returning the value
                        return $sort_key->direction === SortKey::DIR_ASC ? +1 : -1;
                    }
                }



                // Returning the value
                return 0;
            }
        )
        ;



        // Returning the value
        return $this;
    }



    # Returns [array<mixed>]
    public function to_array (?callable $transform = null)
    {
        // Returning the value
        return array_map( $transform ?? function ($record) { return $record; }, $this->records );
    }
}



?>