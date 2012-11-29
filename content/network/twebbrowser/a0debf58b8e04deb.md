Свои настройки Proxy в программе с TWebBrowser
==============================================

::: {.date}
01.01.2007
:::

Сразу скажу, что эта статья - маленькая рекомендация тем, кто хочет
реализовать возможность работы TWebBrowser в своей программе с
настройками Proxy , которые отличаются от стандартных.\
В один прекрасный день мне понадобилось в программе периодически менять
Proxy и при этом пользоваться всем, что предоставляет IE. Лучший и
единственный выбор - TwebBrowser. При близком знакомстве с ним стало
понятно, что через Proxy он работать не может (вернее может, но берет
настройки из \"Свойств обозревателя\"). Перспектива постоянно менять
настройки реестра меня не прельщала . И как назло ни в одной крупной
конференции не было даже упоминания о возможности настройки Proxy в ходе
выполнения программы кроме изменения реестра (может плохо искал).\

Перерыв Fido-архивы и конференции Инета накаткнулся на win-функцию
UrlMkSetSessionOption. Вот к чему привели мои изыскания :

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

Вызывать функцию UrlMkSetSessionOption можно из любого места программы,
причем любое количество раз и с разными настройками.\

После вызова функции TWebBrowser будет работать через указанный прокси.
Еще раз повторюсь, настройки касаются только текущей сессии (программы
на момент выполнения ), общие настройки Windows не изменяются.

Андрей Попков

http://www.delphikingdom.com

Дополнительно:

INTERNET\_PROXY\_INFO Structure

Contains information that is supplied with the INTERNET\_OPTION\_PROXY

value to get or set proxy information on a handle obtained from

a call to the InternetOpen function.

Syntax

typedef struct {

   DWORD dwAccessType;

   LPCTSTR lpszProxy;

   LPCTSTR lpszProxyBypass;

} INTERNET\_PROXY\_INFO, \* LPINTERNET\_PROXY\_INFO;

Members

dwAccessType

       Unsigned long integer value that contains the access type.

       This can be one of the following values:

INTERNET\_OPEN\_TYPE\_DIRECT

       Internet accessed through a direct connection.

INTERNET\_OPEN\_TYPE\_PRECONFIG

       Applies only when setting proxy information.

INTERNET\_OPEN\_TYPE\_PROXY

       Internet accessed using a proxy.

lpszProxy

       Address of a string value that contains the proxy server list.

lpszProxyBypass

       Address of a string value that contains the proxy bypass list.

 \
