<h1>Как добавить собственную панель?</h1>
<div class="date">01.01.2007</div>


<pre>
function AddExplorerBar(BarTitle, Url: string; BarSize: Int64; Horizontal:
  Boolean): string;
const
  EXPLORERBAR_ID = '{4D5C8C2A-D075-11d0-B416-00C04FB90376}';
  VERTICAL_BAR = '{00021493-0000-0000-C000-000000000046}';
  HORIZONTAL_BAR = '{00021494-0000-0000-C000-000000000046}';
var
  GUID: TGUID;
  SysDir, ID: string;
  Reg: TRegistry;
begin
  CreateGuid(GUID);
  ID := GuidToString(GUID);
  Reg := TRegistry.Create;
  with Reg do
  try
    RootKey := HKEY_CLASSES_ROOT;
    OpenKey('\CLSID\' + ID, True);
    WriteString('', 'BarTitle');
    CloseKey;
    CreateKey('\CLSID\' + ID + '\Implemented Categories');
    if HORIZONTAL then
      CreateKey('\CLSID\' + ID + '\Implemented Categories\' +
        HORIZONTAL_BAR)
    else
      CreateKey('\CLSID\' + ID + '\Implemented Categories\' +
        VERTICAL_BAR);
    SetLength(SysDir, 255);
    GetSysDirectory(PChar(SysDir), 255);
    SysDir := PChar(SysDir) + '\SHDOCVW.DLL';
    OpenKey('\CLSID\' + ID + '\InProcServer32', True);
    Writestring('', SysDir);
    WriteString('Threadingmodel', 'Apartment');
    CloseKey;
    OpenKey('\CLSID\' + ID + '\Instance', True);
    WriteString('CLSID', EXPLORERBAR_ID);
    CloseKey;
    OpenKey('\CLSID\' + ID + '\Instance\InitPropertyBag', True);
    WriteString('Url', URL);
    CloseKey;
    RootKey := HKEY_LOCAL_MACHINE;
    OpenKey('Software\Microsoft\Internet Explorer\Explorer Bars\'
      + ID, True);
    WriteBinaryData('BarSize', BarSize, SizeOf(BarSize));
    CloseKey;
    OpenKey('\Software\IE5Tools\Explorer Bars\', True);
    WriteString(BarTitle, ID);
    CloseKey;
    OpenKey('\Software\Microsoft\Internet Explorer\Toolbar', True)
      WriteString(ID, '');
    CloseKey;
  finally
    Free;
  end;
  result := ID;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
