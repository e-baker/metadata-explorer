<?php

require '../../vendor/autoload.php';

use PHPHtmlParser\Dom;

class MDE_Request {

    /**
     * The HTML contents of the URL retrieved
     * @var     object 
     * @since   1.0.0
     * @access  public
     */
    public $html = null;

    /**
     * The URL being retrieved
     * @var     string
     * @since   1.0.0
     * @access  public
     */
    public $URL = null;

    /**
     * The constructor function for HTC_Request
     * @since 1.0.0
     * @access public
     * 
     * @param   string  $url    The URL to be retrieved.
     * @return  void
     */
    public function __construct( $url ) {
        $this->URL = $url;
        $this->get_page();
    }

    /**
     * Uses PHP-HTML-Parser to get the URL
     * @since   1.0.0
     * @access  public
     * 
     * @return  void
     */
    public function get_page(){
        $dom = new Dom;
        $dom->loadFromUrl( $this->URL );
        $this->html = $dom;
    }

    /**
     * Uses PHP-HTML-Parser to search the DOM
     * @since   1.0.0
     * @access  public
     * 
     * @param   string  $element The element for which we search
     */
    public function get_el( $element ){
        $results = array();
        $els = $this->html->find( $element );
        foreach ($els as $el) {
            $heading = strip_tags($el->innerHtml());
            array_push( $results, $heading );
        }
        return $results;
    }
}