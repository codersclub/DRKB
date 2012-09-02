<h1>Использование интернет-функций Win32 API</h1>
<div class="date">01.01.2007</div>


<p>Internet так сильно вошел в нашу жизнь, что программа, так или иначе не использующая его возможности, обречена на "вымирание" почти как динозавры. Поэтому всех программистов, вне зависимости от квалификации и специализации так и тянет дописать до порой уж е готовой программы какой-то модуль для работы с Internet. Но тут и встает вопрос &#8211; как это сделать? Давайте рассмотрим, что нам предлагает среда Borland Delphi и Win32 API. </p>
<p>Во-первых, можно использовать компоненты с вкладки FastNet. Все они написаны фирмой NetMasters и поставляются без исходного кода. По многочисленным откликам различных разработчиков можно сказать, что большинство из них не выдерживает никакой критики, особ енно "отличились" компоненты для работы с почтой. Большинство проблем можно было бы исправить, но так как исходные тексты закрыты, то это вряд ли удастся. Даже если вы будете использовать такие вроде бы надежные компоненты как TNMHTTP, TNMFTP, то в случае распространения готовой программы перед вами встает проблема: для полноценной работы программа с этими компонентами требует наличия ряда динамических библиотек. Значит, их надо отыскать, потом поставлять вместе с приложением, копировать в системные папки … Короче говоря, все слишком запутано. </p>
<p>Если вам не требуется всей функциональности этих компонент, например, надо только реализовать функции GET или POST протокола HTTP, то можно поискать на сайтах с компонентами, вроде torry.ru &#8211; там обязательно сыщется много различных библиотек, по большей ч асти бесплатных, и с исходным кодом. </p>
<p>Но зачем нам что-то использовать, когда есть доступ к Win32 API ? Если приглядеться, то все эти компоненты всего лишь оболочка для вызова функций более низкого порядка. А раз так, то можно сразу их использовать. Кроме полного контроля над реализацией сете вых функций вы будете иметь и более компактный и быстрый код, так как устраняется прослойка между программой и API. Так что же такое Internet- функции Win32 API? </p>
<p>Все Internet- функции разбиты на категории: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>General Win32 Internet Functions - общие функции. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Automatic Dialing Functions &#8211; функции для автодозвона. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Uniform Resource Locator (URL) Functions &#8211; функции для работы с URL. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>FTP Functions &#8211; FTP- функции. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Gopher Functions - Gopher- функции. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>HTTP Functions - HTTP- функции. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Cookie Functions &#8211; Работа и управление файлами cookie. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Persistent URL Cache Functions - работа с офф-лайном и кешем. </td></tr></table></div>&nbsp;</p>
<p>Всего функций довольно много, около 80, но для средних приложений большинство из них не понадобится. Рассмотрим, что можно использовать из первой категории. Из всех функций наибольший практический интерес представляют следующие: </p>
<p>// InternetCheckConnection</p>
<p>// позволяет узнать, есть ли уже соединение с Internet.</p>
<p>// Синтаксис:</p>
<p>function InternetCheckConnection(lpszUrl: PAnsiChar; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwFlags: DWORD; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwReserved: DWORD): BOOL; stdcall;</p>

<p>Если нужно проверить, есть ли соединение по конкретному URL, то параметр lpszUrl должен содержать нужный URL; если интересует, есть ли соединение вообще, установите его в nil. DwFlags может иметь значение только FLAG_ICC_FORCE_CONNECTION. Он делает следующее: если первый параметр не nil, то происходит попытка пропинговать указанный хост. Если параметр lpszUrl установлен в nil и есть соединение с другим сервером, то пингуется эт от хост. </p>
<p>Последнее значение , dwReserved, зарезервировано, и должно быть установлено в 0. </p>
<p>К сожалению, я не проверял эту функцию, когда писал статью... а жаль... вот что получаеться: константа FLAG_ICC_FORCE_CONNECTION вообще не описана в Дельфи. более того - ее нет ни в Microsoft Visual C++ 5 (!!!!), VBasic 5 тоже! едва нашел в C++ Builder 5. </p>
<p>Вот описание - const FLAG_ICC_FORCE_CONNECTION $00000001 </p>
<p>Но! Даже с описанной константой ничего не работает так, как надо! Вот пример: </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
 h:boolean;
begin
 h:= wininet.InternetCheckConnection(nil,$00000001,0);
 if
  h = True then
   Label1.Caption:='Соеденение с сервером 127.0.0.1 установлено.'
 else
  if h = false
   then
     Label1.Caption:='Соеденения с сервером 127.0.0.1 нет.';
end;
</pre>


<p>Запускаю вместе с сервером - вроде должно пинговать его. Но первый раз функция показывает что соеденение есть несмотря на то, стоит ли сервер, или нет. Потом все время выдает false. Если кто из читателей может пролить некоторый свет на проблему этой функции, очень прошу написать мне. Благодарю Суркиза Максима, который впервые обратил мое внимание на проблему. </p>
<p>InternetOpen </p>
<p>Функция возвращает значение TRUE, если компьютер соединен с Internet, и FALSE - в противном случае. Для получения более подробной информации о причинах неудачного выполнения функции вызовите GetLastError, которая возвратит код ошибки. Например, значение E RROR_NOT_CONNECTED информирует нас, что соединение не может быть установлено или компьютер работает в off-line. </p>
<pre>
// Далее рассмотрим одну из самых важных функций. Ее вы будете
// использовать всякий раз, когда нужно получить доступ к любому
// из серверов – будь то HTTP, FTP или Gopher. Речь идет о InternetOpen .
 
//Синтаксис:
 
function InternetOpen(lpszAgent: PChar; 
                      dwAccessType: DWORD; 
                      lpszProxy, lpszProxyBypass: PChar; 
                      dwFlags: DWORD): HINTERNET; stdcall;
</pre>


<p>Параметры: </p>
<p>lpszAgent &#8211; строка символов, которая передается серверу и идентифицирует программное обеспечение, пославшее запрос. </p>
<p>dwAccessType - задает необходимые параметры доступа. Принимает следующие значения: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>INTERNET_OPEN_TYPE_DIRECT &#8211; обрабатывает все имена хостов локально. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>INTERNET_OPEN_TYPE_PRECONFIG &#8211; берет установки из реестра. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>INTERNET_OPEN_TYPE_PRECONFIG_WITH_NO_AUTOPROXY - берет установки из реестра и предотвращает запуск Jscript или Internet Setup (INS) файлов. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>INTERNET_OPEN_TYPE_PROXY &#8211; использование прокси-сервера. В случае неудачи использует INTERNET_OPEN_TYPE_DIRECT. LpszProxy &#8211; адрес прокси-сервера. Игнорируется только если параметр dwAccessType отличается от INTERNET_OPEN_TYPE_PROXY. LpszProxyBypass - спис ок имен или IP- адресов, соединяться с которыми нужно в обход прокси-сервера. В списке допускаются шаблоны. Так же, как и предыдущий параметр, не может содержать пустой строки. Если dwAccessType отличен от INTERNET_OPEN_TYPE_PROXY, то значения игнорируютс я, и параметр можно установить в nil. DwFlags &#8211; задает параметры, влияющие на поведение Internet- функций . Возможно применение комбинации из следующих разрешенных значений: INTERNET_FLAG_ASYNC, INTERNET_FLAG_FROM_CACHE, INTERNET_FLAG_OFFLINE. </td></tr></table></div><p>Функция инициализирует использование Internet- функций Win32 API. В принципе, ваше приложение может неоднократно вызывать эту функцию, например, для доступа к различным сервисам, но обычно ее достаточно вызвать один раз. При последующих вызовах других фун кций возвращаемый указатель HINTERNET должен передаваться им первым. Таким образом, можно дважды вызвать InternetOpen, и, имея два разных указателя HINTERNET, работать с HTTP и FTP параллельно. В случае неудачи, она возвращает nil, и для более детального анализа следует вызвать GetLastError. </p>
<pre>
 
// Непосредственно с этой функцией связанна и еще одна, не
// менее важная: InternetCloseHandle.
 
// InternetCloseHandle
 
// Синтаксис: 
 
function InternetCloseHandle(hInet: HINTERNET): BOOL; stdcall; 
</pre>
<p>Как единственный параметр, она принимает указатель, полученный функцией InternetOpen, и закрывает указанное соединение. В случае успешного закрытия сессии возвращается TRUE, иначе - FALSE. Если поток блокирует возможность вызова Wininet.dll, то другой пот ок приложения может вызвать функцию с тем же указателем, чтобы отменить последнюю команду и разблокировать поток. </p>
<p>// Мы уже установили соединение и знаем, как его закрыть. Теперь</p>
<p>// нам нужно соединиться с конкретным сервером, используя нужный</p>
<p>// протокол. В этом нам помогут следующие функции: InternetConnect </p>
<p>function InternetConnect (hInet: HINTERNET; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszServerName: PChar; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; nServerPort: INTERNET_PORT; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszUsername: PChar; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszPassword: PChar; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwService: DWORD; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwFlags: DWORD; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwContext: DWORD): HINTERNET; stdcall;</p>

<p>Функция открывает сессию с указанным сервером, используя протокол FTP, HTTP, Gopher. Параметры: </p>
<p>HInet &#8211; указатель, полученный после вызова InternetOpen. </p>
<p>LpszServerName &#8211; имя сервера, с которым нужно установить соединение. Может быть как именем хоста &#8211; domain.com.ua, так и IP- адресом &#8211; 134.123.44.66. </p>
<p>NServerPort &#8211; указывает на TCP/IP порт, с которым нужно соединиться. Для задания стандартных портов служат константы: NTERNET_DEFAULT_FTP_PORT (port 21), INTERNET_DEFAULT_GOPHER_PORT (port 70), INTERNET_DEFAULT_HTTP_PORT (port 80), INTERNET_DEFAULT_HTTPS_ PORT (port 443), INTERNET_DEFAULT_SOCKS_PORT (port 1080), INTERNET_INVALID_PORT_NUMBER &#8211; порт по умолчанию для сервиса, описанного в dwService. Стандартные порты для различных сервисов находятся в файле SERVICES в директории Windows. </p>
<p>LpszUsername &#8211; имя пользователя, желающего установить соединение. Если установлено в nil , то будет использовано имя по умолчанию, но для HTTP это вызовет исключение. </p>
<p>LpszPassword &#8211; пароль пользователя для доступа к серверу. Если оба значения установить в nil, то будут использованы параметры по умолчанию. </p>
<p>DwService &#8211; задает сервис, который требуется от сервера. Может принимать значения INTERNET_SERVICE_FTP, INTERNET_SERVICE_GOPHER, INTERNET_SERVICE_HTTP. </p>
<p>DwFlags - Задает специфические параметры для соединения. Например, если DwService установлен в INTERNET_SERVICE_FTP, то можно установить в INTERNET_FLAG_PASSIVE для использования пассивного режима. </p>
<p>Функция возвращает указатель на установленную сессию или nil в случае невозможности ее установки. </p>
<p>Итак, мы имеем связь с сервером, нужный нам порт открыт. Теперь следует открыть соответствующй файл. Для этого определена функция InternetOpenUrl. Она принимает полный URL файла и возвращает указатель на него. Кстати, перед ее использованием не нужно вызы вать InternetConnect. </p>
<p>InternetOpenUrl </p>
<p>Синтаксис: </p>
<p>function InternetOpenUrl(hInet: HINTERNET; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszUrl: PChar; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszHeaders: PChar; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwHeadersLength: DWORD; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwFlags: DWORD; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwContext: DWORD): HINTERNET; stdcall;</p>

<p>Параметры: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>HInet &#8211; указатель, полученный после вызова InternetOpen. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>LpszUrl &#8211; URL , до которого нужно получить доступ. Обязательно должен начинаться с указания протокола, по которому будет происходить соединение. Поддерживаются следующие протоколы - ftp:, gopher:, http:, https:. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>LpszHeaders &#8211; содержит заголовок HTTP запроса. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>DwHeadersLength &#8211; длина заголовка. Если заголовок nil, то можно установить значение &#8211;1, и длина будет вычислена автоматически. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>DwFlags &#8211; флаг, задающий дополнительные параметры перед выполнением функции. Вот некоторые его значения: INTERNET_ FLAG_EXISTING_CONNECT, INTERNET_FLAG_HYPERLINK, INTERNET_FLAG_IGNORE_REDIRECT_TO_HTTP, INTERNET_FLAG_NO_AUTO_REDIRECT, INTERNET_FLAG_NO_CACH E_WRITE, INTERNET_FLAG_NO_COOKIES. </td></tr></table></div>&nbsp;</p>
<p>Возвращается значение TRUE, если соединение успешно, или FELSE - в противном случае. Теперь можно спокойно считывать нужный файл функцией InternetReadFile. </p>
<p>InternetReadFile </p>
<p>Синтаксис: </p>
<p>function InternetReadFile(hFile: HINTERNET; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpBuffer: Pointer; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwNumberOfBytesToRead: DWORD; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; var lpdwNumberOfBytesRead: DWORD): BOOL; stdcall;</p>

<p>Параметры: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>HFile &#8211; указатель на файл, полученный после вызова функции InternetOpenUrl. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>LpBuffer &#8211; указатель на буфер, куда будут заноситься данные. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>DwNumberOfBytesToRead - число байт, которое нужно причитать. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>lpdwNumberOfBytesRead - содержит количество прочитанных байтов. Устанавливается в 0 перед проверкой ошибок. </td></tr></table></div>&nbsp;</p>
<p>Функция позволяет считывать данные, используя указатель, полученный в результате вызова InternetOpenUrl, FtpOpenFile, GopherOpenFile, или HttpOpenRequest. Так же, как и все остальные функции, возвращает TRUE или FALSE. После завершения работы функции нужно освободить указатель Hfile, вызвав InternetCloseHandle(hUrlFile) . </p>
<p>Вот, в принципе, и все об самых основных функциях. Для простейшего приложения можно определить примерно такой упрощенный алгоритм использования Internet- функций Win32 API взамен стандартным компонентов. HSession:= InternetOpen - открывает сессию. </p>
<p>HConnect:= InternetConnect - устанавливает соединение. </p>
<p>hHttpFile:=httpOpenRequest </p>
<p>HttpSendRequest - HttpOpenRequest и HttpSendRequest используются вместе для получения доступа к файлу по HTTP- протоколу. Вызов HttpOpenRequest создает указатель и определяет необходимые параметры, а HttpOpenRequest отсылает запрос HTTP серверу, используя эти параметры. </p>
<p>function HttpOpenRequest(hConnect: HINTERNET;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszVerb: PChar;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszObjectName: PChar;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszVersion: PChar;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszReferrer: PChar;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lplpszAcceptTypes: PLPSTR;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwFlags: DWORD;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwContext: DWORD): HINTERNET; stdcall;</p>
<p>function HttpSendRequest(hRequest: HINTERNET;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpszHeaders: PChar;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwHeadersLength: DWORD;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpOptional: Pointer;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwOptionalLength: DWORD): BOOL; stdcall;</p>
<p>// HttpQueryInfo &#8211; используется для получения информации о файле.</p>
<p>// Вызывается после вызова HttpOpenRequest.</p>
<p>function HttpQueryInfo(hRequest: HINTERNET; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dwInfoLevel: DWORD; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; lpvBuffer: Pointer; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; var lpdwBufferLength: DWORD; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; var lpdwReserved: DWORD): BOOL; stdcall;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>InternetReadFile - считывает нужный файл. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>InternetCloseHandle(hHttpFile) &#8211; освобождает указатель на файл. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>InternetCloseHandle(hConnect) - освобождает указатель на соединение. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>InternetCloseHandle(hSession) - освобождает указатель на сессию. </td></tr></table></div><p>Объем статьи не позволяет подробно рассмотреть все множество функций, предоставляемых Win32 API. Это введение показало вам только вершину айсберга, а дальше дело за вами &#8211; внутренний мир WinAPI очень богат и большинство из того, что обеспечивают сторонние компоненты, можно отыскать в его недрах. Удачи вам!</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
