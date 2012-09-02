<h1>Передача массива записей символов в TMemo</h1>
<div class="date">01.01.2007</div>

Обработка больших строк в 16-битной версии Delphi задача далеко непростая. Особенно когда строки являются частью структуры записи и вы хотите передать их в TMemo. В данном совете показано как создать структуру записи размером 1000 символов, прочесть в нее содержимое Memo и затем записать ее обратно в Memo. Основной метод, который мы здесь используем - метод Memo GetTextBuf. Используемая структура записи представляет собой простую строку и массив из 1000 символов, но структура могла бы быть сложнее.</p>
<pre>
unit URcrdIO;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls, dbtables;
 
type
  TForm1 = class(TForm)
    Button1: TButton;
    Memo1: TMemo;
    Button2: TButton;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
type
  TMyRec = record
    MyArray: array[1..1000] of char;
    mystr: string;
  end;
 
var
  Form1: TForm1;
  MyRec: TMyRec;
  mylist: TStringlist;
  PMyChar: PChar;
  myfile: file;
  mb: TStream;
implementation
 
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
 
begin
 
  assignfile(myfile, 'c:\testblob.txt');
  rewrite(myfile, 1);
  fillchar(MyRec.MyArray, sizeof(MyRec.MyArray), #0);
  pmychar := @MyRec.MyArray;
  StrPCopy(pmychar, memo1.text);
  Blockwrite(MyFile, MyRec, SizeOf(MyRec));
  closefile(MyFile);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
 
  assignfile(myfile, 'c:\testblob.txt');
  reset(myfile, 1);
  fillchar(MyRec.MyArray, sizeof(MyRec.MyArray), #0);
 
  Blockread(MyFile, MyRec, SizeOf(MyRec));
  pmychar := @MyRec.MyArray;
  Memo1.SetTextBuf(pmychar);
end;
 
end.
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

