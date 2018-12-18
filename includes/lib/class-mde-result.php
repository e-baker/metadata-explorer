<?php

class MDE_Result {

    /**
     * H1 results
     * @var     array
     * @since   1.0.0
     * @access  public
     */
    public $h1s = array();

    /**
     * H2 results
     * @var     array
     * @since   1.0.0
     * @access  public
     */
    public $h2s = array();

    /**
     * URL for the instance
     * @var     string
     * @since   1.0.0
     * @access  public
     */
    public $url = null;

    /**
     * The constructor function for mde_Result
     * @since 1.0.0
     * @access public
     * 
     * @param   object $headers An instance of the mde_Request object
     * @return  void
     */
    public function __construct( $headers ) {
        $this->url = $headers->URL;
        $this->h1s = $headers->get_el( 'h1' );
        $this->h2s = $headers->get_el( 'h2' );
    }

    /**
     * Returns the results.
     * @since   1.0.0
     * @access  public
     * 
     * @return  string  $output A string with the whole of the results.
     */
    public function print_result(){
        $output = "<div id='analysis-results'><h3>Heading Tag Results for <a href='{$this->url}' target='_blank' rel='nofollow'>{$this->url}</a>:</h3>";
        $output .= $this->print_els( 'H1', $this->h1s );
        $output .= $this->print_els( 'H2', $this->h2s );
        $output .= '</div>';
        return $output;
    }

    /**
     * Returns a result for a specific element
     * @since 1.0.0
     * @access private
     * 
     * @param   string  $el_type    The type of element being searched (i.e. H1)
     * @param   array   $els        An array of the elements found
     * @return  string  The printed results of the elements
     */
    private function print_els( $el_type, $els ){
        $el_output = "<h4>{$el_type} Headings</h4><ul class='{$el_type}-results'>";
        
        if( count($els) > 0 ) {
            foreach( $els as $el ) {
                // Check for duplicate heading. Add class name if it is
                $count = array_count_values( $els );
                $count[$el]>1 ? $duplicate_class = 'duplicate-result' : $duplicate_class = '';

                // Output heading
                $el_output .= "<li class='{$el_type}-result {$duplicate_class}'>" . $el . "</li>";
            }

            $el_output .= "<div class='mde-errors'>";
            if( strtolower($el_type) == 'h1' && count($els) > 1 ) { 
                $el_output .= "<p class='mde-error-msg'>Your page has more than one <a href='https://trafficlight.me/more-than-one-h1-tag'>H1 tag</a>.</p>";
            }
            $this->has_duplicates( $els ) ? $el_output .= "<p class='mde-warning-msg'>Your page has <a href='https://trafficlight.me/duplicate-h-tags'>duplicate {$el_type} tags</a>.</p>" : null;
            if( strtolower($el_type) === 'h2' && count( $els ) > 10 ) { $el_output .= "<p class='mde-warning-msg'>Your page has <a href='https://trafficlight.me/more-than-10-h2-tags'>more than 10 H2 tags</a>.</p>"; }
            $el_output .= "</div>";
        } else {
            $el_output .= "<li class='{$el_type}-result'>There were no {$el_type} tags found on this page.</li>";
        }
        
        $el_output .= '</ul>';
        
        return $el_output;
    }

    /**
     * Decideds if the array given has duplicates within
     * @since 1.0.0
     * @access private
     * 
     * @param   array   $tocheck    The array to check
     * @return  boolean True if it has duplicates, false if it doesn't.
     */
    private function has_duplicates( $tocheck ) {
        $has_duplicates = count( $tocheck ) === count( array_unique( $tocheck ) ) ? false : true;
        return $has_duplicates;
    }

}