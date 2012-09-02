<h1>Управление mIRC при помощи DDE</h1>
<div class="date">01.01.2007</div>


<pre>
uses
   DdeMan;
 
 procedure mIRCDDE(Service, Topic, Cmd: string);
 var
   DDE: TDDEClientConv;
 begin
   try
     DDE := TDDEClientConv.Create(nil);
     DDE.SetLink(Service, Topic);
     DDE.OpenLink;
     DDE.PokeData(Topic, PChar(Cmd));
   finally
     DDE.Free;
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   mIRCDDE('mIRC', 'COMMAND', '/say Hallo von SwissDelphiCenter.ch');
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

