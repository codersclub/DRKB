<h1>Как получить список всех зарегистрированных typelibs?</h1>
<div class="date">01.01.2007</div>

<pre class="delphi">
 uses
  Registry;
 
procedure EnumTypeLibs(TypeLibNames: TStrings);
var
  f: TRegistry;
  keyNames, keyVersions, keyInfos: TStringList;
  keyName, keyVersion, keyInfo, tlName: string;
  i, j, k: Integer;
begin
  TypeLibNames.Clear;
  keyNames := nil;
  keyVersions := nil;
  keyInfos := nil;
  f := TRegistry.Create;
  try
    keyNames := TStringList.Create;
    keyVersions := TStringList.Create;
    keyInfos := TStringList.Create;
    f.RootKey := HKEY_CLASSES_ROOT;
    if not f.OpenKey('TypeLib', False) then raise
      Exception.Create('TRegistry.Open');
    f.GetKeyNames(keyNames);
    f.CloseKey;
    for i := 0 to keyNames.Count - 1 do
    begin
      keyName := keyNames.Strings[i];
      if not f.OpenKey(Format('TypeLib\%s', [keyName]), False) then Continue;
      f.GetKeyNames(keyVersions);
      f.CloseKey;
      for j := 0 to keyVersions.Count - 1 do
      begin
        keyVersion := keyVersions.Strings[j];
        if not f.OpenKey(Format('TypeLib\%s\%s', [keyName, keyVersion]), False) then
          Continue;
        tlName := f.ReadString('');
        f.GetKeyNames(keyInfos);
        f.CloseKey;
        {$B-}
        for k := 0 to keyInfos.Count - 1 do
        begin
          keyInfo := keyInfos.Strings[k];
          if (keyInfo = '') or (keyInfo[1] &lt; '0') or (keyInfo[1] &gt; '9') then Continue;
          if not f.OpenKey(Format('TypeLib\%s\%s\%s\win32', [keyName, keyVersion,
            keyInfo]), False) then Continue;
          f.CloseKey;
          TypeLibNames.Add(Format('%s ver.%s', [tlName, keyVersion]));
        end;
       {$B+}
      end;
    end;
  finally
    f.Free;
    keyNames.Free;
    keyVersions.Free;
    keyInfos.Free;
  end;
end;
 
// Example Call:
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  EnumTypeLibs(ListBox1.Items);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
