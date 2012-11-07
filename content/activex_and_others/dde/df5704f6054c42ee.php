<h1>DDE для вызова диалога поиска файлов и папок</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
uses DdeMan;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  with TDDEClientConv.Create(Self) do
  begin
    ConnectMode := ddeManual;
    ServiceApplication := 'explorer.exe';
    SetLink( 'Folders', 'AppProperties');
    OpenLink;
    ExecuteMacro('[FindFolder(, C:\Мои документы)]', False);
    CloseLink;
    Free;
  end;
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
