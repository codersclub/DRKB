<h1>Очистка корзины</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;

 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, ShellAPI;
 
const
  SHERB_NOCONFIRMATION  =  $1;
  SHERB_NOPROGRESSUI    =  $2;
  SHERB_NOSOUND         =  $4;
 
type
  TForm1 = class(TForm)
    btnGetRecicleBinFileCount: TButton;
    btnEmptyRecicleBin: TButton;
    btnDelToReciclebin: TButton;
    procedure btnGetRecicleBinFileCountClick(Sender: TObject);
    procedure btnEmptyRecicleBinClick(Sender: TObject);
    procedure btnDelToReciclebinClick(Sender: TObject);
  end;
 
type
   TSHQueryRBInfo = packed record
     cbSize      : DWORD;
     i64Size,
     i64NumItems : TLargeInteger;
   end;
   PSHQueryRBInfo = ^TSHQueryRBInfo;
 
  function SHEmptyRecycleBin(hwnd: HWND; pszRootPath: PChar;
    dwFlags: DWORD): HRESULT; stdcall;
    external 'shell32.dll' name 'SHEmptyRecycleBinA';
 
  function SHQueryRecycleBin (pszRootPath: PChar;
    var SHQueryRBInfo: TSHQueryRBInfo): HRESULT; stdcall;
    external  'Shell32.dll' name 'SHQueryRecycleBinA';  
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
// Очистка корзины
procedure TForm1.btnEmptyRecicleBinClick(Sender: TObject);
var
  Err: HRESULT;
begin
  Err := SHEmptyRecycleBin(Handle, 'c:\', SHERB_NOSOUND);
  if Err &lt;&gt; S_OK then ShowMessage(SysErrorMessage(Err));
end;
 
end.
</pre>
<p>Пример работы с корзиной можно скачать здесь:<br>
<p>&nbsp;</p>
<p><a href="/zip/rbin.zip">
rbin.zip
</a>
</p>
<div class="author">Автор: Rouse_</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
