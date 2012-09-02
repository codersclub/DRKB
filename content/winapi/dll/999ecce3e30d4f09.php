<h1>Статическая и динамическая загрузка DLL</h1>
<div class="date">01.01.2007</div>


<p>DLL возможно загружать двумя способами:</p>

<p>  - статически</p>
<p>  - динамически</p>

<p>Давайте создадим простую библиотеку DLL:</p>

<p>Project file name: c:\example\exdouble\exdouble.dpr </p>
<pre>
library ExDouble; 
// my simple dll 
 
function calc_double ( r: real ): real; stdcall; 
begin 
     result := r * 2; 
end; 
 
exports 
  calc_double index 1; 
 
end;
</pre>


<p>Теперь посмотрим, как её можно загружать:</p>

<p>СТАТИЧЕСКАЯ ЗАГРУЗКА DLL</p>
<p>================== </p>

<p>При таком способе загрузки достаточно поместить файл DLL в директорию приложения или в директорию Windows, или в Windows\System, Windows\Command. Однако, если система не найдёт этого файла в этих директория, то высветится сообщение об ошибке (DLL не найдена, или что-то в этом духе).</p>
<pre>
unit untMain; 
 
interface 
 
uses 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
  StdCtrls; 
 
type 
  TForm1 = class(TForm) 
    Button1: TButton; 
    procedure Button1Click(Sender: TObject); 
  private 
    { Private declarations } 
  public 
    { Public declarations } 
  end; 
 
var 
  Form1: TForm1; 
 
implementation 
 
function calc_double ( r: real ): real; stdcall; external 'ExDouble.dll'; 
 
{$R *.DFM} 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
     // в окошке сообщения будет цифра 21
     showMessage ( floatToStr ( calc_double ( 10.5 ) ) ); 
end; 
 
end. 
</pre>


<p>ДИНАМИЧЕСКАЯ ЗАГРУЗКА DLL</p>
<p>=================== </p>

<p>При динамической загрузке требуется написать немного больше кода.</p>

<p>А вот как это выглядит:</p>

<pre>
unit untMain; 
 
interface 
 
uses 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
  StdCtrls; 
 
type 
  Tcalc_double = function  ( r: real ): real; 
 
  TForm1 = class(TForm) 
    Button1: TButton; 
    procedure Button1Click(Sender: TObject); 
  private 
    { Private declarations } 
  public 
    { Public declarations } 
  end; 
 
var 
  Form1: TForm1; 
 
implementation 
 
{$R *.DFM} 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
   hndDLLHandle: THandle; 
   calc_double: Tcalc_double; 
begin 
     try 
        // загружаем dll динамически
        hndDLLHandle := loadLibrary ( 'ExDouble.dll' ); 
 
        if hndDLLHandle &lt;&gt; 0 then begin 
 
           // получаем адрес функции
           @calc_double := getProcAddress ( hndDLLHandle, 'calc_double' ); 
 
           // если адрес функции найден
           if addr ( calc_double ) &lt;&gt; nil then begin 
              // показываем результат ( 21...) 
              showMessage ( floatToStr ( calc_double ( 10.5 ) ) ); 
           end else 
              // DLL не найдена ("handleable") 
              showMessage ( 'Function not exists...' ); 
 
        end else 
           // DLL не найдена ("handleable") 
           showMessage ( 'DLL not found...' ); 
 
     finally 
        // liberar 
        freeLibrary ( hndDLLHandle ); 
     end; 
end; 
 
end. 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

