<h1>Как загрузить веб-страницу со скрытым IP?</h1>
<div class="date">01.01.2007</div>


<pre>
{ Add a button and memo }
 
implementation
 
{$R *.dfm}
 
uses
  Urlmon;
 
procedure TForm1.Button1Click(Sender : TObject);
var
  ca : iinterface;
  rls : Integer;
  stat : iBindStatusCallBack;
  rr : Cardinal;
  tag : _tagBindInfo;
  exGuid : tguid;
  noIp : Pointer;
  res : HResult;
begin
  // Make a 0.0.0.0 ip giud
  exGuid.D1 := rr;
  exGuid.D2 := word('0');
  exGuid.D3 := word('.');
  // Set Tag options
  with tag do 
  begin
    // set "0." ip guid
    iid := exGuid;
    // set needed size
    cbSize := sizeOf('www.big-x.cjb.net');
    // Add ip hiding ( not tested, but should work )
    securityAttributes.lpSecurityDescriptor := noIp;
    securityAttributes.nLength := length('0.0.0.0');
    securityAttributes.bInheritHandle := True;
  end;{
 Extra: res := stat.GetBindInfo(rr, tag);}
  //Start downloading webpage
  try
    urlmon.URLDownloadToFile(ca, 'www.big-x.cjb.net', 'filename.htm', 1, stat);
  except
    ShowMessage('Could not download the webpage!');
  end;
  //Load the webpage source to a memo
  memo1.Lines.LoadFromFile('filename.htm');
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
