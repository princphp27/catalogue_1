var ViewHelpers = (function(){
 return {

	showProgressBar : function(pHolder){
		$("#"+pHolder).html('<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="progress-text">0% Complete</span></div></div>')
	}
	,
	hideProgressBar : function(pHolder){
		$("#"+pHolder).html('');
	} 
	,
	updateProgressBar : function(pHolder,pWidth,pText){
		if(typeof pWidth !== 'undefined' && pWidth > 0){
			pWidth = parseInt(pWidth);
		}
		else{
			pWidth = 0;
		}
		if(typeof pText !== 'undefined' && pText !==""){
			pText = pText;
		}
		else{
			pText = "";
		}
		
		$("#"+pHolder+' .progress-bar').css('width',pWidth+'%');
		$("#"+pHolder+' .progress-bar').attr("aria-valuenow",pWidth);
		if(pText !=""){
			$("#"+pHolder+' .progress-text').text(pText);
		}
	}
	,
	showAppLoader : function(){
		$("#app_loader").show();
	}
	,
	hideAppLoader : function(){
		$("#app_loader").hide();
	}
	,
	showSpinner : function(pHolder){
		$("#"+pHolder).show();
	}
	,
	hideSpinner : function(pHolder){
		$("#"+pHolder).hide();
	}
	,
	notify : function(pType,pMessage){
		if(pType && pMessage){
			//pType = warn / success / info / error
			$.notify(pMessage,pType);
			//$.notify(pMessage,{autoHide:false, clickToHide: true, hideDuration:2000});
		}
	}
	,
	notifyCustom : function(pTitle,pMessage){
		
		// NOTE : create custom css class as livemsg and design as per your need
		
		if(pTitle!==undefined && pTitle!="" && pMessage!==undefined && pMessage!=""){
			if(screen.width < 600){
				$(".notifyjs-livemsg-base").parent().parent().parent().css({"top":"150px","right":"0px","max-height": "100vh","overflow": "auto","bottom": "150px"});	
			}
			else{
				$(".notifyjs-livemsg-base").parent().parent().parent().css({"bottom":"0px","right":"0px","max-height": "500px","overflow": "auto","margin-top": "20px !important"});	
			}
			$.notify.addStyle('livemsg', {
								  html: 
									"<div>" +
									  "<div class='clearfix'>" +
										"<div class='body'>"+
											"<div class='left'><h2><img src='/images/comment.png'/></h2></div>"+
											"<div class='right'>"+
												"<span class='livemsg-close'>x</span>" +
												"<div class='title' data-notify-html='title'/>" +
												"<div class='content' data-notify-html='content'/>" +
											"</div>" +	
										"</div>" +	
									  "</div>" +
									"</div>"
							});
							
			$.notify({title:pTitle,content:pMessage},{style:'livemsg',autoHide:false,clickToHide: false,position:'bottom right',showDuration:1000,hideDuration:1000});
			//listen for click events from this style
			$(document).on('click', '.notifyjs-livemsg-base .livemsg-close', function() {
			  //programmatically trigger propogating hide event
			  $(this).trigger('notify-hide');
			});
		}
		else{
			$(".notifyjs-wrapper").remove();
		}
	}
	,
	getIndustryOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getIndustryList();
		if(data.length>0){
			retVal +="<option value=''>Please select industry</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	},
	getIndexOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getIndexList();
		if(data.length>0){
			retVal +="<option value=''>No index</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	},
	getMarketOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getMarketList();
		if(data.length>0){
			retVal +="<option value='No market'>No market</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getSectorOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getSectorList();
		if(data.length>0){
			retVal +="<option value=''>Please select sector</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getSubSectorOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getSubSectorList();
		if(data.length>0){
			retVal +="<option value=''>Please select subsector</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getNumberTypeOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getNumberTypeList();
		if(data.length>0){
			retVal +="<option value=''>Please select number type</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getEmailTypeOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getEmailTypeList();
		if(data.length>0){
			//retVal +="<option value=''>Please select email type</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getWebsiteTypeOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getWebsiteTypeList();
		if(data.length>0){
			retVal +="<option value=''>Please select website type</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getAddressTypeOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getAddressTypeList();
		if(data.length>0){
			retVal +="<option value=''>Please select address type</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getCompanyLogoTypeOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getCompanyLogoTypeList();
		if(data.length>0){
			retVal +="<option value=''>Please select image type</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getCompanyLogoTypeByKey : function(pKey){
		var retVal ='';
		var data=DataHelpers.getCompanyLogoTypeList();
		if(data.length>0){
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pKey !=='undefined' && pKey!==null){
					if(pKey.toLowerCase() == data[i].key.toLowerCase()){
						retVal = data[i].value;
						break;
					}
				}
			}
		}
		return retVal;
	}
	,
	getContactTitleOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getContactTitleList();
		if(data.length>0){
			retVal +="<option value=''>Leave Empty</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected !==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getContactTypeOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getContactTypeList();
		if(data.length>0){
			retVal +="<option value=''>Please Select Contact Type</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected == data[i].key){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getOccupationOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getOccupationList();
		if(data.length>0){
			retVal +="<option value=''>Please Select Occupation</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected == data[i].key){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getContactImageTypeOptions : function(pSelected){
		var retVal ='';
		var data=DataHelpers.getContactImageTypeList();
		if(data.length>0){
			//retVal +="<option value=''>Please Select Image Type</option>";
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pSelected !=='undefined' && pSelected!==null){
					if(pSelected.toLowerCase() == data[i].key.toLowerCase()){
						selected = ' SELECTED';
					}
				}
				retVal +="<option value='"+data[i].key+"'"+selected+">"+data[i].value+"</option>";
			}
		}
		return retVal;
	}
	,
	getContactLogoTypeByKey : function(pKey){
		var retVal ='';
		var data=DataHelpers.getContactImageTypeList();
		if(data.length>0){
			for(i=0;i < data.length; i++){
				var selected= '';
				if(typeof pKey !=='undefined' && pKey!==null){
					if(pKey.toLowerCase() == data[i].key.toLowerCase()){
						retVal = data[i].value;
						break;
					}
				}
			}
		}
		return retVal;
	}
	,
	formatDate : function(pDate,pFormat){
		if(!pFormat || typeof pFormat == 'undefined'){
			pFormat = 'DD/MM/YY HH:mm';
		}
		var retval = '';
		if(pDate && pDate!=null && pDate!=""){
			retval = moment(pDate).format(pFormat);
		}
		return retval;
	}
	,
	formatDateMDY : function(pDate,pFormat){
		if(!pFormat || typeof pFormat == 'undefined'){
			pFormat = 'MM/DD/YY HH:mm';
		}
		var retval = '';
		if(pDate && pDate!=null && pDate!=""){
			retval = moment(pDate).format(pFormat);
		}
		return retval;
	}
 }
}());