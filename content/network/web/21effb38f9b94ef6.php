<h1>Hello ISAPI</h1>
<div class="date">01.01.2007</div>

<p>Hello ISAPI</p>
&#169; Delphi Web Development</p>
<p>На этой страничке вы узнаете как создать и запустить простейшее ISAPI приложение сервера.</p>
<p>1. Запустите Delphi, нажмите на меню File | New</p>
<p>2. В диалоговом окне New Items выберите Web Server Application и нажмите OK</p>
<p>3. Появится диалоговое окно New Web Server Application. Пункт ISAPI/NSAPI Dynamic Link Library выбран по умолчанию, поэтому просто нажмите OK.</p>
<p>4. Вы попали в интерактивную среду разработки ISAPI расширения сервера.</p>
<img src="/pic/clip0157.gif" width="282" height="92" border="0" alt="clip0157"></p>
<p>В вашем проекте содержится специальный модуль WebModule, он позволяет помещать в него различные компоненты и обеспечивает работу с ними.</p>
<p>5. Дважды щелкните мышкой на WebModule, появится окно Action Editor, предназначенное для создания и редактирования обработчиков событий ActionItem.</p>
<img src="/pic/clip0158.gif" width="327" height="151" border="0" alt="clip0158"></p>
<p>6. В диалоговом окне Action Editor нажмите кнопку Add New, при этом в окне Object Inspector отобразятся свойства и события созданного ActionItem.</p>
<p>7. Установите свойство Default созданного ActionItem равным true.</p>
<p>8. Создайте обработчик события OnAction для созданного ActionItem и напишите в него код:</p>
<p>    Response.Content := '&lt;html&gt;&lt;body&gt;Hello ISAPI!&lt;/body&gt;&lt;/html&gt;';</p>
<p>У вас должен получиться код приведенный в примере 1.</p>
<p>Пример 1</p>
<p>procedure TWebModule1.WebModule1WebActionItem1Action(Sender: TObject;</p>
<p>  Request: TWebRequest; Response: TWebResponse;</p>
<p>var Handled: Boolean);</p>
<p>begin</p>
<p>Response.Content := '&lt;html&gt;&lt;body&gt;Hello ISAPI!&lt;/body&gt;&lt;/html&gt;';</p>
<p>end;</p>
<p>9. Нажмите на меню File | Save All, выберите имена main.pas и helloisapi.dpr для файлов проекта и сохраните их на диск.</p>
<p>10. Нажмите на меню Project | Build helloisapi. Будет скомпилирован файл helloisapi.dll.</p>
<p>11. Поместите полученный файл в каталог для ISAPI DLL вашего веб сервера. Для IIS 4.0 это каталог /cgi-bin/. Проверьте установлено ли право execute на этот каталог в веб сервере и установите доступ на чтение и запуск для соответствующих пользователей в NTFS.</p>
<p>12.Запустите на выполнение ваше приложение, набрав в браузере полный URL. Например, если ваш сервер имеет URL http://localhost, вы положили DLL в каталог /cgi-bin/, то полный URL будет <a href="https://localhost/cgi-bin/helloisapi.dll. " target="_blank">https://localhost/cgi-bin/helloisapi.dll.</a></p>
