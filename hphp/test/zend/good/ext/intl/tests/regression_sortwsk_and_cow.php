<?hh
/*
 * Check if collator_sort_with_sort_keys()
 * properly supports copy-on-write.
 */


/* Create two copies of the given array.
 * Sort the array and the first copy.
 * Check if the second copy remains unsorted.
 */
function test_COW( $locale, $test_array )
{
    $res_str = '';

    $coll = ut_coll_create( $locale );

    // Create two copies of the given array.
    $copy1 = $test_array;
    $copy2 = $test_array;

    // Sort given array and the first copy of it.
    ut_coll_sort_with_sort_keys( $coll, &$test_array );
    ut_coll_sort_with_sort_keys( $coll, &$copy1      );

    // Return contents of all the arrays.
    // The second copy should remain unsorted.
    $res_str .= dump( $test_array ) . "\n";
    $res_str .= dump( $copy1      ) . "\n";
    $res_str .= dump( $copy2      ) . "\n";

    return $res_str;
}

function ut_main()
{
    $res_str = '';

    $a1 = array( 'b', 'a', 'c' );
    $a2 = array( 'в', 'а', 'б' );

    $res_str .= test_COW( 'en_US', $a1 );
    $res_str .= test_COW( 'ru_RU', $a2 );

    return $res_str;
}
<<__EntryPoint>>
function main_entry(): void {

  require_once( 'ut_common.inc' );
  ut_run();
}
