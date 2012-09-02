<h1>Как узнать версию ADO?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  With different versions of MDAC available it is sometimes 
  useful to know that your application won't fail because a user 
  hasn't got the latest version installed. 
  The following function returns the ADO version installed, 
  you need to place ComObj in the uses clause to use this function. 
} 
 
function GetADOVersion: Double; 
var 
  ADO: OLEVariant; 
begin 
  try 
    ADO    := CreateOLEObject('adodb.connection'); 
    Result := StrToFloat(ADO.Version); 
    ADO    := Null; 
  except 
    Result := 0.0; 
  end; 
end; 
 
// To use this function try something like: 
 
procedure TForm1.Button1Click(Sender: TObject); 
const 
  ADOVersionNeeded = 2.5; 
begin 
  if GetADOVersion then 
    ShowMessage('Need to install MDAC version 2.7') 
  else 
    ShowMessage(Format('ADO Version %n, is OK', [GetADOVersion])); 
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr />
<pre>
function TfrmMain.GetADOVersion: Double;
var
  ADO: OLEVariant;
begin
  try
    ADO := CreateOLEObject('adodb.connection');
    Result := StrToFloat(ADO.Version);
    ADO := Null;
  except
    Result := 0.0;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

