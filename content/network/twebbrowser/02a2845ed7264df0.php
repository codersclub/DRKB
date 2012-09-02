<h1>Навигация в TWebBrowser по линкам</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  Flags, Headers, TargetFrameName, PostData: OLEVariant;
  Url, Ref: string;
  IEApp: OLEVariant;
begin
  try
    IEApp := CreateOLEObject('InternetExplorer.Application');
  except
    Exit;
  end;
  IEApp.Visible := True;
  IEApp.Top := 0;
  IEApp.Left := 0;
  IEApp.Width := Screen.Width;
  IEApp.Height := Screen.Height;
  Flags := '1';
  TargetFrameName := '';
  PostData := '';
  Url := 'http://www.dach.de/weiterempfehlen.php';
  Ref := 'http://www.dach.de/';
  // u cannot navigate to the url above without this referer
  Headers := 'Referer: ' + Ref + #10 + #13;
  IEApp.Navigate(Url, Flags, TargetFrameName, PostData, Headers);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
