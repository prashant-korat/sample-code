var value,i,rule,rule_name,element_id,message,extraparams,return_flag;
function is_blank(element_id,def_val) 
{
//	value=$('#'+element_id).val();	
	value = element_id.val();	

	if($.trim(value).length > 0 && value != def_val)
		return true;
	else
		return false;
}

function EmailValidate(element_id) 
{
	value = element_id.val();
	var ret_flag= /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
	if(ret_flag)
		return false;
	else
		return true;
}


function UrlValidate(element_id) 
{
	value = element_id.val();
	var ret_flag= /(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
	if(ret_flag)
		return false;
	else
		return true;
}

function NumberValidate(element_id) 
{
	value = element_id.val();
	if(isNaN(value))
		return true;
	else
		return false;
}

function DateValidate(element_id) 
{
	currVal = element_id.val();	
	if(currVal == '')
		return false;
	
	/*//Declare Regex  
	var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
	//var rxDatePattern = "^(\d{1,2}).(\d{1,2}).(\d{4})$"; 		  
	var dtArray = currVal.match(rxDatePattern); // is format OK?			
	if (dtArray == null)
		return true;*/
	dtArray=currVal.split('/');
	//Checks for mm/dd/yyyy format.
	dtMonth = dtArray[0];
	dtDay= dtArray[1];
	dtYear = dtArray[2];
	
	if (dtMonth < 1 || dtMonth > 12)
	  return true;
	else if (dtDay < 1 || dtDay> 31)
	  return true;
	else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
	  return true;
	else if (dtMonth == 2)
	{
	 var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
	 if (dtDay> 29 || (dtDay ==29 && !isleap))
		  return true;
	}
	return false;		
}

function is_matched(element1_id,element2_id)
{
	if(element2_id.val() != element1_id.val())
		return true;
	else
		return false;
}

function RangeValidate(element_id,range)
{
	var value_length = element_id.val().length;
	range_rule=range.split('-');	
	if(value_length>=range_rule[0] && value_length<=range_rule[1])
		return false;
	else
		return true;
}

function LengthValidate(element_id,length)
{
	var value_length = element_id.val().length;
	if(value_length != length)
		return true;
	else
		return false;
}

function max_val(element_id,length)
{
	var value = element_id.val();
	if(value_length < length)
		return true;
	else
		return false;
}

function SetRule(ValidationRules)
{	
	if(ValidationRules.length > 0)
	{
		for(var i=0;i<ValidationRules.length;i++)
		{
//			rule=ValidationRules[i].split('||');
			rule_name = ValidationRules[i].rule_name;
			element_id = ValidationRules[i].element_id;
			message = ValidationRules[i].message;
			extraparams = ValidationRules[i].extraparams?ValidationRules[i].extraparams:'';

//			return true;
//			rule_name=rule[0];
//			element_id=rule[1];
//			message=rule[2];
//			extraparams=rule[3]?rule[3]:'';
			return_flag=false;		
			switch(rule_name)
			{
				case 'is_blank':
						return_flag=is_blank(element_id, extraparams);
						break;
				
				case 'EmailValidate':
						if(extraparams == 'required')
							return_flag=is_blank(element_id,'');
						
						if(!is_blank(element_id,''))
							return_flag=EmailValidate(element_id);						
						break;
				
				case 'UrlValidate':
						if(extraparams == 'required')
							return_flag=is_blank(element_id,message,'');
						if(!is_blank(element_id,''))
							return_flag=UrlValidate(element_id);

						break;
				
				case 'NumberValidate':
						if(extraparams == 'required')
							return_flag=is_blank(element_id,'');
						if(!is_blank(element_id,''))
							return_flag=NumberValidate(element_id);

						break;
				
				case 'DateValidate':
						if(extraparams == 'required')
							return_flag=is_blank(element_id,'');
						if(!is_blank(element_id,''))
							return_flag=DateValidate(element_id);
						break;

				case 'is_matched':
						return_flag=is_matched(element_id,extraparams);
						break;
						
				case 'RangeValidate':
						return_flag=RangeValidate(element_id,extraparams);						
						break;
						
				case 'LengthValidate':
						return_flag=LengthValidate(element_id,extraparams);						
						break;
						
				case 'max_val':		
						return_flag = max_val(element_id,extraparams);						
						break;
						
				case 'aa':		
						return_flag = max_val(element_id,extraparams);						
						break;
			}
			if(!return_flag)
			{
				element_id.focus();
				return {obj:element_id,msg:message};			
			}			
		}
		return false;
	}
	else
		return false;
}
function HideMess()
{
	setTimeout(function(){
			$('.alert').slideUp();
			$('.alert-error').slideUp();
		}, 1000);		
}	
