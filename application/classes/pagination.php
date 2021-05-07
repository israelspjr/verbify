<?php

/**

 * PHPSense Pagination Class

 *

 * PHP tutorials and scripts

 *

 * @package		PHPSense

 * @author		Jatinder Singh Thind

 * @copyright	Copyright (c) 2006, Jatinder Singh Thind

 * @link		http://www.phpsense.com

 */



// ------------------------------------------------------------------------





class Pagination {

	var $php_self;

	var $rows_per_page = 100; //Number of records to display per page

	var $total_rows = 0; //Total number of rows returned by the query

	var $links_per_page = 5; //Number of links to display per page

	var $append = ""; //Paremeters to append to pagination links

	var $sql = "";

	var $debug = false;

	var $conn = false;

	var $page = 1;

	var $max_pages = 0;

	var $offset = 0;

	

	/**

	 * Display the link to the first page

	 *

	 * @access public

	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'

	 * @return string

	 */

	function renderFirst($tag = 'Primeiro') {

		if ($this->total_rows == 0)

			return FALSE;

		

		if ($this->page == 1) {

			return "$tag ";

		} else {

			return '<a href="' . $this->php_self . '?page=1&' . $this->append . '">' . $tag . '</a> ';

		}

	}

	

	/**

	 * Display the link to the last page

	 *

	 * @access public

	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'

	 * @return string

	 */

	function renderLast($tag = 'Último') {

		if ($this->total_rows == 0)

			return FALSE;

		

		if ($this->page == $this->max_pages) {

			return $tag;

		} else {

			return ' <a href="' . $this->php_self . '?page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a>';

		}

	}

	

	/**

	 * Display the next link

	 *

	 * @access public

	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'

	 * @return string

	 */

	function renderNext($tag = '&gt;&gt;') {

		if ($this->total_rows == 0)

			return FALSE;

		

		if ($this->page < $this->max_pages) {

			return '<a href="' . $this->php_self . '?page=' . ($this->page + 1) . '&' . $this->append . '">' . $tag . '</a>';

		} else {

			return $tag;

		}

	}

	

	/**

	 * Display the previous link

	 *

	 * @access public

	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'

	 * @return string

	 */

	function renderPrev($tag = '&lt;&lt;') {

		if ($this->total_rows == 0)

			return FALSE;

		

		if ($this->page > 1) {

			return ' <a href="' . $this->php_self . '?page=' . ($this->page - 1) . '&' . $this->append . '">' . $tag . '</a>';

		} else {

			return " $tag";

		}

	}

	

	/**

	 * Display the page links

	 *

	 * @access public

	 * @return string

	 */

	function renderNav($prefix = '<span class="page_link">', $suffix = '</span>') {

		if ($this->total_rows == 0)

			return FALSE;

		

		$batch = ceil($this->page / $this->links_per_page );

		$end = $batch * $this->links_per_page;

		if ($end == $this->page) {

			//$end = $end + $this->links_per_page - 1;

		//$end = $end + ceil($this->links_per_page/2);

		}

		if ($end > $this->max_pages) {

			$end = $this->max_pages;

		}

		$start = $end - $this->links_per_page + 1;

		$links = '';

		

		for($i = $start; $i <= $end; $i ++) {

			if ($i == $this->page) {

				$links .= '<span class="active">'. $i .'</span>';

			} else {

				$links .= ' ' . $prefix . '<a href="' . $this->php_self . '?page=' . $i . '&' . $this->append . '">' . $i . '</a>' . $suffix . ' ';

			}

		}

		

		return $links;

	}

	

	/**

	 * Display full pagination navigation

	 *

	 * @access public

	 * @return string

	 */

	function renderFullNav() {

		// max number of pages

		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );

		if ($this->links_per_page > $this->max_pages) {

			$this->links_per_page = $this->max_pages;

		}

		if($this->max_pages == 1)

			return '';

	

		return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();

	}

	

	/**

	 * Set debug mode

	 *

	 * @access public

	 * @param bool $debug Set to TRUE to enable debug messages

	 * @return void

	 */

	function setDebug($debug) {

		$this->debug = $debug;

	}

}

?>

