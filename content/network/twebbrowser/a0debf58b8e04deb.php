<h1>Свои настройки Proxy в программе с TWebBrowser</h1>
<div class="date">01.01.2007</div>

Сразу скажу, что эта статья - маленькая рекомендация тем, кто хочет реализовать возможность работы TWebBrowser в своей программе с настройками Proxy , которые отличаются от стандартных. <br>
В один прекрасный день мне понадобилось в программе периодически менять Proxy и при этом пользоваться всем, что предоставляет IE. Лучший и единственный выбор - TwebBrowser. При близком знакомстве с ним стало понятно, что через Proxy он работать не может (вернее может, но берет настройки из "Свойств обозревателя"). Перспектива постоянно менять настройки реестра меня не прельщала . И как назло ни в одной крупной конференции не было даже упоминания о возможности настройки Proxy в ходе выполнения программы кроме изменения реестра (может плохо искал).<br>
<p>Перерыв Fido-архивы и конференции Инета накаткнулся на win-функцию UrlMkSetSessionOption. Вот к чему привели мои изыскания :</p>
<pre>
....
uses ... urlmon, wininet ...
....
var PIInfo : PInternetProxyInfo;
...     
New (PIInfo) ;
 //  Изменение  настроек ПРОКСИ 
PIInfo^.dwAccessType := INTERNET_OPEN_TYPE_PROXY ;  //  Тип доступа в интернет - через Proxy сервер 
PIInfo^.lpszProxy := PChar('some.proxy:someport');   //  указать  прокси  напр. 195.43.67.33:8080 
PIInfo^.lpszProxyBypass := PChar('');  //  Список адресов, доступ к которым возможен минуя Proxy сервер 
 
UrlMkSetSessionOption(INTERNET_OPTION_PROXY, piinfo, SizeOf(Internet_Proxy_Info),0);  
.... 
Dispose (PIInfo) ; 
.... 
</pre>
<p>Вызывать функцию UrlMkSetSessionOption можно из любого места программы, причем любое количество раз и с разными настройками. <br>
<p>После вызова функции TWebBrowser будет работать через указанный прокси. Еще раз повторюсь, настройки касаются только текущей сессии (программы на момент выполнения ), общие настройки Windows не изменяются.</p>
Андрей Попков</p>
http://www.delphikingdom.com</p>
<p>Дополнительно:</p>
<p>INTERNET_PROXY_INFO Structure</p>
<p>Contains information that is supplied with the INTERNET_OPTION_PROXY</p>
<p>value to get or set proxy information on a handle obtained from</p>
<p>a call to the InternetOpen function.</p>
<p>Syntax</p>
<p>typedef struct {</p>
<p> &nbsp;&nbsp; DWORD dwAccessType;</p>
<p> &nbsp;&nbsp; LPCTSTR lpszProxy;</p>
<p> &nbsp;&nbsp; LPCTSTR lpszProxyBypass;</p>
<p>} INTERNET_PROXY_INFO, * LPINTERNET_PROXY_INFO;</p>
<p>Members</p>
<p>dwAccessType</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Unsigned long integer value that contains the access type.</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;This can be one of the following values:</p>
<p>INTERNET_OPEN_TYPE_DIRECT</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Internet accessed through a direct connection.</p>
<p>INTERNET_OPEN_TYPE_PRECONFIG</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Applies only when setting proxy information.</p>
<p>INTERNET_OPEN_TYPE_PROXY</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Internet accessed using a proxy.</p>
<p>lpszProxy</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Address of a string value that contains the proxy server list.</p>
<p>lpszProxyBypass</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Address of a string value that contains the proxy bypass list.</p>
<p>&nbsp;<br>

