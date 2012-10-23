<h1>Как пpинимать яpлыки пpи пеpетягивании их на контpол?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Nomadic </div>
<pre>
TForm1 = class(TForm)
  ...
  private
    { Private declarations }
    procedure WMDropFiles(var M: TWMDropFiles); message WM_DROPFILES;
  ...
end;
 
var
  Form1: TForm1;
 
implementation
 
uses
  StrUtils, ShellAPI, ComObj, ShlObj, ActiveX;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  ...
  DragAcceptFiles(Handle, True);
  ...
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  ...
  DragAcceptFiles(Handle, False);
  ...
end;
 
procedure TForm1.WMDropFiles(var M: TWMDropFiles);
var
  hDrop: Cardinal;
  n: Integer;
  s: string;
begin
  hDrop := M.Drop;
  n := DragQueryFile(hDrop, 0, nil, 0);
  SetLength(s, n);
  DragQueryFile(hDrop, 0, PChar(s), n + 1);
  DragFinish(hDrop);
  M.Result := 0;
  FileOpen(s);
end;
 
procedure TForm1.FileOpen(FileName: string);
begin
  if CompareText(ExtractFileExt(FileName), '.lnk') = 0 then
    FileName := ResolveShortcut(Application.Handle, FileName);
  DocName := ExtractFileName(FileName);
  Caption := Application.Title + ' - ' + DocName;
  ...
end;
 
function ResolveShortcut(Wnd: HWND; ShortcutPath: string): string;
var
  obj: IUnknown;
  isl: IShellLink;
  ipf: IPersistFile;
  pfd: TWin32FindDataA;
begin
  Result := '';
  obj := CreateComObject(CLSID_ShellLink);
  isl := obj as IShellLink;
  ipf := obj as IPersistFile;
  ipf.Load(PWChar(WideString(ShortcutPath)), STGM_READ);
  with isl do
  begin
    Resolve(Wnd, SLR_ANY_MATCH);
    SetLength(Result, MAX_PATH);
    GetPath(PChar(Result), Length(Result), pfd, SLGP_UNCPRIORITY);
    Result := PChar(Result);
  end;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

