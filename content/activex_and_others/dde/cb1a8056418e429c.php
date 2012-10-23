<h1>DDE (статья)</h1>
<div class="date">01.01.2007</div>


<p>Обзор</p>
<p>В данной статье приводятся основные факты о DDEML и показывается, как можно использовать DDE в программе. Предмет данной статьи технически сложен, однако библиотека Delphi упрощает наиболее трудные аспекты программирования DDE .</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;В статье предполагается, что читатель может знать очень мало о предмете. Цель статьи - научить его использовать концепцию DDE при создании приложений в среде Delphi.</p>
<p>Основы DDE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp;Аббревиатура DDEML обозначает Dynamic Data Exchange Management Library (библиотека управления динамическим обменом данными). DDEML это надстройка над сложной системой сообщений, называемой Dynamic Data Exchange (DDE). Библиотека, содержащая DDE била разработана для усиления возможностей первоначальной системы сообщений Windows.</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;DDE дает возможность&nbsp; перейти через рамки приложения и взаимодействовать с другими приложениями и системами Windows.</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Dynamic Data Exchange получило свое имя потому, что позволяет двум приложениям обмениваться данными (текстовыми, через глобальную память) динамически во время выполнения. Связь между двумя программами можно установить таким образом, что изменения в одном приложении будут отражаться во втором. Например, если Вы меняете число в электронной таблице, то во втором приложении данные обновятся автоматически и отобразят изменения. Кроме того, с помощью DDE можно из своего приложения управлять другими приложениями такими, как Word for Windows, Report Smith, Excel и др.</p>
<p>Надеюсь, что данное краткое вступление поможет понять что предмет обсуждения представляет интерес. Далее рассказывается, как использовать компоненты Delphi для построения DDE приложений.</p>
<p>Использование DDE</p>
<p>Приложение, получающее данные из другого приложения по DDE и/или управляющее другим приложением с помощью команд через DDE является DDE-клиентом. В этом случае второе приложение является DDE-сервером. Одно и то-же приложение может быть одновременно и сервером, и клиентом (например, MicroSoft Word). Построение DDE-серверов и DDE-клиентов удобно рассмотреть на примере, поставляемом с Delphi (каталог x:\delphi\demos\ddedemo). Сперва давайте рассмотрим логику работы примера. Для начала нужно откомпилировать проекты DDESRVR.DPR и DDECLI.DPR, после этого запустите программу DDECLI.EXE (DDE-клиент) и выберите пункт меню File|New Link. При этом должна запуститься программа DDESRVR (DDE-сервер). Если теперь редактировать текст в окне сервера, то изменения мгновенно отразятся в приложении-клиенте</p>
<p>Пример демонстрирует и другие возможности DDE: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- пересылка данных из клиента на сервер (Poke Data);&nbsp; наберите любой текст в правом окне DDE-клиента и нажмите кнопку Poke Data, этот текст появится в окне сервера. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- исполнение команд (макросов) на сервере; наберите любой текст в правом окне DDE-клиента и нажмите кнопку Exec Macro, DDE-сервер выдаст соответствующее диалоговое окно. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- установление связи через Clipboard; закройте оба DDE-приложения и запустите их заново, затем в DDE-сервере выберите пункт меню Edit|Copy, далее в клиенте выберите пункт меню Edit|Paste Link.</p>
<p>Теперь давайте рассмотрим эти демонстрационные программы с технической точки зрения и узнаем, каким образом в Delphi можно создать DDE-приложения. Начнем с DDE-сервера.</p>
<p>DDE-серверы</p>
<p>Для построении DDE-сервера в Delphi имеются два объекта, расположенные на странице System Палитры Компонент - TDdeServerConv и TDdeServerItem. Обычно в проекте используется один объект TDdeServerConv и один или более TDdeServerItem. Для получения доступа к сервису DDE-сервера, клиенту потребуется знать несколько параметров : имя сервиса (Service Name) - это имя приложения (обычно - имя выполняемого файла без расширения EXE, возможно с полным путем); Topic Name - в Delphi это имя компоненты TDdeServerConv;&nbsp; Item Name - в Delphi это имя нужной компоненты TDdeServerItem.</p>
<p>Назначение объекта TDdeServerConv - общее управление DDE и обработка запросов от клиентов на выполнение макроса. Последнее выполняется в обработчике события OnExecuteMacro, например, как это сделано в нашем случае:</p>
<pre>
procedure TDdeSrvrForm.doMacro(Sender: TObject;
          Msg: TStrings);
var
  Text: string;
begin
  Text := '';
  if Msg.Count &gt; 0 then Text := Msg.Strings[0];
  MessageDlg ('Executing Macro - ' + Text, mtInformation, 
              [mbOK], 0);
end;
</pre>

<p>Объект TDdeServerItem связывается с TDdeServerConv и определяет, что, собственно, будет пересылаться по DDE. Для этого у него есть свойства Text и Lines. (Text имеет то же значение, что и Lines[0].) При изменении значения этих свойств автоматически происходит пересылка обновленных данных во все приложения-клиенты, установившие связь с сервером. В нашем приложении изменение значения свойства Lines происходит в обработчике события OnChange компонента Edit1:</p>
<pre>
procedure TDdeSrvrForm.doOnChange(Sender: TObject);
 
begin
  if not FInPoke then
    DdeTestItem.Lines := Edit1.Lines;
end;
</pre>

<p>Этот же компонент отвечает за получение данных от клиента, в нашем примере это происходило при нажатии кнопки Poke Data, это выполняется в обработчике события OnPokeData:</p>
<pre>
procedure TDdeSrvrForm.doOnPoke(Sender: TObject);
begin
  FInPoke := True;
  Edit1.Lines := DdeTestItem.Lines;
  FInPoke := False;
end;
</pre>

<p>И последнее - установление связи через Clipboard. Для этого служит метод CopyToClipboard объекта TDdeServerItem. Необходимая информации помещается в Clipboard и может быть вызвана из приложения-клиента при установлении связи. Обычно, в DDE-серверах для этого есть специальный пункт меню Paste Special или Paste Link.</p>
<p>Итак, мы рассмотрели пример полнофункционального DDE-сервера, построенного с помощью компонент Delphi. Очень часто существующие DDE-серверы не полностью реализуют возможности DDE и предоставляют только часть сервиса. Например, ReportSmith позволяет по DDE только выполнять команды (макросы).</p>
<p>DDE-клиенты</p>
<p>Для построения DDE-клиента в Delphi используются два компонента TDDEClientConv и TDDEClientItem. Аналогично серверу, в программе обычно используется один объект TDDEClientConv и один и более связанных с ним TDDEClientItem.</p>
<p>TDDEClientConv служит для установления связи с сервером и общим управлением DDE-связью. Установить связь с DDE-сервером можно как во время дизайна, так и во время выполнения программы, причем двумя способами. Первый способ - заполнить вручную необходимые свойства компонента. Это DdeService, DdeTopic&nbsp; и ServiceApplication. Во время дизайна щелкните дважды на одно из первых двух свойств в Инспекторе Объектов</p>
<p>Укажите в диалоге имена DDE Service и DDE Topic. Эти имена можно узнать из документации по тому DDE-серверу, с которым Вы работаете. В случае DDE-сервера, созданного на Delphi, это имя программы (без .EXE) и имя объекта TDdeServerConv. Для установления связи через Clipboard в диалоге есть специальная кнопка Past Link. Ей можно воспользоваться, если Вы запустили DDE-сервер, сохранили каким-то образом информацию о связи и вошли в этот диалог. Например, если DDE-сервером является DataBase Desktop, то нужно загрузить в него какую-нибудь таблицу Paradox, выбрать любое поле и выбрать пункт меню Edit|Copy. После этого войдите в диалог и нажмите кнопку Paste Link. Поля в диалоге заполнятся соответствующим образом.</p>
<p>Свойство ServiceApplication заполняется в том случае, если в поле DDEService содержится имя, отличное от имени программы, либо если эта программа не находится в текущей директории. В этом поле указывается полный путь и имя программы без расширения (.EXE). При работе с Report Smith здесь нужно указать, например :&nbsp; C:\RPTSMITH\RPTSMITH</p>
<p>Данная информация нужна для автоматического запуска сервера при установлении связи по DDE, если тот еще не был запущен.</p>
<p>В нашей демо-программе связь устанавливается во время выполнения программы в пунктах меню File|New Link и Edit|Paste Link. В пункте меню File|New Link программно устанавливается связь по DDE с помощью соответствующего метода объекта TDdeServerConv, OpenLink делать не надо, поскольку свойство ConnectMode имеет значение ddeAutomatic:</p>
<pre>
procedure TFormD.doNewLink(Sender: TObject);
begin
  DdeClient.SetLink(AppName.Text, TopicName.Text);
  DdeClientItem.DdeConv := DdeClient;
  DdeClientItem.DdeItem := ItemName.Text;
end;
</pre>

<p>Здесь же заполняются свойства объекта TDdeClietItem.</p>
<p>В пункте меню Edit|Past Link программно устанавливается связь по DDE с использованием информации из Clipboard:</p>
<pre>
procedure TFormD.doPasteLink(Sender: TObject);
var
  Service, Topic, Item : String;
begin
  if  GetPasteLinkInfo (Service, Topic, Item) then
  begin
    AppName.Text       := Service;
    TopicName.Text     := Topic;
    ItemName.Text      := Item;
    DdeClient.SetLink (Service, Topic);
    DdeClientItem.DdeConv := DdeClient;
    DdeClientItem.DdeItem := ItemName.Text;
  end;
end;
</pre>

<p>После того, как установлена связь, нужно позаботиться о поступающих по DDE данных, это делается в обработчике события OnChange объекта TDdeClietItem:</p>
<pre>
procedure TFormD.DdeClientItemChange(Sender: TObject);
begin
  DdeDat.Lines := DdeClientItem.Lines;
end;
</pre>

<p>Это единственная задача объекта TDdeClientItem.</p>
<p>На объект TDdeClientConv возлагаются еще две задачи : пересылка данных на сервер и выполнение макросов. Для этого у данного объекта есть соответствующие методы. Посмотрим, как это можно было бы сделать. Выполнение макроса на сервере:</p>
<pre>
procedure TFormD.doMacro(Sender: TObject);
begin
  DdeClient.ExecuteMacroLines(XEdit.Lines, True);
end;
</pre>

<p>Пересылка данных на сервер:</p>
<pre>
procedure TFormD.doPoke (Sender: TObject);
begin
 DdeClient.PokeDataLines(DdeClientItem.DdeItem,XEdit.Lines);
end;
</pre>
<p>&nbsp;</p>
<p>Управление ReportSmith по DDE</p>
<p>В прилагаемом примере run-time версия ReportSmith выполняет команду, переданную по DDE. Имена DDE сервиса для ReportSmith и некоторых других приложений можно узнать в Справочнике в среде ReportSmith.</p>
<p>Перед запуском примера нужно правильно установить в свойстве ServiceApplication путь к run-time версии ReportSmith и в тексте программы в строке</p>
<p>Cmd:='LoadReport "c:\d\r\video\summary.rpt","@Repvar1=&lt;40&gt;,@Repvar2=&lt;'#39'Smith'#39'&gt;"'#0;</p>
<p>правильно указать путь к отчету.</p>
