<h1>DDE для захвата текущего URL из окна Internet Explorer или Netscape Navigator</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  windows, ddeman, ...
 
 
function Get_URL(Servicio: string): string;
var
  Cliente_DDE: TDDEClientConv;
  temp: PChar;      //&lt;&lt;-------------------------This is new
begin
  Result := '';
  Cliente_DDE:= TDDEClientConv.Create( nil );
  with Cliente_DDE do
  begin
    SetLink( Servicio,'WWW_GetWindowInfo');
    temp := RequestData('0xFFFFFFFF');
    Result := StrPas(temp);
    StrDispose(temp);  // &lt;&lt;-- Предотвращаем утечку памяти
    CloseLink;
  end;
  Cliente_DDE.Free;
end;
 
procedure TForm1.Button1Click(Sender);
begin
   showmessage(Get_URL('Netscape'));
// или
   showmessage(Get_URL('IExplore'));
end;
</pre>


