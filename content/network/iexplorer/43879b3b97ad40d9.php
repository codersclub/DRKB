<h1>Как добавить cookie?</h1>
<div class="date">01.01.2007</div>


<p>Пример демонстрирует создание cookie посредствам стандартного компонента Delphi</p>
<pre>
procedure TwebDispatcher.WebAction(Sender: TObject; Request: TWebRequest; 
  Response: TWebResponse; var Handled: Boolean); 
begin 
    with (Response.Cookies.Add) do begin 
      Name := 'TESTNAME'; 
      Value := 'TESTVALUE'; 
      Secure := False; 
      Expires := Now; 
      Response.Cookies.WebResponse.SendResponse; 
    end; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
