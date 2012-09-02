<h1>Как получить список инсталлированных програм?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Registry; 
 
procedure TForm1.Button1Click(Sender: TObject); 
const 
  UNINST_PATH = 'SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall'; 
var 
  Reg: TRegistry; 
  SubKeys: TStringList; 
  ListItem: TlistItem; 
  i: integer; 
  sDisplayName, sUninstallString: string; 
begin 
{ 
  ListView1.ViewStyle := vsReport; 
  ListView1.Columns.add; 
  ListView1.Columns.add; 
  ListView1.Columns[0].caption := 'DisplayName'; 
  ListView1.Columns[1].caption := 'UninstallString'; 
  ListView1.Columns[0].Width := 300; 
  ListView1.Columns[1].Width := 300; 
} 
  Reg := TRegistry.Create; 
  with Reg do 
    try 
      with ListView1.Items do 
        try 
          BeginUpdate; 
          Clear; 
          RootKey := HKEY_LOCAL_MACHINE; 
          if OpenKeyReadOnly(UNINST_PATH) then 
          begin 
            SubKeys := TStringList.Create; 
            try 
              GetKeyNames(SubKeys); 
              CloseKey; 
              for i := 0 to subKeys.Count - 1 do 
                if OpenKeyReadOnly(Format('%s\%s', [UNINST_PATH, SubKeys[i]])) then 
                  try 
                    sDisplayName     := ReadString('DisplayName'); 
                    sUninstallString := ReadString('UninstallString'); 
                    if sDisplayName &lt;&gt; '' then 
                    begin 
                      ListItem         := Add; 
                      ListItem.Caption := sDisplayName; 
                      ListItem.subitems.Add(sUninstallString); 
                    end; 
                  finally 
                    CloseKey; 
                  end; 
            finally 
              SubKeys.Free; 
            end; 
          end; 
        finally 
          ListView1.AlphaSort; 
          EndUpdate; 
        end; 
    finally 
      CloseKey; 
      Free; 
    end; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
