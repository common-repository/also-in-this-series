<?php

namespace planetjon\wordpress\also_in_this_series;

function SeriesShortcode( $args ) {
    ob_start();
    displaySeries( $args );
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode( 'alsointhisseries', __NAMESPACE__ . '\SeriesShortcode' );
