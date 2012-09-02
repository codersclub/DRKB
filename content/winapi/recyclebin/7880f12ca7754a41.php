<h1>Просмотр состояния корзины</h1>
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
 
// Просмотр состояния корзины (краткая информация)
procedure TForm1.btnGetRecicleBinFileCountClick(Sender: TObject);
var
  Info: TSHQueryRBInfo;
  Err: HRESULT;
begin
  ZeroMemory(@Info, SizeOf(Info));
  Info.cbSize := SizeOf(Info);
  Err := SHQueryRecycleBin(nil, Info);
  if Err = S_OK then
    ShowMessage(Format('Всего в корзине %d эелементов, их общий размер: %d',
      [Info.i64NumItems, Info.i64Size]))
  else
    ShowMessage(SysErrorMessage(Err));
end;
 
end.
</pre>
<p>Пример работы с корзиной можно скачать здесь:<br>
<p>&nbsp;</p>
<p><a href="/zip/rbin.zip">
rbin.zip
</a>
</p>
<p class="author">Автор: Rouse_</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
