<h1>Как добавить кнопку?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TConnType = (COM_OBJECT, EXPLORER_BAR, SCRIPT, EXECUTABLE);
 
function AddBandToolbarBtn(Visible: Boolean; ConnType: TConnType;
  BtnText, HotIcon, Icon, GuidOrPath: string): string;
var
  GUID: TGUID;
  Reg: TRegistry;
  ID: string;
begin
  CreateGuid(GUID);
  ID := GuidToString(GUID);
  Reg := TRegistry.Create;
  with Reg do
  try
    RootKey := HKEY_LOCAL_MACHINE;
    OpenKey('\Software\Microsoft\Internet Explorer\Extensions\'
      + ID, True);
    if Visible then
      WriteString('Default Visible', 'Yes')
    else
      WriteString('Default Visible', 'No');
    WriteString('ButtonText', BtnText);
    WriteString('HotIcon', HotIcon);
    WriteString('Icon', Icon);
    case ConnType of
      COM_OBJECT:
        begin
          WriteString('CLSID', '{1FBA04EE-3024-11d2-8F1F-0000F87ABD16}');
          WriteString('ClsidExtension', GuidOrPath);
        end;
      EXPLORER_BAR:
        begin
          WriteString('CLSID', '{E0DD6CAB-2D10-11D2-8F1A-0000F87ABD16}');
          WriteString('BandCLSID', GuidOrPath);
        end;
      EXECUTABLE:
        begin
          WriteString('CLSID', '{1FBA04EE-3024-11D2-8F1F-0000F87ABD16}');
          WriteString('Exec', GuidOrPath);
        end;
      SCRIPT:
        begin
          writeString('CLSID', '{1FBA04EE-3024-11D2-8F1F-0000F87ABD16}');
          WriteString('Script', GuidOrPath);
        end;
    end;
    CloseKey;
    OpenKey('\Software\IE5Tools\ToolBar Buttons\', True);
    WriteString(BtnText, ID);
    CloseKey;
  finally
    Free;
  end;
  Result := ID;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
