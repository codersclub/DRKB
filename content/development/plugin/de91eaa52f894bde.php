<h1>Принцип создания плагинов в Delphi</h1>
<div class="date">01.01.2007</div>



<p>Иногда нужные мысли приходят после того, как программа сдана заказчику. Для этого придумали плугины. Плугины - это простая dll библиотека, в которой обязательно присутствует ряд процедур и функций, которые выполняют определенные разработчиком действия, например (из моей практики) : function PluginType : PChar; - функция, определяющая назначение плугина. function PluginName : PChar; - функция, которая возвращает название плугина. Это название будет отоброжаться в меню. function PluginExec(AObject:ТТип) : boolean; - главный обработчик, выполняет определённые действия и возвращает TRUE; и ещё, я делал res файл с небольшим битмапом и компилировал его вместе с плугином, который отображался в меню соответствующего плугина. Откомпилировать res фaйл можно так: 1. создайте файл с расширением *.rc 2. напишите в нём : bitmap RCDATA LOADONCALL 1.bmp где bitmap - это идентификатор ресурса RCDATA LOADONCALL - тип и параметр 1.bmp - имя локального файла для кампиляций 3. откомпилируйте этот файл программой brcc32.exe, лежащей в папке ...\Delphi5\BIN\ .</p>

<p>Загрузка плугина</p>

<p>Перейдём к теоретической части.</p>
<p>раз плугин это dll значит её можно подгрузить следующими способами:</p>
<p>1. Прищипыванием её к программе!</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; function PluginType : PChar; external 'myplg.dll';</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;//в таком случае&nbsp; dll должна обязательно лежать возле exe и мы не можем передать</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;туда конкретное имя! не делать же все плугины одного имени! это нам не подходит.</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Программа просто не загрузится без этого файла! Выдаст сообщение об ошибке. Этот способ</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;может подойти для поддержки обновления&nbsp; вашей программы!</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>2. Динамический</p>
<p> &nbsp; это оэночает, что мы грузим её так, как нам надо! Вот пример:</p>

<pre>
   var       
    PluginType: function: PChar; // объявляем процедурный тип функции из плугина
    PlugHandle: THandle; //объявляем переменную типа хендл в которую мы занесём хендл плугина procedure Button1Click(Sender: TObject);
 begin
  PlugHandle := LoadLibrary('MYplg.DLL'); //грузим плугин
  if PlugHandle &lt;&gt; 0  then //Получилось или нет??
   begin
    @PluginType := GetProcAddress(plugHandle,'Plugintype'); // ищем функцию в dll
    if @PluginType &lt;&gt; nil then ShowMessage(PluginType); //вызываем функцию
   end;
  FreeLibrary(LibHandle);//освобождаем библиотеку
end;
</pre>


<p>Вот этот способ больше подходит для построения плугинов!</p>

<p>Функции:</p>
<p> function LoadLibrary(lpLibFileName : Pchar):THandle;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;//как вы поняли&nbsp; загружает dll и возвращает её хендл</p>
<p> function GetProcAddress(Module: THandle; ProcName: PChar): TFarProc</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;// пытается найти обработчик в переданной ей хендле dll,</p>
<p> при успешном выполнении возвращает указатель обработчика.</p>
<p> function FreeLibrary(LibModule: THandle); //освобождает память, занитую dll</p>

<p>Самое сложное в построений плугинов, это не реализация всего кода, а придусмотрение всего, для чего в программе могут они понадобиться! То есть придусмотреть все возможные типы плугинов! А это не так просто.</p>

<p>Вот полноценный пример реализации простой программы для поддержки плугинов...</p>

<p>Исходный текст модуля программы:</p>
<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, menus,
  Grids, DBGrids;
 
type
  TForm1 = class(TForm)
    MainMenu1: TMainMenu;
    N1231: TMenuItem; //меню,  которое будет содержать ссылки на плугины 
    procedure FormCreate(Sender: TObject);
  private
   PlugList : TStringList; //лист, в котором мы будем держать имена файлов плугинов
   procedure LoadPlug(fileName : string); //Процедура загрузки плугина
   procedure PlugClick(sender : TObject);  
        //Процедура инициализации и выполнения плугина
    { Private declarations }
  public
    { Public declarations }
  end;
 
var                               
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
</pre>


<p>Процедура загрузки плугина. Здесь мы загружаем, вносим имя dll в список</p>
<p>и создаём для него пункт меню; загружаем из dll картинку для пункта меню</p>

<pre>
procedure TForm1.LoadPlug(fileName: string);
 var
  PlugName : function : PChar; 
        //Объявление функции, которая будет возвращать имя плугина
  item : TMenuItem;  //Новый пункт меню
  handle : THandle;  //Хендл dll
  res :TResourceStream;  //Объект, с помощью которого мы загрузим картинку из dll
begin
  item := TMenuItem.create(mainMenu1);  //Создаём новый пункт меню
  handle :=  LoadLibrary(Pchar(FileName));  //загружаем dll
  if handle &lt;&gt; 0 then  //Если удачно, то идём дальше...
   begin
    @PlugName := GetProcAddress(handle,'PluginName');  //грузим процедуру
    if @PlugName &lt;&gt; nil then item.caption := PlugName else  
        //Если всё прошло, идём дальше...
     begin
      ShowMessage('dll not identifi ');  //Иначе, выдаём сообщение об ошибке 
      Exit;  //Обрываем процедуру
     end;
   PlugList.Add(FileName);  //Добавляем название dll
  res:= TResourceStream.Create(handle,'bitmap',rt_rcdata);  //Загружаем ресурс из dll
  res.saveToFile('temp.bmp'); res.free;  //Сохраняем в файл 
  item.Bitmap.LoadFromFile('Temp.bmp');  //Загружаем в пункт меню
  FreeLibrary(handle);  //Уничтожаем dll
  item.onClick:=PlugClick;  //Даём ссылку на обработчик
  Mainmenu1.items[0].add(item);  //Добавляем пункт меню
 end; 
end;
</pre>



<p>Процедура выполнения плугина. Здесь мы загружаем, узнаём тип и выполняем&nbsp;</p>

<pre>
procedure TForm1.PlugClick(sender: TObject);
 var
  PlugExec : function(AObject : TObject): boolean;  
        //Объявление функции, которая будет выполнять плугин
  PlugType : function: PChar;  //Объявление функции, которая будет возвращать тип плугина
  FileName : string;  //Имя dll
  handle   : Thandle;  //Хендл dll
begin
 with (sender as TmenuItem) do  filename:= plugList.Strings[MenuIndex];  
        //Получаем имя dll
 handle := LoadLibrary(Pchar(FileName));  //Загружаем dll
 if handle &lt;&gt; 0 then  //Если всё в порядке, то идём дальше
  begin 
    //Загружаем функции
   @plugExec := GetProcAddress(handle,'PluginExec');
   @plugType := GetProcAddress(handle,'PluginType'); 
    //А теперь, в зависимости от типа, передаём нужный ей параметр...
   if PlugType = 'FORM' then PlugExec(Form1) else    
        //Если плугин для формы, то передаём форму
   if PlugType = 'CANVAS' then PlugExec(Canvas) else    
        //Если плугин для канвы, то передаём канву 
   if PlugType = 'MENU' then PlugExec(MainMenu1) else    
        //Если плугин для меню, то передаём меню
   if PlugType = 'BRUSH' then PlugExec(Canvas.brush) else    
        //Если плугин для заливки, то передаём заливку 
   if PlugType = 'NIL' then PlugExec(nil);    
        //Если плугину ни чего не нужно, то ни чего не передаём
  end;
 FreeLibrary(handle);    //Уничтожаем dll
end;
 
procedure TForm1.FormCreate(Sender: TObject);
var
 SearchRec : TSearchRec; //Запись для поиска
begin
 plugList:=TStringList.create; //Создаём запись для имён dll'ок
 if FindFirst('*.dll',faAnyFile, SearchRec) = 0 then //ищем первый файл 
  begin 
   LoadPlug(SearchRec.name); //Загружаем первый найденный файл
   while FindNext(SearchRec) = 0 do LoadPlug(SearchRec.name); 
        //Загружаем последующий
   FindClose(SearchRec); //Закрываем поиск
  end;
  //Левые параметры
  canvas.Font.pitch := fpFixed;
  canvas.Font.Size := 20;
  canvas.Font.Style:= [fsBold];
end;
 
end.
</pre>




<p>здесь написан простой исходный текст dll, то есть нашего плугина</p>
<p>Он обязательно возвращает название, тип и выполняет свои задачи</p>
<pre>
library plug;
uses
  SysUtils, graphics, Classes, windows;
 
{$R bmp.RES}
 
function PluginType : Pchar;
 begin
  Plugintype := 'CANVAS';  //Мы указали реакцию на этот тип 
 end;
 
function PluginName:Pchar;
 begin
  PluginName := 'Canvas painter'; 
        //Вот оно, название плугина. Эта строчка будет в менюшке
 end;
</pre>



<p>Функция выполнения плугина! Здесь мы рисуем на переданной канве</p>
<p>анимационную строку.&nbsp;</p>

<pre>
function PluginExec(Canvas:TCanvas):Boolean;
 var
  X     : integer;
  I     : integer;
  Z     : byte;
  S     : string;
  color : integer;
  proz  : integer;
begin
color := 10;
proz  :=0;
S:= 'hello всем это из плугина ля -- ля';
for Z:=0 to 200 do
begin
 proz:=proz+2;
 X:= 0;
 for I:=1 to length(S) do
  begin
   X:=X + 20;
   Canvas.TextOut(X,50,S[i]);
   color  := color+X*2+Random(Color);
   canvas.Font.Color := color+X*2;
   canvas.font.color := 10;
   canvas.TextOut(10,100,'execute of '+inttostr(proz div 4) + '%');
   canvas.Font.Color := color+X*2;
   sleep(2);
  end;
end;
 PluginExec:=True;
end;
 
exports
 PluginType, PluginName, PluginExec;
 
end.
</pre>


<p>Пару советов :</p>
<p>1. Не оставляйте у своих плугинов расширение *.dll, это не катит. А вот сделайте, например *.plu . Просто в исходном тексте плугина напишите {$E plu} Ну и в исходном тексте программы ищите не Dll, а уже plu.</p>

<p>2. Когда вы сдаёте программу, напишите к ней уже готовых несколько плугинов, что бы юзеру было интересно искать новые.</p>
<p>3. Сделайте поддержку обновления через интернет. То есть программа заходит на ваш сервер, узнаёт, есть ли новые плугины или нет, если есть - то она их загружает. Этим вы увеличите спрос своей программы и конечно трафик своего сайта!</p>

<p>Взято с сайта <a href="https://www.emanual.ru" target="_blank">www.emanual.ru</a></p>
