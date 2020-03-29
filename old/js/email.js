/*
     showEmail(linkid, cutid, n, d, x, nm, subj) displays a hyperlinked
     email address when viewed using a JavaScript-capable browser.

     Arguments:
         linkid: The id of the <a> element that should contain the
	         email address.
	 cutid: The id of an element to be removed, usually inside the
	        linkid element.
	 
	 n: The username of the mail address, with each character
	    xor'ed with x
	 d: Domainname of the address
	 nm: The full name of the recipient
	 subj: Subject line of the email (opt.)
     
     Example:
     
        <head>
	    ...
	    <script src="email.js" type="text/javascript"></script>
	</head>
	<body>
	...
	<a id="mailto" href="default.html" class="email">
	    <span id="cutme">
	    Turn on JavaScript to view the email address
	    </span>
	</a>
	<script type="text/javascript">
	    showEmail("mailto",  "cutme", "KDNX_", "cs.cornell.edu",
			42, "Andrew Myers");
	</script>

    Author: Andrew Myers, 2006
*/

function showEmail(linkid, n, d, x, rplc) {

	if($("."+linkid).length>0)
	{
		var links=$("."+linkid).get();
		var i;
		for(i=0;i<links.length;i++)
		{
			showEmailElem(links[i],n,d,x,rplc,"");
		}
		links=$(".join-"+linkid).get();
		var i;
		for(i=0;i<links.length;i++)
		{
			showEmailElem(links[i],n,d,x,false,"-request");
		}
	}
	else
	{
		var links=$("#"+linkid).get();
		for(i=0;i<links.length;i++)
		{
			showEmailElem(links[i],n,d,x,rplc,"");
		}
		links=$("#join-"+linkid).get();
		for(i=0;i<links.length;i++)
		{
			showEmailElem(links[i],n,d,x,false,"-request");
		}
	}
}
	
function showEmailElem(link, n, d, x, rplc,join)
{
    function xor_str(s, x) {
	var ret = "";
	var i;
	for (i = 0; i < s.length; i++) // 'for i in s' doesn't work in IE
	    ret += String.fromCharCode(s.charCodeAt(i) ^ x);
	return ret;
    }

    n = xor_str(n, x);
   
    //var text = document.createTextNode(n + "@" + d);
	 //changed by FM

    var kid = "";
	if(rplc==false)
	{
		kid=link.firstChild;
	}
	else
	{
		while(link.childNodes.length>0)
		{
			link.removeChild(link.firstChild);
		}
		kid=document.createElement("span");
		kid.appendChild(document.createTextNode(rplc));
		link.appendChild(kid);
	}
    kid.onmouseover = function () {
	//kid.parentNode.removeChild(kid);
	var url = "mailto:" + n + join + "@" + d; // + "%20(" + nm + ")"; --changed by FM
	if (join.length>0)
	{
	    url += "?Subject=join"
	}
	link.setAttribute("href", url);
	link.setAttribute("class", "email");
	kid.onmouseover = function () {}
    }
}
