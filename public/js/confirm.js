function Confirm (text, url_true)
{
	var r = confirm(text);
	if (r==true)
 	{
		document.location.href = url_true;
 	}
}