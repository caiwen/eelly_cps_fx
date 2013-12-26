<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Google Weather API for Codeigniter
*
* @author Barna Szalai <sz.b@devartpro.com>
* @created 31/07/2012
* @version 1.0.0
* @license www.opensource.org/licenses/MIT
*/

class Gweather 
{
	private $_ci;
	private $_lang = 'en';
	private $_temp = 'F';	// C or F
	private $_api_url = 'http://www.google.com/ig/api?weather=';

	public function __construct()
	{
		$this->_ci =& get_instance();

		$this->_ci->load->spark('curl/1.2.1');
		$this->_ci->load->helper('file');
		$this->_ci->load->helper('text');

		$this->_ci->load->config('gweather');
		$this->_lang = (! $this->_ci->config->item('gw_lang')) ? $this->_lang : $this->_ci->config->item('gw_lang');
		$this->_temp = (! $this->_ci->config->item('gw_temp')) ? $this->_temp : $this->_ci->config->item('gw_temp');		

		log_message('debug', 'Gweather library started.');
	}

	public function get_weather($locations)
	{
		if( ! is_array($locations) || empty($locations))
		{
			return FALSE;
		}

		foreach($locations as $country => $cities)
		{
			foreach($cities as $city)
			{
				$location = strtolower($city.','.$country);

				$xml = $this->_ci->curl->simple_get($this->_api_url.trim(urlencode($location)).'&hl='.$this->_lang);

				if(count($this->_ci->curl->error_code))
				{
					log_message('error', 'Error in Gweather library: '.$this->_ci->curl->error_string.' - cURL error code:'.$this->_ci->curl->error_code);
					throw new Exception($this->_ci->curl->error_string.' - cURL error code:'.$this->_ci->curl->error_code);			
				}

				$xml = iconv("ISO-8859-1", "UTF-8//TRANSLIT", $xml);
                $xml = simplexml_load_string($xml);
	            
                $finformation = $xml->xpath("/xml_api_reply/weather/forecast_information");
                
                $data[$country][$city]['information'] = array(
					'city'        => $finformation[0]->city['data'],
					'date'        => $finformation[0]->forecast_date['data'],
					'unit_system' => $finformation[0]->unit_system['data']
                );               

                $cconditions = $xml->xpath("/xml_api_reply/weather/current_conditions");

                $data[$country][$city]['current'] = array(
					'condition'      => $cconditions[0]->condition['data'],
					'temp'           => ($this->_temp === 'C') ? $cconditions[0]->temp_c['data'] : $cconditions[0]->temp_f['data'],
					'humidity'       => $cconditions[0]->humidity['data'],
					'icon'           => 'http://www.google.com'.$cconditions[0]->icon['data'],
					'wind_condition' => $cconditions[0]->wind_condition['data']
                );

                $fconditions = $xml->xpath("/xml_api_reply/weather/forecast_conditions");

                foreach($fconditions as $fcondition)
                {
                	$data[$country][$city]['forecast'][] = array(						
						'day_of_week' => $fcondition->day_of_week['data'],
						'low'         => $fcondition->low['data'],
						'high'        => $fcondition->high['data'],
						'condition'   => $fcondition->condition['data'],
						'icon'        => 'http://www.google.com'.$fcondition->icon['data']
                	);
                }                
			}
		}		

		return $data;
	}
}