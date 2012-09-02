<h1>Как использовать форму из DLL?</h1>
<div class="date">01.01.2007</div>


<pre>
library Form;
uses
  Classes,
  Unit1 in 'Unit1.pas' {Form1};
exports
  CreateMyForm,
  DestroyMyForm;
end.
</pre>

<p>Это его Unit1: </p>

<pre>
unit Unit1;
 
interface
 
// раздел uses и определение класса Form1
 
  procedure CreateMyForm(AppHandle: THandle); stdcall;
  procedure DestroyMyForm; stdcall;
 
implementation
{$R *.DFM}
 
procedure CreateMyForm(AppHandle: THandle);
begin
  Application.Handle := AppHandle;
  Form1 := TForm1.Create(Application);
  Form1.Show
end;
 
procedure DestroyMyForm;
begin
  Form1.Free;
end;
 
end.
</pre>

<p>Это UnitCall вызывающего EXE-шника: </p>

<pre>
unit
  UnitCall;
 
interface
 
// раздел uses и определение класса Form1
 
  procedure CreateMyForm(AppHandle: THandle); stdcall; external 'Form.dll';
  procedure DestroyMyForm; stdcall; external 'Form.dll';
 
implementation
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  CreateMyForm(Application.Handle);
end;
 
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  DestroyMyForm;
end;
 
end.
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
