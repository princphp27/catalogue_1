<?php
use App\Models\Category;

function my_asset($path, $secure = null){
	return app('url')->asset("public/".$path, $secure);
}
function getUserImageUrl($pImageName){
	
	if(isset($pImageName) && $pImageName!="" && Storage::disk('public')->exists('uploads/user_images/'.$pImageName)){
		return Storage::disk('public')->url('uploads/user_images/'.$pImageName);
	}
	else{
		return Storage::disk('public')->url('uploads/user.jpg');
	}
}
function getStoreImageUrl($pImageName){
	
	if(isset($pImageName) && $pImageName!="" && Storage::disk('public')->exists('uploads/store_images/'.$pImageName)){
		return Storage::disk('public')->url('uploads/store_images/'.$pImageName);
	}
	else{
		return Storage::disk('public')->url('uploads/image-not-available.png');
	}
}
function getCategoryImageUrl($pImageName){
	if(isset($pImageName) && $pImageName!="" && Storage::disk('public')->exists('uploads/category_images/'.$pImageName)){
		return Storage::disk('public')->url('uploads/category_images/'.$pImageName);
	}
	else{
		return Storage::disk('public')->url('uploads/image-not-available.png');
	}
}
function getCategoryBannerImageUrl($pImageName){
	if(isset($pImageName) && $pImageName!="" && Storage::disk('public')->exists('uploads/category_banners/'.$pImageName)){
		return Storage::disk('public')->url('uploads/category_banners/'.$pImageName);
	}
	else{
		return Storage::disk('public')->url('uploads/image-not-available.png');
	}
}
function getProductImageUrl($pImageName){
	if(isset($pImageName) && $pImageName!="" && Storage::disk('public')->exists('uploads/product_images/'.$pImageName)){
		return Storage::disk('public')->url('uploads/product_images/'.$pImageName);
	}
	else{
		return Storage::disk('public')->url('uploads/image-not-available.png');
	}
}
function getProductBannerImageUrl($pImageName){
	if(isset($pImageName) && $pImageName!="" && Storage::disk('public')->exists('uploads/product_banners/'.$pImageName)){
		return Storage::disk('public')->url('uploads/product_banners/'.$pImageName);
	}
	else{
		return Storage::disk('public')->url('uploads/image-not-available.png');
	}
}

function smart_wordwrap($string, $width = 75, $break = "\n") {
    // split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        if (false !== strpos($word, ' ')) {
            // normal behaviour, rebuild the string
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);

            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;

            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}
function displayLimitedWords($string, $count = 20) {
   
	$original_string = $string;
	$words = explode(' ', $original_string);

	if (count($words) > $count){
	$words = array_slice($words, 0, $count);
	$string = implode(' ', $words);
	}

	return $string;
}
function formatBookingStatus($pStatus,$pText){
	$retVal ='';
	if(isset($pText) && $pText!=""){
		switch($pStatus){
			case '0':
				$retVal='<span class="badge badge-dark">'.$pText.'</span>';
			break;
			case '1':
				$retVal='<span class="badge badge-success">'.$pText.'</span>';
			break;
			case '2':
				$retVal='<span class="badge badge-danger">'.$pText.'</span>';
			break;
			case '3':
				$retVal='<span class="badge badge-info">'.$pText.'</span>';
			break;
			case '4':
				$retVal='<span class="badge badge-primary">'.$pText.'</span>';
			break;
			default:
				$retVal='<span class="badge badge-dark">'.$pText.'</span>';
			break;
		}
	}
	return $retVal;
}
function formatDate($pDate,$pFormat="d/m/Y"){
	if(isset($pDate) && $pDate!=""){
		$pDate = date($pFormat,strtotime($pDate));
	}
	return $pDate;
}
function getMobileCountryCodeList(){
	return array(
		'966'=>'+966 (Saudi Arab)',
		'968'=>'+968 (Oman)',
		'965'=>'+965 (Kuwait)',
		'967'=>'+967 (Yemen)',
		'971'=>'+971 (U.A.E)',
		'974'=>'+974 (Qatar)',
		'973'=>'+973 (Bahrain)',
		'91'=>'+91 (India)',
	);
}
function getMobileCountryCodeOptions($pSelected=""){
	$options = '';
	$codes = getMobileCountryCodeList();
	if(isset($codes) && is_array($codes) && count($codes) > 0){
		foreach($codes as $key=>$val){
			$selected='';
			if(isset($pSelected) && $pSelected==$key){
				$selected=' SELECTED';
			}
			$options.='<option value="'.$key.'"'.$selected.'>'.$val.'</option>';
		}
	}
	return $options;
}
function getCategoryOptions($pSelected=""){
	$retVal = '';
	$dataList = Category::where('parent',0)->where('client_id',Auth::user()->id)->get();
     //dd($dataList);
	if(isset($dataList) && count($dataList) > 0){
		foreach($dataList as $data){
			$selected = '';
			if(isset($pSelected) && $pSelected!="" && $pSelected == $data->id){
				$selected = ' SELECTED';
			}
			$retVal.='<option value="'.$data->id.'"'.$selected.'>'.$data->name.'</option>';
			//dd($retVal);
		}
	}
	return $retVal;
}
function getSubCategoryOptions($pParentId,$pSelected=""){
	$retVal = '';
	//dd($pParentId);
	if(isset($pParentId) && $pParentId!=""){
		$dataList = Category::where('parent',$pParentId)->where('client_id',Auth::user()->id)->get();
		if(isset($dataList) && count($dataList) > 0){
			foreach($dataList as $data){
				$selected = '';
				if(isset($pSelected) && $pSelected!="" && $pSelected == $data->id){
					$selected = ' SELECTED';
				}
				$retVal.='<option value="'.$data->id.'"'.$selected.'>'.$data->name.'</option>';
			}
		}
	}
	return $retVal;
}