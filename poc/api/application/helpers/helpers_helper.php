<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Input */

if ( ! function_exists('post'))
{
	function post($str = '')
	{
		$CI =& get_instance();
		
		//return $CI->db->escape_str($CI->input->post($str));
		return $CI->input->post($str);
	}
}

if ( ! function_exists('get'))
{
	function get($str = '')
	{
		$CI =& get_instance();
		return $CI->input->get($str);
	}
}


/* load  */

if ( ! function_exists('model'))
{
	function model($model = '', $alias = '')
	{
		$CI =& get_instance();
	
		if($alias){
			$CI->load->model($model, $alias);
			return $CI->$alias;
		}else{
			$CI->load->model($model);
			$modelName = explode('/', $model);
			$modelName = $modelName[count($modelName) - 1];
			return $CI->$modelName;
		}
	}
}

if ( ! function_exists('library'))
{
	function library($lib = '')
	{
		$libName = explode('/', $lib);
		
		$CI =& get_instance();
		$CI->load->library($lib);
		
		$libName = $libName[count($libName) - 1];
		return $CI->{$libName};
	}
}

if ( ! function_exists('helper'))
{
	function helper($helper = '')
	{
		$CI =& get_instance();
		$CI->load->helper($helper);
	}
}

/* View */

if ( ! function_exists('view'))
{
	function view($view = '', $data = '')
	{
		$CI =& get_instance();
		
		if(! isset($data)) {
			return $CI->load->view($view);
		}
		return $CI->load->view($view, $data);
	}
}

if(!function_exists('jumlahSama')){
	function jumlahSama(){
		$numArg 	= func_num_args();
		$flagSama 	= true;
		
		if($numArg){
			$lastArg = func_get_arg(0);
			for($i = 1; $i < $numArg; $i++){
				$currArg = func_get_arg(1);
				if(!is_array($currArg) || count($lastArg) != count($currArg)){
					// Lansung cabut, udah gak sama
					return false;
				}
				
				$lastArg = $currArg;
			}
		}else{
			// Return True aja soalnya cuma 1 atau gak ada sama sekali
			return true;	
		}
		
		return true;
	}
}

if(!function_exists('formatUang')){
	function formatUang($n){
		$n = str_replace('.', '', $n);
		$n = str_replace(',', '.', $n);
		
		return number_format($n, 0, ',', '.');	
	}
}


if(!function_exists('memUsage')){
	function memUsage($var){
		$before = memory_get_usage();
		$clone = $var;
		$after = memory_get_usage();
		
		return $after - $before;
	}
}

if(!function_exists('gridHeader')){
	function gridHeader($field, $label, $cfg){
		$urlAdd = ($cfg->keyword ? "/kw:$cfg->keyword" : '').($cfg->searchField ? "/sf:$cfg->searchField" : '');
		
		if($cfg->sortField == $field){
			if($cfg->sortMethod == 'ASC'){
				$url = "$cfg->base/ob:$field@DESC".$urlAdd;
			}else{
				$url = "$cfg->base/ob:$field@ASC".$urlAdd;
			}
			
			$class = strtolower($cfg->sortMethod);
		}else{
			$url = "$cfg->base/ob:$field@ASC".$urlAdd;
			$class = '';
		}
	?>
	<a href="<?php echo site_url($url) ?>" class="<?php echo $class ?>"><?php echo $label ?></a>
	<?php
	}
}

if(!function_exists('pretty_print_json')){
	function pretty_print_json( $json )
	{
		$result = '';
		$level = 0;
		$in_quotes = false;
		$in_escape = false;
		$ends_line_level = NULL;
		$json_length = strlen( $json );
	
		for( $i = 0; $i < $json_length; $i++ ) {
			$char = $json[$i];
			$new_line_level = NULL;
			$post = "";
			if( $ends_line_level !== NULL ) {
				$new_line_level = $ends_line_level;
				$ends_line_level = NULL;
			}
			if ( $in_escape ) {
				$in_escape = false;
			} else if( $char === '"' ) {
				$in_quotes = !$in_quotes;
			} else if( ! $in_quotes ) {
				switch( $char ) {
					case '}': case ']':
						$level--;
						$ends_line_level = NULL;
						$new_line_level = $level;
						break;
	
					case '{': case '[':
						$level++;
					case ',':
						$ends_line_level = $level;
						break;
	
					case ':':
						$post = " ";
						break;
	
					case " ": case "\t": case "\n": case "\r":
						$char = "";
						$ends_line_level = $new_line_level;
						$new_line_level = NULL;
						break;
				}
			} else if ( $char === '\\' ) {
				$in_escape = true;
			}
			if( $new_line_level !== NULL ) {
				$result .= "\n".str_repeat( "\t", $new_line_level );
			}
			$result .= $char.$post;
		}
	
		return $result;
	}
}