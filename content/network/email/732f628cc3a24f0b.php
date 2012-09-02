<h1>Как получить имена установленных почтовых клиентов?</h1>
<div class="date">01.01.2007</div>


<pre>
{
  Get names of installed Mail-Clients.
}
 
uses
  Registry;
 
function GetInstalledMailClients(AList: TStrings): Boolean;
const
  RegClientsRoot = '\SOFTWARE\Clients';
  RegClientsMail = '\Mail';
  RegClientsOpenCmd = '\shell\open\command';
var
  reg: TRegistry;
begin
  Result := True;
  try
    AList.Clear;
    reg := nil;
    reg := TRegistry.Create;
    try
      with reg do
      begin
        CloseKey;
        RootKey := HKEY_LOCAL_MACHINE;
        if OpenKeyReadOnly(RegClientsroot + RegClientsMail) then
          if HasSubKeys then
            GetKeyNames(AList);
      end;
    finally
      if Assigned(reg) then reg.Free;
    end;
  except
    Result := False;
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  GetInstalledMailClients(ListBox1.Items);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
