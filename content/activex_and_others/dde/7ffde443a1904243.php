<h1>Работа с Netscape Navigator через DDE</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
uses DDEman;
...
procedure GotoURL(sURL: string);
var
  dde: TDDEClientConv;
begin
  dde := TDDEClientConv.Create(nil);
  with dde do
  begin
    // specify the location of netscape.exe
    ServiceApplication :='C:\Program Files\Netscape\Communicator\Program\NETSCAPE.EXE';
    // activate the Netscape Navigator
    SetLink( 'Netscape', 'WWW_Activate' );
    RequestData('0xFFFFFFFF');
    // go to the specified URL
    SetLink( 'Netscape', 'WWW_OpenURL' );
    RequestData( sURL+',,0xFFFFFFFF,0x3,,,' );
    // ... CloseLink;
  end;
  dde.Free;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  GotoURL('http://www.site.ru');
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
