// JavaScript Document
var XHR;	//定义一个全局对象
function createXHR(){  			//首先我们得创建一个XMLHttpRequest对象
	if(window.ActiveXObject){//IE的低版本系类
		XHR=new ActiveXObject('Microsoft.XMLHTTP');//之前IE垄断了整个浏览器市场，没遵循W3C标准，所以就有了这句代码。。。但IE6之后开始有所改观
	}else if(window.XMLHttpRequest){//非IE系列的浏览器，但包括IE7 IE8
		XHR=new XMLHttpRequest();
	}
}
function checkname(){
	var username=document.myform.user.value;
	createXHR();	
	XHR.open("GET","checkname.php?id="+username,true);//true:表示异步传输，而不等send()方法返回结果，这正是ajax的核心思想
	XHR.onreadystatechange=byhongfei;//当状态改变时，调用byhongfei这个方法，方法的内容我们另外定义
	XHR.send(null);
}
function byhongfei(){
	if(XHR.readyState == 4){//关于Ajax引擎对象中的方法和属性，可以参考我的另一篇博文：http://www.cnblogs.com/hongfei/archive/2011/11/29/2265377.html
		if(XHR.status == 200){	
			var textHTML=XHR.responseText;			
			document.getElementById('checkbox').innerHTML=textHTML;
		}
	}
}