<h1>Как предотвратить появление login dialog?</h1>
<div class="date">01.01.2007</div>



<p>To bypass the login dialog when connecting to a server database, use the property LoginPrompt.You will have to provide the username &amp; password at runtime, but you also can set that up at design time in the object inspector, property Params.</p>

<p>This short source code shows how to do it:</p>

<pre>
Database1.LoginPrompt := false;
with Database1.Params do
begin
  Clear;
  // the parameters SYSDBA &amp; masterkey should be
  // retrieved somewhat different :-)
  Add('USER NAME=SYSDBA');
  Add('PASSWORD=masterkey');
end;
Database1.Connected := tr
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
