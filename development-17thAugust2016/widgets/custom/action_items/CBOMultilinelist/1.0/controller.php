<?php
namespace Custom\Widgets\action_items;

class CBOMultilinelist extends \RightNow\Widgets\Multiline {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function freeBugger($data){
    	echo "<pre>";
		print_r($data);
		echo "</pre>";
    }
	
    function getData() {
        $format = array(
            'truncate_size' => $this->data['attrs']['truncate_size'],
            'max_wordbreak_trunc' => $this->data['attrs']['max_wordbreak_trunc'],
            'emphasisHighlight' => $this->data['attrs']['highlight'],
            'dateFormat' => $this->data['attrs']['date_format'],
            'urlParms' => \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']),
        );
        $filters = array('recordKeywordSearch' => true);
		
        $reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);

        \RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
	   
	    #################################################################################################
	    #########################Implementing Filter Functionality ######################################
	    #################################################################################################
		if($this->CI->session->getSessionData('incident_order_by')):
        $col_order=explode("_",$this->CI->session->getSessionData('incident_order_by'));
	    $col_id=(int)$col_order[0];
		$sort_order=($col_order[1])?(int)$col_order[1]:null;		
		$sort_dir=(int)$this->CI->session->getSessionData('incident_sort_by');
	    $filters=$this->CI->model('custom/ReportCustomModel')->setSortArgsColumn($filters,$col_id,$sort_order,$sort_dir);  
		endif;
		
        $results = $this->CI->model('custom/ReportCustomModel')->getDataHTML($this->data['attrs']['report_id'], $reportToken, $filters, $format)->result;
        //$this->freeBugger($results['headers']);
		
        if ($results['error'] !== null) {
            echo $this->reportError($results['error']);
        }
        $this->data['reportData'] = $results;
        if($this->data['attrs']['hide_when_no_results'] && count($this->data['reportData']['data']) === 0) {
            $this->classList->add('rn_Hidden');
        }
        $this->data['js'] = array(
            'filters' => $filters,
            'format' => $format,
            'r_tok' => $reportToken,
            'error' => $results['error']
        );
        $this->data['js']['filters']['page'] = $results['page'];
        //Fields to hide
        $this->data['js']['hide_columns'] = array_map('trim', explode(",", $this->data['attrs']['hide_columns']));
    }

    /**
     * Determines whether or not to show label based on widget attribute and header values.
     *
     * @param string $value The column's data (as opposed to its label/header).
     * @param array $header The array represented at $this->data['reportData']['headers'][index].
     * @return boolean
     */
    function showColumn($value, array $header) {
        if((!array_key_exists('visible', $header) || $header['visible'] === true)) {
            if($this->data['attrs']['hide_empty_columns'] && (is_null($value) || $value === '' || $value === false)) {
                return false;
            }
            if(is_array($this->data['js']['hide_columns']) && in_array($header['col_definition'], $this->data['js']['hide_columns'])) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Get value for the header span.
     *
     * @param array $header The array represented at $this->data['reportData']['headers'][index].
     * @return string
     */
    function getHeader(array $header) {
        return $header['heading'] ? $header['heading'] . ': ' : '';
    }
}
