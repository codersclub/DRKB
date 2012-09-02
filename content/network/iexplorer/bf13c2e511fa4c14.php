<h1>Как прочитать / изменить домашнюю страницу IE?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  {...,}Registry; 
 
function GetIEStartPage: string; 
var 
  Reg: TRegistry; 
begin 
  Reg := TRegistry.Create; 
  try 
    Reg.RootKey := HKEY_CURRENT_USER; 
    Reg.OpenKey('Software\Microsoft\Internet Explorer\Main', False); 
    try 
      Result := Reg.ReadString('Start Page'); 
    except 
      Result := ''; 
    end; 
    Reg.CloseKey; 
  finally 
    Reg.Free; 
  end; 
end; 
 
function SetIEStartPage(APage: string): Boolean; 
var 
  Reg: TRegistry; 
begin 
  Reg := TRegistry.Create; 
  try 
    Reg.RootKey := HKEY_CURRENT_USER; 
    Reg.OpenKey('Software\Microsoft\Internet Explorer\Main', False); 
    try 
      Reg.WriteString('Start Page', APage); 
      Result := True; 
    finally 
      Reg.CloseKey; 
      Result := False; 
    end; 
  finally 
    Reg.Free; 
  end; 
end; 
 
// Show the Startpage 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  ShowMessage(GetIEStartPage); 
end; 
 
// Set the Startpage 
procedure TForm1.Button2Click(Sender: TObject); 
begin 
  SetIEStartPage('http://forum.vingrad.ru'); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
