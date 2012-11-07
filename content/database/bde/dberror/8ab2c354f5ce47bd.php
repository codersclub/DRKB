<h1>Обработка исключения index not found</h1>
<div class="date">01.01.2007</div>


<p>Как мне открыть таблицу dBASE без требуемого MDX-файла? Я постоянно получаю исключение "Index not found..." (индекс не найден).</p>

<p>Во время создания таблицы dBASE с production-индексом (MDX) в заголовке DBF-файла устанавливается специальный байт. При последующем открытии таблицы, dBASE-драйвер читает этот специальный байт и, если он установлен, он также пытается открыть файл MDX. Если попытка открыть файл MDX заканчивается неудачей, возникает исключительная ситуация.</p>

<p>Для решения этой проблемы вам необходимо обнулить этот байт (28-й десятичный байт) в файле DBF, избавляющий таблицу от зависимости MDX-файла.</p>

<p>Нижеприведенным модуль является простым примером того, как можно обработать исключение при открытии таблицы, обнулив этот байт в DBF-файле и вновь открыв таблицу.</p>

<pre class="delphi">
unit Fixit;
 
interface
 
uses
 
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics,
  Controls, Forms, Dialogs, StdCtrls, DB, DBTables, Grids, DBGrids;
 
type
 
  TForm1 = class(TForm)
    Table1: TTable;
    ;
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
 
const
 
  TheTableDir = 'c:\temp\';
  TheTableName = 'animals.dbf';
 
procedure RemoveMDXByte(dbFile: string);
{ Данная процедура использует в качестве параметра имя файла DBF   }
{ и исправляет его заголовок для того, чтобы не требовать MDX-файл }
const
 
  Value: Byte = 0;
var
 
  F: file of byte;
begin
 
  AssignFile(F, dbFile);
  Reset(F);
  Seek(F, 28);
  Write(F, Value);
  CloseFile(F);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
{ Данная процедура вызывается в ответ на нажатие кнопки. Она }
{ пытается открыть таблицу и, если файл .MDX не найден,      }
{ DBF-файл исправляется и управление вновь передается данной }
{ процедуре для повторного открытия таблицы, но уже без MDX  }
begin
 
  try
    { устанавливаем каталог таблицы }
    Table1.DatabaseName := ThheTableDir;
    { устанавливаем имя таблицы }
    Table1.TableName := TheTableName;
    { пытаемся открыть таблицу }
    Table1.Open;
  except
    on E: EDBEngineError do
      { Нижеследующее сообщение указывает на то, что файл MDX не найден: }
      if Pos('Index does not exist. File', E.Message) &gt; 0 then
      begin
        { Сообщаем пользователю о наличии проблемы. }
        MessageDlg('Файл MDX не найден. Попытка открытия
          без индекса.', mtWarning, [mbOk], 0);
          { удаляем байт MDX из заголовка таблицы }
          RemoveMDXByte(TheTableDir + TheTableName);
          { Посылаем кнопке сообщение для эмуляции ее нажатия. }
          { Этот трюк заставит данную процедуру выполниться    }
          { повторно, и таблица будет открыта без файла MDX    }
          PostMessage(Button1.Handle, cn_Command, bn_Clicked, 0);
      end;
  end;
end;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
